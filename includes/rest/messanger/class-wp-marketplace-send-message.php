<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Rest_Send_Message
{
    private $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'rest_api_send_message'));
    }

    public function rest_api_send_message()
    {
        $namespace = 'wm/v1';
        $rout = '/send_message';

        register_rest_route($namespace, $rout, array(
            'methods' => 'POST',
            'callback' => array($this, 'send_message'),
            'args'     => array(
                'message' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'dialog_id' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'user_id' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
            ),
        ));
    }

    public function send_message($request)
    {
        global $wpdb;
        $table_name = 'wp_dialogs';

        $response = array(
            'message' => sanitize_text_field($request->get_param('message')),
            'dialog_id' => sanitize_text_field($request->get_param('dialog_id')),
            'user_id' => sanitize_text_field($request->get_param('user_id')),
        );

        $dialog_id = $response['dialog_id'];
        $user_id = $response['user_id'];
        $message = $response['message'];

        $new_massage = array(
            'time' => date("h:i:s - Y/m/d"),
            'message' => $message,
            'user_id' => $user_id,
        );

        $new_dialog_check = explode('-', $dialog_id);
        if ($new_dialog_check &&  $new_dialog_check[0] == 'new') {
            return $this->create_dialog($new_dialog_check[1], $user_id, $new_massage);
        } else {

            $messages_querry = $wpdb->prepare(
                "SELECT * FROM $table_name  WHERE `ID` = $dialog_id"
            );
            $messages_json = $wpdb->get_results($messages_querry, 'ARRAY_A');
            $messages_array = json_decode($messages_json[0]['messages']);
            array_push($messages_array, $new_massage);


            $result =  $wpdb->update(
                $table_name,
                ['messages'        => json_encode($messages_array)],
                ['ID' => $dialog_id]
            );

            if ($result) {
                return 200;
            } else {
                return 300;
            }
        }
    }


    public function create_dialog($to_id, $from_id, $new_massage)
    {
        global $wpdb;
        $table_name = 'wp_dialogs';
        $messages = array();
        array_push($messages, $new_massage);

        $to_data = get_users(array('include'      => array($to_id)));
        $from_data = get_users(array('include'      => array($from_id)));

        $result =  $wpdb->insert(
            $table_name,
            [
                'from_id'       => $from_id,
                'from_name'     => $from_data[0]->data->display_name,
                'to_id'       => $to_id,
                'to_name'   => $to_data[0]->data->display_name,
                'messages'        => json_encode($messages),
            ]
        );

        $index = $wpdb->insert_id;
        return $index;
    }
}
