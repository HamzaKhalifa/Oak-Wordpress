<?php 
class Publishers {
    public static $properties;
    public static $filters;
    function __construct() {
        $this->table_creator();
        $this->data_collector();

        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        Oak::$elements_script_properties_functions['publishers'] = function() {
            $this->properties_to_enqueue_for_script();
        };
        
        Publishers::$filters = array(
            array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'publisher_identifier' ),
            array ( 'title' => __( 'Url', Oak::$text_domain ), 'property' => 'publisher_url' ),
            array ( 'title' => __( 'Sélecteur', Oak::$text_domain ), 'property' => 'publisher_selector' )
        );

        $this->handle_ajax_calls();
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'publisher';
        $elements = Oak::$publishers;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'publisher',
            'table_in_plural' => 'publishers',
            'elements' => Oak::$publishers,
            'properties' => array_merge( Oak::$shared_properties, Publishers::$properties ),
            'filters' => Publishers::$filters,
            'revisions' => Oak::$revisions
        );
    }

    function admin_enqueue_scripts() {
        if ( isset( $_GET['publisher_identifier'] ) ) :
            wp_enqueue_script( 'oak_publisher_synchronize', get_template_directory_uri() . '/functions/tables/elements/publishers/src/synchronize-elements.js', array('jquery'), false, true );
            wp_localize_script( 'oak_publisher_synchronize', 'SYNCHRONIZE_DATA', array(
                'publishers' => Oak::$publishers,
                'allObjects' => Oak::$all_objects_without_redundancy
            ) ); 
        endif;
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/publishers/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/publishers/functions/data-collector.php';
    } 
 
    public static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/publishers/functions/properties-initialization.php';
    }

    function handle_ajax_calls() {
        add_action('wp_ajax_send_sync_data', array( $this, 'send_sync_data') );
        add_action('wp_ajax_nopriv_send_sync_data', array( $this, 'send_sync_data') );

        add_action('wp_ajax_save_sync_data', array( $this, 'save_sync_data') );
        add_action('wp_ajax_nopriv_save_sync_data', array( $this, 'save_sync_data') );

        add_action('wp_ajax_all_objects_synchronized', array( $this, 'all_objects_synchronized') );
        add_action('wp_ajax_nopriv_all_objects_synchronized', array( $this, 'all_objects_synchronized') );
    }

    public function send_sync_data() {
        $objects_to_send = [];
        $terms_and_objects_to_send = [];
        foreach( Oak::$all_objects_without_redundancy as $object ) :
            if ( $object->object_synchronized == 'false' ) :
                $objects_to_send[] = $object;
                foreach( Oak::$terms_and_objects as $term_and_object ) :
                    if ( $term_and_object->object_identifier == $object->object_identifier ) :
                        $terms_and_objects_to_send[] = $term_and_object;
                    endif;
                endforeach;
            endif;
        endforeach;
        
        wp_send_json_success( array(
            'objects' => $objects_to_send,
            'terms_and_objects' => $terms_and_objects_to_send,
        ) );
    }

    public function save_sync_data() {
        global $wpdb; 

        $objects = $_POST['objectsToSave'];
        $terms_and_objects = $_POST['termsAndObjects'];
        
        foreach( $objects as $object ) :
            foreach( Oak::$terms_and_objects as $term_and_object ) :
                if ( $term_and_object->object_identifier == $object['object_identifier'] ) :
                    $wpdb->delete(
                        $wpdb->prefix . 'oak_terms_and_objects',
                        array( 'term_identifier' => $term_and_object->term_identifier, 'object_identifier' => $object['object_identifier'] )
                    );
                endif;
            endforeach;

            // Lets get the model:
            $found_model = false;
            $counter = 0;
            $model = null;
            do {
                if ( Oak::$models_without_redundancy[ $counter ]->model_identifier == $object['object_model_identifier'] ) :
                    $found_model = true;
                    $model = Oak::$models_without_redundancy[ $counter ];
                endif;
                $counter++;
            } while( !$found_model && $counter < count( Oak::$models_without_redundancy ) );

            if ( $model != null ) :
                // Lets get the model fields
                $model_fields = Models::get_model_fields( $model, false );

                $object_to_save = array(
                    'object_synchronized' => 'true',
                );
                foreach( $model_fields as $key => $field ) :
                    $column_name = 'object_' . $key . '_' . $field->field_identifier;
                    $object_to_save[ $column_name ] = $object[ $column_name ];
                endforeach;

                $default_properties = array('object_designation', 'object_identifier', 'object_modification_time', 'object_content_language', 'object_model_selector', 'object_selector',
                        'object_locked', 'object_state', 'object_trashed', 'object_selectors', 'object_form_selectors', 'object_model_selector');

                foreach( $default_properties as $property ) :
                    $object_to_save[ $property ] = $object[ $property ];
                endforeach;
                
                $result = $wpdb->insert(
                    $wpdb->prefix . 'oak_model_' . $model->model_identifier,
                    $object_to_save
                );

            endif;
        endforeach;

        // Now lets insert all the terms: 
        foreach( $terms_and_objects as $term_and_object ) :
            $result = $wpdb->insert(
                $wpdb->prefix . 'oak_terms_and_objects',
                array(
                    'term_identifier' => $term_and_object['term_identifier'],
                    'object_identifier' => $term_and_object['object_identifier']
                )
            );
        endforeach;
        
        wp_send_json_success();
    }

    public function all_objects_synchronized() {
        global $wpdb; 

        foreach( Oak::$all_objects_without_redundancy as $object ) :
            if ( $object->object_synchronized != 'true' ) :
                $model_identifier = $object->object_model_identifier;
                $table_name = $wpdb->prefix . 'oak_model_' . $model_identifier;

                $result = $wpdb->update (
                    $table_name,
                    array (
                        'object_synchronized' => 'true'
                    ),
                    array(
                        'object_identifier' => $object->object_identifier
                    )
                );
            endif;
        endforeach;

        wp_send_json_success();
        
    }

    public static function synchronize_view() {
        include get_template_directory() . '/functions/tables/elements/publishers/views/synchronize-view.php';
    }
}

$publishers = new Publishers();