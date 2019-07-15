<?php
class Terms {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['terms'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Oak::$elements_script_properties_functions['term_objects'] = function() {
            $this->properties_to_enqueue_for_script_if_term_objects();
        };

        Terms::$filters = array(
            array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'term_identifier' ),
            array ( 'title' => __( 'Sélecteur de cadres RSE', Oak::$text_domain ), 'property' => 'term_selector' ),
            array ( 'title' => __( 'Identifiant', Oak::$text_domain ), 'property' => 'term_identifier' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        global $wpdb; 
        
        $term_table_name = $wpdb->prefix . 'oak_taxonomy_' . $_GET['taxonomy_identifier'];
        Oak::$terms = $wpdb->get_results ( "
            SELECT *
            FROM $term_table_name
        " );

        $table = 'term';
        $elements = Oak::$terms;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'term',
            'table_in_plural' => $_GET['taxonomy_identifier'],
            'elements' => Oak::$terms,
            'properties' => array_merge( Oak::$shared_properties, Terms::$properties ),
            'filters' => Terms::$filters,
            'revisions' => Oak::$revisions
        );
    }

    public static function properties_to_enqueue_for_script_if_term_objects() {
        $term_identifier = $_GET['term_identifier'];
        foreach( Oak::$terms_and_objects as $term_and_object ) :
            if ( $term_and_object->term_identifier == $term_identifier ) :
                foreach( Oak::$all_objects_without_redundancy as $object ) :
                    if ( $object->object_identifier == $term_and_object->object_identifier ) :
                        Oak::$term_objects_without_redundancy[] = $object;
                    endif;
                endforeach;
            endif;
        endforeach;

        $table = 'object';
        $elements = Oak::$term_objects_without_redundancy;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array(
            'table' => 'object',
            'table_in_plural' => 'objects',
            'elements' => Oak::$term_objects_without_redundancy,
            'properties' => array_merge( Oak::$shared_properties, Terms::$properties ),
            'filters' => Objects::$filters,
            'revisions' => Oak::$revisions
        );  
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/terms/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/terms/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/terms/functions/data-collector.php';
    }

    public static function get_tabs_data( $identifier  ) {
        return array();
    }

}

if ( 
    ( 
        isset( $_GET['elements'] ) 
    ) || 
    ( 
        isset( $_GET['post'] ) 
    ) || 
    ( 
        isset( $_GET['page'] ) && 
        $_GET['page'] == 'oak_corn_configuration_page'
    )
) 
    $terms = new Terms();