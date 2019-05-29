<?php
class Sources {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['sources'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Sources::$filters = array(
            array ( 'title' => __( 'Désignation', Oak::$text_domain ), 'property' => 'source_designation' ),
            array ( 'title' => __( 'Titre Court', Oak::$text_domain ), 'property' => 'source_short_title' ),
            array ( 'title' => __( 'Type', Oak::$text_domain ), 'property' => 'source_type' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'source';
        $elements = Oak::$sources;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'source',
            'table_in_plural' => 'sources',
            'elements' => Oak::$sources,
            'properties' => array_merge( Oak::$shared_properties, Sources::$properties ),
            'filters' => Sources::$filters,
            'revisions' => Oak::$revisions
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