<?php
class Models {
    public static $properties;
    public static $other_elements;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Models::$filters = array (
            array ( 'title' => __( 'Types', Oak::$text_domain ), 'property' => 'model_types' ),
            array ( 'title' => __( 'Catégories de publications', Oak::$text_domain ), 'property' => 'model_publications_categories' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'model_publications_categories' )
        );
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

    static function get_model_fields( $model ) {
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
                                            if ( $model->model_identifier == $_GET['model_identifier'] ) :
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
}

$models = new Models();

// include get_template_directory() . '/functions/tables/elements/models/functions/table-creator.php';
// include get_template_directory() . '/functions/tables/elements/models/functions/data-collector.php';