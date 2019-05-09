<?php
class Qualis {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Qualis::$filters = array(
            array ( 'title' => __( 'Publication', Oak::$text_domain ), 'property' => 'quali_publication' ),
            array ( 'title' => __( 'Parent', Oak::$text_domain ), 'property' => 'quali_parent' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'quali_parent' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/qualis/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/qualis/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/qualis/functions/data-collector.php';
    }
}

$qualis = new Qualis();