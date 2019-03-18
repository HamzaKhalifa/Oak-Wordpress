<?php
use Elementor\Controls_Manager;


class Generic_Widget extends \Elementor\Widget_Base {

	private $widget_options;

	public function get_name() {
		return __( $this->widget_options['name'], Oak::$text_domain );
	}

	public function get_title() {
		return __( $this->widget_options['title'], Oak::$text_domain );
	}

	public function get_icon() {
		return __( $this->widget_options['icon'], Oak::$text_domain );
	}

	public function get_categories() {
		return $this->widget_options['categories'];
	}

  public function set_widgets_options( $widget_options ) {
		$this->widget_options = $widget_options;
	}

	public function get_widgets_options(){
		return $this->widget_options;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( $this->widget_options['title'], 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control (
			$this->get_name(),
			[
				'label' => __( 'Valeur', Oak::$text_domain ),
				// 'type' => $this->get_widgets_options()['type'],
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => $this->widget_options['input_type'],
				'placeholder' => __( '', Oak::$text_domain ),
				'default' => $this->get_widgets_options()['value'],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$did_show = false;
		foreach ( $settings as $key => $value ) :
			if ( !$did_show ) :
				if ( filter_var( $settings[ $key ], FILTER_VALIDATE_URL ) ) :
					echo(
						'<div class="elementor-image"><img src="' . $settings[ $key ] . '" class=""></div>'
					);
				else :
					echo( $settings[ $key ] );
				endif;
			endif;
			$did_show = true;
		endforeach; 
	}

	public function get_value( $field, $options ){
		$array = explode('->',$field);

		if(($this->widget_options)['widget_type'] == 'materiality_widgeditor_image'){
			return $this->get_value_iterate($array,0,$options)['url'];

		}else{
			return $this->get_value_iterate($array,0,$options)[0];

		}

	}
	
	public function get_value_iterate($array_field, $current,$array){
		$tempArray = (Array) $array[$array_field[$current]];
		if($current < count($array_field) -1){
			return $this->get_value_iterate($array_field,$current+1,$tempArray);
		}else{
			return $tempArray;
		}

	}

}
