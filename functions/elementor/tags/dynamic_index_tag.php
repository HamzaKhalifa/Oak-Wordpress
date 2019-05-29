<?php
require_once get_template_directory() . '/functions/class-download-remote-image.php';

Class Dynamic_Index_Tag extends \Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'oak_index';
	}

	public function get_title() {
		return 'Oak';
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
        foreach( Oak::$all_frame_objects_without_redundancy as $frame_object ) :
            $has_been_used_in_at_least_one_post = false;

            $single_frame_object_data = array(
                'frame_object' => array(
                    'id' => $frame_object->object_identifier,
                    'designation' => $frame_object->object_designation
                ),
                'fields' => array(),
                'form_posts' => array(),
                'model_posts' => array(),
                'options' => array()
            );

            foreach( $indexes_data as $index_data ) :
                foreach( $index_data['fields_data'] as $field_data ) :
                    foreach( $field_data['frame_linked_objects'] as $linked_frame_object ) :
                        if ( $linked_frame_object == $frame_object->object_identifier ) :
                            $has_been_used_in_at_least_one_post = true;
                            $single_frame_object_data['fields'][] = $field_data;
                        endif;
                    endforeach;
                endforeach;
                foreach( $index_data['forms_frame_linked_objects'] as $forms_frame_objects ) :
                    if ( $forms_frame_objects == $frame_object->object_identifier ) :
                        $has_been_used_in_at_least_one_post = true;
                        $single_frame_object_data['form_posts'][] = $index_data['post_url'];
                    endif;
                endforeach;
                foreach( $index_data['model_frame_linked_objects'] as $model_frame_objects ) :
                    if ( $model_frame_objects == $frame_object->object_identifier ) :
                        $has_been_used_in_at_least_one_post = true;
                        $single_frame_object_data['model_posts'][] = $index_data['post_url'];
                    endif;
                endforeach;
            endforeach;

            // if ( $has_been_used_in_at_least_one_post ) :
                $frame_objects_designations[] = $frame_object->object_designation;
                $frame_objects_data[] = $single_frame_object_data;
            // endif;
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
                'label'   => __( 'Type de- données à afficher', Oak::$text_domain ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [ __( 'Désignation de l\'object cadres RSE', Oak::$text_domain), __('Nom du champ', Oak::$text_domain ), __( 'Valeur du champ', Oak::$text_domain ), __( 'URL', Oak::$text_domain ) ],
            ]
        );

        foreach( $frame_objects_data as $key => $single_frame_object_data ) :
            $options = [];

            foreach( $single_frame_object_data['fields'] as $field_key => $field_data ) :
                $options[] = __( 'Champ: ' . $field_data['field_name'] );
            endforeach;

            if ( isset( $single_frame_object_data['form_posts'] ) ) :
                foreach( $single_frame_object_data['form_posts'] as $form_key => $form_posts ) :
                    $options[] = __( 'Url Formulair ' . $form_key, Oak::$text_domain );
                endforeach;
            endif;

            if ( isset( $single_frame_object_data['model_posts'] ) ) :
                foreach( $single_frame_object_data['model_posts'] as $model_key => $form_posts ) :
                    $options[] = __( 'Url Objet ' . $model_key, Oak::$text_domain );
                endforeach;
            endif;

            $single_frame_object_data['options'] = $options;
            $frame_objects_data[ $key ] = $single_frame_object_data;

            $this->add_control(
                'frame_object_' . $single_frame_object_data['frame_object']['id'] . '_data',
                [
                    'label'   => __( $single_frame_object_data['frame_object']['designation'], Oak::$text_domain ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => $options,
                ]
            );    
        endforeach;

        $this->add_control(
			'frame_objects_data',
			[
				'label' => __( 'Données des objects cadres RSE', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => $frame_objects_data,
			]
		);
        
        
    }
    
    public function render() {
        $settings = $this->get_settings();

        if ( $settings['frame_object'] != '' && $settings['frame_object_type_of_data_to_show'] != '' ) :
            $frame_object_data = $settings['frame_objects_data'][ $settings['frame_object'] ];
            $which_field_settings_name = 'frame_object_' . $frame_object_data['frame_object']['id'] . '_data';
            $which_field = $settings[ $which_field_settings_name ];

            if ( $which_field == '' ) :
                _e( 'Veuillez d\'abord sélectionner les champs à prendre en compte', Oak::$text_domain );
                return;
            endif;
            
            $form_index = $which_field - count( $frame_object_data['fields'] );
            $model_index = $which_field - count( $frame_object_data['fields'] ) - count( $frame_object_data['form_posts'] );
            $the_field_data = array();
            if ( count( $frame_object_data['fields'] ) > $which_field ) :
                $the_field_data = $frame_object_data['fields'][ $which_field ];
            elseif ( count( $frame_object_data['form_posts'] ) > $form_index ) :
                $the_field_data = $frame_object_data['form_posts'][ $form_index ];
            elseif ( count( $frame_object_data['model_posts'] ) > $model_index ) : 
                $the_field_data = $frame_object_data['model_posts'][ $model_index ];
            endif;

            switch ( $settings['frame_object_type_of_data_to_show'] ): 
                case '0' :
                    // This is the frame object designation
                    echo( $frame_object_data['frame_object']['designation'] );
                break;
                case '1' :
                    // This is field name
                    if ( isset( $the_field_data['field_name'] ) ) :
                        echo( $the_field_data['field_name'] );
                    else :
                        echo( $frame_object_data['frame_object']['designation'] );
                    endif;
                break;
                case '2' :
                    // This is the field value
                    if ( isset( $the_field_data['value'] ) ) :
                        echo( $the_field_data['value'] );
                    else :
                        echo( $frame_object_data['frame_object']['designation'] );
                    endif;
                break;
                case '3' :
                    // This is the post URL
                    if ( isset( $the_field_data['used_in_posts'] ) ) :
                        if ( count ( $the_field_data['used_in_posts'] ) > 0 ) :
                            echo( $the_field_data['used_in_posts'][0]['guid'] );
                        else: 
                            _e( 'Pas d\'URL à afficher', Oak::$text_domain );
                        endif;
                    else :
                        echo( $the_field_data );
                    endif;
                break;
                default :
                    _e( 'Veuillez sélectionner le type de données à afficher' );
                break;

            endswitch;
        else : 
            _e( 'Veuillez d’abord sélectionner les données nécessaire pour l\'affichage.' );
        endif;
        // Oak::var_dump( $settings );
    }
}