<?php
class Glossaries {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Glossaries::$filters = array(
            array ( 'title' => __( 'Publication', Oak::$text_domain ), 'property' => 'glossary_publication' ),
            array ( 'title' => __( 'Parent', Oak::$text_domain ), 'property' => 'glossary_parent' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'glossary_parent' )
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