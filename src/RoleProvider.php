<?php


namespace Octo;

interface RoleProvider
{

    /**
     * @param       $user
     * @param array $roles
     * @return bool
     */
    public function hasOneOfRoles($user, array $roles):bool;
}