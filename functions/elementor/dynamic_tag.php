<?php

Class Dynamic_Tag extends \Elementor\Core\DynamicTags\Data_Tag {

	public function get_name() {
		return 'oak_image';
	}

	public function get_title() {
		return 'Oak';
	}

	public function get_group() {
		return 'oak';
	}

	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
	}

	protected function _register_controls() {
		$fields = get_option('oak_post_elementor_fields');

		$images = get_option('oak_all_images');

		foreach( $fields as $key => $field ) :
			if ( $field['field_type'] == 'image' ) :
				$id = 1;
				foreach( $images as $image ) :
					if ( $image['url'] == $field['value'] ) :
						$id = $image['id'];
					endif;
				endforeach;
				$this->add_control(
					preg_replace( '/\s+/', '', $field['field_designation'] ),
					[
						'label' => $field['field_designation'],
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => array(
							'id' => $id,
							'url' => $field['value']
						)
					]
				);
			endif;
		endforeach;
	}
	
	public function get_value( array $options = [] ) {		
		$image_data = array(
			'url' => ''
		);

		$fields = get_option('oak_post_elementor_fields');
		foreach( $fields as $field ) :
			if ( $field['field_type'] == 'Image' ) :
				$single_data = $this->get_settings( preg_replace( '/\s+/', '', $field['field_designation'] ) );
				if ( $single_data['url'] != '' ) :
					$image_data = $single_data;
				endif;
			endif;
		endforeach;

		return $image_data;
	}
}