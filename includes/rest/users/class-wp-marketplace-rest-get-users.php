<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Rest_Get_Users
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_get_users'));
    }

    public function add_rest_api_get_users()
    {
        $namespace = 'wm/v1';
        $id_point = '(?P<id>[0-9-]+)';
        $rout = '/get-users/' . $id_point;

        register_rest_route($namespace, $rout, array(
            'methods' => 'GET',
            'callback' => array($this, 'get_users'),
        ));
    }

    public function get_users($request)
    {
        $users_data = array();
        if ($request['id'] == -1) {
            $users = get_users();

            foreach ($users as $user) {
                $user_data = array();
                $user_data['ID'] = $user->ID;
                $user_data['name'] = $user->display_name;
                array_push($users_data, $user_data);
            }
            return $users_data;
        } else {
            $args = array(
                'include'      => array($request['id']),
            );

            $users = get_users($args);
            foreach ($users as $user) {
                $user_data = array();
                $user_data['ID'] = $user->ID;
                $user_data['display_name'] = $user->display_name;
                array_push($users_data, $user_data);
            }
            return $users_data;
        }
    }
}
