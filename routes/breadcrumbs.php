<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push(Lang::get('Home'), route('home'));
});

// System
Breadcrumbs::for('system', function ($trail) {
    $trail->parent('home');
    $trail->push(Lang::get('System'), '#');
});

// User
Breadcrumbs::for('user.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('User'), route('user.index'));
});
Breadcrumbs::for('user.create', function ($trail) {
    $trail->parent('user.index');
    $trail->push(Lang::get('Create'), route('user.create'));
});
Breadcrumbs::for('user.edit', function ($trail) {
    $trail->parent('user.index');
    $trail->push(Lang::get('Edit'), route('user.edit', ''));
});
Breadcrumbs::for('user.show', function ($trail) {
    $trail->parent('user.index');
    $trail->push(Lang::get('View'), route('user.show', ''));
});

// Role
Breadcrumbs::for('role.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Role'), route('role.index'));
});
Breadcrumbs::for('role.create', function ($trail) {
    $trail->parent('role.index');
    $trail->push(Lang::get('Create'), route('role.create'));
});
Breadcrumbs::for('role.edit', function ($trail) {
    $trail->parent('role.index');
    $trail->push(Lang::get('Edit'), route('role.edit', ''));
});
Breadcrumbs::for('role.show', function ($trail) {
    $trail->parent('role.index');
    $trail->push(Lang::get('View'), route('role.show', ''));
});

// Permission
Breadcrumbs::for('permission.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Permission'), route('permission.index'));
});
Breadcrumbs::for('permission.create', function ($trail) {
    $trail->parent('permission.index');
    $trail->push(Lang::get('Create'), route('permission.create'));
});
Breadcrumbs::for('permission.edit', function ($trail) {
    $trail->parent('permission.index');
    $trail->push(Lang::get('Edit'), route('permission.edit', ''));
});
Breadcrumbs::for('permission.show', function ($trail) {
    $trail->parent('permission.index');
    $trail->push(Lang::get('View'), route('permission.show', ''));
});

// Record Rule
Breadcrumbs::for('record-rule.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Record Rule'), route('record-rule.index'));
});
Breadcrumbs::for('record-rule.create', function ($trail) {
    $trail->parent('record-rule.index');
    $trail->push(Lang::get('Create'), route('record-rule.create'));
});
Breadcrumbs::for('record-rule.edit', function ($trail) {
    $trail->parent('record-rule.index');
    $trail->push(Lang::get('Edit'), route('record-rule.edit', ''));
});
Breadcrumbs::for('record-rule.show', function ($trail) {
    $trail->parent('record-rule.index');
    $trail->push(Lang::get('View'), route('record-rule.show', ''));
});

// Parameter
Breadcrumbs::for('parameter.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Parameter'), route('parameter.index'));
});
Breadcrumbs::for('parameter.create', function ($trail) {
    $trail->parent('parameter.index');
    $trail->push(Lang::get('Create'), route('parameter.create'));
});
Breadcrumbs::for('parameter.edit', function ($trail) {
    $trail->parent('parameter.index');
    $trail->push(Lang::get('Edit'), route('parameter.edit', ''));
});
Breadcrumbs::for('parameter.show', function ($trail) {
    $trail->parent('parameter.index');
    $trail->push(Lang::get('View'), route('parameter.show', ''));
});

// Menu
Breadcrumbs::for('menu.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Menu'), route('menu.index'));
});
Breadcrumbs::for('menu.create', function ($trail) {
    $trail->parent('menu.index');
    $trail->push(Lang::get('Create'), route('menu.create'));
});
Breadcrumbs::for('menu.edit', function ($trail) {
    $trail->parent('menu.index');
    $trail->push(Lang::get('Edit'), route('menu.edit', ''));
});
Breadcrumbs::for('menu.show', function ($trail) {
    $trail->parent('menu.index');
    $trail->push(Lang::get('View'), route('menu.show', ''));
});

// Sequence
Breadcrumbs::for('sequence.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Sequence'), route('sequence.index'));
});
Breadcrumbs::for('sequence.create', function ($trail) {
    $trail->parent('sequence.index');
    $trail->push(Lang::get('Create'), route('sequence.create'));
});
Breadcrumbs::for('sequence.edit', function ($trail) {
    $trail->parent('sequence.index');
    $trail->push(Lang::get('Edit'), route('sequence.edit', ''));
});
Breadcrumbs::for('sequence.show', function ($trail) {
    $trail->parent('sequence.index');
    $trail->push(Lang::get('View'), route('sequence.show', ''));
});

