<?php
class Publications {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['publications'] = function() {
            $this->properties_to_enqueue_for_script();
        };
        
        Publications::$filters = array(
            array ( 'title' => __( 'Année', Oak::$text_domain ), 'property' => 'publication_year' ),
            array ( 'title' => __( 'Format', Oak::$text_domain ), 'property' => 'publication_format' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'publication_format' )
        );
    }
    
    public static function properties_to_enqueue_for_script() {
        $table = 'publication';
        $elements = Oak::$publications;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'publication',
            'table_in_plural' => 'publications',
            'elements' => Oak::$publications,
            'properties' => array_merge( Oak::$shared_properties, Publications::$properties ),
            'filters' => Publications::$filters,
            'revisions' => Oak::$revisions
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