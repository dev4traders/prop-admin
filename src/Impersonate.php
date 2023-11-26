<?php

namespace App;

use Dcat\Admin\Admin;
use Illuminate\Foundation\Auth\User;

class Impersonate
{
    private CONST IS_ACTIVE_KEY = 'impersonate.is_active';
    private CONST ORIGINAL_USER_ID = 'impersonate.original_user_id';

    /**
     * Create a new Impersonate instance.
     */
    public function __construct()
    {
    }

    /**
     * Impersonate the given user
     * Store the currently logged in user's id in session.
     * Log the new user in
     * @param User $user
     */
    public function login($userId)
    {
        // if not impersonated, save current logged in user
        // otherwise do not update (leave first original user in session)
        if (!$this->isActive()) {
            session()->put(self::ORIGINAL_USER_ID, Admin::user()->id);
        }

        Admin::guard()->loginUsingId($userId);

        session()->put(self::IS_ACTIVE_KEY, true);
    }

    /**
     * Logout the impersonated user
     * Log back in as the orignal user
     * Delete the impersonation session
     * @return bool
     */
    public function logout(): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        Admin::guard()->logout();

        // log back in as the original user
        $originalUserId = session()->get(self::ORIGINAL_USER_ID);

        if ($originalUserId) {
            Admin::guard()->loginUsingId($originalUserId);
        }

        session()->forget(self::ORIGINAL_USER_ID);
        session()->forget(self::IS_ACTIVE_KEY);

        return true;
    }

    /**
     * Is a user currently busy impersonate another user
     * @return mixed
     */
    public function isActive()
    {
        return session()->has(self::IS_ACTIVE_KEY);
    }
}