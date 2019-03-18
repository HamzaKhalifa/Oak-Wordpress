<?php

Class Dynamic_Tag extends \Elementor\Core\DynamicTags\Tag {

    public $variables = [];
    private $tag_options;

	public function get_name() {
        return $this->tag_options['name'];
	}

	public function get_title() {
        return $this->tag_options['title'];
	}

	public function get_group() {
		return $this->tag_options['group'];
	}

	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
	}

	protected function _register_controls() {
        global $wpdb; 

		$this->add_control(
			$this->tag_options['param_name'],
			[
				'label' => __( 'Champ', Oak::$text_domain ),
			    'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array( 'waaw' => 'weey' ),
			]
        );
        
    }
    
	public function render( ) {
        $field = $this->get_settings( $this->tag_options['param_name'] );
        echo( $field );
    }
    
    public function set_tag_options( $tag_options ) {
        $this->tag_options = $tag_options;
    }
}