<?php
global $wpdb; 

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