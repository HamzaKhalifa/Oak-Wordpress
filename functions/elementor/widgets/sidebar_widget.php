<?php
use Elementor\Controls_Manager;

class Sidebar_Widget extends \Elementor\Widget_Base {
    public static $post_selected_objects = [];
    public static $post_selected_performances = [];
    public static $post_selected_qualis = [];
    public static $post_selected_sources = [];


    public function get_name() {
		return 'oak_sidebar';
    }

    public function get_title() {
		return __( 'Oak Sidebar', Oak::$text_domain );
    }

	public function get_icon() {
		return 'eicon-sidebar';
    }

    public function get_categories() {
		return [ 'oak' ];
	}
    
	public function get_keywords() {
		return [ 'sidebar', 'widget' ];
    }
    
	protected function _register_controls() {
		global $wp_registered_sidebars;

		$options = [];

		if ( ! $wp_registered_sidebars ) {
			$options[''] = __( 'Pas de Sidebars trouvés', Oak::$text_domain );
		} else {
			$options[''] = __( 'Choisir une Sidebar', Oak::$text_domain );

			foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
				$options[ $sidebar_id ] = $sidebar['name'];
			}
		}

		$default_key = array_keys( $options );
		$default_key = array_shift( $default_key );

		$this->start_controls_section(
			'section_sidebar',
			[
				'label' => __( 'Sidebar', Oak::$text_domain ),
			]
		);

		$this->add_control( 'sidebar', [
			'label' => __( 'Choisir une Sidebar', Oak::$text_domain ),
			'type' => Controls_Manager::SELECT,
			'default' => $default_key,
			'options' => $options,
		] );

