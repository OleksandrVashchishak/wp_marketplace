<?php
if (!defined('ABSPATH')) {
    exit;
}

class Wp_Marketplace_Ajax_Add_Car
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
?>
        <div class="rc_add-car">
            <h1>Add new car</h1>
            <br>
            <div class="rc_add-car__wrapper">
                <input type="text" placeholder="Brand" class="rc_add-car__brand">
                <input type="text" placeholder="Model" class="rc_add-car__model">
                <input type="text" placeholder="Year" class="rc_add-car__year">
                <input type="text" placeholder="Mileage" class="rc_add-car__mileage">
                <input type="text" placeholder="Price" class="rc_add-car__price">
                <button type="button">Submit</button>
            </div>
        </div>
<?php
    }
}
