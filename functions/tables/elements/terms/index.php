<?php
class Terms {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Terms::$filters = array(
            array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'term_identifier' ),
            array ( 'title' => __( 'Sélecteur de cadres RSE', Oak::$text_domain ), 'property' => 'term_selector' ),
            array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'term_identifier' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/terms/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/terms/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/terms/functions/data-collector.php';
    }
}

$terms = new Terms();