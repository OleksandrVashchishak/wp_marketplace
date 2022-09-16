<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Menu_item
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
        $menu_slug = 'rent-cars';
        add_menu_page('Rent cars ', 'Rent cars', 'read', $menu_slug, array($this, 'rent_cars_table_callback'));
        add_submenu_page($menu_slug, 'Add rent cars', 'Add rent cars', 'read', 'rent-add-cars',  array($this, 'rent_cars_add_callback'));
    }

    public function rent_cars_table_callback()
    {
        new Wp_Marketplace_Ajax_Rent_Table($this->table_name, $this->post_per_page);
    }

    public function rent_cars_add_callback()
    {
        new Wp_Marketplace_Ajax_Add_Car();
    }
}
