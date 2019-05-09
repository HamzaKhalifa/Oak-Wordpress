<?php
class Model {
    function __construct() {
        $this->table_creator();
        $this->data_collector();
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/models-and-forms/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/models-and-forms/functions/data-collector.php';
    }
}

$model = new Model();

// include get_template_directory() . '/functions/tables/elements/models-and-forms/functions/table-creator.php';
// include get_template_directory() . '/functions/tables/elements/models-and-forms/functions/data-collector.php';