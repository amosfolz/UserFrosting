<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Database\Models;

use UserFrosting\Sprinkle\Core\Database\Models\Model;

/**
 * Email Address Class.
 *
 * Represents a pending email verification for a new user account.
 *
 * @author Amos Folz
 *
 * @property string email
 * @property bool flag_email_verified
 * @property int user_id
 */
class EmailAddress extends Model
{
    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'email_addresses';

    protected $fillable = [
        'email',
        'flag_email_verified',
        'user_id',
    ];

    /**
     * @var bool Enable timestamps for Verifications.
     */
    public $timestamps = true;

    /**
     * Get the user associated with this verification request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        /** @var \UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = static::$ci->classMapper;

        return $this->belongsTo($classMapper->getClassMapping('user'), 'user_id');
    }
}
