<?php
/**
 * Created by PhpStorm.
 * Date: 10/22/2019
 * Time: 12:37 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    protected $table = 'setting';
   
   
   public static function main(){
       return Setting::find(1);
   }
}
