<?php
class Performances {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();
        
        Oak::$elements_script_properties_functions['performances'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Performances::$filters = array(
            array ( 'title' => __( 'Nom', Oak::$text_domain ), 'property' => 'performance_designation' ),
            array ( 'title' => __( 'Type', Oak::$text_domain ), 'property' => 'performance_type' ),
            array ( 'title' => __( 'Type', Oak::$text_domain ), 'property' => 'performance_type' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'performance';
        $elements = Oak::$performances;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'performance',
            'table_in_plural' => 'performances',
            'elements' => Oak::$performances,
            'properties' => array_merge( Oak::$shared_properties, Performances::$properties ),
            'filters' => Performances::$filters,
            'revisions' => Oak::$revisions
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