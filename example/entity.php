<?php

/*
 * A user can be tied to, for example, a company, which causes him to inherit
 * all permissions for that certain company, however since company->has(track)
 * it will also get all permissions within its role for all tracks beneath the
 * company.
 */
$entities = new Entities();

//Example (maybe more like eloquent relations)
class CompanyEntity implements Entity, EntityVisitor {
    public function has($companyId, $otherId, Entity $entity) {
        EntityVisitor::visit($companyId, $otherId, $entity);
    }
    
    public function hasReseller($companyId, $resellerId) {
        
    }
}

$resellerEntity = new Entity('reseller', $resellerRelationProvider);
$companyEntity = new Entity('company', $companyRelationProvider);
$trackEntity = new Entity('track', $trackRelationProvider);

$resellerEntity->has($companyEntity);
$companyEntity->has($trackEntity);

/*
 * Assigments is how permissions are assigned to a certain role
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

/*
 * Role provider can find roles for certain user
 */
$roleProvider = new RoleProvider();

$Octo = new Octo($assignmentProvider, $roleProvider, $entities);

$user = new User();
$company = new Company();
$bool = $Octo->canForEntity($user->getId(), PERMISSION_CREATE_USER, Entities::COMPANY, $company->getId());
$bool = $Octo->canForEntity($user->getId(), PERMISSION_CREATE_USER, Entities::TRACK, $track->getId());
$bool = Octo::canForEntity($user->getId(), PERMISSION_CREATE_USER, Entities::TRACK, $track->getId());


