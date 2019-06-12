<?php
use Elementor\Controls_Manager;

class Graph_Widget extends \Elementor\Widget_Base {

	private $widget_options;

	public function get_name() {
		return $this->widget_options['graph_identifier'];
	}

	public function get_title() {
		return $this->widget_options['title'];
	}

	public function get_icon() {
		return 'eicon-type-tool';
	}

	public function get_categories() {
		return [ 'oak_charts' ];
	}

	public function get_widgets_options(){
		return $this->widget_options;
	}

  	public function set_widgets_options( $widget_options ) {
		$this->widget_options = $widget_options;
	}

	protected function _register_controls() {

		$this->start_controls_section (
			'section_title',
			[
				'label' => $this->get_widgets_options()['title'],
			]
		);
		
		// Identifiant
		$this->add_control(
			'graph_identifier',
			[
				'label' => __( 'Identifiant', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => $this->get_widgets_options()['graph_identifier']
			]
		);
        
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="oak_front_graph_container" graph-identifier="<?php echo( $settings['graph_identifier'] ); ?>">
			<?php _e( 'Graph goes here', Oak::$text_domain ); ?>
		</div>
		<?php
	}


}