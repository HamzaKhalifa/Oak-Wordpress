<?php
class Fields {
    public static $filters;
    public static $properties;

    public static $field_types;
    public static $field_functions;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Fields::$field_types = array (
            array ( 'value' => 'text', 'innerHTML' => __( 'Texte', Oak::$text_domain ) ),
            array ( 'value' => 'textarea', 'innerHTML' => __( 'Zone de Texte', Oak::$text_domain ) ),
            array ( 'value' => 'image', 'innerHTML' => __( 'Image', Oak::$text_domain ) ),
            array ( 'value' => 'file', 'innerHTML' => __( 'Fichier', Oak::$text_domain ) ),
            array ( 'value' => 'url', 'innerHTML' => __( 'Url', Oak::$text_domain ) ),
            array ( 'value' => 'quali', 'innerHTML' => __( 'Indicateur Qualitatif', Oak::$text_domain ) ),
            array ( 'value' => 'quanti', 'innerHTML' => __( 'Indicateur Quantitatif', Oak::$text_domain ) ),
            array ( 'value' => 'selector', 'innerHTML' => __( 'Selecteur', Oak::$text_domain ) ),
            array ( 'value' => 'checkbox', 'innerHTML' => __( 'Booléen', Oak::$text_domain ) ),
        );

        Fields::$field_functions =  array ( 
            array ( 'value' => 'information/description', 'innerHTML' => __( 'Information/Description', Oak::$text_domain ) ), 
            array ( 'value' => 'example', 'innerHTML' => __( 'Exemple', Oak::$text_domain ) ), 
            array ( 'value' => 'illustration', 'innerHTML' => __( 'Illustration', Oak::$text_domain ) )
        );

        Fields::$filters = array(
            array ( 'title' => __( 'Nature', Oak::$text_domain ), 'property' => 'field_type', 'choices' => Fields::$field_types ),
            array ( 'title' => __( 'Fonction', Oak::$text_domain ), 'property' => 'field_function', 'choices' => Fields::$field_functions ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'field_function' )
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/fields/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/fields/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/fields/functions/data-collector.php';
    }
}

$fields = new Fields();