// Sequence Period
Breadcrumbs::for('sequence.period.index', function ($trail, $data) {
    $trail->parent('sequence.index');
    $trail->push($data->name, route('sequence.show', $data->id));
    $trail->push(Lang::get('Period'), route('sequence.period.index', $data->id));
});
Breadcrumbs::for('sequence.period.create', function ($trail, $data) {
    $trail->parent('sequence.period.index', $data);
    $trail->push(Lang::get('Create'), route('sequence.period.create', $data->id));
});
Breadcrumbs::for('sequence.period.show', function ($trail, $data) {
    $trail->parent('sequence.period.index', $data->sequence);
    $trail->push(Lang::get('Show'), route('sequence.period.show', ["parentId"=>$data->sequence_id,"period"=>$data->id]));
});
Breadcrumbs::for('sequence.period.edit', function ($trail, $data) {
    $trail->parent('sequence.period.index', $data->sequence);
    $trail->push(Lang::get('Edit'), route('sequence.period.edit', ["parentId"=>$data->sequence_id,"period"=>$data->id]));
});

// Rule
Breadcrumbs::for('rule.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Rule'), route('rule.index'));
});
Breadcrumbs::for('rule.create', function ($trail) {
    $trail->parent('rule.index');
    $trail->push(Lang::get('Create'), route('rule.create'));
});
Breadcrumbs::for('rule.edit', function ($trail) {
    $trail->parent('rule.index');
    $trail->push(Lang::get('Edit'), route('rule.edit', ''));
});
Breadcrumbs::for('rule.show', function ($trail) {
    $trail->parent('rule.index');
    $trail->push(Lang::get('View'), route('rule.show', ''));
});

// Route
Breadcrumbs::for('route.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Route'), route('route.index'));
});
Breadcrumbs::for('route.create', function ($trail) {
    $trail->parent('route.index');
    $trail->push(Lang::get('Create'), route('route.create'));
});
Breadcrumbs::for('route.edit', function ($trail) {
    $trail->parent('route.index');
    $trail->push(Lang::get('Edit'), route('route.edit', ''));
});
Breadcrumbs::for('route.show', function ($trail) {
    $trail->parent('route.index');
    $trail->push(Lang::get('View'), route('route.show', ''));
});

// Job
Breadcrumbs::for('job.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Job'), route('job.index'));
});
Breadcrumbs::for('job.show', function ($trail) {
    $trail->parent('job.index');
    $trail->push(Lang::get('View'), route('job.show', ''));
});

// Notification Template
Breadcrumbs::for('notification-template.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Notification Template'), route('notification-template.index'));
});
Breadcrumbs::for('notification-template.create', function ($trail) {
    $trail->parent('notification-template.index');
    $trail->push(Lang::get('Create'), route('notification-template.create'));
});
Breadcrumbs::for('notification-template.edit', function ($trail) {
    $trail->parent('notification-template.index');
    $trail->push(Lang::get('Edit'), route('notification-template.edit', ''));
});
Breadcrumbs::for('notification-template.show', function ($trail) {
    $trail->parent('notification-template.index');
    $trail->push(Lang::get('View'), route('notification-template.show', ''));
});

// Node
Breadcrumbs::for('route.node.index', function ($trail, $data) {
    $trail->parent('route.index');
    $trail->push($data->name, route('route.show', $data->id));
    $trail->push(Lang::get('Node'), route('route.node.index', $data->id));
});

// Route Notification
Breadcrumbs::for('route.notification.index', function ($trail, $data) {
    $trail->parent('route.index');
    $trail->push($data->name, route('route.show', $data->id));
    $trail->push(Lang::get('Notification'), route('route.notification.index', $data->id));
});
Breadcrumbs::for('route.notification.create', function ($trail, $data) {
    $trail->parent('route.notification.index', $data);
    $trail->push(Lang::get('Create'), route('route.notification.create', $data->id));
});
Breadcrumbs::for('route.notification.show', function ($trail, $data) {
    $trail->parent('route.notification.index', $data->route);
    $trail->push(Lang::get('Show'), route('route.notification.show', ["parentId"=>$data->route_id,"notification"=>$data->id]));
});
Breadcrumbs::for('route.notification.edit', function ($trail, $data) {
    $trail->parent('route.notification.index', $data->route);
    $trail->push(Lang::get('Edit'), route('route.notification.edit', ["parentId"=>$data->route_id,"notification"=>$data->id]));
});

