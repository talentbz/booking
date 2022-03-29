<?php

namespace App\Addons;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Stichoza\GoogleTranslate\TranslateClient;

class ChatController extends Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function _translator(Request $request)
    {
        $language_from = request()->get('language_from', 'en');
        $language_to = request()->get('language_to', 'en');
        $string = trim(request()->get('translate_text', ''));

        if (empty($string)) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Please put some text')
            ]);
        }
        $all_language_key = get_translator_languages('key');
        if (!empty($language_from) && $language_to && in_array($language_from, $all_language_key) && in_array($language_to, $all_language_key)) {
            $result = TranslateClient::translate($language_from, $language_to, $string);
            return $this->sendJson([
                'status' => 1,
                'html' => $result
            ]);
        } else {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Please select languages')
            ]);
        }
    }

    public function _saveSettings(Request $request)
    {
        if (!is_admin()) {
            return $this->sendJson([
                'status' => 0,
                'message' => '<div class="alert alert-danger">' . __('Can not access this action.[Permission Error]') . '</div>'
            ]);
        }
        $refresh_time = (int)request()->get('refresh_time', 5);

        update_opt('messenger_refresh_time', $refresh_time);

        return $this->sendJson([
            'status' => 1,
            'message' => '<div class="alert alert-success">' . __('Save successfully') . '</div>'
        ]);
    }

    public function _refreshChannel(Request $request)
    {
        $user_id = request()->get('user_id');
        $encrypt = request()->get('encrypt');

        if (!hh_compare_encrypt($user_id, $encrypt) || $user_id != get_current_user_id()) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Can not process this action. Permission Error!')
            ]);
        }

        $html = view('messenger::components.contact-items')->render();

        if (!empty($html)) {
            return $this->sendJson([
                'status' => 1,
                'html' => $html
            ]);
        }
        return $this->sendJson([
            'status' => 0,
            'message' => __('Can not load channel data')
        ]);
    }

    public function _refreshMessage(Request $request)
    {
        $channel_id = request()->get('channel_id');
        $encrypt = request()->get('encrypt');

        if (!hh_compare_encrypt($channel_id, $encrypt)) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Can not process this action. Permission Error!')
            ]);
        }
        $users = $this->getUsersInChannel($channel_id);
        if ($users['from_user'] != get_current_user_id()) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Can not process this action. Permission Error [2]!')
            ]);
        }

        $html = view('messenger::components.chat-conversation-item', ['channel_id' => $channel_id])->render();

        return $this->sendJson([
            'status' => 1,
            'html' => $html
        ]);
    }

    public function _messengerPost(Request $request)
    {
        $channel_id = request()->get('channel_id');
        $encrypt = request()->get('encrypt');
        $user_id = request()->get('user_id');
        $message = request()->get('message');
        $attachments = request()->get('attachments');

        if (!hh_compare_encrypt($channel_id, $encrypt)) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Can not send this message. Permission Error!')
            ]);
        }

        if ($user_id != get_current_user_id()) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Can not send this message. Permission Error [2]!')
            ]);
        }

        $channel = new \Messenger_Channel_Model();
        $has_channel = $channel->getChanelByID($channel_id);
        if (is_null($has_channel)) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('This channel is not available')
            ]);
        }

        if (empty(trim($message))) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Please enter message before sending')
            ]);
        }

        $users = $this->getUsersInChannel($channel_id);

        $messenger = new \Messenger_Model();
        $new_message = $messenger->newMessage([
            'channel_id' => $channel_id,
            'from_user' => $user_id,
            'to_user' => $users['to_user'],
            'message' => $message,
            'attachment' => $attachments,
            'created_at' => time()
        ]);

        if ($new_message) {

            $this->updateChannelLatestUserTime($channel_id, $user_id);
            $this->updateChannelChecking($user_id, $channel_id);
            return $this->sendJson([
                'status' => 1,
                'message' => __('Sent Successfully')
            ]);
        } else {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Can not send this message. Try again!')
            ]);
        }
    }

    public function _messenger(Request $request, $code = '')
    {
        if (empty($code)) {
            $this->updateLastcheckInbox(get_current_user_id());
            return view('messenger::index');
        } else {
            $code_decode = json_decode(base64_decode($code), true);
            if (!is_array($code_decode) || count($code_decode) < 2 || get_current_user_id() != $code_decode['from_user']) {
                return view('frontend.404');
            }
            $this->updateChannelChecking($code_decode['from_user'], $code_decode['channel_id']);

            $this->updateLastcheckInbox(get_current_user_id());

            return view('messenger::index', $code_decode);
        }
    }

    public function updateLastcheckInbox($user_id)
    {
        update_user_meta($user_id, 'last_check_inbox', time());
    }

    public function _startMessage(Request $request)
    {
        if (!is_user_logged_in()) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Please login to contact host'),
                'callback' => 'login'
            ]);
        }

        $code = request()->get('code');
        $code_decode = json_decode(base64_decode($code), true);

        if (!is_array($code_decode) || count($code_decode) < 5) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Can not decrypt data')
            ]);
        }
        extract($code_decode);

        $post = get_post($post_id, $post_type);

        if (is_null($post)) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('This service is unavailable')
            ]);
        }
        if ((int)$post->author !== (int)$to_user) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Can not create this session')
            ]);
        }
        if ($from_user != get_current_user_id() || $from_user == $to_user) {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Can not create this session')
            ]);
        }

        $channel = new \Messenger_Channel_Model();
        $has_channel = $channel->getChanelByUsers($from_user, $to_user);
        if (!$has_channel) {
            $channel_id = 'CN' . $from_user . $to_user;
            $new_channel = $channel->newChannel([
                'channel_id' => $channel_id,
                'user_created' => $from_user,
                'user_joined' => $to_user,
                'last_user' => $from_user,
                'last_time' => time(),
                'status' => 'open',
                'created_at' => time(),
            ]);

            $this->_create_channel_checking($channel_id, $from_user);

            if ($new_channel) {

                $messenger = new \Messenger_Model();

                $new_message = $messenger->newMessage([
                    'channel_id' => $channel_id,
                    'from_user' => $from_user,
                    'to_user' => $to_user,
                    'message' => __('Getting Started'),
                    'attachment' => '',
                    'created_at' => time()
                ]);
                if ($new_message) {

                    return $this->sendJson([
                        'status' => 1,
                        'message' => __('Created channel successfully'),
                        'redirect' => $this->getChannelUrl($channel_id, $from_user)
                    ]);
                } else {
                    return $this->sendJson([
                        'status' => 0,
                        'message' => __('Can not start this channel. Please try again')
                    ]);
                }
            } else {
                return $this->sendJson([
                    'status' => 0,
                    'message' => __('Can not create this channel')
                ]);
            }

        } else {
            $this->_create_channel_checking($has_channel->channel_id, $from_user);

            return $this->sendJson([
                'status' => 1,
                'message' => __('Created channel successfully'),
                'redirect' => $this->getChannelUrl($has_channel->channel_id, $from_user)
            ]);
        }
    }

    public function getLatestChannels($from_user, $limit = 4)
    {
        $channel = new \Messenger_Channel_Model();
        return $channel->getLatestChannels($from_user, $limit);
    }

    public function updateFlag(Request $request) {
        $channel_id = request()->get('channel_id');
        $channelModel = new \Messenger_Channel_Model();
        
        $channelModel->updateChannel($channel_id, array('status' => 'open'));
        
        $channel = $channelModel->getChanelByID($channel_id);
        $_users = $this->getUsersInChannel($channel);
        $current_user = get_user_by_id(get_current_user_id());
        $to_user = get_user_by_id($channel->user_created);
        $message = "Please check the inbox. You can chat with this client and have a good result.";
        send_mail($current_user->email, 'Chat opend', $to_user->email, sprintf(__('[%s] Chatting request is accepted from %s'), get_option('site_name'), get_username($current_user->getUserId())), balanceTags($message));
        return redirect(esc_url($this->getChannelUrl($channel_id, $_users['from_user'])));
    }

    public function updateChannelLatestUserTime($channel_id, $latest_user)
    {
        $channel = new \Messenger_Channel_Model();

        return $channel->updateChannel($channel_id, [
            'last_user' => $latest_user,
            'last_time' => time()
        ]);
    }

    public function updateChannelChecking($user_id, $channel_id)
    {
        $channel_checking = new \Messenger_Channel_Checking_Model();

        $checking = $channel_checking->getChecking($channel_id, $user_id);
        if (is_null($checking)) {
            return $channel_checking->newChecking([
                'channel_id' => $channel_id,
                'user_id' => $user_id,
                'last_time_check' => time()
            ]);
        }
        return $channel_checking->updateChecking($user_id, $channel_id);
    }

    public function countNewMessageInChannel($user_id, $channel_id)
    {
        $channel_checking = new \Messenger_Channel_Checking_Model();
        $checking = $channel_checking->getChecking($channel_id, $user_id);
        if (is_null($checking)) {
            return 0;
        }

        $last_time_check = $checking->last_time_check;
        if (!is_timestamp($last_time_check)) {
            return 0;
        }
        $messenger = new \Messenger_Model();
        $count = $messenger->countNewMessageInChannel($user_id, $channel_id, $last_time_check);

        return $count;

    }

    public function _create_channel_checking($channel_id, $user_id)
    {
        $channel_checking = new \Messenger_Channel_Checking_Model();
        $has_checking = $channel_checking->getChecking($channel_id, $user_id);
        if (is_object($has_checking)) {
            return true;
        } else {
            $new_checking = $channel_checking->newChecking([
                'channel_id' => $channel_id,
                'user_id' => $user_id,
                'last_time_check' => time()
            ]);
            if ($new_checking) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function countChannel($user_id)
    {
        $channel = new \Messenger_Channel_Model();

        return $channel->countChannel($user_id);
    }

    public function getLatestChannel($user_from)
    {
        $channel = new \Messenger_Channel_Model();
        return $channel->getLatestChannel($user_from);
    }

    public function getLatestStateChannel($user_from, $status)
    {
        $channel = new \Messenger_Channel_Model();
        return $channel->getLatestStateChannel($user_from, $status);
    }

    public function getChannelUrl($channel_id, $from_user)
    {
        $new_code = [
            'from_user' => $from_user,
            'channel_id' => $channel_id,
        ];
        return dashboard_url('messenger/' . base64_encode(json_encode($new_code)));
    }

    public function getListMessageInChannel($channel_id)
    {
        $messenger = new \Messenger_Model();
        return $messenger->getMessageInChannel($channel_id);
    }

    public function getLastestMessageInChannel($channel_id)
    {
        $messenger = new \Messenger_Model();
        return $messenger->getLastestMessageInChannel($channel_id);
    }

    public function getUsersInChannel($channel_id)
    {
        if (is_object($channel_id)) {
            $channel = $channel_id;
        } else {
            $channel = $this->getChannel($channel_id);
        }

        if ($channel) {
            if (get_current_user_id() == $channel->user_created) {
                return [
                    'from_user' => $channel->user_created,
                    'to_user' => $channel->user_joined
                ];
            } else {
                return [
                    'from_user' => $channel->user_joined,
                    'to_user' => $channel->user_created
                ];
            }
        }
        return false;
    }

    public function getChannel($channel_id)
    {
        $channel = new \Messenger_Channel_Model();
        return $channel->getChanelByID($channel_id);
    }

    public function get_attachments($user_id)
    {
        return null;
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

ChatController::get_inst();
