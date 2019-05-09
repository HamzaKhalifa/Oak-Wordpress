<?php
class Forms {
    public static $properties;
    public static $other_elements;
    public static $filters;

    public static $attributes = [];

    public static $form_structures = array (
        array ( 'value' => '0', 'innerHTML' => 'Fixe' ),
    );

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Forms::$filters = array(
            array ( 'title' => __( 'Structure', Oak::$text_domain ), 'property' => 'form_structure' ),
            array ( 'title' => __( 'Attributs', Oak::$text_domain ), 'property' => 'form_attributes' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'form_attributes' )
        );
        
        Forms::$form_structures = array (
            array ( 'value' => '0', 'innerHTML' => 'Fixe' ),
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/forms/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/forms/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/forms/functions/data-collector.php';
    }
}

$forms = new Forms();