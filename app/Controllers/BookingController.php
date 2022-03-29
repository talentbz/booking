<?php

namespace App\Controllers;

use App\Controllers\Services\ExperienceController;
use App\Controllers\Services\HomeController;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;

class BookingController extends Controller
{
    public function createBooking($user_id)
    {
       
        $lastBookingID = DB::table('booking')->orderBy('ID', 'desc')->get()->first();
        $bookingID = 1;
        if($lastBookingID != null && !empty($lastBookingID)) {
            $bookingID = intval(explode("-", $lastBookingID->booking_id)[2]);
            $bookingID = $bookingID + 1;
        }
        $cart = \Cart::get_inst()->getCart();
        $paymentMethod = request()->get('payment');
        $payment = get_available_payments($paymentMethod);
   
        $serviceObject = unserialize($cart['serviceObject']);
        
        $user_data = [
            'email' => request()->get('email'),
            'firstName' => request()->get('firstName'),
            'lastName' => request()->get('lastName'),
            'phone' => request()->get('phone'),
            'address' => request()->get('address'),
            'city' => request()->get('city'),
            'postCode' => request()->get('postCode'),
            'country' => request()->get('country'),
        ];

        $cart['user_data'] = $user_data;
        $total_minutes = 1440;
        if (isset($serviceObject->booking_type) && $serviceObject->booking_type == 'per_hour') {
            $total_minutes = hh_date_diff($cart['cartData']['startTime'], $cart['cartData']['endTime'], 'minute');
        }
  
        $created_at = time();
        $data = [
            'booking_id' => date('n-Y').'-'.$bookingID,
            'booking_description' => sprintf(__('Booking at %s'), $serviceObject->post_title),
            'service_id' => $cart['serviceID'],
            'service_type' => $cart['serviceType'],
            'first_name' => request()->get('firstName', ''),
            'last_name' => request()->get('lastName', ''),
            'email' => request()->get('email', ''),
            'phone' => request()->get('phone', ''),
            'address' => request()->get('address', ''),
            'note' => request()->get('note', ''),
            'number_of_guest' => isset($cart['cartData']['numberGuest']) ? $cart['cartData']['numberGuest'] : 0,
            'total' => $cart['amount'],
            'token_code' => hh_encrypt($cart['serviceID'] . $created_at),
            'currency' => serialize(\Currencies::get_inst()->currentCurrency()),
            'buyer' => $user_id,
            'owner' => $serviceObject->author,
            //'payment_type' => $payment::$paymentId,
            'payment_type' =>  $paymentMethod,
            'total_minutes' => $total_minutes,
            'status' => 'pending',
            'checkout_data' => base64_encode(serialize($cart)),
            'number' => isset($cart['cartData']['number']) ? $cart['cartData']['number'] : 0,
            'created_date' => $created_at
        ];

        if($cart['serviceType'] == 'home'){
            $data['real_owner'] = $serviceObject->owner;
        }

        if ($cart['serviceType'] == 'car') {
            $data['start_date'] = strtotime(date('Y-m-d', $cart['cartData']['startDate']));
            $data['end_date'] = strtotime(date('Y-m-d', $cart['cartData']['endDate']));
            $data['start_time'] = strtotime(date('Y-m-d h:i a', $cart['cartData']['startDateTime']));
            $data['end_time'] = strtotime(date('Y-m-d h:i a', $cart['cartData']['endDateTime']));
        } else {
            $data['start_date'] = strtotime(date('Y-m-d', $cart['cartData']['startDate']));
            $data['end_date'] = strtotime(date('Y-m-d', $cart['cartData']['endDate']));
            $data['start_time'] = $cart['cartData']['startTime'];
            $data['end_time'] = $cart['cartData']['endTime'];
        }

        $booking_model = new Booking();

        $new_booking_id = $booking_model->createBooking($data);
        
        do_action('awebooking_created_new_booking', $new_booking_id, $data);

        return $new_booking_id;
    }


    public function getProjection($start_date, $end_date, $user_id = '')
    {
        $booking_model = new Booking();
        $user_id = get_current_user_id();
        return $booking_model->getProjection($start_date, $end_date, $user_id);
    }

    public function getBookingByID($booking_id)
    {
        global $booking, $old_booking;
        $booking_model = new Booking();
        if (!is_null($booking)) {

            if (isset($booking->ID) && $booking->ID == $booking_id) {
                return $booking;
            } else {
                $old_booking = $booking;
                $booking = $booking_model->getBooking($booking_id);
            }
        } else {
            $booking = $booking_model->getBooking($booking_id);
        }

        return $booking;
    }

    public function updateBookingStatus($booking_id, $status, $created_booking = false)
    {
        $booking_model = new Booking();
        if(is_owner()) {
            $status = "request ".$status;
        }
        $booking_model->updateBooking(['status' => $status], $booking_id);
        if(is_owner()) {
            $booking = get_booking($booking_id);
            $serviceObject = get_post($booking->service_id, 'home');
            $currentUser = get_current_user_data();
            $admin = get_admin_user();
            $partner = get_user_by_id($serviceObject->author);
            $start_date = date('m.d.Y.', $booking->start_date);
            $end_date = date('m.d.Y.', $booking->end_date);
            $title = "Owner request";
            $subject = $status .$currentUser->email;
            $message = "Now ". $currentUser->email .$status." from ".$start_date." to ".$end_date; 
            send_mail($currentUser->email, $title, $admin->email, $subject, $message);
            send_mail($currentUser->email, $title, $partner->email, $subject, $message);
            return $this->sendJson([
                'status' => 1,
                'message' => __('Your request have been succssfully.')
            ], true);
        }
        $has = $booking_model->getBooking($booking_id);
        switch ($has->service_type) {
            case 'home':
                HomeController::get_inst()->_updateHomeAvailability($booking_id, $status);
                break;
            case 'experience':
                ExperienceController::get_inst()->_updateExperienceAvailability($booking_id, $status);
                break;
        }

        EarningController::get_inst()->updateEarning($booking_id);

        do_action('hh_change_booking_status', $status, $booking_id, $created_booking);
    }

