<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Messenger_Channel_Checking_Model extends Model
{
    protected $table = 'messenger_channel_checking';
    protected $primaryKey = 'ID';

    public function getChecking($channel_id, $user_id)
    {
        $checking = DB::table($this->table)->where('channel_id', $channel_id)->where('user_id', $user_id)->get()->first();
        return is_object($checking) ? $checking : null;
    }

    public function newChecking($data)
    {
        return DB::table($this->table)->insertGetId($data);
    }

    public function updateChecking($user_id, $channel_id)
    {
        return DB::table($this->table)->where('user_id', $user_id)->where('channel_id', $channel_id)->update(['last_time_check' => time()]);
    }
}
