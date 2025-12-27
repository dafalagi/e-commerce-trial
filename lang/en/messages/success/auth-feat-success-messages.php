<?php

return [
    /** Auth */
    'auth' => [
        'login' => 'User successfully logged in.',
        'logout' => 'User successfully logged out.',
        'password_changed' => 'Password successfully changed.',
        'reset_link_sent' => 'Password reset link successfully sent to :email.',
        'password_reset' => 'Password successfully reset.',
        'user_session_fetched' => 'User session successfully fetched.',
    ],

    /** User */
    'user' => [
        'stored' => 'User successfully stored.',
        'updated' => 'User successfully updated.',
        'deleted' => 'User successfully deleted.',
        'fetched' => 'User successfully fetched.',
        'created' => 'User successfully created.',
    ],

    /** Permission */
    'permission' => [
        'fetched' => 'Permission successfully fetched.',
    ],

    /** Role */
    'role' => [
        'stored' => 'Role successfully stored.',
        'updated' => 'Role successfully updated.',
        'deleted' => 'Role successfully deleted.',
        'fetched' => 'Role successfully fetched.',
        'removed' => 'Role successfully removed.',
    ],

    /** Role Permission */
    'role_permission' => [
        'updated' => 'Role Permission successfully updated.',
    ],

    /** User Role */
    'user_role' => [
        'added' => 'Role successfully added to User.',
        'removed' => 'Role successfully removed from User.',
    ],
];
