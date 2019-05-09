<?php
class Objects {
    public static $properties; 
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Objects::$filters = array(
            array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'object_identifier' ),
            array ( 'title' => __( 'Sélecteur de cadres RSE', Oak::$text_domain ), 'property' => 'object_selector' ),
            array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'object_identifier' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/objects/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/objects/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/objects/functions/data-collector.php';
    }
}

$objects = new Objects();