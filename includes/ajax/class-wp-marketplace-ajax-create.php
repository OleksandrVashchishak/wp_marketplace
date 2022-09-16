<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Ajax_Create
{
    private $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->init();
    }

    private function init() {
        add_action('wp_ajax_wp_markplace_create_new_rent', array($this, 'wp_markplace_create_new_rent'));
        add_action('wp_ajax_nopriv_wp_markplace_create_new_rent', array($this, 'wp_markplace_create_new_rent'));
    }

    public function wp_markplace_create_new_rent()
    {
        global $wpdb;

        $table_name = $this->table_name;
        $result =  $wpdb->insert(
            $table_name,
            [
                'brand'       => $_POST['brand'],
                'model'       => $_POST['model'],
                'year'        => $_POST['year'],
                'mileage'     => $_POST['mileage'],
                'price'       => $_POST['price'],
                'date'        => date('Y-m-d'),
                'status'      => 'created',
            ]
        );

        if ($result) {
            echo 200;
        } else {
            echo 300;
        }
        die();
    }
 
}
