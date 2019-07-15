<?php
class Objects {
    public static $properties; 
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['objects'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Objects::$filters = array(
            array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'object_identifier' ),
            array ( 'title' => __( 'Sélecteur de cadres RSE', Oak::$text_domain ), 'property' => 'object_selector' ),
            array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'object_identifier' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        foreach( Oak::$objects as $object ) :
            $object->object_model_identifier = $_GET['model_identifier'];
        endforeach;

        foreach( Oak::$current_model_fields as $key => $field ) :
            $input_type = $field->field_type;
            
            Oak::$object_properties[] = array (
                'name' => $key . '_' . $field->field_identifier,
                'property_name' => 'object_' . $key . '_' . $field->field_identifier,
                'type' => 'text',
                'input_type' => $input_type,
                'placeholder' => $field->form_and_field_properties->field_designation != '' ? $field->form_and_field_properties->field_designation : $field->field_designation,
                'description' => $field->form_and_field_properties->field_designation != '' ? $field->form_and_field_properties->field_designation : $field->field_designation,
                'selector' => $field->field_selector,
                'width' => '50',
                'model_and_form_instance' => $field->model_and_form_instance,
                'form' => $field->form,
                'translatable' => true
            );
        endforeach;

        $table = 'object';
        $elements = Oak::$objects;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'object',
            'table_in_plural' => $_GET['model_identifier'],
            'elements' => Oak::$objects,
            'properties' => array_merge( Oak::$shared_properties, Oak::$object_properties ),
            'filters' => Objects::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/objects/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/objects/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/objects/functions/data-collector.php';
    }

    public static function get_all_objects_for_sync() {
        include get_template_directory() . '/functions/tables/elements/objects/functions/all-objects.php';
        include get_template_directory() . '/functions/tables/elements/objects/functions/all-objects-without-redundancy.php';
    } 

    public static function get_object_of_corresponding_language( $object ) {
        $found_frame_object_for_corresponding_language = false; 

        $counter = count( Oak::$all_objects ) - 1;
        do {
            if ( Oak::$all_objects[ $counter ]->object_content_language == Oak::$site_language && Oak::$all_objects[ $counter ]->object_identifier == $object->object_identifier ) :
                return Oak::$all_objects[ $counter ];
            endif;
            $counter--;
        } while ( $counter >= 0 && !$found_frame_object_for_corresponding_language );

        return $object;
    }

    public static function get_tabs_data( $identifier  ) {
        return array();
    }
}

if ( 
    ( 
        isset( $_GET['elements'] ) && 
        in_array( $_GET['elements'], [ 'organizations', 'publications', 'taxonomies', 'terms', 'objects', 'sources', 'performances', 'goodpractices', 'qualis', 'quantis', 'publishers'] ) 
    )
    ||
    (
        !is_admin()
    ) ||
    ( 
        isset( $_GET['post'] ) 
    )
) 
    $objects = new Objects();