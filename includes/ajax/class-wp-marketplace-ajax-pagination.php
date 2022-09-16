<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Ajax_Pagination
{
    private $table_name;
    private $post_per_page;

    public function __construct($table_name, $post_per_page)
    {
        $this->table_name = $table_name;
        $this->post_per_page = $post_per_page;
        $this->init();
    }


    private function init()
    {
        add_action('wp_ajax_wp_markplace_pagination', array($this, 'wp_markplace_pagination'));
    }

    public function wp_markplace_pagination()
    {
        global $wpdb;
        $post_per_page = $this->post_per_page;
        $table_name = $this->table_name;

        $page = $_POST['page'];
        $start_from = ($post_per_page * $page) - $post_per_page;
        $cars = $wpdb->prepare(
            "SELECT * FROM $table_name ORDER BY date LIMIT $start_from, $post_per_page"
        );
        $cars_arr = $wpdb->get_results($cars, 'ARRAY_A');

        new Wp_Marketplace_Ajax_Table_Items($cars_arr);
        die();
    }
}
