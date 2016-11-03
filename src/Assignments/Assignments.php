<?php


namespace Octo\Assignments;

use Octo\AssignmentProvider;

class Assignments
{

    /**
     * @var Assignment[]
     */
    private $assignments = [];

    /**
     * Create all assignments from tree of roles vs. permissions, e.g.:
     *
     * [
     *      'admin' => [
     *          'create_user',
     *          'read_user',
     *          'update_user',
     *          'delete_user'
     *      ],
     *      'manager' => [
     *          'create_user'
     *      ]
     * ]
     *
     * Will create a list of assignments
     *
     * @param $array
     */
    public static function fromTree($array)
    {
        $assignments = new Assignments();
        foreach ($array as $role => $permissions) {
            foreach ($permissions as $permission) {
                $assignment = new Assignment();
                $assignment->setRole($role);
                $assignment->setPermission($permission);
                $assignments->add($assignment);
            }
        }

        return $assignments;
    }

    /**
     * @param Assignment $assignment
     */
    public function add(Assignment $assignment)
    {
        $this->assignments[] = $assignment;
    }

    /**
     * Check if a combination of role vs. permission exists
     * @param $role
     * @param $permission
     * @return bool
     */
    public function exists($role, $permission):bool
    {
        foreach ($this->assignments as $assignment) {
            if (
                $assignment->getRole() === $role
                && $assignment->getPermission() === $permission
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Fetch a list of roles that have a certain permission
     * @param $permission
     */
    public function getRolesByPermission($permission)
    {
        $roles = [];
        foreach ($this->assignments as $assignment) {
            if ($assignment->getPermission() === $permission) {
                $roles[] = $assignment->getRole();
            }
        }

        return $roles;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->assignments;
    }

    /**
     * Create simple assingment provider from this list of assignments
     * @return AssignmentProvider
     */
    public function toProvider():AssignmentProvider
    {
        return new AssignmentFromCollectionProvider($this);
    }

    /**
     * Will define a certain role as a parent such that the parent inherits all permissions of the child
     * @param $child
     * @param $parent
     */
    public function addParent($child, $parent)
    {
        foreach ($this->assignments as $assignment) {
            if (
                $assignment->getRole() === $child
                && !$this->exists($parent, $assignment->getPermission())
            ) {
                $this->assignments[] = $assignment->withRole($parent);
            }
        }
    }

}