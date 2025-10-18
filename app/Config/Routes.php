<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');

// TAREAS (Rutas simplificadas y limpiadas, el filtro 'login' debe aplicarse en app/Config/Filters.php)
$routes->get('tasks', 'Tasks::index');
$routes->get('tasks/show/(:num)', 'Tasks::show/$1');
$routes->get('tasks/new', 'Tasks::new');
$routes->post('tasks/create', 'Tasks::create');
$routes->get('tasks/edit/(:num)', 'Tasks::edit/$1');
$routes->post('tasks/update/(:num)', 'Tasks::update/$1');
$routes->match(['get', 'post'], 'tasks/delete/(:num)', 'Tasks::delete/$1');

// SIGNUP (Con filtro 'guest')
$routes->get('signup', 'Signup::new', ['filter' => 'guest']);
$routes->get('signup/new', 'Signup::new', ['filter' => 'guest']);
$routes->post('signup/create', 'Signup::create', ['filter' => 'guest']);
$routes->get('signup/success', 'Signup::success', ['filter' => 'guest']);

// LOGIN (Con filtro 'guest' para acceso)
$routes->get('login', 'Login::new', ['filter' => 'guest']);
$routes->post('login/create', 'Login::create', ['filter' => 'guest']);
$routes->post('login/authenticate', 'Login::authenticate', ['filter' => 'guest']);

// LOGOUT (SIN filtro 'guest')
$routes->get('login/logout', 'Login::delete');
$routes->get('logout', 'Login::delete');
$routes->get('login/logout', 'Login::logout');
$routes->get('logout', 'Login::logout');
$routes->get('login/showLogoutMessage', 'Login::showLogoutMessage'); 

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'login'], function($routes) {
    
    // Página principal de usuarios
    $routes->get('users', 'Users::index');
    
    // Mostrar un usuario
    $routes->get('users/show/(:num)', 'Users::show/$1');
    
    // Crear nuevo usuario
    $routes->get('users/new', 'Users::new');
    $routes->post('users/create', 'Users::create');
    
    
    // Editar usuario existente
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->post('users/update/(:num)', 'Users::update/$1');
    
    // Eliminar usuario
    $routes->match(['get', 'post'], 'users/delete/(:num)', 'Users::delete/$1');

    $routes->group('admin', ['filter' => 'login'], function($routes) {
    $routes->resource('users');
});
});

