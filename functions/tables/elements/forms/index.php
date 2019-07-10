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

    public static function properties_to_enqueue_for_script() {
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

    public static function get_tabs_data( $identifier  ) {
        $tabs_data = array();
        if ( $identifier == '' ) :
            return $tabs_data;
        endif;

        $tabs_element = array(
            'title' => __( 'Modèles', Oak::$text_domain ),
            'elements' => 'models',
            'elements_instances' => array(),
            'table' => 'model'
        );
        foreach( Oak::$models_without_redundancy as $model ) :
            foreach( Oak::$all_models_and_forms as $single_model_and_form ) :
                if ( $single_model_and_form->model_revision_number == $model->model_revision_number 
                    && $single_model_and_form->form_identifier == $identifier 
                    && $single_model_and_form->model_identifier == $model->model_identifier
                    ) :
                    $model_already_exists = false;
                    foreach( $tabs_element['elements_instances'] as $element ) :
                        if ( $element->model_identifier == $model->model_identifier ) :
                            $model_already_exists = true;
                        endif;
                    endforeach;
                    
                    if ( !$model_already_exists ) :
                        $tabs_element['elements_instances'][] = $model;
                    endif;
                endif;
            endforeach;
        endforeach;

        $tabs_data[] = $tabs_element;

        return $tabs_data;
    }
}

// if ( 
//     ( 
//         isset( $_GET['elements'] ) && 
//         in_array( $_GET['elements'], ['forms', 'models', 'objects', 'sources', 'performances', 'goodpractices'] ) 
//     ) || 
//     ( 
//         did_action( 'elementor/loaded' ) &&
//         \Elementor\Plugin::$instance->editor != null &&
//         \Elementor\Plugin::$instance->editor->is_edit_mode() 
//     )
// ) 
    $forms = new Forms();