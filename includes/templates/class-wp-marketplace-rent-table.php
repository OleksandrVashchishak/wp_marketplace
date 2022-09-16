<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Ajax_Rent_Table
{
    private $table_name;
    private $post_per_page;
    private $columns;

    public function __construct($table_name, $post_per_page)
    {
        $this->table_name = $table_name;
        $this->post_per_page = $post_per_page;
        $this->columns = array('Brand', 'Model', 'Year', 'Mileage', 'Price', 'Date created', '');
        $this->init();
    }

    private function init()
    {
        $cars_arr = $this->get_cars_array();
        $this->render_table($cars_arr);
    }

    private function get_cars_array()
    {
        global $wpdb;
        $cars = $wpdb->prepare(
            "SELECT * FROM $this->table_name ORDER BY date LIMIT $this->post_per_page"
        );
        $cars_arr = $wpdb->get_results($cars, 'ARRAY_A');

        return $cars_arr;
    }

    private function calc_pagination()
    {
        global $wpdb;
        $cars_all = $wpdb->prepare(
            "SELECT * FROM $this->table_name ORDER BY date "
        );
        $cars_all_arr = $wpdb->get_results($cars_all, 'ARRAY_A');
        $pagination_count = ceil(count($cars_all_arr) / $this->post_per_page);
        return $pagination_count;
    }

    private function get_pagination()
    {
        $pagination_count = $this->calc_pagination();
        $html = '';
        for ($i = 1; $i < $pagination_count + 1; $i++) {
            if ($i == 1) {
                $html .= '<button class="current" data-page="' . $i . '">' . $i . '</button>';
            } else {
                $html .= '<button data-page="' . $i . '">' . $i . '</button>';
            }
        }
        return $html;
    }

    private function get_thead_tfoot()
    {
        $html = '<tr>';
        foreach ($this->columns as $column) {
            $html .= '<th>' . $column . '</th>';
        }
        $html .= '</tr>';
        return $html;
    }

    public function render_table($cars_arr)
    {
?>
        <div id="wpbody-content">
            <div class="wrap">
                <h1 class="wp-heading-inline"> Cars</h1>
                <table class="wp-list-table widefat plugins rc_add-car__table">
                    <thead><?php echo $this->get_thead_tfoot() ?></thead>
                    <tbody><?php new Wp_Marketplace_Ajax_Table_Items($cars_arr) ?></tbody>
                    <tfoot><?php echo $this->get_thead_tfoot() ?></tfoot>
                </table>
                <div class="pagination">
                    <ul><?php echo $this->get_pagination(); ?></ul>
                </div>
            </div>

            <button class="checks">check</button>

            <?php
            $marks = array("Peter" => 65, "Harry" => 80, "John" => 78, "Clark" => 90);
            echo json_encode($marks);
            ?>

        </div>
<?php
    }
}
