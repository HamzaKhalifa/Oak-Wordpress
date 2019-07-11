<?php
global $wpdb;

$objects_identifiers_that_can_be_pushed = [];
$push_everything = true;
if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
    $push_everything = false;
    foreach( Oak::$content_filters['selected_publications'] as $publication_identifier ) :
        foreach( Oak::$taxonomies_without_redundancy as $single_taxonomy_without_redundancy ) :
            if ( $single_taxonomy_without_redundancy->taxonomy_publication == $publication_identifier ) :
                foreach( Oak::$all_terms_without_redundancy as $single_term_without_redundancy ) :
                    if ( $single_term_without_redundancy->term_taxonomy_identifier == $single_taxonomy_without_redundancy->taxonomy_identifier ) :
                        foreach( Oak::$terms_and_objects as $term_and_object ) :
                            if ( $term_and_object->term_identifier == $single_term_without_redundancy->term_identifier ) :
                                $objects_identifiers_that_can_be_pushed[] = $term_and_object->object_identifier;
                            endif;
                        endforeach;
                    endif;
                endforeach;
            endif;
        endforeach;
    endforeach;
endif;

// To get all objects associated to all models:
foreach( Oak::$models as $model ) :
    $table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;

    $model_objects = [];

    if ( $push_everything ) :
        $model_objects = $wpdb->get_results ( "
            SELECT * 
            FROM $table_name
        " );
    else :
        foreach( $objects_identifiers_that_can_be_pushed as $object_identifier ) :
            $model_objects = array_merge( $model_objects, $wpdb->get_results ( "
                SELECT * 
                FROM $table_name
                WHERE object_identifier = '$object_identifier'
            " ) );
        endforeach;
    endif;

    foreach( $model_objects as $object ) :
        $object->object_model_identifier = $model->model_identifier;
    endforeach;

    // $actual_objects = [];
    // if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
    //     foreach( $model_objects as $model_object ) :
    //         $should_add_because_belongs_to_publication = false;

    //         foreach( Oak::$terms_and_objects as $term_and_object ) :
    //             if ( $term_and_object->object_identifier == $model_object->object_identifier ) :
    //                 foreach( Oak::$all_terms as $term ) :
    //                     if ( $term->term_identifier == $term_and_object->term_identifier ) : 
    //                         $should_add_because_belongs_to_publication = true;
    //                     endif;
    //                 endforeach;
    //             endif;
    //         endforeach;
    //         if ( $should_add_because_belongs_to_publication ) :
    //             $actual_objects[] = $model_object;
    //         endif;
    //     endforeach;
    // else:
    //     $actual_objects = $model_objects;
    // endif;

    Oak::$all_objects = array_merge( Oak::$all_objects, $model_objects );
endforeach;