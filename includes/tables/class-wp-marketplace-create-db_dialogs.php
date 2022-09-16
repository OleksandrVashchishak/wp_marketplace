<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Create_Db_Dialogs
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "dialogs";
        $charset_collate = $wpdb->get_charset_collate();

        if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                ID mediumint(9) NOT NULL AUTO_INCREMENT,
                `from_id` text NOT NULL,
                `from_name` text NOT NULL,
                `to_id` text NOT NULL,
                `to_name` text NOT NULL,
                `messages` text NOT NULL,
                PRIMARY KEY  (ID)
        ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
}
