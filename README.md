Octo
====

[![Build Status](https://travis-ci.org/Label305/Octo.svg?branch=master)](https://travis-ci.org/Label305/Octo)

For structuring roles and their permissions in a flexible and clear way.

__Work in progress!__

We're working on this library to incorporate knowledge we've gathered
during the course of several projects, this is a start. 

Usage
-----

__Basic__

Simplest use case is a traditional role -> permission combination, such
that, for example, an `admin` has the permission `create_user` and
a `moderator` has the permission `create_post`. 

```php
$assignments = Assignments::fromTree([
    'admin' => ['create_user', 'create_post'],
    'moderator' => ['create_post']
]);

class MyRoleProvider implement RoleProvider {
    public function hasOneOfRoles($userId, array $roles):bool {
        /* Laravel Eloquent example */
        return Role::whereIn('name', $roles)->where('user_id', $user)->exists();
    }
}

$octo = new Octo(
    $assignments->toProvider(),
    new MyRoleProvider()
);

$octo->can(Auth::user()->id, 'create_user');
```

__Notes__

Please don't use string for roles and permissions directly, this will make
your codebase unmaintainable, as well as catching typos will be a nightmare, 
create enum-like classes, e.g.:

```php
class Roles {
    const ADMIN = 'admin';
}
class Permissions {
    const USER_CREATE = 'user_create';
}

$assignments = Assignments::fromTree([
    Roles::ADMIN => [
        Permissions::USER_CREATE 
    ]
]);
```



License
---------
Copyright 2016 Label305 B.V.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

[http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0)

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.