    public function deleteBooking($booking_id)
    {
        $booking_model = new Booking();
        return $booking_model->deleteBooking($booking_id);
    }

    public function allBookings($data = [])
    {
        $booking_model = new Booking();

        if (is_partner()) {
            $data['user_type'] = 'owner';
            $data['user_id'] = get_current_user_id();
        }
        if (is_customer()) {
            $data['user_type'] = 'buyer';
            $data['user_id'] = get_current_user_id();
        }

        if (is_owner()) {
            $data['user_type'] = 'real_owner';
            $data['user_id'] = get_current_user_id();
        }

        return $booking_model->allBookings($data);
    }

    public function _allBooking(Request $request, $page = 1)
    {
        $folder = $this->getFolder();

        $search = request()->get('_s');
        $orderBy = request()->get('orderby', 'ID');
        $order = request()->get('order', 'desc');
        $status = request()->get('status', '');

        $data = [
            'search' => $search,
            'orderby' => $orderBy,
            'order' => $order,
            'status' => $status,
            'page' => $page,
            'services' => get_enabled_service_keys()
        ];
        if (is_partner()) {
            $data['user_type'] = 'owner';
            $data['user_id'] = get_current_user_id();
        }
        if (is_customer()) {
            $data['user_type'] = 'buyer';
            $data['user_id'] = get_current_user_id();
        }

        if (is_owner()) {
            $data['user_type'] = 'real_owner';
            $data['user_id'] = get_current_user_id();
        }

        $allBooking = $this->allBookings($data);
        return view("dashboard.screens.{$folder}.all-booking", ['role' => $folder, 'bodyClass' => 'hh-dashboard', 'allBooking' => $allBooking]);
    }

    public function _changeBookingStatus(Request $request)
    {
        $booking_id = request()->get('bookingID');
        $booking_encrypt = request()->get('bookingEncrypt');
        $status = request()->get('status', 'incomplete');

        $booking = get_booking($booking_id);
        if (hh_compare_encrypt($booking_id, $booking_encrypt) || is_null($booking)) {
            $this->updateBookingStatus($booking_id, $status);
            $this->sendJson([
                'status' => 1,
                'title' => __('System Alert'),
                'message' => __('This booking is changed'),
                'reload' => true
            ], true);
        } else {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This booking is not available')
            ], true);
        }
    }

    public function _getBookingInvoice(Request $request)
    {
        $booking_id = request()->get('bookingID');
        $booking_encrypt = request()->get('bookingEncrypt');

        $booking = get_booking($booking_id);
        $service_type = $booking->service_type;
        if (hh_compare_encrypt($booking_id, $booking_encrypt) || is_null($booking)) {
            $html = view('dashboard.components.services.' . $service_type . '.invoice', ['bookingObject' => $booking])->render();
            $this->sendJson([
                'status' => 1,
                'html' => $html,
                'message' => __('Get the invoice successfully')
            ], true);
        } else {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This booking is not available')
            ], true);
        }
    }

    public function _requestBookingReview(Request $request)
    {
        $booking_id = request()->get('bookingID');
        $booking_encrypt = request()->get('bookingEncrypt');

        $booking = get_booking($booking_id);
        $service_type = $booking->service_type;
        if (hh_compare_encrypt($booking_id, $booking_encrypt) || is_null($booking)) {
            $html = view('dashboard.components.services.' . $service_type . '.request_booking_review', ['bookingObject' => $booking])->render();
            $this->sendJson([
                'status' => 1,
                'html' => $html,
                'message' => __('Get the invoice successfully')
            ], true);
        } else {
            $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This booking is not available')
            ], true);
        }
    }

    public function _sendRequestBookingReview(Request $request)
    {
        $booking_id = request()->get('bookingID');
        $detail = balanceTags(request()->get('detail'));

        $booking = get_booking($booking_id);
        $service_type = $booking->service_type;
        $user = get_user_by_id($booking->buyer);
        $subject = "Agent Review & Tip";
        $from = get_user_by_id(get_current_user_id());
        $content = view('frontend.email.send-request-booking-review', ['service_type' => $service_type, 'agent'=> $from, 'detail'=> $detail, 'user'=> $user, 'bookingObject' => $booking])->render();
        send_mail($from->email, get_username($from->getUserId()), $user->email, $subject, $content);

        return $this->sendJson([
            'status' => 1,
            'title' => __('System Alert'),
            'message' => __('Success send offer'),
            'html' => ''
        ]);
    }

    public function _bookingConfirmation(Request $request)
    {
        $token = request()->get('token');
        $code = request()->get('code');
        $booking_model = new Booking();
        $booking = $booking_model->getBookingByToken($token);

        $status = 0;
        if ($booking) {
            $encrypt = create_confirmation_code($booking);
            if ($encrypt === $code) {
                if ($booking->confirm == 'confirmed') {
                    $status = 2;
                } else {
                    $status = 1;
                    $booking_model->updateBooking(['confirm' => 'confirmed'], $booking->ID);
                    do_action('hh_confirmed_booking', $booking->ID);
                }
            }
        }

        return view('frontend.confirmation-detail', ['status' => $status]);

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
