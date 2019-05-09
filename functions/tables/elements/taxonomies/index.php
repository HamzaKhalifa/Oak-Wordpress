<?php
class Taxonomies {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Taxonomies::$filters = array(
            array ( 'title' => __( 'Description', Oak::$text_domain ), 'property' => 'taxonomy_description' ),
            array ( 'title' => __( 'Structure', Oak::$text_domain ), 'property' => 'taxonomy_structure' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'taxonomy_structure' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/taxonomies/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/taxonomies/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/taxonomies/functions/data-collector.php';
    }
}

$taxonomies = new Taxonomies();