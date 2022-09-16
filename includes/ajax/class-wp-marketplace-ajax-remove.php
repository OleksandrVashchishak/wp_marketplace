<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Ajax_Remove
{
    private $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->init();
    }

    private function init()
    {
        add_action('wp_ajax_wp_markplace_remove_car', array($this, 'wp_markplace_remove_car'));
    }

    public function wp_markplace_remove_car()
    {
        global $wpdb;
        $table_name = $this->table_name;

        $result = $wpdb->delete(
            $table_name,
            ['id' => $_POST['id']],
            ['%d'],
        );

        if ($result) {
            echo 200;
        } else {
            echo 300;
        }
        die();
    }
}
