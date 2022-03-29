<?php

namespace App\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentAgent;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function updateRating($agent_id, $comment_type = 'home')
    {
        $comments = get_comment_agent_list($agent_id, [
            'number' => -1,
            'type' => $comment_type,
        ]);
        if ($comments['count'] > 0) {
            $ratings = [];
            foreach ($comments['results'] as $item) {
                array_push($ratings, $item->comment_rate);
            }
            $ratings = array_filter($ratings);
            if (count($ratings)) {
                $average = array_sum($ratings) / count($ratings);
                $average = round($average, 1);
                $class = 'App\\Models\\' . ucfirst($comment_type);
                $model = new $class();
                $method = 'update' . ucfirst($comment_type);
                $model->$method(['rating' => $average], $post_id);
            }
        }
    }

    public function _changeReviewStatusAction()
    {

        $review_id = request()->get('serviceID');
        $review_encrypt = request()->get('serviceEncrypt');
        $status = request()->get('status', '');

        if (!hh_compare_encrypt($review_id, $review_encrypt) || !$status) {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('The data is invalid')
            ], true);
        }

        $review_model = new Comment();
        $updated = $review_model->updateStatus($review_id, $status);
        if (!is_null($updated)) {

            //Update review for all services
            $comment = new Comment();
            $commentObject = $comment->getById($review_id);
            if (!empty($commentObject)) {
                if (in_array($commentObject->post_type, ['home', 'experience', 'car'])) {
                    $post_id = $commentObject->post_id;
                    $this->updateRating($post_id, $commentObject->post_type);
                }
            }

            $this->sendJson([
                'status' => 1,
                'title' => __('System Alert'),
                'message' => __('Updated Successfully'),
                'reload' => true
            ], true);
        } else {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('Have error when saving')
            ], true);
        }
    }

    public function _deleteReviewAction(Request $request)
    {
        $review_id = request()->get('serviceID');
        $review_encrypt = request()->get('serviceEncrypt');

        if (!hh_compare_encrypt($review_id, $review_encrypt)) {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This data is invalid')
            ], true);
        }

        $text = __('comment');
        $comment = new Comment();
        $commentObject = $comment->getById($review_id);

        if (!empty($commentObject) && is_object($commentObject)) {

            $deleted = $comment->deleteComment($review_id);

            if (in_array($commentObject->post_type, ['home', 'experience', 'car'])) {
                $text = __('review');
                $post_id = $commentObject->post_id;
                $this->updateRating($post_id, $commentObject->post_type);
            }

            if ($deleted) {
                $this->sendJson([
                    'status' => 1,
                    'title' => __('System Alert'),
                    'message' => sprintf(__('This %s is deleted'), $text),
                    'reload' => true
                ], true);
            } else {
                $this->sendJson([
                    'status' => 0,
                    'title' => __('System Alert'),
                    'message' => sprintf(__('Can not delete this %s'), $text)
                ], true);
            }
        } else {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => sprintf(__('This %s is invalid'), $text)
            ], true);
        }
    }

    public function addCommentAction()
    {

        $post_id = request()->get('post_id');
        $comment_name = request()->get('comment_name');
        $comment_email = request()->get('comment_email');
        $comment_content = request()->get('comment_content');
        $comment_title = request()->get('comment_title');
        $comment_rate = request()->get('review_star', 5);
        $parent_id = request()->get('comment_id', 0);
        $comment_type = request()->get('comment_type', 'post');
        $status = 'publish';

        if (get_option('use_google_captcha', 'off') == 'on') {
            $recaptcha = new \ReCaptcha\ReCaptcha(get_option('google_captcha_secret_key'));
            $gRecaptchaResponse = request()->get('g-recaptcha-response');
            $resp = $recaptcha->verify($gRecaptchaResponse, request()->ip());
            if (!$resp->isSuccess()) {
                return $this->sendJson([
                    'status' => 0,
                    'title' => __('System Alert'),
                    'message' => view('common.alert', ['type' => 'danger', 'message' => __('Your request was denied')])->render()
                ]);
            }
        }

        $text = 'comment';
        if (!enable_review()) {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => '<div class="alert alert-warning">' . __('Review function was closed') . '</div>'
            ], true);
        }

        if (in_array($comment_type, ['home', 'experience', 'car'])) {
            $text = 'review';
        }

        if (need_approve_review() && !is_admin()) {
            $status = 'pending';
        }

        if (is_user_logged_in()) {
            $user_data = get_current_user_data();
            $comment_email = $user_data->getUserLogin();
            $comment_name = get_username($user_data->getUserId());
        }

        if ($comment_name) {
            $data = [
                'post_id' => intval($post_id),
                'comment_name' => $comment_name,
                'comment_title' => $comment_title,
                'comment_content' => $comment_content,
                'comment_rate' => $comment_rate,
                'comment_email' => $comment_email,
                'comment_author' => get_current_user_id(),
                'post_type' => $comment_type,
                'parent' => $parent_id,
                'status' => $status,
                'created_at' => time()
            ];

            $comment = new Comment();

            $newPost = $comment->createPost($data);

            if ($newPost) {

                if (in_array($comment_type, ['home', 'experience', 'car'])) {
                    $this->updateRating($post_id, $comment_type);
                }

                $success_text = '<div class="alert alert-success">' . sprintf(__('Add new %s successfully'), $text) . '</div>';
                if (need_approve_review() && !is_admin() && $comment_type == 'posts') {
                    $success_text = '<div class="alert alert-warning">' . sprintf(__('Add new %s successfully. Your comment needs to be moderated before publishing'), $text) . '</div>';
                }
                if (in_array($comment_type, ['home', 'experience', 'car']) && need_approve_review() && !is_admin()) {
                    $success_text = '<div class="alert alert-warning">' . sprintf(__('Add new %s successfully. Your review needs to be moderated before publishing'), $text) . '</div>';
                }

                $this->sendJson([
                    'status' => 1,
                    'title' => __('System Alert'),
                    'message' => $success_text,
                    'reload' => true
                ], true);
            } else {
                $this->sendJson([
                    'status' => 0,
                    'title' => __('System Alert'),
                    'message' => '<div class="alert alert-warning">' . sprintf(__('Can not add this %s'), $text) . '</div>'
                ], true);
            }
        } else {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => '<div class="alert alert-warning">' . __('Some fields is incorrect') . '</div>'
            ], true);
        }
    }

    public function addAgentCommentAction()
    {

        $agent_id = request()->get('agent_id');
        $comment_name = request()->get('comment_name');
        $comment_email = request()->get('comment_email');
        $comment_content = request()->get('comment_content');
        $comment_title = request()->get('comment_title');
        $comment_rate = request()->get('review_star', 5);
        $parent_id = request()->get('comment_id', 0);
        $comment_type = request()->get('comment_type', 'home');
        $status = 'publish';

        $text = 'comment';
        if (!enable_review()) {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => '<div class="alert alert-warning">' . __('Review function was closed') . '</div>'
            ], true);
        }

        if (in_array($comment_type, ['home', 'experience', 'car'])) {
            $text = 'review';
        }

        // if (need_approve_review() && !is_admin()) {
        //     $status = 'pending';
        // }

        if (is_user_logged_in()) {
            $user_data = get_current_user_data();
            $comment_email = $user_data->getUserLogin();
            $comment_name = get_username($user_data->getUserId());
        }

        if ($comment_name) {
            $data = [
                'agent_id' => intval($agent_id),
                'comment_name' => $comment_name,
                'comment_title' => $comment_title,
                'comment_content' => $comment_content,
                'comment_rate' => $comment_rate,
                'comment_email' => $comment_email,
                'comment_author' => get_current_user_id(),
                'post_type' => $comment_type,
                'parent' => $parent_id,
                'status' => $status,
                'created_at' => time()
            ];

            $comment = new CommentAgent();

            $newPost = $comment->createPost($data);

            if ($newPost) {

                $success_text = '<div class="alert alert-success">' . sprintf(__('Add new %s successfully'), $text) . '</div>';
                if (need_approve_review() && !is_admin() && $comment_type == 'posts') {
                    $success_text = '<div class="alert alert-warning">' . sprintf(__('Add new %s successfully. Your comment needs to be moderated before publishing'), $text) . '</div>';
                }
                if (in_array($comment_type, ['home', 'experience', 'car']) && need_approve_review() && !is_admin()) {
                    $success_text = '<div class="alert alert-warning">' . sprintf(__('Add new %s successfully. Your review needs to be moderated before publishing'), $text) . '</div>';
                }

                $this->sendJson([
                    'status' => 1,
                    'title' => __('System Alert'),
                    'message' => $success_text,
                    'reload' => true
                ], true);
            } else {
                $this->sendJson([
                    'status' => 0,
                    'title' => __('System Alert'),
                    'message' => '<div class="alert alert-warning">' . sprintf(__('Can not add this %s'), $text) . '</div>'
                ], true);
            }
        } else {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => '<div class="alert alert-warning">' . __('Some fields is incorrect') . '</div>'
            ], true);
        }
    }

    public function addAgentTipCommentAction()
    {
        $service_id = request()->get('service_id');
        $agent_id = request()->get('agent_id');
        $comment_content = request()->get('comment_content');
        $comment_title = request()->get('comment_title');
        $communication_rate = request()->get('communication_star', 5);
        $service_rate = request()->get('service_star', 5);
        $recommend_rate = request()->get('recommend_star', 5);
        $parent_id = request()->get('comment_id', 0);
        $comment_type = request()->get('comment_type', 'home');
        $serviceObject = get_post($service_id, $comment_type);
        $status = 'publish';

        $comment_rate = intval(( intval($service_rate) + intval($recommend_rate) + intval($communication_rate) ) / 3);
        $text = 'comment';
        if (!enable_review()) {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => '<div class="alert alert-warning">' . __('Review function was closed') . '</div>'
            ], true);
        }

        if (in_array($comment_type, ['home', 'experience', 'car'])) {
            $text = 'review';
        }

        // if (need_approve_review() && !is_admin()) {
        //     $status = 'pending';
        // }

        if (is_user_logged_in()) {
            $user_data = get_current_user_data();
            $comment_email = $user_data->getUserLogin();
            $comment_name = get_username($user_data->getUserId());
        }

        if ($comment_name) {
            $data = [
                'agent_id' => intval($agent_id),
                'comment_name' => $comment_name,
                'comment_title' => $comment_title,
                'comment_content' => $comment_content,
                'comment_rate' => $comment_rate,
                'comment_email' => $comment_email,
                'comment_author' => get_current_user_id(),
                'post_type' => $comment_type,
                'parent' => $parent_id,
                'status' => $status,
                'created_at' => time()
            ];

            $comment = new CommentAgent();
            // return view('frontend.agent-tip', ['post' => $serviceObject, 'service_type' => $comment_type, 'service_id' => $service_id]);
            $newPost = $comment->createPost($data);

            if ($newPost) {

                $success_text = '<div class="alert alert-success">' . sprintf(__('Add new %s successfully'), $text) . '</div>';
                if (need_approve_review() && !is_admin() && $comment_type == 'posts') {
                    $success_text = '<div class="alert alert-warning">' . sprintf(__('Add new %s successfully. Your comment needs to be moderated before publishing'), $text) . '</div>';
                }
                if (in_array($comment_type, ['home', 'experience', 'car']) && need_approve_review() && !is_admin()) {
                    $success_text = '<div class="alert alert-warning">' . sprintf(__('Add new %s successfully. Your review needs to be moderated before publishing'), $text) . '</div>';
                }

                return view('frontend.agent-tip', ['post' => $serviceObject, 'service_type' => $comment_type, 'service_id' => $service_id]);
            } else {
                $this->sendJson([
                    'status' => 0,
                    'title' => __('System Alert'),
                    'message' => '<div class="alert alert-warning">' . sprintf(__('Can not add this %s'), $text) . '</div>'
                ], true);
            }
        } else {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => '<div class="alert alert-warning">' . __('Some fields is incorrect') . '</div>'
            ], true);
        }
    }

    public function _addTipPayment(Request $request)
    {
        $paymentMethod = request()->get('payment');
        $create_user_checkout = get_option('create_user_checkout', 'off');
        if ($create_user_checkout == 'off' && !is_user_logged_in()) {
            if (!is_user_logged_in()) {
                return $this->sendJson([
                    'status' => 0,
                    'message' => view('common.alert', ['type' => 'danger', 'message' => __('You need to login before making payments')])->render(),
                    'need_login' => true
                ]);
            }
        }
        $tip_price = request()->get('tip_price');

        $payment = get_available_payments($paymentMethod);
        if (!$payment) {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'danger', 'message' => __('This payment gateway is not available')])->render()
            ]);
        }

        if (method_exists($payment, 'sendTransaction')) {
            $paymentObject = $payment::get_inst();
            $validation = $paymentObject->validation();
            if (is_array($validation) && $validation['status'] === false) {
                return $this->sendJson([
                    'status' => 0,
                    'message' => view('common.alert', ['type' => 'danger', 'message' => $validation['message']])->render()
                ]);
            }
            $responsive = $paymentObject->sendTransaction($tip_price);
            $return = [
                'status' => 1,
                'message' => view('common.alert', ['type' => 'success', 'message' => $responsive['message']])->render()
            ];
            if (isset($responsive['redirectUrl'])) {
                $return['redirect'] = $responsive['redirectUrl'];
            }
            if (isset($responsive['redirectForm'])) {
                $return['redirect_form'] = $responsive['redirectForm'];
            }
            if (isset($responsive['formID'])) {
                $return['form_id'] = $responsive['formID'];
            }
            return $this->sendJson($return);
        } else {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'danger', 'message' => __('Something went wrong')])->render()
            ]);
        }
    }

    public function _getListReview(Request $request, $type = '', $page = 1)
    {
        $folder = $this->getFolder();

        $search = request()->get('_s');
        $status = request()->get('status', '');

        $comment_obj = new Comment();
        $data = [
            'type' => $type,
            'search' => $search,
            'page' => $page,
            'status' => $status
        ];
        if (!is_admin()) {
            $data['author'] = get_current_user_id();
        }

        $comments = $comment_obj->getAllComments($data);


        return view("dashboard.screens.{$folder}.services.{$type}.{$type}-review", ['role' => $folder, 'bodyClass' => 'hh-dashboard', 'comments' => $comments]);
    }

    public function userCanReview($user_id, $post_id, $type = 'home')
    {
        if(is_admin() || is_partner()){
            return true;
        }
        if (in_array($type, ['post', 'page'])) {
            return true;
        }
        $review_after_booking = get_option('review_after_booking', 'off');
        if ($review_after_booking == 'off') {
            return true;
        }

        $has_booking = DB::table('booking')->where('buyer', $user_id)->where('service_id', $post_id)->where('service_type', $type)->whereIn('status', ['incomplete', 'completed'])->get()->first();

        return (!empty($has_booking) && is_object($has_booking)) ? true : false;
    }

    public function agentUserCanReview($agent_id, $author_id, $type = 'home')
    {
        // if(is_admin() || is_partner()){
        //     return true;
        // }
        // if (in_array($type, ['post', 'page'])) {
        //     return true;
        // }
        // $review_after_booking = get_option('review_after_booking', 'off');
        // if ($review_after_booking == 'off') {
        //     return true;
        // }

        $alreadySet = DB::table('comments_agent')->where('agent_id', $agent_id)->where('comment_author', $author_id)->where('post_type', $type)->get()->first();

        return (!empty($alreadySet) && is_object($alreadySet)) ? false : true;
    }

    public static function get_inst()
    {
        static $instance;
        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}
