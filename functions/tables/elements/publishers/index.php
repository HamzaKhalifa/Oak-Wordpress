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

        add_action('wp_ajax_all_elements_synchronized', array( $this, 'all_elements_synchronized') );
        add_action('wp_ajax_nopriv_all_elements_synchronized', array( $this, 'all_elements_synchronized') );
    }

    public function get_models_without_redundancy() {
        global $wpdb; 

        $models_table_name = $wpdb->prefix . 'oak_models';
        $models = $wpdb->get_results ( "
            SELECT * 
            FROM  $models_table_name
        " );
        $reversed_models = array_reverse( $models );
        $models_without_redundancy = [];
        foreach( $reversed_models as $model ) :
            $added = false;
            foreach( $models_without_redundancy as $model_without_redundancy ) :
                if ( $model_without_redundancy->model_identifier == $model->model_identifier ) :
                    $added = true;
                endif;
            endforeach;
            if ( !$added ) :
                $models_without_redundancy[] = $model;
            endif;
        endforeach;

        return $models_without_redundancy;
    }

    public function get_all_objects_without_redundancy() {
        global $wpdb; 

        $all_objects_without_redundancy = [];

        $models_without_redundancy = $this->get_models_without_redundancy();

        
        $all_objects = [];
        foreach( $models_without_redundancy as $model ) :
            $table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
        
            $model_objects = [];
            $model_objects = $wpdb->get_results ( "
                SELECT * 
                FROM $table_name
            " );
        
            foreach( $model_objects as $object ) :
                $object->model = $model->model_identifier;
            endforeach;
        
            $all_objects = array_merge( $all_objects, $model_objects );
        endforeach;

        $objects_reversed = array_reverse( $all_objects );
        foreach( $objects_reversed as $object ) :
            $exists = false;
            foreach( $all_objects_without_redundancy as $object_without_redundancy) :
                if ( $object_without_redundancy->object_identifier == $object->object_identifier ) 
                    $exists = true;
            endforeach;
            if ( !$exists )
                $all_objects_without_redundancy[] = $object;
        endforeach;

        return $all_objects_without_redundancy;
    }

    public function send_sync_data() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'oak_organizations';
        $organizations = $wpdb->get_results ( "
            SELECT *
            FROM $table_name
            WHERE organization_synchronized = 'false' OR organization_synchronized IS NULL
        " );

        $table_name = $wpdb->prefix . 'oak_publications';
        $publications = $wpdb->get_results ( "
            SELECT *
            FROM $table_name
            WHERE publication_synchronized = 'false' OR publication_synchronized IS NULL
        " );
        
        $qualis_table_name = $wpdb->prefix . 'oak_qualis';
        $qualis = $wpdb->get_results ( "
            SELECT *
            FROM  $qualis_table_name
            WHERE quali_synchronized = 'false' OR quali_synchronized IS NULL
        " );

        $quantis_table_name = $wpdb->prefix . 'oak_quantis';
        $quantis = $wpdb->get_results ( "
            SELECT *
            FROM  $quantis_table_name
            WHERE quanti_synchronized = 'false' OR quanti_synchronized IS NULL
        " );

        $goodpractices_table_name = $wpdb->prefix . 'oak_goodpractices';
        $goodpractices = $wpdb->get_results ( "
            SELECT *
            FROM  $goodpractices_table_name
            WHERE goodpractice_synchronized = 'false' OR goodpractice_synchronized IS NULL
        " );

        $performances_table_name = $wpdb->prefix . 'oak_performances';
        $performances = $wpdb->get_results ( "
            SELECT *
            FROM  $performances_table_name
            WHERE performance_synchronized = 'false' OR performance_synchronized IS NULL
        " );

        $sources_table_name = $wpdb->prefix . 'oak_sources';
        $sources = $wpdb->get_results ( "
            SELECT *
            FROM  $sources_table_name
            WHERE source_synchronized = 'false' OR source_synchronized IS NULL
        " );

        $glossaries_table_name = $wpdb->prefix . 'oak_glossaries';
        $glossaries = $wpdb->get_results ( "
            SELECT *
            FROM  $glossaries_table_name
            WHERE glossary_synchronized = 'false' OR glossary_synchronized IS NULL
        " );
        
        $all_objects_without_redundancy = $this->get_all_objects_without_redundancy();

        $terms_and_objects_table_name = $wpdb->prefix . 'oak_terms_and_objects';
        $terms_and_objects = $wpdb->get_results ( "
            SELECT * 
            FROM $terms_and_objects_table_name
            WHERE term_and_object_synchronized = 'false' OR term_and_object_synchronized IS NULL
        " );

        $objects_to_send = [];
        foreach( $all_objects_without_redundancy as $object ) :
            if ( $object->object_synchronized == 'false' ) :
                $objects_to_send[] = $object;
            endif;
        endforeach;
        
        wp_send_json_success( array(
            'organizations' => $organizations, 
            'publications' => $publications,
            'qualis' => $qualis,
            'quantis' => $quantis,
            'glossaries' => $glossaries,
            'goodpractices' => $goodpractices,
            'performances' => $performances,
            'sources' => $sources,
            'objects' => $objects_to_send,
            'terms_and_objects' => $terms_and_objects,
        ) );
    }

    public function save_sync_data() {
        global $wpdb; 

        Oak::$all_images = Corn_Import::get_all_images()->posts;

        $elements_types_to_sync = array(
            array( 'element_name' => 'organization', 'elements' => json_decode( stripslashes( $_POST['organizations'] ), true ), 'table_name' => Oak::$organizations_table_name, 'properties' => Organizations::$properties, Organizations::$properties ),
            array( 'element_name' => 'publication', 'elements' => json_decode( stripslashes( $_POST['publications'] ), true ), 'table_name' => Oak::$publications_table_name, 'properties' => Publications::$properties ),
            array( 'element_name' => 'quali', 'elements' => json_decode( stripslashes( $_POST['qualis'] ), true ), 'table_name' => Oak::$qualis_table_name, 'properties' => Qualis::$properties ),
            array( 'element_name' => 'quanti', 'elements' => json_decode( stripslashes( $_POST['quantis'] ), true ), 'table_name' => Oak::$quantis_table_name, 'properties' => Quantis::$properties ),
            array( 'element_name' => 'glossary', 'elements' => json_decode( stripslashes( $_POST['glossaries'] ), true ), 'table_name' => Oak::$glossaries_table_name, 'properties' => Glossaries::$properties ),
            array( 'element_name' => 'goodpractice', 'elements' => json_decode( stripslashes( $_POST['goodpractices'] ), true ), 'table_name' => Oak::$goodpractices_table_name, 'properties' => Good_Practices::$properties ),
            array( 'element_name' => 'performance', 'elements' => json_decode( stripslashes( $_POST['performances'] ), true ), 'table_name' => Oak::$performances_table_name, 'properties' => Performances::$properties ),
            array( 'element_name' => 'source', 'elements' => json_decode( stripslashes( $_POST['sources'] ), true ), 'table_name' => Oak::$sources_table_name, 'properties' => Sources::$properties ),
        );

        $objects =  json_decode( stripslashes( $_POST['objectsToSave'] ), true );
        $terms_and_objects = json_decode( stripslashes( $_POST['termsAndObjects'] ), true );

        foreach( $elements_types_to_sync as $single_element_type_to_sync ) :
            $table_name = $single_element_type_to_sync['table_name'];

            foreach( $single_element_type_to_sync['elements'] as $element ) :
                unset( $element['id'] );
                $element[ $single_element_type_to_sync['element_name'] . '_synchronized' ] = 'true';
                Corn_Import::corn_simple_register_element( $element, $table_name, $single_element_type_to_sync['properties'], false );
            endforeach;

        endforeach;

        foreach( $objects as $object ) :
            $object['object_synchronized'] = 'true';
        endforeach;

        Corn_Import::corn_save_element( $objects, '', null );

        // Now lets insert all the terms: 
        foreach( $terms_and_objects as $term_and_object ) :
            $result = $wpdb->insert(
                $wpdb->prefix . 'oak_terms_and_objects',
                array(
                    'term_identifier' => $term_and_object['term_identifier'],
                    'object_identifier' => $term_and_object['object_identifier'],
                    'term_and_object_synchronized' => 'true'
                )
            );
        endforeach;
        
        wp_send_json_success();
    }

    public function all_elements_synchronized() {
        global $wpdb; 

        $elements_types_to_confirm_for_sync = array(
            array( 'element_name' => 'organization', 'table_name' => Oak::$organizations_table_name ),
            array( 'element_name' => 'publication', 'table_name' => Oak::$publications_table_name ),
            array( 'element_name' => 'quali', 'table_name' => Oak::$qualis_table_name ),
            array( 'element_name' => 'quanti', 'table_name' => Oak::$quantis_table_name ),
            array( 'element_name' => 'glossary', 'table_name' => Oak::$glossaries_table_name ),
            array( 'element_name' => 'goodpractice', 'table_name' => Oak::$goodpractices_table_name ),
            array( 'element_name' => 'performance', 'table_name' => Oak::$performances_table_name ),
            array( 'element_name' => 'source', 'table_name' => Oak::$sources_table_name ),
            array( 'element_name' => 'source', 'table_name' => Oak::$sources_table_name ),
        );

        $terms_and_objects_table_name = Oak::$terms_and_objects_table_name;
        $all_terms_and_objects = $wpdb->get_results ( "
            SELECT *
            FROM $terms_and_objects_table_name
        " );
        foreach( $all_terms_and_objects as $term_and_object ) :
            $result = $wpdb->update (
                $terms_and_objects_table_name,
                array (
                    'term_and_object_synchronized' => 'true'
                ),
                array( 'id' => $term_and_object->id )
            );
        endforeach;

        foreach( $elements_types_to_confirm_for_sync as $single_element_type_to_confirm_for_sync ) :
            $table_name = $single_element_type_to_confirm_for_sync['table_name'];
            
            $elements = $wpdb->get_results ( "
                SELECT *
                FROM $table_name
            " );
            $identifier_property = $single_element_type_to_confirm_for_sync['element_name'] . '_identifier';

            foreach( $elements as $element ) :
                $identifier = $element->$identifier_property;
                $result = $wpdb->update (
                    $table_name,
                    array (
                        $single_element_type_to_confirm_for_sync['element_name'] . '_synchronized' => 'true'
                    ),
                    array( $identifier_property => $identifier )
                );
            endforeach;
        endforeach;

        $all_objects_without_redundancy = $this->get_all_objects_without_redundancy();
        foreach( $all_objects_without_redundancy as $object ) :

            if ( $object->object_synchronized != 'true' ) :
                $model_identifier = $object->model;
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

    public static function get_tabs_data( $identifier  ) {
        return array();
    }
}

$publishers = new Publishers();