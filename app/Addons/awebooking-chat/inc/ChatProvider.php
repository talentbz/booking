<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

class ChatProvider
{
    public function __construct()
    {
        add_filter('extension_config_path', [$this, '_config_path']);
        add_filter('extension_route_web', [$this, '_route_path']);
        add_filter('extension_view_path', [$this, '_view_path']);
        add_action('awebooking_page_title', [$this, '_page_title'], 10, 3);

        add_action('hh_register_scripts', [$this, '_enqueue']);
        add_action('hh_owner_information', [$this, '_add_button_contact']);
        add_action('awebooking_dashboard_menu_item_all-notifications_after', [$this, '_add_dashboard_menu']);
        add_filter('awebooking_total_notifications', [$this, '_countNewConversation'], 10, 3);
        add_filter('awebooking_notification_alert_box_html', [$this, '_showNotification'], 10, 2);
        add_action('awebooking_get_notifications', [$this, '_updateTimeCheck']);
    }

    public function _updateTimeCheck()
    {
        \App\Addons\ChatController::get_inst()->updateLastcheckInbox(get_current_user_id());
    }

    public function _enqueue($enqueue)
    {
        $enqueue->addScript('messenger-frontend-js', ChatRegister::get_inst()->url . '/assets/js/messenger-frontend.js');
        $enqueue->addStyle('messenger-frontend-css', ChatRegister::get_inst()->url . '/assets/css/frontend.css');
    }

    public function _showNotification($html, $user_id)
    {
        $messenger = new Messenger_Model();
        $time = get_user_meta($user_id, 'last_check_inbox', 0);
        $count = $messenger->countNewMessages($user_id, $time);
        if ($count > 0) {
            $html_inbox = '<div class="dropdown-item notify-item"><div class="notify-icon notify-inbox">';
            $html_inbox .= '<i class="icon-bell"></i>';
            $html_inbox .= '</div>';
            $html_inbox .= '<p class="notify-details">' . __('You have new messages') . '</p>
                <p class="text-muted mb-0 user-msg">
                    <small><a href="' . dashboard_url('messenger') . '">' . __('Open Now') . '</a></small>
                </p>
            </div>';
            $html = $html_inbox . $html;
        }
        return $html;
    }

    public function _countNewConversation($total, $user_id, $type)
    {
        $messenger = new Messenger_Model();
        $time = get_user_meta($user_id, 'last_check_inbox', 0);
        $count = $messenger->countNewMessages($user_id, $time);
        $total['total'] += $count > 0 ? 1 : 0;
        return $total;
    }

    public function _add_dashboard_menu()
    {
        $messenger = new Messenger_Model();
        $time = get_user_meta(get_current_user_id(), 'last_check_inbox', 0);
        $count = $messenger->countNewMessages(get_current_user_id(), $time);

        $count_message = $count > 0 ? '<span class="badge badge-pink float-right">' . $count . '</span>' : '';
        echo ' <li><a href = "' . dashboard_url('messenger') . '"> ' . $count_message . get_icon('001_email', '#555', '20px') . '<span>' . __('Inbox') . '</span></a></li>';
    }

    public function _add_button_contact()
    {
        echo view('messenger::button')->render();
    }

    public function _page_title($title, $is_dashboard, $route_name)
    {
        if ($route_name == 'messenger') {
            $title = get_option('site_name', Config::get('app.name', 'Laravel App')) . '-' . get_option('site_description', 'Awesome Booking System');
            $title = awe_lang('Inbox') . '-' . $title;
        }

        return $title;
    }

    public function _view_path($path)
    {
        $path['messenger'] = ChatRegister::get_inst()->path . '/views';

        return $path;
    }

    public function _route_path($path)
    {
        $path[] = ChatRegister::get_inst()->path . '/routes/web.php';
        return $path;
    }

    public function _config_path($path)
    {
        $path[] = ChatRegister::get_inst()->path . '/config/config.php';

        return $path;
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

ChatProvider::get_inst();
