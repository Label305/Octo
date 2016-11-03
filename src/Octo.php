<?php


namespace Octo;


class Octo
{
    /**
     * @var AssignmentProvider
     */
    private $assignmentProvider;
    /**
     * @var RoleProvider
     */
    private $roleProvider;

    /**
     * Octo constructor.
     * @param AssignmentProvider $assignmentProvider
     * @param RoleProvider       $roleProvider
     */
    public function __construct(
        AssignmentProvider $assignmentProvider,
        RoleProvider $roleProvider
    ) {
        $this->assignmentProvider = $assignmentProvider;
        $this->roleProvider = $roleProvider;
    }


    /**
     * Check if a user has a certain permission
     * @param $userId
     * @param $permission
     * @return bool
     */
    public function can($userId, $permission):bool
    {
        $roles = $this->assignmentProvider->getRolesByPermission($permission);

        return $this->roleProvider->hasOneOfRoles($userId, $roles);
    }
}