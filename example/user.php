<?php


/*
 * Assigments is how permissions are assigned to a certain role or directly on a user
 */
$assignments = new Assignments();

const PERMISSION_CREATE_USER = 'create_user';
const PERMISSION_DELETE_USER = 'delete_user';

//Simple for role
const ROLE_ADMIN = 'admin';
$assignments->add(Assignment::forRole(ROLE_ADMIN, PERMISSION_CREATE_USER));
$assignments->add(Assignment::forRole(ROLE_ADMIN, PERMISSION_DELETE_USER));

//For a user custom
$user = new User();
$assignments->add(Assignment::forUser($user->getId(), PERMISSION_DELETE_USER));

/*
 * Assignment provider can be implemented with your own implementation or using one of Octo's
 */
$assignmentProvider = new AssignmentProvider();

$assignments->toProvider();

/*
 * Role provider can find roles for certain user
 */
$roleProvider = new RoleProvider();
//Has method ->hasOneOfRoles($user->getId(), [ROLE_ADMIN, xxx]);

$Octo = new Octo($assignmentProvider, $roleProvider);

$bool = $Octo->can($user->getId(), PERMISSION_CREATE_USER);
