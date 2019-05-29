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

        Oak::$elements_script_properties_functions['forms'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Forms::$filters = array(
            array ( 'title' => __( 'Structure', Oak::$text_domain ), 'property' => 'form_structure' ),
            array ( 'title' => __( 'Attributs', Oak::$text_domain ), 'property' => 'form_attributes' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'form_attributes' )
        );
        
        Forms::$form_structures = array (
            array ( 'value' => '0', 'innerHTML' => 'Fixe' ),
        );
    }

    function properties_to_enqueue_for_script() {
        $table = 'form';
        $elements = Oak::$forms;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        $properties = array_merge( Oak::$shared_properties, Forms::$properties );
        $properties[] = array( 'name' => 'revision_number', 'type' => 'text', 'input_type' => 'checkbox' );

        $additional_data_to_pass = array(
            'otherElementProperties' => Forms::$other_elements,
            'attributes' => Oak::$forms_attributes
        );
        
        Oak::$current_element_script_properties = array (
            'table' => 'form',
            'table_in_plural' => 'forms',
            'elements' => Oak::$forms,
            'properties' => $properties,
            'filters' => Forms::$filters,
            'revisions' => Oak::$revisions
        );

        Oak::$current_element_script_properties = array_merge( Oak::$current_element_script_properties, $additional_data_to_pass );
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