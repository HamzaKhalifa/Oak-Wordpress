<?php
class Form_And_Field {
    function __construct() {
        $this->table_creator();
        $this->data_collector();
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/forms-and-fields/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/forms-and-fields/functions/data-collector.php';
    }
}

$form_and_field = new Form_And_Field();