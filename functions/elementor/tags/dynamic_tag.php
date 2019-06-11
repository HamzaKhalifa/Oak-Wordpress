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

		$this->add_control (
			'post_images_data',
			[
				'label' => __( 'Données Images', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => $post_images_to_show,
			]
		);
	}
	
	public function get_value( array $options = [] ) {		
		$image_data = array(
			'url' => ''
		);
		
		$post_images_to_show = $this->get_settings()['post_images_data'];
		
		foreach( $post_images_to_show as $post_image ) :
			$single_data = $this->get_settings( preg_replace( '/\s+/', '', $post_image['label'] ) );
			if ( $single_data['url'] != '' ) :
				$image_data = $single_data;
			endif;
		endforeach;

		return $image_data;
	}
}