// Mail History
Breadcrumbs::for('mail-history.index', function ($trail) {
    $trail->parent('system');
    $trail->push(Lang::get('Mail History'), route('mail-history.index'));
});
Breadcrumbs::for('mail-history.show', function ($trail) {
    $trail->parent('mail-history.index');
    $trail->push(Lang::get('View'), route('mail-history.show', ''));
});

// Master
Breadcrumbs::for('master', function ($trail) {
    $trail->parent('home');
    $trail->push(Lang::get('Master'), '#');
});

// Company Group
Breadcrumbs::for('company-group.index', function ($trail) {
    $trail->parent('master');
    $trail->push(Lang::get('Company Group'), route('company-group.index'));
});
Breadcrumbs::for('company-group.create', function ($trail) {
    $trail->parent('company-group.index');
    $trail->push(Lang::get('Create'), route('company-group.create'));
});
Breadcrumbs::for('company-group.edit', function ($trail) {
    $trail->parent('company-group.index');
    $trail->push(Lang::get('Edit'), route('company-group.edit', ''));
});
Breadcrumbs::for('company-group.show', function ($trail) {
    $trail->parent('company-group.index');
    $trail->push(Lang::get('View'), route('company-group.show', ''));
});

// Company
Breadcrumbs::for('company.index', function ($trail) {
    $trail->parent('master');
    $trail->push(Lang::get('Company'), route('company.index'));
});
Breadcrumbs::for('company.create', function ($trail) {
    $trail->parent('company.index');
    $trail->push(Lang::get('Create'), route('company.create'));
});
Breadcrumbs::for('company.edit', function ($trail) {
    $trail->parent('company.index');
    $trail->push(Lang::get('Edit'), route('company.edit', ''));
});
Breadcrumbs::for('company.show', function ($trail) {
    $trail->parent('company.index');
    $trail->push(Lang::get('View'), route('company.show', ''));
});

// Position
Breadcrumbs::for('position.index', function ($trail) {
    $trail->parent('master');
    $trail->push(Lang::get('Position'), route('position.index'));
});
Breadcrumbs::for('position.create', function ($trail) {
    $trail->parent('position.index');
    $trail->push(Lang::get('Create'), route('position.create'));
});
Breadcrumbs::for('position.edit', function ($trail) {
    $trail->parent('position.index');
    $trail->push(Lang::get('Edit'), route('position.edit', ''));
});
Breadcrumbs::for('position.show', function ($trail) {
    $trail->parent('position.index');
    $trail->push(Lang::get('View'), route('position.show', ''));
});

// Department
Breadcrumbs::for('department.index', function ($trail) {
    $trail->parent('master');
    $trail->push(Lang::get('Department'), route('department.index'));
});
Breadcrumbs::for('department.create', function ($trail) {
    $trail->parent('department.index');
    $trail->push(Lang::get('Create'), route('department.create'));
});
Breadcrumbs::for('department.edit', function ($trail) {
    $trail->parent('department.index');
    $trail->push(Lang::get('Edit'), route('department.edit', ''));
});
Breadcrumbs::for('department.show', function ($trail) {
    $trail->parent('department.index');
    $trail->push(Lang::get('View'), route('department.show', ''));
});

// Attribute
Breadcrumbs::for('attribute.index', function ($trail) {
    $trail->parent('master');
    $trail->push(Lang::get('Attribute'), route('attribute.index'));
});
Breadcrumbs::for('attribute.create', function ($trail) {
    $trail->parent('attribute.index');
    $trail->push(Lang::get('Create'), route('attribute.create'));
});
Breadcrumbs::for('attribute.edit', function ($trail) {
    $trail->parent('attribute.index');
    $trail->push(Lang::get('Edit'), route('attribute.edit', ''));
});
Breadcrumbs::for('attribute.show', function ($trail) {
    $trail->parent('attribute.index');
    $trail->push(Lang::get('View'), route('attribute.show', ''));
});

// Employee
Breadcrumbs::for('employee.index', function ($trail) {
    $trail->parent('master');
    $trail->push(Lang::get('Employee'), route('employee.index'));
});
Breadcrumbs::for('employee.create', function ($trail) {
    $trail->parent('employee.index');
    $trail->push(Lang::get('Create'), route('employee.create'));
});
Breadcrumbs::for('employee.edit', function ($trail) {
    $trail->parent('employee.index');
    $trail->push(Lang::get('Edit'), route('employee.edit', ''));
});
Breadcrumbs::for('employee.show', function ($trail) {
    $trail->parent('employee.index');
    $trail->push(Lang::get('View'), route('employee.show', ''));
});