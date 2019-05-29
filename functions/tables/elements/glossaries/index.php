<?php
class Glossaries {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['glossaries'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Glossaries::$filters = array(
            array ( 'title' => __( 'Publication', Oak::$text_domain ), 'property' => 'glossary_publication' ),
            array ( 'title' => __( 'Parent', Oak::$text_domain ), 'property' => 'glossary_parent' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'glossary_parent' )
        );
    }

    function properties_to_enqueue_for_script() {
        $table = 'glossary';
        $elements = Oak::$glossaries;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'glossary',
            'table_in_plural' => 'glossaries',
            'elements' => Oak::$glossaries,
            'properties' => array_merge( Oak::$shared_properties, Glossaries::$properties ),
            'filters' => Glossaries::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/glossaries/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/glossaries/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/glossaries/functions/data-collector.php';
    }
}

$glossaries = new Glossaries();