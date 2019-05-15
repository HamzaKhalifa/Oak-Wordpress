<?php
class Sources {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Sources::$filters = array(
            array ( 'title' => __( 'Désignation', Oak::$text_domain ), 'property' => 'source_designation' ),
            array ( 'title' => __( 'Titre Court', Oak::$text_domain ), 'property' => 'source_short_title' ),
            array ( 'title' => __( 'Type', Oak::$text_domain ), 'property' => 'source_type' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/sources/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/sources/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/sources/functions/data-collector.php';
    }
}

$sources = new Sources();