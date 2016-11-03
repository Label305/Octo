<?php

$assignments = Assignments::fromTree([
    ROLE_ADMIN => [
        PERMISSION_CREATE_USER,
        PERMISSION_DELETE_USER
    ],
    ROLE_MODERATOR => [
        PERMISSION_CREATE_USER,
    ]
]);

/*
 * Assignments is how permissions are assigned to a certain role or directly on a user
 */
$assignments = new Assignments();

const PERMISSION_CREATE_USER = 'create_user';
const PERMISSION_DELETE_USER = 'delete_user';

//Simple for role
const ROLE_ADMIN = 'admin';
$assignments->add(Assignment::forRole(ROLE_ADMIN, PERMISSION_CREATE_USER));
$assignments->add(Assignment::forRole(ROLE_ADMIN, PERMISSION_DELETE_USER));

/*
 * Assignment provider can be implemented with your own implementation or using one of Octo's
 */
$assignmentProvider = new AssignmentProvider();

$assignmentProvider = $assignments->toProvider();

$Octo = new Octo($assignmentProvider);

$bool = $Octo->assigned(ROLE_ADMIN, PERMISSION_CREATE_USER);
