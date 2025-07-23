<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

Breadcrumbs::for('dashboard', function (Generator $trail) {
    $trail->push('Dashboard', route('dashboard'));
});


// Customers
Breadcrumbs::for('customers.index', function (Generator $trail) {
    $trail->parent('dashboard');
    $trail->push('Customers', route('customers.index'));
});

Breadcrumbs::for('customers.create', function (Generator $trail) {
    $trail->parent('customers.index');
    $trail->push('Create Customer', route('customers.create'));
});

Breadcrumbs::for('customers.edit', function (Generator $trail,$customer) {
    $trail->parent('customers.index');
    $trail->push('Edit Customer', route('customers.edit', $customer));
});

Breadcrumbs::for('customers.show', function (Generator $trail,$customer) {
    $trail->parent('customers.index');
    $trail->push('View Customer', route('customers.show', $customer));
});

//product
Breadcrumbs::for('products.index', function (Generator $trail) {
    $trail->parent('dashboard');
    $trail->push('Products', route('products.index'));
});

Breadcrumbs::for('products.create', function (Generator $trail) {
    $trail->parent('products.index');
    $trail->push('Create Product', route('products.create'));
});

Breadcrumbs::for('products.edit', function (Generator $trail,$product) {
    $trail->parent('products.index');
    $trail->push('Edit Product', route('products.edit', $product));
});

Breadcrumbs::for('products.show', function (Generator $trail,$product) {
    $trail->parent('products.index');
    $trail->push('View Product', route('products.show', $product));
});

//user
Breadcrumbs::for('users.index', function (Generator $trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('users.index'));
});

Breadcrumbs::for('users.create', function (Generator $trail) {
    $trail->parent('users.index');
    $trail->push('Create User', route('users.create'));
});

Breadcrumbs::for('users.edit', function (Generator $trail,$user) {
    $trail->parent('users.index');
    $trail->push('Edit User', route('users.edit', $user));
});

Breadcrumbs::for('users.show', function (Generator $trail,$user) {
    $trail->parent('users.index');
    $trail->push('View User', route('users.show', $user));
});

//product Assignment
Breadcrumbs::for('product_assignments.index', function (Generator $trail) {
    $trail->parent('dashboard');
    $trail->push('Product Assignments', route('product_assignments.index'));
});
Breadcrumbs::for('product_assignments.create', function (Generator $trail) {
    $trail->parent('product_assignments.index');
    $trail->push('Create Product Assignment', route('product_assignments.create'));
});
Breadcrumbs::for('product_assignments.edit', function (Generator $trail,$product_assignment) {
    $trail->parent('product_assignments.index');
    $trail->push('Edit Product Assignment', route('product_assignments.edit', $product_assignment));
});

Breadcrumbs::for('product_assignments.show', function (Generator $trail,$product_assignment) {
    $trail->parent('product_assignments.index');
    $trail->push('View Product Assignment', route('product_assignments.show', $product_assignment));
});

//roles & permission
Breadcrumbs::for('roles.index', function (Generator $trail) {
    $trail->parent('dashboard');
    $trail->push('Roles & Permissions Management', route('roles.index'));
});
Breadcrumbs::for('roles.create', function (Generator $trail) {
    $trail->parent('roles.index');
    $trail->push('Create Role', route('roles.create'));
});
Breadcrumbs::for('roles.edit', function (Generator $trail,$role) {
    $trail->parent('roles.index');
    $trail->push('Edit Role', route('roles.edit', $role));
});

//licences
Breadcrumbs::for('licenses.index', function (Generator $trail) {
    $trail->parent('dashboard');
    $trail->push('Licenses Management', route('licenses.index'));
});

//logs
Breadcrumbs::for('logs.index', function (Generator $trail) {
    $trail->parent('dashboard');
    $trail->push('Logs Management', route('logs.index'));
});
