<?php
class Fields {
    public static $filters;
    public static $properties;

    public static $field_types;
    public static $field_functions;

    function __construct() {
        $this->table_creator();
        Fields::data_collector();

        Oak::$elements_script_properties_functions['fields'] = function() {
            $this->properties_to_enqueue_for_script();
        };

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

    public static function properties_to_enqueue_for_script() {
        $table = 'field';
        $elements = Oak::$fields;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => $table,
            'table_in_plural' => 'fields',
            'elements' => $elements,
            'properties' => array_merge( Oak::$shared_properties, Fields::$properties ),
            'filters' => Fields::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/fields/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/fields/functions/table-creator.php';
    }

    public static function data_collector() {
        include get_template_directory() . '/functions/tables/elements/fields/functions/data-collector.php';
    }

    public static function get_tabs_data( $identifier  ) {
        $tabs_data = array();
        if ( $identifier == '' ) :
            return $tabs_data;
        endif;

        $tabs_element = array(
            'title' => __( 'Formulaires', Oak::$text_domain ),
            'elements' => 'forms',
            'elements_instances' => array(),
            'table' => 'form'
        );

        $models_elements_instances = [];
        foreach( Oak::$forms_without_redundancy as $form ) :
            foreach( Oak::$all_forms_and_fields as $single_form_and_field ) :
                if ( $single_form_and_field->form_revision_number == $form->form_revision_number 
                    && $single_form_and_field->field_identifier == $identifier
                    && $single_form_and_field->form_identifier == $form->form_identifier ) :
                    $form_already_exists = false;
                    foreach( $tabs_element['elements_instances'] as $element ) :
                        if ( $element->form_identifier == $form->form_identifier ) :
                            $form_already_exists = true;
                        endif;
                    endforeach;
                    
                    if ( !$form_already_exists ) :
                        $tabs_element['elements_instances'][] = $form;

                        $form_tabs = Forms::get_tabs_data( $form->form_identifier );
                        foreach( $form_tabs[0]['elements_instances'] as $models_using_form ) :
                            $model_already_exists = false;
                            foreach( $models_elements_instances as $model_single_instance ) :
                                if ( $model_single_instance->model_identifier == $models_using_form->model_identifier ) :
                                    $model_already_exists = true;
                                endif;
                            endforeach;
                            if ( !$model_already_exists ) :
                                $models_elements_instances[] = $models_using_form;
                            endif; 
                        endforeach;
                    endif;
                endif;
            endforeach;
        endforeach;

        $tabs_data[] = $tabs_element;

        $tables_model_element = array(
            'title' => __( 'Modèles', Oak::$text_domain ),
            'elements' => 'models',
            'elements_instances' => $models_elements_instances,
            'table' => 'model'
        );

        $tabs_data[] = $tables_model_element;

        return $tabs_data;
    }
}

if ( 
    ( 
        isset( $_GET['elements'] ) && 
        in_array( $_GET['elements'], ['fields', 'forms', 'models', 'objects', 'sources', 'performances', 'goodpractices', 'publishers'] ) 
    ) || 
    ( 
        !is_admin()
    ) || 
    ( 
        isset( $_GET['page'] ) && 
        $_GET['page'] == 'oak_import_page'
    )

    
) 
    $fields = new Fields();