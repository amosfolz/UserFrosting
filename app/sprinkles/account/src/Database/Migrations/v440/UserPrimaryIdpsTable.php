<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Database\Migrations\v440;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

/**
 * Account Identity Providers migration.
 * Manages user account primary identity provider information.
 * Version 4.4.0.
 *
 * See https://laravel.com/docs/5.8/migrations#tables
 *
 * @author Archey Barrell
 * @author Amos Folz
 */
class UserPrimaryIdpsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Account\Database\Migrations\v400\UsersTable',
        '\UserFrosting\Sprinkle\Account\Database\Migrations\v440\PrimaryIdpsTable',
    ];

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        if (!$this->schema->hasTable('users_primary_idps')) {
            $this->schema->create('users_primary_idps', function (Blueprint $table) {
                $table->integer('primary_idps_id')->unsigned()->comment('The id of the idp.');
                $table->integer('user_id')->unsigned()->comment('The id of the user.');
                $table->string('external_id');
                $table->json('options');
                $table->timestamps();

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('primary_idps_id')->references('id')->on('primary_idps');
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->drop('users_primary_idps');
    }
}