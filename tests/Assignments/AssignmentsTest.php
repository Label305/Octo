<?php


namespace Tests\Assignments;


use Octo\AssignmentProvider;
use Octo\Assignments\Assignment;
use Octo\Assignments\Assignments;
use Tests\TestCase;

class AssignmentsTest extends TestCase
{

    public function test_add()
    {
        /* Given */
        $assignments = new Assignments();

        /* When */
        $assignment = new Assignment();
        $assignments->add($assignment);

        /* Then */
        $result = $assignments->all();
        $this->assertCount(1, $result);
        $this->assertEquals($assignment, $result[0]);
    }

    public function test_fromTree()
    {
        /* When */
        $assignments = Assignments::fromTree([
            'admin' => [
                'create_user',
                'read_user',
                'update_user',
                'delete_user'
            ],
            'manager' => [
                'create_user'
            ]
        ]);

        /* Then */
        $result = $assignments->all();
        $this->assertCount(5, $result);
    }

    public function test_toProvider()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'create_user',
                'read_user',
                'update_user',
                'delete_user'
            ],
            'manager' => [
                'create_user'
            ]
        ]);

        /* When */
        $result = $assignments->toProvider();

        /* Then */
        $this->assertInstanceOf(AssignmentProvider::class, $result);
    }

    public function test_getRolesByPermission()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'create_user',
                'read_user',
                'update_user',
                'delete_user'
            ],
            'manager' => [
                'create_user'
            ]
        ]);

        /* When */
        $roles = $assignments->getRolesByPermission('read_user');

        /* Then */
        $this->assertEquals(['admin'], $roles);
    }

    public function test_getRolesByPermission_noRolesWithPermission()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'create_user',
                'read_user',
                'update_user',
                'delete_user'
            ],
            'manager' => [
                'create_user'
            ]
        ]);

        /* When */
        $roles = $assignments->getRolesByPermission('read_company');

        /* Then */
        $this->assertEquals([], $roles);
    }

    public function test_exists()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'create_user',
                'read_user',
                'update_user',
                'delete_user'
            ],
            'manager' => [
                'create_user'
            ]
        ]);

        /* When */
        $result = $assignments->exists('manager', 'create_user');

        /* Then */
        $this->assertTrue($result);
    }

    public function test_exists_not()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'create_user',
                'read_user',
                'update_user',
                'delete_user'
            ],
            'manager' => [
                'create_user'
            ]
        ]);

        /* When */
        $result = $assignments->exists('manager', 'read_user');

        /* Then */
        $this->assertFalse($result);
    }

    public function test_addInheritance()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'create_user',
            ],
            'manager' => [
                'read_user'
            ]
        ]);

        /* When */
        $assignments->addParent('manager', 'admin');
        $result = $assignments->exists('admin', 'read_user');

        /* Then */
        $this->assertTrue($result);
    }

}