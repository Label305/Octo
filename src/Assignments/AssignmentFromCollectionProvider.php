<?php


namespace Octo\Assignments;


use Octo\AssignmentProvider;

class AssignmentFromCollectionProvider implements AssignmentProvider
{
    /**
     * @var Assignments
     */
    private $assignments;

    /**
     * AssignmentFromCollectionProvider constructor.
     * @param Assignments $assignments
     */
    public function __construct(Assignments $assignments)
    {
        $this->assignments = $assignments;
    }

    /**
     * @param $role
     * @param $permission
     * @return bool
     */
    public function hasPermission($role, $permission):bool
    {
        return $this->assignments->exists($role, $permission);
    }

    /**
     * @param $permission
     * @return array
     */
    public function getRolesByPermission($permission)
    {
        return $this->assignments->getRolesByPermission($permission);
    }
}