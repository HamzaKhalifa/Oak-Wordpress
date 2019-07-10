<?php
class Publications {
    public static $properties;
    public static $filters;

    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['publications'] = function() {
            $this->properties_to_enqueue_for_script();
        };
        
        Publications::$filters = array(
            array ( 'title' => __( 'Année', Oak::$text_domain ), 'property' => 'publication_year' ),
            array ( 'title' => __( 'Format', Oak::$text_domain ), 'property' => 'publication_format' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'publication_format' )
        );

       
    }
    
    public static function properties_to_enqueue_for_script() {
        $table = 'publication';
        $elements = Oak::$publications;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'publication',
            'table_in_plural' => 'publications',
            'elements' => Oak::$publications,
            'properties' => array_merge( Oak::$shared_properties, Publications::$properties ),
            'filters' => Publications::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/publications/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/publications/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/publications/functions/data-collector.php';
    }

    public static function get_child_elements() {
        return ( 
            array (
                'table' => 'taxonomy',
                'elements_name' => 'taxonomies',
                'get_child_elements_function' => function( $publication_identifier ) {
                    $elements_to_return = array();
                    foreach( Oak::$taxonomies_without_redundancy as $taxonomy ) :
                        if( $taxonomy->taxonomy_publication == $publication_identifier ) :
                            $elements_to_return[] = $taxonomy;
                        endif;
                    endforeach;

                    return $elements_to_return;
                },
                'child_elements' => array(
                    'table' => 'term',
                    'elements_name' => 'terms',
                    'get_child_elements_function' => function( $taxonomy_identifier ) {
                        $elements_to_return = array();
                        foreach( Oak::$all_terms_without_redundancy as $term ) :
                            if ( $term->term_taxonomy_identifier == $taxonomy_identifier ) :
                                $elements_to_return[] = $term;
                            endif;
                        endforeach;

                        return $elements_to_return;
                    },
                    'child_elements' => array(
                        'table' => 'object',
                        'elements_name' => 'objects',
                        'get_child_elements_function' => function ( $term_identifier ) {
                            $elements_to_return = array();
                            foreach( Oak::$all_objects_without_redundancy as $object ) :
                                foreach( Oak::$terms_and_objects as $term_and_object ) :
                                    if ( $term_and_object->object_identifier == $object->object_identifier && $term_and_object->term_identifier == $term_identifier ) :
                                        $elements_to_return[] = $object;
                                    endif;
                                endforeach;
                            endforeach;

                            return $elements_to_return;
                        },
                        'child_elements' => array()
                    )
                )
            )
        );
    }

    public static function get_tabs_data( $identifier  ) {
        return array();
    }
}

// if ( 
//     ( 
//         isset( $_GET['elements'] ) && 
//         in_array( $_GET['elements'], ['publications', 'organizations', 'taxonomies', 'terms', 'goodpractices', 'sources', 'performances', 'qualis', 'quantis'] ) 
//     ) 
// )
    $publications = new Publications();