<?php

/**
 * Part of the Sentinel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Sentinel
 * @version    2.0.18
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrationExperienceAvailability122 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experience_availability', function (Blueprint $table) {
            if (!Schema::hasColumn("experience_availability", 'type')) {
                $table->string('type')->nullable();
            }
            if (!Schema::hasColumn("experience_availability", 'summary')) {
                $table->string('summary')->default('');
            }
        });
    }
    public function down()
    {
        Schema::table('experience_availability', function (Blueprint $table) {
            $table->dropColumn(['type']);
            $table->dropColumn(['summary']);
        });
    }
}
