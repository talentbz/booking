<?php

namespace App\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Home;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Sentinel;

class DashboardController extends Controller
{
    public function _getQRcode(Request $request)
    {
        $service_id = request()->get('serviceID');
        $service_encrypt = request()->get('serviceEncrypt');
        $service_type = request()->get('serviceType', 'home');

        if (!hh_compare_encrypt($service_id, $service_encrypt)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This service does not exist')
            ]);
        }

        $serviceObject = get_post($service_id, $service_type);
        if (!is_object($serviceObject)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This service does not exist')
            ]);
        }

        $service_url = get_the_permalink($serviceObject->post_id, $serviceObject->post_slug, $serviceObject->post_type);
        start_get_view();
        ?>
        <div class="qrcode-render">
            <?php
            echo QrCode::size(200)->generate($service_url);
            ?>
        </div>
        <?php
        $qrcode_html = end_get_view();
        return $this->sendJson([
            'status' => 1,
            'title' => __('System Alert'),
            'message' => __('Successfully get QR Code'),
            'html' => $qrcode_html
        ]);
    }

    public function _getHomeId(Request $request)
    {
        $service_id = request()->get('serviceID');
        $service_encrypt = request()->get('serviceEncrypt');
        $service_type = request()->get('serviceType', 'home');

        if (!hh_compare_encrypt($service_id, $service_encrypt)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This service does not exist')
            ]);
        }

        $serviceObject = get_post($service_id, $service_type);
        if (!is_object($serviceObject)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This service does not exist')
            ]);
        }

        start_get_view();
        ?>
        <div class="row">
            <div class="col-sm-6">
                <select
                data-plugin="customselect"
                name="send_offer_user">
                    <?php
                        $allUsers = get_customer_user_list();
                        foreach ($allUsers as $val) { ?>
                            <option value="<?php echo $val->id?>"><?php echo $val->email?></option>
                        <?php }
                    ?>
                </select>
            </div>
        </div>
        <div class="get-home-id">
            <input type="hidden" name="serviceID" value=<?php echo $service_id;?> >
            <input type="hidden" name="service_type" value=<?php echo $service_type;?> >
        </div>
        <?php
        $qrcode_html = end_get_view();
        return $this->sendJson([
            'status' => 1,
            'title' => __('System Alert'),
            'message' => __('Successfully get QR Code'),
            'html' => $qrcode_html
        ]);
    }

    public function sendSelectOffer(Request $request)
    {
        $service_id = request()->get('serviceID');
        $userid = request()->get('send_offer_user');
        $service_type = request()->get('service_type', 'home');

        $user = get_user_by_id($userid);
        $serviceObject = get_post($service_id, $service_type);

        $subject = "New Offer from SalmareTravel";
        $from = get_user_by_id(get_current_user_id());

        $content = view('frontend.email.send-offer', ['agent' => $from, 'service_type' => $service_type, 'user' => $user, 'serviceObject' => $serviceObject])->render();
        $admin_data = get_admin_user();
        
        $from_name = get_option('email_from');
        send_mail($from->email, get_username($from->getUserId()), $user->email, $subject, $content);

        return $this->sendJson([
            'status' => 1,
            'title' => __('System Alert'),
            'message' => __('Success send offer'),
            'html' => ''
        ]);
    }

    public function _getGalleryOrder(Request $request)
    {
        $service_id = request()->get('serviceID');
        $service_encrypt = request()->get('serviceEncrypt');
        $service_type = request()->get('serviceType', 'home');

        if (!hh_compare_encrypt($service_id, $service_encrypt)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This service does not exist')
            ]);
        }

        $serviceObject = get_post($service_id, $service_type);
        if (!is_object($serviceObject)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This service does not exist')
            ]);
        }

        start_get_view();
        if(!empty($serviceObject->gallery)) {
            $galleries = explode(',', $serviceObject->gallery);
            ?>
            <div class="row">
                <input type="hidden" value="<?php echo $serviceObject->gallery; ?>" id="gallery_id_change" name="gallery" />
                <input type="hidden" value="<?php echo $service_id;?>" name="serviceID"/>
                <?php foreach ($galleries as $key => $imageID) { ?>
                    <div class="col-sm-6" style="display:flex; justify-content: center; margin-top: 5px;">
                        <img src="<?php echo get_attachment_url($imageID, [60, 40]); ?>" alt="<?php echo get_translate($serviceObject->post_title); ?>"/>
                        <select style="margin-left: 5px" class="form-control" id="orderChange_<?php echo $imageID; ?>" onchange="javascript:changeGalleryOrder('<?php echo $imageID?>')">
                            <?php foreach($galleries as $in => $item) { ?>
                                <option value="<?php echo ($in + 1);?>" <?php if(($in + 1) == ($key + 1)){ echo 'selected';}?>><?php echo ($in + 1);?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
        $gallery_html = end_get_view();
        return $this->sendJson([
            'status' => 1,
            'title' => __('System Alert'),
            'message' => __('Success load galleries'),
            'html' => $gallery_html
        ]);
    }

    public function _galleryOrderChange(Request $request)
    {
        $service_id = request()->get('serviceID');
        $gallery = request()->get('gallery');
        $home = new Home();
        $serviceObject = get_post($service_id, 'home');
        if (!is_object($serviceObject)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This service does not exist')
            ]);
        }
        $data = array('gallery' => $gallery);
        $home->updateHome($data, $service_id);
        return $this->sendJson([
            'status' => 1,
            'title' => __('System Alert'),
            'message' => __('Success update gallery order'),
            'reload' => true
        ]);
    }

    public function _updateYourPayoutInformation(Request $request)
    {
        $user_id = request()->get('user_id');
        $user_encrypt = request()->get('user_encrypt');
        if (!hh_compare_encrypt($user_id, $user_encrypt)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user does not exist')
            ]);
        }

        $user = get_user_by_id($user_id);

        if (!$user) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user does not exist')
            ]);
        }
        $payout_payment = request()->get('payout_payment');
        $payout_detail = request()->get('payout_detail');

        update_user_meta($user_id, 'payout_payment', $payout_payment);
        update_user_meta($user_id, 'payout_detail', $payout_detail);

        return $this->sendJson([
            'status' => 1,
            'title' => __('System Alert'),
            'message' => __('Updated payout information successfully')
        ]);
    }

    public function _updatePassword(Request $request)
    {
        $user_id = request()->get('user_id');
        $user_encrypt = request()->get('user_encrypt');
        if (!hh_compare_encrypt($user_id, $user_encrypt)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user does not exist')
            ]);
        }

        $user = get_user_by_id($user_id);

        if (!$user) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user does not exist')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => $validator->errors()->first()
            ]);
        } else {
            $password = trim(request()->get('password'));
            $credentials = [
                'password' => $password,
            ];
            $user_updated = Sentinel::update($user, $credentials);
            return $this->sendJson([
                'status' => 1,
                'title' => __('System Alert'),
                'message' => __('Updated password successfully')
            ]);
        }
    }

    public function _getFontIcon(Request $request)
    {
        global $text;
        $text = request()->get('text', '');
        $text = strtolower(trim($text));
        if (empty($text)) {
            $this->sendJson(
                [
                    'status' => 0,
                    'data' => __('Not found icons')
                ]
                , true);
        }
        include public_path('fonts/fonts.php');
        include public_path('fonts/fonts-system.php');
        if (!isset($fonts) && !isset($fonts_system)) {
            $this->sendJson([
                'status' => 0,
                'data' => __('Not found icons data')
            ], true);
        }
	    $fonts_merge = [];
	    if (isset($fonts)) {
		    $fonts_merge = $fonts;
	    }
	    if (isset($fonts_system)) {
		    $fonts_merge = array_merge($fonts_merge, $fonts_system);
	    }
        $results = array_filter($fonts_merge, function ($key) {
            global $text;
            if (strpos(strtolower($key), $text) === false) {
                return false;
            } else {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY);
        if (empty($results)) {
            $this->sendJson([
                'status' => 0,
                'data' => __('Not found icons')
            ], true);
        } else {
            $this->sendJson([
                'status' => 1,
                'data' => $results
            ], true);
        }
    }

    public function _updateYourAvatar(Request $request)
    {
        $user_id = request()->get('user_id');
        $user_encrypt = request()->get('user_encrypt');
        $avatar = request()->get('avatar');
        if (hh_compare_encrypt($user_id, $user_encrypt) && $user_id == get_current_user_id()) {
            $user_model = new User();
            $updated = $user_model->updateUser($user_id, ['avatar' => $avatar]);
            if (!is_null($updated)) {
                return $this->sendJson([
                    'status' => 1,
                    'title' => __('System Alert'),
                    'message' => __('Updated successfully')
                ]);
            } else {
                return $this->sendJson([
                    'status' => 0,
                    'title' => __('System Alert'),
                    'message' => __('Can not update this user. Try again!')
                ]);
            }
        } else {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user is invalid')
            ]);
        }
    }

    public function _updateYourProfile(Request $request)
    {
        $user_id = request()->get('user_id');
        $user_encrypt = request()->get('user_encrypt');
        $first_name = request()->get('first_name');
        $last_name = request()->get('last_name');
        $mobile = request()->get('mobile');
        $location = request()->get('location');
        $address = request()->get('address');
        $description = request()->get('description');
        $video = request()->get('video');

        if (hh_compare_encrypt($user_id, $user_encrypt) && $user_id == get_current_user_id()) {
            $args = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'mobile' => $mobile,
                'location' => $location,
                'address' => $address,
                'description' => $description,
                'video' => $video,
            ];
            $user = get_user_by_id($user_id);

            if (is_admin($user_id)) {
                $email = request()->get('email');
                $check_user = get_user_by_email($email);
                if ($user->email != $email && (empty($email) || !is_email($email) || $check_user)) {
                    return $this->sendJson([
                        'status' => 0,
                        'title' => __('System Alert'),
                        'message' => __('Can not use this email')
                    ]);
                }
                $args['email'] = $email;
            }

            $user_model = new User();
            $updated = $user_model->updateUser($user_id, $args);
            if (!is_null($updated)) {
                return $this->sendJson([
                    'status' => 1,
                    'title' => __('System Alert'),
                    'message' => __('Updated successfully')
                ]);
            } else {
                return $this->sendJson([
                    'status' => 0,
                    'title' => __('System Alert'),
                    'message' => __('Can not update this user. Try again!')
                ]);
            }
        } else {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user is invalid')
            ]);
        }
    }

    public function _getProfile()
    {
        $folder = $this->getFolder();
        return view("dashboard.screens.{$folder}.profile", ['role' => $folder, 'bodyClass' => 'hh-dashboard']);
    }

    public function index()
    {
        $folder = $this->getFolder();
        return view("dashboard.screens.{$folder}.dashboard", ['role' => $folder, 'bodyClass' => 'hh-dashboard']);
    }

}
