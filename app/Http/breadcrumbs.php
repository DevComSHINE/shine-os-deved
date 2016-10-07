<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});

// Home > About
Breadcrumbs::register('roles', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Roles', route('roles'));
});

// Home > Roles > Edit
Breadcrumbs::register('Edit', function($breadcrumbs)
{
    $breadcrumbs->parent('roles');
    $breadcrumbs->push('edit', route('roles.edit'));
});