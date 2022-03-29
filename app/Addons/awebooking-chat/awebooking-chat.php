<?php
/*
 * Name: Inbox System
 * Slug: awebooking-chat
 * Description: Connection between owners and customers
 * Author: Salim Mlare
 * Version: 1.1
 * Tags: chat
 */

class ChatRegister
{
    public $path;
    public $url;

    public function __construct()
    {
        $this->path = dirname(__FILE__);
        //$this->url = asset('addons/' . basename(__DIR__));

        $this->url = 'http://localhost:8000';
        
        require_once dirname(__FILE__) . '/helpers/chat.php';
        require_once dirname(__FILE__) . '/inc/ChatProvider.php';
        require_once dirname(__FILE__) . '/inc/ChatController.php';
        require_once dirname(__FILE__) . '/inc/ChatObject.php';
        require_once dirname(__FILE__) . '/models/Messenger_Model.php';
        require_once dirname(__FILE__) . '/models/Messenger_Channel_Model.php';
        require_once dirname(__FILE__) . '/models/Messenger_Channel_Checking_Model.php';
        require_once dirname(__FILE__) . '/vendor/autoload.php';
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

ChatRegister::get_inst();
