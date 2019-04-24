<?php
use Elementor\Controls_Manager;

class Generic_Widget extends \Elementor\Widget_Base {

	private $widget_options;

	public function get_name() {
		$unique_id = uniqid();
		$name = $this->widget_options['name'] . ' ' . $unique_id;
		return $this->widget_options['name'];
	}

	public function get_title() {
		return $this->widget_options['title'];
	}

	public function get_icon() {
		return __( $this->widget_options['icon'], Oak::$text_domain );
	}

	public function get_categories() {
		return $this->widget_options['categories'];
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
		
		// Value
		$this->add_control(
			'value',
			[
				'label' => __( 'Valeur', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'placeholder' => __( 'Entrer la valeur', Oak::$text_domain ),
				// 'default' => 'the default',
				'default' => wp_http_validate_url( $this->get_widgets_options()['value'] ) == true && $this->get_widgets_options()['field_type'] != 'social_media' ? '' : isset( $this->get_widgets_options()['value'] ) ? $this->get_widgets_options()['value'] : '',
			]
		);

		// Image
		$this->add_control(
			'image',
			[
				'label' => __( 'Choisir l\'image', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => wp_http_validate_url( $this->get_widgets_options()['value'] ) != true ? \Elementor\Utils::get_placeholder_image_src() : isset( $this->get_widgets_options()['value'] ) ? $this->get_widgets_options()['value'] : \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'field_type',
			[
				'label' => __( 'Type du widget', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type du widget', Oak::$text_domain ),
				'default' => $this->get_widgets_options()['field_type'],
				'show_label' => false,
				'label_block' => false
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_global',
			[
				'label' => __( 'Paramètres Globaux', Oak::$text_domain),
			]
		);
		
		// Vizual Editor
		$this->add_control(
			'class',
			[
				'label' => __( 'VizualEditor', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Classe', Oak::$text_domain ),
				'default' => '',
			]
		);
		
		// Link
		$this->add_control(
			'link',
			[
				'label' => __( 'Lien', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => [
					'url' => '',
				]
			]
		);

		// Alignment
		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignement', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', Oak::$text_domain ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', Oak::$text_domain ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', Oak::$text_domain ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', Oak::$text_domain ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text',
			[
				'label' => __( 'Paramètres Texte', Oak::$text_domain ),
			]
		);

		// Color
		$this->add_control(
			'color',
			[
				'label' => __( 'Couleur', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#0c0c0c',
			]
		);

		// HTML TAG 
		$this->add_control(
			'tag',
			[
				'label' => __( 'HTML Tag', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'div' => 'div',
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'div',
			]
		);

		// Text Shadow
		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		// Font Size
		$this->add_control(
			'font_size',
			[
				'label' => __( 'Font Size', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$typo_weight_options = [
			'' => __( 'Default', Oak::$text_domain ),
		];

		foreach ( array_merge( [ 'normal', 'bold' ], range( 100, 900, 100 ) ) as $weight ) {
			$typo_weight_options[ $weight ] = ucfirst( $weight );
		}

		// Font Weight
		$this->add_control(
			'font_weight',
			[
				'label' => _x( 'Weight', 'Typography Control', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $typo_weight_options,
			]
		);

		// Text Transform
		$this->add_control(
			'text_transform',
			[
				'label' => _x( 'Transform', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'elementor' ),
					'uppercase' => _x( 'Uppercase', Oak::$text_domain ),
					'lowercase' => _x( 'Lowercase', Oak::$text_domain ),
					'capitalize' => _x( 'Capitalize', Oak::$text_domain ),
					'none' => _x( 'Normal', Oak::$text_domain ),
				],
			]
		);

		// Text Decoration
		$this->add_control(
			'text_decoration',
			[
				'label' => _x( 'Decoration', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', Oak::$text_domain ),
					'underline' => _x( 'Underline', Oak::$text_domain ),
					'overline' => _x( 'Overline', Oak::$text_domain ),
					'line-through' => _x( 'Line Through', Oak::$text_domain ),
					'none' => _x( 'None', Oak::$text_domain ),
				],
			]
		);

		// Line height
		$this->add_control(
			'line_height',
			[
				'label' => __( 'Line Height', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		// Letter Spacing
		$this->add_control(
			'letter_spacing',
			[
				'label' => __( 'Letter Spacing', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Paramètres Image', Oak::$text_domain ),
			]
		);

		$this->add_control(
			'image_width',
			[
				'label' => __( 'Largeur', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'image_height',
			[
				'label' => __( 'Hauteur', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'image_max_width',
			[
				'label' => __( 'Largeur Maximale', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacité', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->end_controls_section();

		
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$before = '';
		$after = '';
		if ( $settings['link']['url'] != '' ) :
			$before = '<a href="' . $settings['link']['url'] . '">';
			$after = '</a>';
		endif;

		$value = '';

		if ( isset( $settings['value'] ) && $settings['value'] != '' && strpos( $settings['value'], 'undefined' ) == false ) :
			$color = $settings['color'] != '' ? 'color: ' . $settings['color'] . '; ' : '';
			$font_size = $settings['font_size'] != '' ? 'font-size: ' . $settings['font_size'] . '; ' : '';
			$font_weight = $settings['font_weight'] != '' ? 'font-weight: ' . $settings['font_weight'] . '; ' : '';
			$text_align = $settings['align'] != '' ? 'text-align: ' . $settings['align'] . '; ' : '';
			$text_transform = $settings['text_transform'] != '' ? 'text-transform: ' . $settings['text_transform'] . '; ' : '';
			$text_decoration = $settings['text_decoration'] != '' ? 'text-decoration: ' . $settings['text_decoration'] . '; ' : '';
			$line_height = $settings['line_height'] != '' ? 'line-height: ' . $settings['line_height'] . '; ' : '';
			$letter_spacing = $settings['letter_spacing'] != '' ? 'letter-spacing: ' . $settings['letter_spacing'] . '; ' : '';
			$text_shadow_text_shadow = 'text-shadow: ' . $settings['text_shadow_text_shadow']['horizontal'] . 'px ' . $settings['text_shadow_text_shadow']['vertical'] . 'px ' . $settings['text_shadow_text_shadow']['blur'] . 'px ' . $settings['text_shadow_text_shadow']['color'] . '; ';

			
			$style = $color . $font_size . $font_weight . $text_align . $text_transform . $text_decoration . $line_height . $letter_spacing . $text_shadow_text_shadow;
			
			$value = $before . '<' . $settings['tag'] . ' class="' . $settings['class'] . '" style="' . $style . '">' . $settings['value'] . '</' . $settings['tag'] . '>' . $after;
		endif;
		
		if ( wp_http_validate_url( $settings['image']['url'] ) && $settings['field_type'] != 'social_media' ) :
			$width = $settings['image_width'] != '' ? 'width: ' . $settings['image_width'] . ';' : '';
			$opacity = $settings['image_opacity'] != '' ? 'opacity: ' . $settings['image_opacity'] . ';' : '';
			$max_width = $settings['image_max_width'] != '' ? 'max-width: ' . $settings['image_max_width'] . ';' : '';
			$height = $settings['image_height'] != '' ? 'height: ' . $settings['image_height'] . ';' : '';
			$style = $width . $max_width . $opacity . $height;
			$value = $value . '<div class="oak_image_wrapper" style="text-align: ' . $settings['align'] . '">' . $before . '<img class="' . $settings['class'] . '" src="' . $settings['image']['url'] . '" class="" style="' . $style . '">' . $after . '</div>';
		endif;

		echo( $value );
	}


}