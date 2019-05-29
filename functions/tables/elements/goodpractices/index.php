<?php
class Good_Practices {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['goodpractices'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Good_Practices::$filters = array(
            array ( 'title' => __( 'Nom', Oak::$text_domain ), 'property' => 'goodpractice_designation' ),
            array ( 'title' => __( 'Nom Court', Oak::$text_domain ), 'property' => 'goodpractice_short_designation' ),
            array ( 'title' => __( 'Lien', Oak::$text_domain ), 'property' => 'goodpractice_link' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'goodpractice';
        $elements = Oak::$goodpractices;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'goodpractice',
            'table_in_plural' => 'goodpractices',
            'elements' => Oak::$goodpractices,
            'properties' => array_merge( Oak::$shared_properties, Good_Practices::$properties ),
            'filters' => Good_Practices::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/goodpractices/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/goodpractices/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/goodpractices/functions/data-collector.php';
    }
}

$goodpractices = new Good_Practices();