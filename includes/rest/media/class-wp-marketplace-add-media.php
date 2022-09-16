<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Rest_Add_Media
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'rest_api_add_media'));
    }

    public function rest_api_add_media()
    {
        $namespace = 'wm/v1';
        $rout = '/add_media';

        register_rest_route($namespace, $rout, array(
            'methods' => 'POST',
            'callback' => array($this, 'add_media'),
            'args'     => array(
                'hash' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'format' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
            ),
        ));
    }

    public function add_media($request)
    {
        $response = array(
            'hash' => sanitize_text_field($request->get_param('hash')),
            'format' => sanitize_text_field($request->get_param('format')),
        );

        $base64_img = $response['hash'];
        $format = $response['format'];
        $title = 'title';

        $upload_dir  = wp_upload_dir();
        $upload_path = str_replace('/', DIRECTORY_SEPARATOR, $upload_dir['path']) . DIRECTORY_SEPARATOR;

        $img             = str_replace('data:image/'. $format .';base64,', '', $base64_img);
        $img             = str_replace(' ', '+', $img);
        $decoded         = base64_decode($img);
        $filename        = $title;
        $file_type       = 'image/' . $format;
        $hashed_filename = md5($filename . microtime()) . '_' . $filename;
        file_put_contents($upload_path . $hashed_filename, $decoded);

        $attachment = array(
            'post_mime_type' => $file_type,
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($hashed_filename)),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'guid'           => $upload_dir['url'] . '/' . basename($hashed_filename)
        );

        $attach_id = wp_insert_attachment($attachment, $upload_dir['path'] . '/' . $hashed_filename);
        return $attach_id;
    }
}
