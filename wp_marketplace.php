<?php

/**
 * Plugin Name: WP Marketplace
 * Version: 1.0.0
 * Description: WP Marketplace
 * Author: Alex Vashch
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once 'includes/class-wp-marketplace.php';

require_once 'includes/lib/class-wp-marketplace-add-menu-item.php';

require_once 'includes/tables/class-wp-marketplace-create-db_cars.php';
require_once 'includes/tables/class-wp-marketplace-create-db_dialogs.php';


require_once 'includes/ajax/class-wp-marketplace-ajax-create.php';
require_once 'includes/ajax/class-wp-marketplace-ajax-remove.php';
require_once 'includes/ajax/class-wp-marketplace-ajax-pagination.php';

require_once 'includes/templates/class-wp-marketplace-add-car.php';
require_once 'includes/templates/class-wp-marketplace-rent-table.php';
require_once 'includes/templates/class-wp-marketplace-table-items.php';

require_once 'includes/rest/class-wp-marketplace-rest-get-cars.php';
require_once 'includes/rest/class-wp-marketplace-rest-add-car.php';
require_once 'includes/rest/users/class-wp-marketplace-rest-register-user.php';
require_once 'includes/rest/users/class-wp-marketplace-rest-get-users.php';
require_once 'includes/rest/users/class-wp-marketplace-rest-get-user-id.php';
require_once 'includes/rest/messanger/class-wp-marketplace-send-message.php';
require_once 'includes/rest/messanger/class-wp-marketplace-get-messages.php';
require_once 'includes/rest/messanger/class-wp-marketplace-get-dialogs.php';
require_once 'includes/rest/media/class-wp-marketplace-add-media.php';



function wp_marketplace()
{
    $instance = wp_marketplace::instance(__FILE__, '1.0.0');
    return $instance;
}

wp_marketplace();

require_once 'includes/rest/example/example.php';

