<?php

$permissions = [];

/**
 * Organize the permissions based on its feature and merge them here.
 */
$permissions = array_merge($permissions, include __DIR__ . '/permissions/auth-feat-permission.php');

return $permissions;
