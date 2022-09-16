<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Ajax_Table_Items
{
    private $cars;

    public function __construct($cars)
    {
        $this->cars = $cars;
        $this->init();
    }

    private function init()
    {
        $this->render_table_items();
    }

    private function render_table_items()
    {
        foreach ($this->cars as $car) { ?>
            <tr>
                <td> <?= $car['brand'] ?> </td>
                <td> <?= $car['model'] ?> </td>
                <td> <?= $car['year'] ?> </td>
                <td> <?= $car['mileage'] ?> </td>
                <td> <?= $car['price'] ?>$ </td>
                <td> <?= $car['date'] ?> </td>
                <td> <button class="remove-car" data-id='<?= $car['ID'] ?>'>Remove</button> </td>
            </tr>
<?php }
    }
}
