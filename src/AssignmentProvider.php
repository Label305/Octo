<?php


namespace Octo;


interface AssignmentProvider
{

    /**
     * @param $role
     * @param $permission
     * @return bool
     */
    public function hasPermission($role, $permission):bool;

    /**
     * @param $permission
     * @return array
     */
    public function getRolesByPermission($permission);
}