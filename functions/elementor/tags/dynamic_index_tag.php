<?php
require_once get_template_directory() . '/functions/class-download-remote-image.php';

Class Dynamic_Index_Tag extends \Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'oak_index';
	}

	public function get_title() {
		return 'Customer - Side';
	}

	public function get_group() {
		return 'oak_indexes';
	}

	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
	}

	protected function _register_controls() {
        $indexes_data = get_option('oak_indexes') == false ? [] : get_option('oak_indexes');

        $frame_objects_designations = [];
        $frame_objects_data = [];

        // Oak::var_dump( $indexes_data );
        foreach( Oak::$all_frame_objects_without_redundancy as $frame_object ) :
            $single_frame_object_data = array (
                'frame_object' => $frame_object,
                'used_in' => [],
            );

            foreach( $indexes_data as $index_data ) :
                // For fields
                foreach( $index_data['fields_data'] as $field_data ) :
                    if ( in_array( $frame_object->object_identifier, $field_data['frame_linked_objects'] ) ) :
                        foreach( $field_data['used_in_posts'] as $posts_in_which_it_is_used ) :
                            if ( $posts_in_which_it_is_used['post_url'] == $index_data['post_url'] ) :
                                $single_frame_object_data['used_in'][] = array(
                                    'field_name' => $field_data['field_name'],
                                    'field_value' => $field_data['value'],
                                    'source_object_designation' => $index_data['object']['designation'],
                                    'url' => $index_data['post_url'],
                                    'post_title' => $posts_in_which_it_is_used['post_title'],
                                    'field' => true,
                                );
                            endif;
                        endforeach;
                    endif;
                endforeach; 
                
                // For forms
                if ( in_array( $frame_object->object_identifier, $index_data['forms_frame_linked_objects'] ) ) :
                    $single_frame_object_data['used_in'][] = array(
                        'source_object_designation' => $index_data['object']['designation'],
                        'url' => $index_data['post_url'],
                        'post_title' => $index_data['post_title'],
                        'form' => true,
                    );
                endif;

                // For models
                if ( in_array( $frame_object->object_identifier, $index_data['model_frame_linked_objects'] ) ) :
                    $single_frame_object_data['used_in'][] = array(
                        'source_object_designation' => $index_data['object']['designation'],
                        'url' => $index_data['post_url'],
                        'post_title' => $index_data['post_title'],
                        'model' => true,
                    );
                endif;
            endforeach;

            // foreach( $indexes_data as $index_data ) :
            //     $single_frame_object_data['source_object']['object_designation'] = $index_data['object']['designation'];
            //     $single_frame_object_data['source_object']['object_identifier'] = $index_data['object']['identifier'];
            //     $post_title = '';

            //     foreach( $index_data['fields_data'] as $field_data ) :
            //         foreach( $field_data['frame_linked_objects'] as $linked_frame_object ) :
            //             if ( $linked_frame_object == $frame_object->object_identifier ) :
            //                 $single_frame_object_data['fields'][] = $field_data;
            //             endif;
            //         endforeach;
            //     endforeach;
            //     foreach( $index_data['forms_frame_linked_objects'] as $forms_frame_objects ) :
            //         if ( $forms_frame_objects == $frame_object->object_identifier ) :
            //             $single_frame_object_data['form_posts'][] = array ( 
            //                 'used_in_posts' => array(
            //                     array(
            //                         'post_url' => $index_data['post_url'],
            //                         'post_title' => $index_data['post_title'],
            //                         'object_designation' => $index_data['object']['designation']
            //                     )
            //                 )
            //             );
            //         endif;
            //     endforeach;
            //     foreach( $index_data['model_frame_linked_objects'] as $model_frame_objects ) :
            //         if ( $model_frame_objects == $frame_object->object_identifier ) :
            //             $single_frame_object_data['model_posts'][] = array (
            //                 'used_in_posts' => array (
            //                     array(
            //                         'post_url' => $index_data['post_url'],
            //                         'post_title' => $index_data['post_title'],
            //                         'object_designation' => $index_data['object']['designation']
            //                     )
            //                 )
            //             );
            //         endif;
            //     endforeach;
            // endforeach;

            $frame_objects_designations[] = $frame_object->object_designation;
            $frame_objects_data[] = $single_frame_object_data;
        endforeach;

		$this->add_control(
			'frame_object',
			[
				'label'   => __( 'Choisir l\'objet cadres RSE', Oak::$text_domain ),
			        'type' => \Elementor\Controls_Manager::SELECT,
			        'options' => $frame_objects_designations,
			]
        );

        $this->add_control(
            'frame_object_type_of_data_to_show',
            [
                'label'   => __( 'Type de données à afficher', Oak::$text_domain ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [ __( 'Désignation de l\'object', Oak::$text_domain), __('Nom du champ', Oak::$text_domain ), __( 'Valeur du champ', Oak::$text_domain ), __( 'URL', Oak::$text_domain ), __( 'Nom du post', Oak::$text_domain ) ],
            ]
        );

        foreach( $frame_objects_data as $key => $single_frame_object_data ) :
            $options = [];

            foreach( $single_frame_object_data['used_in'] as $used_in ) : 
                if ( isset( $used_in['field'] ) ) :
                    $options[] = __( 'Champ: ' . $used_in['field_name'] . ', Post: ' . $used_in['post_title'] );
                endif;

                if ( isset( $used_in['form'] ) ) :
                    $options[] = __( 'Url Formulair Objet: ' . $used_in['source_object_designation'] . ', Post: ' . $used_in['post_title'] );
                endif;

                if ( isset( $used_in['model'] ) ) :
                    $options[] = __( 'Url Objet: ' . $used_in['source_object_designation'] . ', Post: ' . $used_in['post_title'] );
                endif;
            endforeach;

            // Oak::var_dump( $options );
            $single_frame_object_data['options'] = $options;
            $frame_objects_data[ $key ] = $single_frame_object_data;

            $this->add_control(
                'frame_object_' . $single_frame_object_data['frame_object']->object_identifier . '_data',
                [
                    'label'   => __( $single_frame_object_data['frame_object']->object_designation, Oak::$text_domain ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => $options,
                ]
            );
        endforeach;

        update_option( 'oak_customer_side_frame_objects_data', $frame_objects_data );
        // $this->add_control(
		// 	'frame_objects_data',
		// 	[
		// 		'label' => __( 'Données des objects cadres RSE', Oak::$text_domain ),
		// 		'type' => \Elementor\Controls_Manager::HIDDEN,
		// 		'default' => $frame_objects_data,
		// 	]
		// );
    }
    
    public function render() {
        $settings = $this->get_settings();

        if ( $settings['frame_object'] != '' && $settings['frame_object_type_of_data_to_show'] != '' ) :
            // $all_frame_objects_data = $settings['frame_objects_data'];
            $all_frame_objects_data = get_option('oak_customer_side_frame_objects_data');

            $frame_object_data = $all_frame_objects_data[ $settings['frame_object'] ];
            $which_field_settings_name = 'frame_object_' . $frame_object_data['frame_object']->object_identifier . '_data';
            $which_field = $settings[ $which_field_settings_name ];

            if ( $which_field == '' ) :
                _e( 'Veuillez d\'abord sélectionner les champs à prendre en compte', Oak::$text_domain );
                return;
            endif;

            $element = $frame_object_data['used_in'][ $which_field ];
            switch ( $settings['frame_object_type_of_data_to_show'] ): 
                case '0' :
                    // This is the frame object designation
                    echo( $element['source_object_designation'] );
                break;
                case '1' :
                    // This is field name
                    if ( isset( $element['field_name'] ) ) :
                        echo( $element['field_name'] );
                    else: 
                        _e( '---------', Oak::$text_domain );
                    endif;
                break;
                case '2' :
                    // This is the field value
                    if ( isset( $element['field_value'] ) ) :
                        echo( $element['field_value'] );
                    else: 
                        _e( '---------', Oak::$text_domain );
                    endif;
                break;
                case '3' :
                    echo( $element['url'] );
                break;
                case '4' :
                    echo( $element['post_title'] );
                break;
                default :
                    _e( 'Veuillez sélectionner le type de données à afficher' );
                break;

            endswitch;
        else : 
            _e( 'Veuillez d’abord sélectionner les données nécessaire pour l\'affichage.' );
        endif;
    }
}