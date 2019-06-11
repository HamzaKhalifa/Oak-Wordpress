<?php
require_once get_template_directory() . '/functions/class-download-remote-image.php';

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

		// For field images:
		$images = get_option('oak_all_images');

		// For post images to show (goodpractice)
		$post_images_to_show = get_option('oak_post_images_to_show');

		foreach( $post_images_to_show as $post_image ) :
			$this->add_control(
				preg_replace( '/\s+/', '', $post_image['label'] ),
				[
					'label' => $post_image['label'],
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => array(
						'id' => $post_image['id'],
						'url' => $post_image['url']
					)
				]
			);
		endforeach;
	}
	
	public function get_value( array $options = [] ) {		
		$image_data = array(
			'url' => ''
		);

		$fields = get_option('oak_post_elementor_fields');

		$post_images_to_show = get_option('oak_post_images_to_show');

		foreach( $post_images_to_show as $post_image ) :
			$single_data = $this->get_settings( preg_replace( '/\s+/', '', $post_image['label'] ) );
			if ( $single_data['url'] != '' ) :
				$image_data = $single_data;
			endif;
		endforeach;

		// foreach( $fields as $field ) :
		// 	if ( $field['field_type'] == 'image' ) :
		// 		$single_data = $this->get_settings( preg_replace( '/\s+/', '', $field['field_designation'] ) );
		// 		if ( $single_data['url'] != '' ) :
		// 			$image_data = $single_data;
		// 		endif;
		// 	endif;
		// endforeach;
		

		return $image_data;
	}
}