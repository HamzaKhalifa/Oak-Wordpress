<?php
class Quantis {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['quantis'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Quantis::$filters = array(
            array ( 'title' => __( 'Publication', Oak::$text_domain ), 'property' => 'quanti_publication' ),
            array ( 'title' => __( 'Parent', Oak::$text_domain ), 'property' => 'quanti_parent' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'quanti_parent' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'quanti';
        $elements = Oak::$quantis;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'quanti',
            'table_in_plural' => 'quantis',
            'elements' => Oak::$quantis,
            'properties' => array_merge( Oak::$shared_properties, Quantis::$properties ),
            'filters' => Quantis::$filters,
            'revisions' => Oak::$revisions
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

    public static function get_tabs_data( $identifier  ) {
        return array();
    }
}

$quantis = new Quantis();