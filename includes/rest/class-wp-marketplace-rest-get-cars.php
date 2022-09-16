<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Rest_Get_Cars
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_get_cars'));
    }

    public function add_rest_api_get_cars()
    {
        $namespace = 'wm/v1';
        $id_point = '(?P<id>[0-9-]+)';
        $rout = '/get-cars/'. $id_point;

        register_rest_route($namespace, $rout, array(
            'methods' => 'GET',
            'callback' => array($this, 'get_cars'),
        ));
    }

    public function get_cars($request)
    {
        //  $request['id']
        global $wpdb;
        $table = $wpdb->prefix . "rent_car";
        $cars = $wpdb->prepare(
            "SELECT * FROM $table ORDER BY date "
        );
        $cars_arr = $wpdb->get_results($cars, 'ARRAY_A');

        return $cars_arr;
    }
}
