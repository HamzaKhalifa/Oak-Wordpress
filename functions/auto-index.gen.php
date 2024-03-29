<?php
if( !is_admin() ) :
    wp_send_json_error();
endif;

// if ( get_option( 'central' ) === false ) :
    $indexes = [];

    $all_posts_and_pages = Oak::oak_get_all_posts_and_pages();

    foreach( $all_posts_and_pages as $post ) :
        $post_selected_objects = get_post_meta( $post->ID, 'objects_selector' ) ? get_post_meta( $post->ID, 'objects_selector' )[0] : [];
        
        global $wpdb;

        $objects = Oak::oak_get_selected_objects_data( $post_selected_objects, false );

        foreach( $objects as $object ) : 
            // For the model selector 
            $model_linked_objects_identifiers = [];
            $object_model_selectors = explode( '|', $object->object_model_selector );
            foreach( $object_model_selectors as $object_model_selector ) :
                if ( $object_model_selector != '' ) :
                    $model_linked_objects_identifiers[] = $object_model_selector;
                endif;
            endforeach;

            // For the form selectors
            $form_linked_objects_identifiers = [];
            $object_form_selectors = explode( '|', $object->object_form_selectors );
            foreach( $object_form_selectors as $object_form_selector ) :
                if ( $object_form_selector != '' ) :
                    $form_linked_objects_identifiers[] = explode( '_', $object_form_selector )[3];
                endif;
            endforeach;

            $object_data = array(
                'object' => array(
                    'identifier' => $object->object_identifier,
                    'designation' => $object->object_designation
                ),
                'fields_data' => array (
                ),
                'forms_frame_linked_objects' => $form_linked_objects_identifiers,
                'model_frame_linked_objects' => $model_linked_objects_identifiers,
                'post_url' => $post->guid,
                'post_title' => $post->post_title
            );
            $object_selectors = explode( '|', $object->object_selectors );
            foreach( $object->object_model_fields as $model_field_key => $model_field ) :
                if ( $model_field->field_selector == 'true' ) :
                    $frame_linked_objects_identifiers = [];
                    foreach( $object_selectors as $object_selector ) :
                        if ( $object_selector != '' ) :
                            if( $model_field_key == explode( '_', explode( ':', $object_selector )[0] )[0]
                                && explode( '_', explode( ':', $object_selector )[0] )[1] == $model_field->field_identifier ) :
                                    $frame_linked_objects_identifiers[] = explode( ':', $object_selector )[1];
                            endif;
                        endif;
                    endforeach;
                    $field_property = 'object_' . $model_field_key . '_' . $model_field->field_identifier;
                    $value = $object->$field_property;
                    // Find where the object fields have been used in each post: 
                    $used_in_posts = [];
                    foreach( $all_posts_and_pages as $post_or_page_to_check ) :
                        $post_content = file_get_contents( $post_or_page_to_check->guid );
                        if ( strpos( $post_content, $value ) !== false ) :
                            $used_in_posts[] = array ( 
                                'id' => $post_or_page_to_check->ID,
                                'post_url' => $post_or_page_to_check->guid,
                                'post_title' => $post_or_page_to_check->post_title,
                                'object_designation' => $object->object_designation
                            );
                        endif;
                    endforeach;

                    $single_field_data = array(
                        'field_name' => $model_field->field_name_in_model,
                        'value' => $value,
                        'frame_linked_objects' => $frame_linked_objects_identifiers,
                        'used_in_posts' => $used_in_posts
                    );
                    $object_data['fields_data'][] = $single_field_data;
                    // Now lets look for that value in all posts
                endif;
            endforeach;

            $indexes[] = $object_data;
        endforeach;

        $all_posts_and_pages = Oak::oak_get_all_posts_and_pages();

        // For quali indictors and specific objects: 
        $sources = Oak_Elementor::get_post_sources_data( $post->ID, [], false );
        $qualis = Oak_Elementor::get_post_qualis_data( $post->ID, [], false );
        // $goodpractices = Oak_Elementor::get_post_goodpractices_data( $post->ID, [], false );
        $performances = Oak_Elementor::get_post_performances_data( $post->ID, [], false );

        foreach ( $sources as $source_data ) :
            $source = $source_data[0];
            $indexes = Oak::oak_get_quali_indicators_and_specific_objects_linked_frame_objects( $post, $indexes, $source, 'source' );
        endforeach;

        foreach ( $qualis as $quali_data ) :
            $quali = $quali_data[0];
            $indexes = Oak::oak_get_quali_indicators_and_specific_objects_linked_frame_objects( $post, $indexes, $quali, 'quali' );
        endforeach;

        foreach ( $performances as $performance_data ) :
            $performance = $performance_data[0];
            $indexes = Oak::oak_get_quali_indicators_and_specific_objects_linked_frame_objects( $post, $indexes, $performance, 'performance' );
        endforeach;
    endforeach;
// endif;

update_option( 'oak_indexes', $indexes );
wp_send_json_success( array(
    'indexes' => $indexes
) );