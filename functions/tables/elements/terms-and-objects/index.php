<?php
class Terms_And_Objects {
    function __construct() {
        $this->table_creator();
        $this->data_collector();
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/terms-and-objects/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/terms-and-objects/functions/data-collector.php';
    }
}

$terms_and_objects = new Terms_And_Objects();