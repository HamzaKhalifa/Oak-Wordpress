<?php
class Publications {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Publications::$filters = array(
            array ( 'title' => __( 'Année', Oak::$text_domain ), 'property' => 'publication_year' ),
            array ( 'title' => __( 'Format', Oak::$text_domain ), 'property' => 'publication_format' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'publication_format' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/publications/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/publications/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/publications/functions/data-collector.php';
    }
}

$publications = new Publications();