<?php


namespace Octo\Assignments;


class Assignment
{

    /**
     * @var mixed
     */
    private $role;

    /**
     * @var mixed
     */
    private $permission;

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param mixed $permission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }

    /**
     * @param $role
     */
    public function withRole($role)
    {
        $assignment = clone $this;
        $assignment->setRole($role);

        return $assignment;
    }

}