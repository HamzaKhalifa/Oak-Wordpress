<?php
require_once get_template_directory() . '/functions/class-download-remote-image.php';

Class Dynamic_Content_Panel extends \Elementor\Core\DynamicTags\Data_Tag {
    public static $post_selected_objects = [];
    public static $post_selected_performances = [];
    public static $post_selected_qualis = [];

	public function get_name() {
		return 'oak_content_panel';
	}

	public function get_title() {
		return __( 'Content Panel', Oak::$text_domain );
	}

	public function get_group() {
		return 'oak';
	}

	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
	}

	protected function _register_controls() {
		$post_images_to_show = get_option('oak_post_images_to_show');

        $publications_and_frame_objects = Dynamic_Content_Panel::make_publications_and_frame_objects();

        // Oak::var_dump( $publications_and_frame_objects );
        // die;
	}
	
	public function get_value( array $options = [] ) {		
		return '';
    }

    public static function make_publications_and_frame_objects() {
        $publications_and_frame_objects = [];

        foreach( Dynamic_Content_Panel::$post_selected_objects[0] as $object ) :
            // for object fields selectors
            $object_selectors_array = explode( '|', $object->object_selectors );
            foreach( $object_selectors_array as $object_selector_data ) :
                if ( $object_selector_data != '' ) :
                    $field_index = explode( '_', $object_selector_data )[0];
                    $field_identifier = explode( '_', explode( ':', $object_selector_data )[0] )[1];
                    $frame_object_identifier = explode( ':', $object_selector_data )[1];
                    $field_content_property = 'object_' . $field_index . '_' . $field_identifier;
                    $field_content = $object->$field_content_property;
                    
                    // Lets get the frame object now: 
                    $field_frame_object = Dynamic_Content_Panel::find_frame_object( $frame_object_identifier );

                    // Find the field 
                    $the_field = null;
                    $field_counter = 0;
                    $found_the_field = false;
                    do {
                        if ( Oak::$fields_without_redundancy[ $field_counter ]->field_identifier == $field_identifier ) :
                            $the_field = Oak::$fields_without_redundancy[ $field_counter ];
                        endif;
                        $field_counter++;
                    } while ( !$found_the_field && $field_counter < count( Oak::$fields_without_redundancy ) );

                    $frame_object_data_within_object = array (
                        'field_index' => $field_index,
                        'field_identifier' => $field_identifier,
                        'field_designation' => $the_field->field_designation,
                        'field_content_property' => $field_content_property,
                        'field_content' => $field_content,
                        'frame_object_identifier' => $frame_object_identifier
                    );

                    $publication_identifier = Dynamic_Content_Panel::to_which_publication_frame_object_belongs( $field_frame_object->object_identifier );
                    $publications_and_frame_objects = Dynamic_Content_Panel::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_object ); 
                endif;
            endforeach;

            // for object forms selectors
            $form_selectors_array = explode( '|', $object->object_form_selectors );
            foreach( $form_selectors_array as $form_selector_data ) :
                if ( $form_selector_data != '' ) :
                    $form_identifier = explode( '_', $form_selector_data )[1];
                    $frame_object_identifier = explode( '_', $form_selector_data )[3];
                    // Lets get the frame object now: 

                    $frame_object_data_within_object = array (
                        'form_identifier' => $form_identifier,
                        'frame_object_identifier' => $frame_object_identifier,
                    );

                    $publication_identifier = Dynamic_Content_Panel::to_which_publication_frame_object_belongs( $form_frame_object->object_identifier );
                    $publications_and_frame_objects = Dynamic_Content_Panel::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_object );
                endif;
            endforeach;
            // for object model selector
            if ( $object->object_model_selector != null && $object->object_model_selector != '' ) :
                $model_frame_object = Dynamic_Content_Panel::find_frame_object( $object->object_model_selector );
                $frame_object_data_within_object = array(
                    'frame_object_identifier' => $object->object_model_selector,
                );

                $publication_identifier = Dynamic_Content_Panel::to_which_publication_frame_object_belongs( $model_frame_object->object_identifier );
                $publications_and_frame_objects = Dynamic_Content_Panel::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_object );
            endif;
        endforeach;
        
        foreach( Dynamic_Content_Panel::$post_selected_performances as $selected_performance ) :
            $performance_frame_objects = explode( '|', $selected_performance->performance_selectors );
            $publication_identifier = $selected_performance->performance_publication;
            $frame_objects_identifiers = [];
            $performance_frame_objects = explode( '|', $selected_performance->performance_selectors );
            foreach( $performance_frame_objects as $performance_frame_object ) :
                if ( $performance_frame_object != '' ) :
                    $frame_objects_identifiers[] = $performance_frame_object;
                endif;
            endforeach;

            foreach( $frame_objects_identifiers as $frame_object_identifier ) :
                $frame_object_data_within_performance = array(
                    'data' => $selected_performance->performance_data,
                    'frame_object_identifier' => $frame_object_identifier
                );
                $publications_and_frame_objects = Dynamic_Content_Panel::add_publication_and_frame_object( $publications_and_frame_objects, $selected_performance->performance_publication, $frame_object_data_within_performance );
            endforeach;
        endforeach;

        foreach( Dynamic_Content_Panel::$post_selected_qualis as $selected_quali ) :
            $quali_frame_objects = explode( '|', $selected_quali->quali_frame_objects );
            $publication_identifier = $selected_quali->quali_publication;
            $frame_objects_identifiers = [];
            $quali_frame_objects = explode( '|', $selected_quali->quali_frame_objects );
            foreach( $quali_frame_objects as $quali_frame_object ) :
                if ( $quali_frame_object != '' ) :
                    $frame_objects_identifiers[] = $quali_frame_object;
                endif;
            endforeach;

            foreach( $frame_objects_identifiers as $frame_object_identifier ) :
                $frame_object_data_within_quali = array(
                    'data' => $selected_quali->quali_data,
                    'frame_object_identifier' => $frame_object_identifier
                );

                $publications_and_frame_objects = Dynamic_Content_Panel::add_publication_and_frame_object( $publications_and_frame_objects, $selected_quali->quali_publication, $frame_object_data_within_quali );
            endforeach;
        endforeach;

        return $publications_and_frame_objects;
    }
    
    public static function find_frame_object( $frame_object_identifier ) {
        $incrementer = 0;
        $found_frame_object = false;
        $frame_object;
        do {
            if ( Oak::$all_frame_objects_without_redundancy[$incrementer]->object_identifier == $frame_object_identifier ) :
                $found_frame_object = true;
                $frame_object = Oak::$all_frame_objects_without_redundancy[$incrementer];
            endif;
            $incrementer++;
        } while( $incrementer < count( Oak::$all_frame_objects_without_redundancy ) && !$found_frame_object );

        return $frame_object;
    }

    public static function to_which_publication_frame_object_belongs( $frame_object_identifier ) {
        foreach( Oak::$terms_and_objects as $term_and_object ) :
            if ( $term_and_object->object_identifier == $frame_object_identifier ) :
                foreach( Oak::$all_terms_without_redundancy as $term ) :
                    if ( $term->term_identifier == $term_and_object->term_identifier ) :
                        foreach( Oak::$taxonomies_without_redundancy as $taxonomy ) :
                            if ( $taxonomy->taxonomy_identifier == $term->term_taxonomy_identifier ) :
                                return $taxonomy->taxonomy_publication;
                            endif;
                        endforeach;
                    endif;
                endforeach;
            endif;
        endforeach;

        return '';
    }

    public static function add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_element ) {
        foreach( $publications_and_frame_objects as $key => $single_publication_and_frame_objects ) :
            if ( $single_publication_and_frame_objects['publication']->publication_identifier == $publication_identifier ) :
                // Check if object already exists
                $object_already_exists = false;
                foreach( $single_publication_and_frame_objects['frame_objects_identifiers'] as $frame_object_identifier ) :
                    if( $frame_object_identifier == $frame_object_data_within_element['frame_object_identifier'] ) :
                        $object_already_exists = true;
                    endif;
                endforeach;

                if( !$object_already_exists ) :
                    $single_publication_and_frame_objects['frame_objects_identifiers'][] = $frame_object_data_within_element['frame_object_identifier'];
                endif;
                    $single_publication_and_frame_objects['frame_object_data_within_elements'][] = $frame_object_data_within_element;
                    $publications_and_frame_objects[ $key ] = $single_publication_and_frame_objects;
                
                return $publications_and_frame_objects;
            endif;
        endforeach;
        // This is if publication doesn't already exist in our array
        $the_publication;
        foreach( Oak::$publications_without_redundancy as $publication ) :
            if ( $publication->publication_identifier == $publication_identifier ) :
                $the_publication = $publication;
            endif;
        endforeach;

        $publications_and_frame_objects[] = array(
            'publication' => $the_publication,
            'frame_objects_identifiers' => [ $frame_object_data_within_element['frame_object_identifier'] ],
            'frame_object_data_within_elements' => [ $frame_object_data_within_element ]
        );

        return $publications_and_frame_objects;
    }
}