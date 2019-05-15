<?php
class Good_Practices {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Good_Practices::$filters = array(
            array ( 'title' => __( 'Nom', Oak::$text_domain ), 'property' => 'goodpractice_designation' ),
            array ( 'title' => __( 'Nom Court', Oak::$text_domain ), 'property' => 'goodpractice_short_designation' ),
            array ( 'title' => __( 'Lien', Oak::$text_domain ), 'property' => 'goodpractice_link' )
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