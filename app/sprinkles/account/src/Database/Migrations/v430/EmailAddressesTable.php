<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Database\Migrations\v430;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

/**
 * Email Addresses table migration.
 * This table stores additional user email addresses and their verification status.
 * Allows users to have more than one email associated with their account. However,
 * Only the primary email address stored in the `users` table may be used for login.
 * Version 4.3.0.
 *
 * See https://laravel.com/docs/5.8/migrations#tables
 *
 * @author Amos Folz
 */
class EmailAddressesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Account\Database\Migrations\v400\UsersTable',
    ];

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        if ($this->schema->hasTable('users')) {
            $this->schema->table('email_addresses', function (Blueprint $table) {
                $table->increments('id');
                $table->string('email', 254);
                $table->boolean('flag_email_verified')->default(0)->comment('Set to 1 if the user has verified this email address, 0 otherwise.');
                $table->integer('user_id')->unsigned()->comment('The id of the user.');
                $table->timestamps();

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
                $table->foreign('user_id')->references('id')->on('users');
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->drop('email_addresses');
    }
}
