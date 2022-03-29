<?php

namespace App\Addons;

use App\Http\Controllers\Controller;
use App\Models\HomeAvailability;
use App\Models\Post;
use function GuzzleHttp\_current_time;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class ChatObject extends Controller
{
    private $message_id;
    private $message = null;

    public function __construct($message_id)
    {
        parent::__construct();
        $this->message_id = $message_id;
        $this->_set_message();
    }

    public function getID()
    {
        return $this->message->ID;
    }

    public function getChannelID()
    {
        return $this->message->channel_id;
    }

    public function getMessage()
    {
        return $this->message->message;
    }

    public function getFromUser()
    {
        return (int)$this->message->from_user;
    }

    public function getToUser()
    {
        return (int)$this->message->to_user;
    }

    public function getAttachment()
    {
        $attachment = $this->message->attachment;
        if (!empty($attachment)) {
            return explode(',', $attachment);
        }
        return false;
    }

    public function getReferLink()
    {
        return !empty($this->message->refer_link) ? esc_url($this->message->refer_link) : '';
    }

    public function getCreatedAt()
    {
        return $this->message->created_at;
    }

    private function _set_message()
    {
        if (!is_object($this->message_id)) {
            $messenger = new \Messenger_Model();
            $this->message = $messenger->getMessageByID($this->message_id);
        } else {
            $this->message = $this->message_id;
        }
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
