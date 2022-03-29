<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Messenger_Channel_Model extends Model
{
    protected $table = 'messenger_channel';
    protected $primaryKey = 'ID';

    public function getLatestChannels($from_user, $limit = 4)
    {
        $query = DB::table($this->table)->whereRaw("(user_created = {$from_user} OR user_joined = {$from_user})")->orderBy('last_time', 'DESC');
        if ($limit !== -1 && $limit > 0) {
            $query->limit($limit);
        }
        $channels = $query->get()->all();
        return !empty($channels) && is_array($channels) ? $channels : null;
    }

    public function getLatestStateChannel($from_user, $status = 'open', $limit = 4)
    {
        $query = DB::table($this->table)->where('status', $status)->whereRaw("(user_created = {$from_user} OR user_joined = {$from_user})")->orderBy('last_time', 'DESC');
        if ($limit !== -1 && $limit > 0) {
            $query->limit($limit);
        }
        $channels = $query->get()->all();
        return !empty($channels) && is_array($channels) ? $channels : null;
    }

    public function getLatestChannel($from_user)
    {
        $channel = DB::table($this->table)->where('status', esc_sql('open'))->whereRaw("(user_created = {$from_user} OR user_joined = {$from_user})")->limit(1)->orderBy('last_time', 'DESC')->get()->first();

        return !is_object($channel) ? $channel : null;
    }

    public function getChanelByUsers($from_user, $to_user, $status = 'open')
    {
        $channel = DB::table($this->table)->whereRaw("(user_created = {$from_user} AND user_joined = {$to_user}) OR (user_created = {$to_user} AND user_joined = {$from_user})")->where('status', esc_sql($status))->limit(1)->get()->first();
        return is_object($channel) ? $channel : null;
    }

    public function getChanelByID($channel_id, $status = 'open')
    {
        $channel = DB::table($this->table)->where('channel_id', $channel_id)->where('status', $status)->limit(1)->get()->first();
        return is_object($channel) ? $channel : null;
    }

    public function countChannel($user_id)
    {
        $count = DB::table($this->table)->where('status', 'open')->whereRaw("(user_created = {$user_id} OR user_joined = {$user_id})")->get()->count();

        return $count;
    }

    public function updateChannel($channel_id, $data)
    {
        $channel = DB::table($this->table)->where('channel_id', $channel_id)->update($data);

        return !!$channel;
    }

    public function newChannel($data)
    {
        return DB::table($this->table)->insertGetId($data);
    }

}
