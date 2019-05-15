<?php
class Quantis {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Quantis::$filters = array(
            array ( 'title' => __( 'Publication', Oak::$text_domain ), 'property' => 'quanti_publication' ),
            array ( 'title' => __( 'Parent', Oak::$text_domain ), 'property' => 'quanti_parent' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'quanti_parent' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/quantis/functions/properties-initialization.php';
    }
    
    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/quantis/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/quantis/functions/data-collector.php';
    }
}

$quantis = new Quantis();