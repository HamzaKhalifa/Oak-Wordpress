<?php
class Organizations {
    public static $properties;
    public static $filters;
    
    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Organizations::$filters = array(
            array ( 'title' => __( 'Acronyme', Oak::$text_domain ), 'property' => 'organization_acronym' ),
            array ( 'title' => __( 'Description', Oak::$text_domain ), 'property' => 'organization_description' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'organization_description' )
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