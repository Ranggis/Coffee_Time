<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ================= PUBLIC =================
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');
$routes->get('login', 'Home::login');

// ================= (DATABASE) =================
$routes->get('menu', 'Menu::index');
$routes->get('gallery', 'Gallery::index');
$routes->get('blog', 'Blog::index');
$routes->get('blog/read/(:segment)', 'Blog::read/$1');


// ================= AUTH =================
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/process_login', 'Auth::process_login');
$routes->post('auth/process_register', 'Auth::process_register');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('checkout', 'Checkout::index');
$routes->get('profile', 'Auth::profile');
$routes->post('profile/update', 'Auth::updateProfile');
$routes->post('checkout/process', 'Checkout::process');
$routes->get('payment/(:segment)', 'Payment::index/$1');
$routes->post('payment/confirm/(:segment)', 'Payment::confirm/$1');
$routes->get('tracking/(:segment)', 'Tracking::index/$1');
$routes->post('tracking/complete/(:segment)', 'Tracking::complete/$1');
$routes->get('contact', 'Contact::index');
$routes->post('contact/send', 'Contact::send');
$routes->post('auth/forgot_password', 'Auth::forgot_password');
$routes->get('auth/reset_password/(:any)', 'Auth::reset_password/$1');
$routes->post('auth/process_reset', 'Auth::process_reset');
$routes->get('admin/notifications', 'Admin::notifications');
$routes->get('user/history', 'User::history');
$routes->get('user/confirm_received/(:num)', 'User::confirm_received/$1');
$routes->get('user/profile', 'User::profile');
$routes->post('user/update_profile', 'User::update_profile');
$routes->get('user/cancel_order/(:num)', 'User::cancel_order/$1');

// ================= ADMIN (PRIVATE CONSOLE) =================
// 'filter' => 'adminAuth' memastikan hanya user dengan role admin yang bisa masuk
$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    
    // 1. Dashboard (Estate Overview)
    $routes->get('/', 'Admin::index'); 
    
    // 2. Manage Reservations (Orders)
    $routes->get('orders', 'Admin::orders');
    $routes->post('update_order_status/(:num)', 'Admin::update_order_status/$1');
    $routes->get('order_items/(:num)', 'Admin::order_items/$1');
    
    // 3. Product Catalog (Menu)
    $routes->get('products', 'Admin::products');
    $routes->post('save_product', 'Admin::save_product');
    $routes->get('delete_product/(:num)', 'Admin::delete_product/$1');
    
    // 4. Roast Journal (Blog)
    $routes->get('journal', 'Admin::journal');
    $routes->post('save_journal', 'Admin::save_journal');   // Proses Simpan/Update
    $routes->get('delete_journal/(:num)', 'Admin::delete_journal/$1'); // Proses Hapus
    
    // 5. Visual Archive (Gallery)
    $routes->get('gallery', 'Admin::gallery');
    $routes->post('save_gallery', 'Admin::save_gallery');
    $routes->get('delete_gallery/(:num)', 'Admin::delete_gallery/$1');
    
    // 6. Concierge Inbox (Messages)
    $routes->get('inbox', 'Admin::inbox');
    $routes->post('mark_message_read/(:num)', 'Admin::mark_message_read/$1');
    $routes->get('delete_message/(:num)', 'Admin::delete_message/$1');
    
    // 7. Access Control (Users)
    $routes->get('users', 'Admin::users');
    $routes->post('save_user', 'Admin::save_user');
    $routes->get('delete_user/(:num)', 'Admin::delete_user/$1');
});