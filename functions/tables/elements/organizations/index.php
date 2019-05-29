<?php
class Organizations {
    public static $properties;
    public static $filters;
    
    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['organizations'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Organizations::$filters = array(
            array ( 'title' => __( 'Acronyme', Oak::$text_domain ), 'property' => 'organization_acronym' ),
            array ( 'title' => __( 'Description', Oak::$text_domain ), 'property' => 'organization_description' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'organization_description' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'organization';
        $elements = Oak::$organizations;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'organization',
            'table_in_plural' => 'organizations',
            'elements' => Oak::$organizations,
            'properties' => array_merge( Oak::$shared_properties, Organizations::$properties ),
            'filters' => Organizations::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/organizations/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/organizations/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/organizations/functions/data-collector.php';
    }
}

$organizations = new Organizations();