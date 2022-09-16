<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Create_Db_Cars
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "rent_car";
        $charset_collate = $wpdb->get_charset_collate();

        if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                ID mediumint(9) NOT NULL AUTO_INCREMENT,
                `brand` text NOT NULL,
                `model` text NOT NULL,
                `year` text NOT NULL,
                `mileage` text NOT NULL,
                `price` text NOT NULL,
                `date` text NOT NULL,
                `status` text NOT NULL,
                PRIMARY KEY  (ID)
        ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
}
