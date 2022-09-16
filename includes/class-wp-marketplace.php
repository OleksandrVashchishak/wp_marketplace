<?php
class wp_marketplace
{
    private static $_instance = null;
    public $_version;
    public $_token;
    public $file;
    public $dir;
    public $assets_dir;
    public $assets_url;
    public $script_suffix;
    public $table_name;
    public $post_per_page;

    public function __construct($file = '', $version = '1.0.0')
    {
        global $wpdb;
        $this->_version = $version;
        $this->_token   = 'wp_marketplace';
        $this->file       = $file;
        $this->dir        = dirname($this->file);
        $this->assets_dir = trailingslashit($this->dir) . 'assets';
        $this->assets_url = esc_url(trailingslashit(plugins_url('/assets/', $this->file)));
        $this->table_name = $wpdb->prefix . "rent_car";
        $this->post_per_page = 5;
        $this->init();
    }

    public function init()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'), 10);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 10);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'), 10, 1);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 10, 1);
        add_action('admin_menu', array($this, 'add_menu_items'));

        $this->ajax_queryes($this->table_name, $this->post_per_page);
        $this->init_rest_api($this->table_name);
        $this->create_tables($this->table_name);
    }

    public function create_tables($table_name)
    {
        new Wp_Marketplace_Create_Db_Cars($table_name);
        new Wp_Marketplace_Create_Db_Dialogs();
    }

    public function init_rest_api($table_name)
    {
        new Wp_Marketplace_Rest_Get_Cars();
        new Wp_Marketplace_Rest_Add_Car($table_name);
        new Wp_Marketplace_Rest_Register_User($table_name);
        new Wp_Marketplace_Rest_Get_Users();
        new Wp_Marketplace_Rest_Get_User_ID();
        new Wp_Marketplace_Rest_Send_Message($table_name);
        new Wp_Marketplace_Rest_Get_Messages($table_name);
        new Wp_Marketplace_Rest_Get_Dialogs($table_name);
        new Wp_Marketplace_Rest_Add_Media();
    }


    public function register_templates($page_name, $template_name)
    {
        $tamplates = new Wp_Marketplace_Templates($page_name, $template_name);
        return $tamplates;
    }

    public function add_menu_items()
    {
        $menu_items = new Wp_Marketplace_Menu_item($this->table_name, $this->post_per_page);
        return $menu_items;
    }

    private function ajax_queryes($table_name, $post_per_page)
    {
        new Wp_Marketplace_Ajax_Create($table_name);
        new Wp_Marketplace_Ajax_Remove($table_name);
        new Wp_Marketplace_Ajax_Pagination($table_name, $post_per_page);
    }

    public function enqueue_styles()
    {
        wp_register_style($this->_token . '-frontend', esc_url($this->assets_url) . 'css/style.css', array(), $this->_version);
        wp_enqueue_style($this->_token . '-frontend');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->_token .  'jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), null, true);

        wp_register_script($this->_token . '-create-car-rent', esc_url($this->assets_url) . 'js/ajax/create-car-rent.js', array('jquery'), $this->_version, true);
        wp_enqueue_script($this->_token . '-create-car-rent');

        wp_register_script($this->_token . '-remove-car', esc_url($this->assets_url) . 'js/ajax/remove-car.js', array('jquery'), $this->_version, true);
        wp_enqueue_script($this->_token . '-remove-car');

        wp_register_script($this->_token . '-pagination', esc_url($this->assets_url) . 'js/ajax/pagination.js', array('jquery'), $this->_version, true);
        wp_enqueue_script($this->_token . '-pagination');
    }

    public static function instance($file = '', $version = '1.0.0')
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($file, $version);
        }

        return self::$_instance;
    }
}