		$this->end_controls_section();
    }

    protected function _content_template() {}
        
    public function render_plain_content() {}
    
    protected function render() {
        $sidebar = $this->get_settings_for_display( 'sidebar' );
        
        if ( $sidebar == 'csr_sidebar' ) :
            /*$selected_objects = get_post_meta( get_the_ID(), 'objects_selector' ) ? get_post_meta( get_the_ID(), 'objects_selector' ) [0] : [];
            
            $publications_and_frame_objects = [];

            foreach( Sidebar_Widget::$post_selected_objects[0] as $object ) :
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
                        $field_frame_object = Sidebar_Widget::find_frame_object( $frame_object_identifier );

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

                        $publication_identifier = Sidebar_Widget::to_which_publication_frame_object_belongs( $field_frame_object->object_identifier );
                        $publications_and_frame_objects = Sidebar_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_object ); 
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

                        $publication_identifier = Sidebar_Widget::to_which_publication_frame_object_belongs( $form_frame_object->object_identifier );
                        $publications_and_frame_objects = Sidebar_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_object );
                    endif;
                endforeach;
                // for object model selector
                if ( $object->object_model_selector != null && $object->object_model_selector != '' ) :
                    $model_selectors_array = explode( '|', $object->object_model_selector );
                    foreach( $model_selectors_array as $model_selector ) :
                        if ( $model_selector != '' ) :
                            $model_frame_object = Sidebar_Widget::find_frame_object( $model_selector );
                            $frame_object_data_within_object = array(
                                'frame_object_identifier' => $model_selector,
                            );

                            $publication_identifier = Sidebar_Widget::to_which_publication_frame_object_belongs( $model_frame_object->object_identifier );
                            $publications_and_frame_objects = Sidebar_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_object );
                        endif;
                    endforeach;
                    
                endif;
            endforeach;
            
            foreach( Sidebar_Widget::$post_selected_performances as $selected_performance ) :
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
                    $publications_and_frame_objects = Sidebar_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $selected_performance->performance_publication, $frame_object_data_within_performance );
                endforeach;
            endforeach;

            foreach( Sidebar_Widget::$post_selected_qualis as $selected_quali ) :
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

                    $publications_and_frame_objects = Sidebar_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $selected_quali->quali_publication, $frame_object_data_within_quali );
                endforeach;
            endforeach;

            foreach( Sidebar_Widget::$post_selected_sources as $selected_source ) :
                $publication_identifier = $selected_source->source_publication;
                $frame_objects_identifiers = [];
                $source_frame_objects = explode( '|', $selected_source->source_frame_objects );
                foreach( $source_frame_objects as $source_frame_object ) :
                    if ( $source_frame_object != '' ) :
                        $frame_objects_identifiers[] = $source_frame_object;
                    endif;
                endforeach;

                foreach( $frame_objects_identifiers as $frame_object_identifier ) :
                    $frame_object_data_within_source = array(
                        'data' => $selected_source->source_data,
                        'frame_object_identifier' => $frame_object_identifier
                    );

                    $publications_and_frame_objects = Sidebar_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $selected_source->source_publication, $frame_object_data_within_source );
                endforeach;
            endforeach;*/
            
            $publications_and_frame_objects = Oak_Content_Panel_Widget::make_publications_and_frame_objects();
            // Oak::var_dump( $publications_and_frame_objects );
            foreach( $publications_and_frame_objects as $publication_and_frame_object ) :
                ?>
                <div class="oak_sidebar_publication_container">
                    <h2 class="oak_sidebar_object_container__publication_designation_title"><?php echo( $publication_and_frame_object['publication']->publication_designation ); ?></h2>
                    <div class="oak_sidebar_frame_objects_container">
                        <?php 
                        foreach( $publication_and_frame_object['frame_objects_identifiers'] as $frame_object_identifier ) : 
                            $the_frame_object = Oak_Content_Panel_Widget::find_frame_object( $frame_object_identifier );
                        ?>
                            <div frame-object-identifier="<?php echo( $the_frame_object->object_identifier ); ?>" class="oak_sidebar_frame_objects_container__single_frame">
                                <h3 class="sidebar_element_info"><?php echo( $the_frame_object->object_designation ); ?></h3>
                                <div class="data_go_butons sidebar_element_info">
                                <?php
                                foreach( $publication_and_frame_object['frame_object_data_within_elements'] as $frame_object_data ) : 
                                    if ( $frame_object_data['frame_object']->object_identifier == $frame_object_identifier ) :
                                        // This is for fields
                                        if( isset( $frame_object_data['field_identifier'] ) ) : ?>
                                            <span class="oak_sidebar_frame_objects_container_single_frame__scroll_to_content_button" value="<?php echo( $frame_object_data['field_content'] ); ?>"><i class="fas sidebar_thumbtack fa-thumbtack"></i></span>
                                        <?php
                                        // This is for perfrormance and quali
                                        elseif( isset( $frame_object_data['data'] ) ) : ?>
                                        <?php
                                            foreach( $frame_object_data['data'] as $key => $data ) : 
                                                // Oak::var_dump( $key );
                                                // Oak::var_dump( $key != 0 && $key !== '' && $key !== 'true' && $key !== 'false' );
                                                if ( $key != '' && $key != 'true' && $key != 'false' ) :
                                                    // Oak::var_dump('key won ' . $key );
                                            ?>
                                                    <span class="oak_sidebar_frame_objects_container_single_frame__scroll_to_content_button" value="<?php echo( $key ); ?>"><i class="fas sidebar_thumbtack fa-thumbtack"></i></span>
                                            <?php
                                                endif;
                                            endforeach; ?>
                                        <?php
                                        endif;
                                    endif; 
                                endforeach;
                                ?>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
                <?php
            endforeach;

        else :
            if ( empty( $sidebar ) ) {
                return;
            }

            dynamic_sidebar( $sidebar );
        endif;
    }

    public static function create_widgets( $widgets_manager ) {
        $sidebar_widget = new Sidebar_Widget();
        $widgets_manager->register_widget_type( $sidebar_widget );
    }
}