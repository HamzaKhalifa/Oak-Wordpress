<?php
require_once get_template_directory() . '/functions/class-download-remote-image.php';

Class Dynamic_Csr_Side_Index_Tag extends \Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'oak_csr_side_index';
	}

	public function get_title() {
		return 'CSR - Side';
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
		foreach( Oak::$all_frame_objects_without_redundancy as $key => $frame_object ) :
			$field_names = [];
			foreach( Oak::$models_without_redundancy as $model ) :
				if ( $model->model_identifier == $frame_object->object_model_identifier ) :
					$model_fields = Models::get_model_fields( $model, false );
					$frame_object->model_fields = $model_fields;

					$model_fields_names = explode( '|', $model->model_fields_names );
					foreach( $model_fields as $model_field_key => $model_field ) :
						$field_name = $model_field->field_designation;
						if ( isset( $model_fields_names[ $model_field_key ] ) ) :
							$field_name = $model_fields_names[ $model_field_key ];
						endif;
						$field_names[] = $field_name;
					endforeach;
				endif;
			endforeach;
            
			$frame_objects_designations[] = $frame_object->object_designation;
			
			$this->add_control(
				$frame_object->object_identifier,
				[
					'label'   => $frame_object->object_designation,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $field_names,
				]
			);

			$frame_objects_data[] = $frame_object;
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

		if ( $settings['frame_object'] == '' ) :
			_e( 'Veuillez avant sélectionnez l\'objet cadres RSE', Oak::$text_domain );
			return;
		endif;
		
		$selected_frame_object_data = $settings['frame_objects_data'][ $settings['frame_object'] ];

		$selected_frame_object_identifier = $settings['frame_objects_data'][ $settings['frame_object'] ]['object_identifier'];
		$field_index = $settings[ $selected_frame_object_identifier ];
		if ( $field_index == '' ) :
			_e( 'Veuillez avant sélectionnez la propriété de l\'objet cadres RSE', Oak::$text_domain );
			return;
		endif;

		$selected_field_data = $selected_frame_object_data['model_fields'][ $field_index ];
		$field_property_name = 'object_' . $field_index . '_' . $selected_field_data['field_identifier'];
		
		echo( $selected_frame_object_data[ $field_property_name ] );
    }
}