<?php
class Models {
    public static $properties;
    public static $other_elements;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['models'] = function() {
            $this->properties_to_enqueue_for_script();
        };
        
        Models::$filters = array (
            array ( 'title' => __( 'Types', Oak::$text_domain ), 'property' => 'model_types' ),
            array ( 'title' => __( 'Catégories de publications', Oak::$text_domain ), 'property' => 'model_publications_categories' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'model_publications_categories' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'model';
        $elements = Oak::$models;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        $properties = array_merge( Oak::$shared_properties, Models::$properties );
        $properties[] = array( 'name' => 'revision_number', 'type' => 'text', 'input_type' => 'checkbox' );
        $additional_data_to_pass = array(
            'fields' => Oak::$fields,
            'formsAndFields' => Oak::$all_forms_and_fields,
            'otherElementProperties' => Models::$other_elements,
            'attributes' => Forms::$attributes
        );
        Oak::$current_element_script_properties = array (
            'table' => 'model',
            'table_in_plural' => 'models',
            'elements' => Oak::$models,
            'properties' => $properties,
            'filters' => Models::$filters,
            'revisions' => Oak::$revisions
        );

        Oak::$current_element_script_properties = array_merge( Oak::$current_element_script_properties, $additional_data_to_pass );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/models/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/models/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/models/functions/data-collector.php';
    }

    static function get_model_fields( $model, $modify_current_model_fields ) {
        $model_fields = [];
        $model_fields_names = explode( '|', $model->model_fields_names );
        foreach( Oak::$all_models_and_forms as $model_and_form_instance ) :
            if ( $model_and_form_instance->model_identifier == $model->model_identifier 
                && $model_and_form_instance->model_revision_number == $model->model_revision_number 
            ) :
                $form_identifier = $model_and_form_instance->form_identifier;
                foreach( Oak::$forms_without_redundancy as $form ) :
                    if ( $form->form_identifier == $form_identifier ) :
                        foreach ( Oak::$all_forms_and_fields as $form_and_field_instance ) :
                            if ( $form_and_field_instance->form_identifier == $form->form_identifier 
                                && $form_and_field_instance->form_revision_number == $form->form_revision_number 
                            ) :
                                foreach( Oak::$fields_without_redundancy as $field ) :
                                    if ( $field->field_identifier == $form_and_field_instance->field_identifier ) :
                                        $field_copy = clone $field;
                                        $field_copy->field_name_in_model = $model_fields_names[ count( $model_fields ) ];
                                        if ( isset( $_GET['model_identifier'] ) ) :
                                            if ( $model->model_identifier == $_GET['model_identifier'] && $modify_current_model_fields === true ) :
                                                array_push( Oak::$current_model_fields, $field_copy );
                                            endif;
                                        endif;
                                        array_push( $model_fields, $field_copy );
                                    endif;
                                endforeach;
                            endif;
                        endforeach;
                    endif;
                endforeach;
            endif;
        endforeach;

        return $model_fields;
    }
    
    public static function get_tabs_data( $identifier  ) {
        return array();
    }

    public static function get_child_elements() {
        return ( 
            array (
                'for_table' => 'model',
                'table' => 'form',
                'elements_name' => 'forms',
                'get_child_elements_function' => function( $model_identifier ) {
                    $elements_to_return = array();
                    foreach( Oak::$all_models_and_forms as $model_and_form ) :
                        if ( $model_and_form->model_identifier == $model_identifier ) :
                            $forms_counter = 0;
                            $found_form = false;
                            do {
                                if ( Oak::$forms_without_redundancy[ $forms_counter ]->form_identifier == $model_and_form->form_identifier ) :
                                    $found_form = true;
                                    $elements_to_return[] = Oak::$forms_without_redundancy[ $forms_counter ];
                                endif;
                                $forms_counter++;
                            } while ( $forms_counter < count( Oak::$forms_without_redundancy ) && !$found_form );
                        endif;
                    endforeach;

                    return $elements_to_return;
                },
                'child_elements' => array(
                    'for_table' => 'form',
                    'table' => 'field',
                    'elements_name' => 'fields',
                    'get_child_elements_function' => function( $form_identifier ) {
                        $elements_to_return = array();
                        foreach( Oak::$all_forms_and_fields as $form_and_field ) :
                            if ( $form_and_field->form_identifier == $form_identifier ) :
                                $fields_counter = 0;
                                $found_field = false;
                                do {
                                    if ( Oak::$fields_without_redundancy[ $fields_counter ]->field_identifier == $form_and_field->field_identifier ) :
                                        $found_field = true;
                                        $elements_to_return[] = Oak::$fields_without_redundancy[ $fields_counter ];
                                    endif;
                                    $fields_counter++;
                                } while ( $fields_counter < count( Oak::$fields_without_redundancy ) && !$found_field );
                            endif;
                        endforeach;

                        return $elements_to_return;
                    },
                    'child_elements' => array()
                )
            )
        );
    }
}

$models = new Models();

// include get_template_directory() . '/functions/tables/elements/models/functions/table-creator.php';
// include get_template_directory() . '/functions/tables/elements/models/functions/data-collector.php';