<?php
class Performances {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Performances::$filters = array(
            array ( 'title' => __( 'Nom', Oak::$text_domain ), 'property' => 'performance_designation' ),
            array ( 'title' => __( 'Type', Oak::$text_domain ), 'property' => 'performance_type' ),
            array ( 'title' => __( 'Objectif', Oak::$text_domain ), 'property' => 'performance_goal' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/performances/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/performances/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/performances/functions/data-collector.php';
    }
}

$performances = new Performances();