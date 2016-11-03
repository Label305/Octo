<?php


namespace Tests;


use Mockery;
use Octo\Assignments\Assignments;
use Octo\Octo;
use Octo\RoleProvider;

class OctoTest extends TestCase
{

    public function test_can_by_role()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'view_user',
                'create_user'
            ],
            'moderator' => [
                'view_user'
            ]
        ]);

        $userId = 123;

        /** @var RoleProvider|Mockery\MockInterface $roleProvider */
        $roleProvider = Mockery::mock(RoleProvider::class);
        $roleProvider->shouldReceive('hasOneOfRoles')
            ->withArgs([$userId, ['admin']])
            ->andReturn(true);

        /* When */
        $octo = new Octo(
            $assignments->toProvider(),
            $roleProvider
        );
        $result = $octo->can($userId, 'create_user');

        /* Then */
        $this->assertTrue($result);
    }

    public function test_can_by_multiple_roles()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'view_user',
                'create_user'
            ],
            'moderator' => [
                'view_user'
            ]
        ]);

        $userId = 123;

        /** @var RoleProvider|Mockery\MockInterface $roleProvider */
        $roleProvider = Mockery::mock(RoleProvider::class);
        $roleProvider->shouldReceive('hasOneOfRoles')
            ->withArgs([$userId, ['admin', 'moderator']])
            ->andReturn(true);

        /* When */
        $octo = new Octo(
            $assignments->toProvider(),
            $roleProvider
        );
        $result = $octo->can($userId, 'view_user');

        /* Then */
        $this->assertTrue($result);
    }

    public function test_can_not_assigned()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'view_user',
                'create_user'
            ],
            'moderator' => [
                'view_user',
                'edit_user'
            ]
        ]);

        $userId = 123;

        /** @var RoleProvider|Mockery\MockInterface $roleProvider */
        $roleProvider = Mockery::mock(RoleProvider::class);
        $roleProvider->shouldReceive('hasOneOfRoles')
            ->withArgs([$userId, ['moderator']])
            ->andReturn(false);

        /* When */
        $octo = new Octo(
            $assignments->toProvider(),
            $roleProvider
        );
        $result = $octo->can($userId, 'edit_user');

        /* Then */
        $this->assertFalse($result);
    }

}