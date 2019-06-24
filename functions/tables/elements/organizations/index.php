<?php
class Organizations {
    public static $properties;
    public static $filters;
    
    function __construct() {
        $this->table_creator();
        $this->data_collector();

        Oak::$elements_script_properties_functions['organizations'] = function() {
            $this->properties_to_enqueue_for_script();
        };

        Organizations::$filters = array(
            array ( 'title' => __( 'Acronyme', Oak::$text_domain ), 'property' => 'organization_acronym' ),
            array ( 'title' => __( 'Description', Oak::$text_domain ), 'property' => 'organization_description' ),
            array ( 'title' => __( 'Instances', Oak::$text_domain ), 'property' => 'organization_description' )
        );
    }

    public static function properties_to_enqueue_for_script() {
        $table = 'organization';
        $elements = Oak::$organizations;
        Oak::$revisions = Oak::oak_get_revisions( $table, $elements );

        Oak::$current_element_script_properties = array (
            'table' => 'organization',
            'table_in_plural' => 'organizations',
            'elements' => Oak::$organizations,
            'properties' => array_merge( Oak::$shared_properties, Organizations::$properties ),
            'filters' => Organizations::$filters,
            'revisions' => Oak::$revisions
        );
    }

    static function properties_initialization() {
        include get_template_directory() . '/functions/tables/elements/organizations/functions/properties-initialization.php';
    }

    function table_creator() {
        include get_template_directory() . '/functions/tables/elements/organizations/functions/table-creator.php';
    }

    function data_collector() {
        include get_template_directory() . '/functions/tables/elements/organizations/functions/data-collector.php';
    }

    public static function get_child_elements() {
        return ( 
            array(
                'for_table' => 'organization',
                'table' => 'publication', 
                'elements_name' => 'publications',
                'get_child_elements_function' => function( $organization_identifier ) {
                    $elements_to_return = array();

                    foreach( Oak::$publications_without_redundancy as $publication ) :
                        if ( $publication->publication_organization == $organization_identifier ) :
                            $elements_to_return[] = $publication;
                        endif;
                    endforeach;

                    return $elements_to_return;
                },
                'child_elements' => array (
                    'for_table' => 'publication',
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
                        'for_table' => 'taxonomy',
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
                            'for_table' => 'term',
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
            )
        );
    }

    public static function get_tabs_data( $identifier  ) {
        return array();
    }
}

$organizations = new Organizations();