<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InboxEmail extends Model
{
    protected $table = 'inbox_emails';
    protected $primaryKey = 'id';

}
