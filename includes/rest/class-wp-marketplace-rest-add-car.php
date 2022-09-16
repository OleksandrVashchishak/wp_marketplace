<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Rest_Add_Car
{
    private $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'rest_api_add_car'));
    }

    public function rest_api_add_car()
    {
        $namespace = 'wm/v1';

        $brand_point = '(?P<brand>[a-zA-Z0-9-]+)';
        $model_point = '(?P<model>[a-zA-Z0-9-]+)';
        $year_point = '(?P<year>[a-zA-Z0-9-]+)';
        $mileage = '(?P<mileage>[a-zA-Z0-9-]+)';
        $price = '(?P<price>[a-zA-Z0-9-]+)';
    
        $rout = '/add-car/' . $brand_point . '/' . $model_point  . '/' . $year_point . '/' . $mileage . '/' . $price;

        register_rest_route($namespace, $rout, array(
            'methods' => 'GET',
            'callback' => array($this, 'add_car'),
        ));
    }

    public function add_car($request)
    {
        global $wpdb;

        $table_name = $this->table_name;
        $result =  $wpdb->insert(
            $table_name,
            [
                'brand'       => $request['brand'],
                'model'       => $request['model'],
                'year'        => $request['year'],
                'mileage'     => $request['mileage'],
                'price'       => $request['price'],
                'date'        => date('Y-m-d'),
                'status'      => 'created',
            ]
        );

        if ($result) {
            return 200;
        } else {
            return 300;
        }
    }
}
