<?php
global $wpdb;

// To get all objects associated to all models:
foreach( Oak::$models as $model ) :
    $table_name = $wpdb->prefix . 'oak_model_' . $model->model_identifier;
    $model_objects = $wpdb->get_results ( "
        SELECT * 
        FROM $table_name
    " );

    foreach( $model_objects as $object ) :
        $object->object_model_identifier = $model->model_identifier;
    endforeach;

    $actual_objects = [];
    if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
        foreach( $model_objects as $model_object ) :
            $should_add_because_belongs_to_publication = false;

            foreach( Oak::$terms_and_objects as $term_and_object ) :
                if ( $term_and_object->object_identifier == $model_object->object_identifier ) :
                    foreach( Oak::$all_terms as $term ) :
                        if ( $term->term_identifier == $term_and_object->term_identifier ) : 
                            $should_add_because_belongs_to_publication = true;
                        endif;
                    endforeach;
                endif;
            endforeach;
            if ( $should_add_because_belongs_to_publication ) :
                $actual_objects[] = $model_object;
            endif;
        endforeach;
    else:
        $actual_objects = $model_objects;
    endif;

    Oak::$all_objects = array_merge( Oak::$all_objects, $actual_objects );
endforeach;

// All objects without redundancy: 
$objects_reversed = array_reverse( Oak::$all_objects );
foreach( $objects_reversed as $object ) :
    $exists = false;
    foreach( Oak::$all_objects_without_redundancy as $object_without_redundancy) :
        if ( $object_without_redundancy->object_identifier == $object->object_identifier ) 
            $exists = true;
    endforeach;
    if ( !$exists )
        Oak::$all_objects_without_redundancy[] = $object;
endforeach;

// To get the objects associated to the current model:
if ( isset( $_GET['elements'] ) && isset( $_GET['model_identifier'] ) ) :
    $object_table_name = $wpdb->prefix . 'oak_model_' . $_GET['model_identifier'];
    Oak::$objects = $wpdb->get_results ( "
        SELECT *
        FROM  $object_table_name
    " );

    $actual_objects = [];
    if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
        foreach( Oak::$objects as $model_object ) :
            $should_add_because_belongs_to_publication = false;

            foreach( Oak::$terms_and_objects as $term_and_object ) :
                if ( $term_and_object->object_identifier == $model_object->object_identifier ) :
                    foreach( Oak::$all_terms as $term ) :
                        if ( $term->term_identifier == $term_and_object->term_identifier ) : 
                            $should_add_because_belongs_to_publication = true;
                        endif;
                    endforeach;
                endif;
            endforeach;
            if ( $should_add_because_belongs_to_publication ) :
                $actual_objects[] = $model_object;
            endif;
        endforeach;
    else:
        $actual_objects = Oak::$objects;
    endif;

    $reversed_objects = array_reverse( $actual_objects  );
    foreach( $reversed_objects as $object ) :
        $added = false;
        foreach( Oak::$objects_without_redundancy as $object_without_redundancy ) :
            if ( $object_without_redundancy->object_identifier == $object->object_identifier) :
                $added = true;
            endif;
        endforeach;
        if ( !$added ) :
            Oak::$objects_without_redundancy[] = $object;
        endif;
    endforeach;
endif;

// To get all frame objects: 
foreach( Oak::$all_objects_without_redundancy as $object ) :
    foreach( Oak::$terms_and_objects as $term_and_object ) :
        if ( $term_and_object->object_identifier == $object->object_identifier ) :
            $term_identifier = $term_and_object->term_identifier;
            if ( in_array( $term_identifier, Oak::$frame_terms_identifiers ) ) :
                // Check if the object has already been added: 
                $exists = false;
                foreach( Oak::$all_frame_objects_without_redundancy as $frame_object ) :
                    if ( $frame_object->object_identifier == $object->object_identifier ) :
                        $exists = true;
                    endif;
                endforeach;
                if ( !$exists ) :
                    Oak::$all_frame_objects_without_redundancy[] = $object;
                endif;
            endif;
        endif;
    endforeach;
endforeach;
