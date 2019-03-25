<?php
use Elementor\Controls_Manager;

/* class Generic_Widget extends \Elementor\Widget_Base {

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

  	public function set_widgets_options( $widget_options ) {
		$this->widget_options = $widget_options;
	}

	public function get_widgets_options(){
		return $this->widget_options;
	}

	protected function _register_controls() {

		$this->start_controls_section(
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
				'default' => wp_http_validate_url( $this->get_widgets_options()['value'] ) == true ? '' : isset( $this->get_widgets_options()['value'] ) ? $this->get_widgets_options()['value'] : '',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Valeur', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'placeholder' => __( 'Entrer la valeur', Oak::$text_domain ),
				// 'default' => 'the default',
				'default' => wp_http_validate_url( $this->get_widgets_options()['value'] ) == true ? '' : isset( $this->get_widgets_options()['value'] ) ? $this->get_widgets_options()['value'] : '',
			]
		);

		// Image
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => wp_http_validate_url( $this->get_widgets_options()['value'] ) != true ? \Elementor\Utils::get_placeholder_image_src() : isset( $this->get_widgets_options()['value'] ) ? $this->get_widgets_options()['value'] : \Elementor\Utils::get_placeholder_image_src(),
				],
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

		if ( wp_http_validate_url( $settings['image']['url'] ) ) :
			$value = '<div class="oak_image_wrapper" style="text-align: ' . $settings['align'] . '">' . $before . '<img class="' . $settings['class'] . '" src="' . $settings['image']['url'] . '" class="" style="
				width: ' . $settings['image_width'] . ';
				opacity: ' . $settings['image_opacity'] . ';
				max-width: ' . $settings['image_max_width'] . ';
			">' . $after . '</div>';
		endif;

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

		echo( $value );
	}


} */

class Generic_Widget extends \Elementor\Widget_Base {

	private $widget_options;

	public function get_name() {
		return $this->get_widgets_options()['name'];
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

	public function get_keywords() {
		return [ 'text', 'editor' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_editor',
			[
				'label' => __( 'Text Editor', 'elementor' ),
			]
		);

		$this->add_control(
			'editor',
			[
				'label' => '',
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'dynamic' => [
					'active' => true,
				],
				'default' => $this->widget_options['value'],
			]
		);

		$this->add_control(
			'the_name',
			[
				'label' => '',
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => 'wtf',
			]
		);

		$this->add_control(
			'widget_options',
			[
				'label' => __( 'Fuck', Oak::$text_domain ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => wp_json_encode( $this->widget_options ),
				'show_label' => false,
				'label_block' => false,
			]
		);

		$this->add_control(
			'drop_cap', [
				'label' => __( 'Drop Cap', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'elementor' ),
				'label_on' => __( 'On', 'elementor' ),
				'prefix_class' => 'elementor-drop-cap-',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Text Editor', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-text-editor' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$text_columns = range( 1, 10 );
		$text_columns = array_combine( $text_columns, $text_columns );
		$text_columns[''] = __( 'Default', 'elementor' );

		$this->add_responsive_control(
			'text_columns',
			[
				'label' => __( 'Columns', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'separator' => 'before',
				'options' => $text_columns,
				'selectors' => [
					'{{WRAPPER}} .elementor-text-editor' => 'columns: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => __( 'Columns Gap', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'vw' ],
				'range' => [
					'px' => [
						'max' => 100,
					],
					'%' => [
						'max' => 10,
						'step' => 0.1,
					],
					'vw' => [
						'max' => 10,
						'step' => 0.1,
					],
					'em' => [
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-text-editor' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_drop_cap',
			[
				'label' => __( 'Drop Cap', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'drop_cap' => 'yes',
				],
			]
		);

		$this->add_control(
			'drop_cap_view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'elementor' ),
					'stacked' => __( 'Stacked', 'elementor' ),
					'framed' => __( 'Framed', 'elementor' ),
				],
				'default' => 'default',
				'prefix_class' => 'elementor-drop-cap-view-',
				'condition' => [
					'drop_cap' => 'yes',
				],
			]
		);

		$this->add_control(
			'drop_cap_primary_color',
			[
				'label' => __( 'Primary Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-drop-cap-view-stacked .elementor-drop-cap' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap, {{WRAPPER}}.elementor-drop-cap-view-default .elementor-drop-cap' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'condition' => [
					'drop_cap' => 'yes',
				],
			]
		);

		$this->add_control(
			'drop_cap_secondary_color',
			[
				'label' => __( 'Secondary Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-drop-cap-view-stacked .elementor-drop-cap' => 'color: {{VALUE}};',
				],
				'condition' => [
					'drop_cap_view!' => 'default',
				],
			]
		);

		$this->add_control(
			'drop_cap_size',
			[
				'label' => __( 'Size', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-drop-cap' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'drop_cap_view!' => 'default',
				],
			]
		);

		$this->add_control(
			'drop_cap_space',
			[
				'label' => __( 'Space', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .elementor-drop-cap' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} .elementor-drop-cap' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'drop_cap_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-drop-cap' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'drop_cap_border_width', [
				'label' => __( 'Border Width', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .elementor-drop-cap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'drop_cap_view' => 'framed',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'drop_cap_typography',
				'selector' => '{{WRAPPER}} .elementor-drop-cap-letter',
				'exclude' => [
					'letter_spacing',
				],
				'condition' => [
					'drop_cap' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$widget_options = json_decode( $settings['widget_options'] );
		$editor_content = $widget_options->value;

		$editor_content = $this->parse_text_editor( $editor_content );
		$settings['editor'] = $editor_content;

		$this->add_render_attribute( 'editor', 'class', [ 'elementor-text-editor', 'elementor-clearfix' ] );

		$this->add_inline_editing_attributes( 'editor', 'advanced' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'editor' ); ?>><?php echo $editor_content; ?></div>
		<?php
	}

	public function render_plain_content() {
		// In plain mode, render without shortcode
		echo $this->get_settings( 'editor' );
	}
	
	protected function _content_template() {
		?>
		<#
		view.addRenderAttribute( 'editor', 'class', [ 'elementor-text-editor', 'elementor-clearfix' ] );

		view.addInlineEditingAttributes( 'editor', 'advanced' );
		#>
		<div {{{ view.getRenderAttributeString( 'editor' ) }}}>{{{ settings.editor }}}</div>
		<?php
	}
}

