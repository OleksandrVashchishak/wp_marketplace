<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Rest_Get_Dialogs
{
    private $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'rest_api_get_dialogs'));
    }

    public function rest_api_get_dialogs()
    {
        $namespace = 'wm/v1';
        $rout = '/get_dialogs';

        register_rest_route($namespace, $rout, array(
            'methods' => 'POST',
            'callback' => array($this, 'get_dialogs'),
            'args'     => array(
                'from_id' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'to_id' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
            ),
        ));
    }

    public function get_dialogs($request)
    {
        global $wpdb;
        $table_name = 'wp_dialogs';

        $response = array(
            'from_id' => sanitize_text_field($request->get_param('from_id')),
            'to_id' => sanitize_text_field($request->get_param('to_id')),
        );

        $from_id = $response['from_id'];
        $to_id = $response['to_id'];

        $messages_querry = $wpdb->prepare(
            "SELECT * FROM $table_name  WHERE `from_id` = $from_id OR `to_id` = '$to_id'"
        );
        $messages = $wpdb->get_results($messages_querry, 'ARRAY_A');
        return $messages;
    }
}
