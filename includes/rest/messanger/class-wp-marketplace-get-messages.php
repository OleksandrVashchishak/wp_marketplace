<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Rest_Get_Messages
{
    private $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'rest_api_get_messages'));
    }

    public function rest_api_get_messages()
    {
        $namespace = 'wm/v1';
        $rout = '/get_messages';

        register_rest_route($namespace, $rout, array(
            'methods' => 'POST',
            'callback' => array($this, 'get_messages'),
            'args'     => array(
                'id' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
            ),
        ));
    }

    public function get_messages($request)
    {
        global $wpdb;
        $table_name = 'wp_dialogs';

        $response = array(
            'id' => sanitize_text_field($request->get_param('id')),
        );

        $id = $response['id'];

        $messages_querry = $wpdb->prepare(
            "SELECT * FROM $table_name  WHERE `ID` = $id"
        );
        $messages = $wpdb->get_results($messages_querry, 'ARRAY_A');

        return json_decode($messages[0]['messages']);
    }
}
