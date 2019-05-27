<?php
global $wpdb;

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