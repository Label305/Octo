<?php


namespace Tests\Assignments;


use Octo\Assignments\AssignmentFromCollectionProvider;
use Octo\Assignments\Assignments;
use Tests\TestCase;

class AssignmentFromCollectionProviderTest extends TestCase
{

    public function test_assigned()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'create_user'
            ]
        ]);
        $assignmentFromCollectionProvider = new AssignmentFromCollectionProvider($assignments);

        /* When */
        $result = $assignmentFromCollectionProvider->hasPermission('admin', 'create_user');

        /* Then */
        $this->assertTrue($result);
    }

    public function test_not_assigned()
    {
        /* Given */
        $assignments = Assignments::fromTree([
            'admin' => [
                'create_user',
                'delete_user'
            ],
            'moderator' => [
                'create_user'
            ]
        ]);
        $assignmentFromCollectionProvider = new AssignmentFromCollectionProvider($assignments);

        /* When */
        $result = $assignmentFromCollectionProvider->hasPermission('moderator', 'delete_user');

        /* Then */
        $this->assertFalse($result);
    }
}