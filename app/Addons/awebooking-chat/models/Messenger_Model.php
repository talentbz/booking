<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Messenger_Model extends Model
{
    protected $table = 'messenger';
    protected $primaryKey = 'ID';

    public function countNewMessages($user_id, $time_from = 0): int
    {
        return DB::table($this->table)->where('to_user', $user_id)->where('created_at', '>=', $time_from)->count();;
    }

    public function getMessageInChannel($channel_id, $time_from = 0): ?array
    {
        $messages = DB::table($this->table)->where('channel_id', $channel_id)->where('created_at', '>=', $time_from)->get()->all();
        return is_array($messages) && !empty($messages) ? $messages : null;
    }

    public function countNewMessageInChannel($to_user, $channel_id, $time = 0): int
    {
        $count = DB::table($this->table)->where('channel_id', $channel_id)->whereRaw("(from_user <> {$to_user})")->where('created_at', '>=', $time)->count();
        return (int)$count;
    }

    public function getLastestMessageInChannel($channel_id)
    {
        $message = DB::table($this->table)->where('channel_id', $channel_id)->limit(1)->orderBy('ID', 'DESC')->get()->first();
        return is_object($message) ? $message : null;
    }

    public function getMessageByID($message_id)
    {
        $message = DB::table($this->table)->where('ID', $message_id)->get()->first();

        return is_object($message) ? $message : null;
    }

    public function updateMessage($data)
    {
        $message = DB::table($this->table)->update($data);

        return !!$message;
    }

    public function newMessage($data)
    {
        return DB::table($this->table)->insertGetId($data);
    }
}
