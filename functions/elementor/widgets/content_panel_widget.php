<?php 
use \Elementor\Controls_Manager;

class Oak_Content_Panel_Widget extends \Elementor\Widget_Heading {
    public static $post_selected_objects = [];
    public static $post_selected_performances = [];
    public static $post_selected_qualis = [];
    public static $post_selected_sources = [];
    
    public $the_configuration = [];


    public function get_name() {
        return 'oak_content_panel';
    }

    public function get_title() {
        return __( 'Content Panel', Oak::$text_domain );
    }

    public function get_categories() {
		return [ 'oak_content_panel' ];
    }

    public function parent_register_controls() {
        $this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Title', 'elementor' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'elementor' ),
					'small' => __( 'Small', 'elementor' ),
					'medium' => __( 'Medium', 'elementor' ),
					'large' => __( 'Large', 'elementor' ),
					'xl' => __( 'XL', 'elementor' ),
					'xxl' => __( 'XXL', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'header_size',
			[
				'label' => __( 'HTML Tag', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}}.elementor-widget-heading .elementor-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->add_control(
			'blend_mode',
			[
				'label' => __( 'Blend Mode', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Normal', 'elementor' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'difference' => 'Difference',
					'exclusion' => 'Exclusion',
					'hue' => 'Hue',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_section();
    }

    protected function _register_controls() {
        // $this->parent_register_controls();
        parent::_register_controls();

        $this->start_controls_section(
			'section_content_panel',
			[
				'label' => __( 'Content Panel', Oak::$text_domain ),
			]
        );
        
        $publications_and_frame_objects = Oak_Content_Panel_Widget::make_publications_and_frame_objects();

        $publications_options = array(
            '0' => __( 'Aucune publication sélectionnée', Oak::$text_domain )
        );
        foreach( $publications_and_frame_objects as $single_publication_and_frame_objects ) :
            $publications_options = array_merge( $publications_options, array(
                $single_publication_and_frame_objects['publication']->publication_identifier => $single_publication_and_frame_objects['publication']->publication_designation
            ) );
        endforeach;

        $this->add_control( 'icon_or_designation', [
            'label' => __( 'Désignation/Icone', Oak::$text_domain ),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                'icon' => __( 'Icone', Oak::$text_domain ),
                'designation' => __( 'Désignation', Oak::$text_domain )
            )
        ] );

        $this->add_control( 'publications_array', [
            'label' => __( 'Publications', Oak::$text_domain ),
            'type' => Controls_Manager::SELECT,
            'options' => $publications_options,
        ] );

        foreach( $publications_and_frame_objects as $single_publication_and_frame_objects ) :
            $frame_objects = array (
                '0' => __( 'Aucun Objet sélectionné', Oak::$text_domain )
            );
            $frame_objects_data = [];

            foreach( $single_publication_and_frame_objects['frame_objects_identifiers'] as $frame_object_identifier ) :
                foreach( $single_publication_and_frame_objects['frame_object_data_within_elements'] as $frame_object_data_within_element ) :
                    if ( $frame_object_data_within_element['frame_object']->object_identifier == $frame_object_identifier ) :
                        if ( !isset( $frame_objects[ $frame_object_data_within_element['frame_object']->object_identifier ] ) ) :
                            $frame_object_to_add = array (
                                $frame_object_data_within_element['frame_object']->object_identifier => $frame_object_data_within_element['frame_object']->object_designation
                            );
                            $frame_objects = array_merge( $frame_objects, $frame_object_to_add );
                        endif;

                        $frame_object_data_within_element['frame_object'] = array(
                            'object_identifier' => $frame_object_identifier,
                            'object_designation' => $frame_object_data_within_element['frame_object']->object_designation
                        );
                        $frame_objects_data[ $frame_object_identifier ][] = $frame_object_data_within_element;
                        // $frame_objects_data_of_frame_object_length = count( $frame_objects_data[ $frame_object_data_within_element['frame_object']->object_identifier ] );
                        // unset( $frame_objects_data[ $$frame_object_identifer ][ $frame_objects_data_of_frame_object_length - 1 ]['frame_object'] );
                    endif;
                endforeach;
            endforeach;

            $this->add_control( 'frame_objects_publication_' . $single_publication_and_frame_objects['publication']->publication_identifier, [
                'label' => __( 'Choisir un Object de cadres RSE', Oak::$text_domain ),
                'type' => Controls_Manager::SELECT,
                'options' => $frame_objects,
                'condition' => [
                    'publications_array' => [ $single_publication_and_frame_objects['publication']->publication_identifier ],
                ],
            ] );
    
            foreach( $frame_objects_data as $frame_object_identifier => $frame_object_data_within_elements ) :
                $options = array(
                    '0' => __( 'Aucune liason sélectionnée', Oak::$text_domain )
                );

                $frame_object_controller_id = $frame_object_identifier . '_publication_' . 'frame_objects_publication_' . $single_publication_and_frame_objects['publication']->publication_identifier;
                
                $source_quali_or_performance_data_controllers = array();

                foreach( $frame_object_data_within_elements as $single_frame_object_within_element ) :
                    $data = '';
                    if ( isset( $single_frame_object_within_element['field_content'] ) ) :
                        $options = array_merge( $options, array(
                            $single_frame_object_within_element['field_identifier'] => 'Lié au Champ : ' . $single_frame_object_within_element['field_designation']
                        ) );
                    elseif ( isset( $single_frame_object_within_element['performance_designation'] ) ) :
                        $options = array_merge( $options, array(
                            $single_frame_object_within_element['performance_identifier'] => 'Lié à la Donnée de Performance: ' . $single_frame_object_within_element['performance_designation']
                        ) );
                        $source_quali_or_performance_data_controllers[] = array(
                            'controller_id' => $frame_object_identifier . '_frame_object_publication_' . $single_publication_and_frame_objects['publication']->publication_identifier . '_data_of_' . $single_frame_object_within_element['performance_identifier'],
                            'controller_dataset' => array( 
                                'label' => __(' Données de la donnée de performance: ', Oak::$text_domain ) . $single_frame_object_within_element['performance_designation'],
                                'type' => Controls_Manager::SELECT,
                                'options' => $single_frame_object_within_element['data'],
                                'condition' => [
                                    $frame_object_controller_id => [ $single_frame_object_within_element['performance_identifier'] ],
                                    'publications_array' => [ $single_publication_and_frame_objects['publication']->publication_identifier ],
                                    'frame_objects_publication_' . $single_publication_and_frame_objects['publication']->publication_identifier => [ $frame_object_identifier ],
                                ],
                            )
                        );
                    elseif ( isset( $single_frame_object_within_element['quali_designation'] ) ) :
                        $options = array_merge( $options, array(
                            $single_frame_object_within_element['quali_identifier'] => 'Lié à l\'Indicateur Quali: ' . $single_frame_object_within_element['quali_designation']
                        ) );
                        $source_quali_or_performance_data_controllers[] = array(
                            'controller_id' => $frame_object_identifier . '_frame_object_publication_' . $single_publication_and_frame_objects['publication']->publication_identifier . '_data_of_' . $single_frame_object_within_element['quali_identifier'],
                            'controller_dataset' => array( 
                                'label' => __( 'Données de l\indicateur qualitatif', Oak::$text_domain ) . $single_frame_object_within_element['quali_designation'],
                                'type' => Controls_Manager::SELECT,
                                'options' => $single_frame_object_within_element['data'],
                                'condition' => [
                                    $frame_object_controller_id => [ $single_frame_object_within_element['quali_identifier'] ],
                                    'publications_array' => [ $single_publication_and_frame_objects['publication']->publication_identifier ],
                                    'frame_objects_publication_' . $single_publication_and_frame_objects['publication']->publication_identifier => [ $frame_object_identifier ],
                                ],
                            )
                        );
                    elseif ( isset( $single_frame_object_within_element['source_designation'] ) ) :
                        $options = array_merge( $options, array(
                            $single_frame_object_within_element['source_identifier'] => 'Lié à la source: ' . $single_frame_object_within_element['source_designation']
                        ) );
                        $source_quali_or_performance_data_controllers[] = array(
                            'controller_id' => $frame_object_identifier . '_frame_object_publication_' . $single_publication_and_frame_objects['publication']->publication_identifier . '_data_of_' . $single_frame_object_within_element['source_identifier'],
                            'controller_dataset' => array( 
                                'label' => __( 'Données de la Source', Oak::$text_domain ) . $single_frame_object_within_element['source_designation'],
                                'type' => Controls_Manager::SELECT,
                                'options' => $single_frame_object_within_element['data'],
                                'condition' => [
                                    $frame_object_controller_id => [ $single_frame_object_within_element['source_identifier'] ],
                                    'publications_array' => [ $single_publication_and_frame_objects['publication']->publication_identifier ],
                                    'frame_objects_publication_' . $single_publication_and_frame_objects['publication']->publication_identifier => [ $frame_object_identifier ],
                                ],
                            )
                        );
                    elseif ( isset( $single_frame_object_within_element['form_identifier'] ) ) :
                        $options = array_merge( $options, array(
                            $single_frame_object_within_element['form_identifier'] => 'Lié au Formulaire: ' . $single_frame_object_within_element['form_designation']
                        ) );
                    else :
                        $options = array_merge( $options, array(
                            $single_frame_object_within_element['object_identifier'] => 'Lié à l\'objet: ' . $single_frame_object_within_element['object_designation']
                        ) );
                    endif;
                endforeach;
    
                $this->add_control( $frame_object_controller_id, [
                    'label' => $frame_object_data_within_elements[0]['frame_object']['object_designation'],
                    'type' => Controls_Manager::SELECT,
                    'options' => $options,
                    'condition' => [
                        'publications_array' => [ $single_publication_and_frame_objects['publication']->publication_identifier ],
                        'frame_objects_publication_' . $single_publication_and_frame_objects['publication']->publication_identifier => [ $frame_object_identifier ],
                    ],
                ] );

                foreach( $source_quali_or_performance_data_controllers as $single_source_quali_or_performance_controller ) :
                    $this->add_control( $single_source_quali_or_performance_controller['controller_id'], $single_source_quali_or_performance_controller['controller_dataset'] );
                endforeach;
            endforeach;

        endforeach;


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->the_configuration = $settings;

        $element_to_which_frame_object_is_linked = $this->get_the_element_to_which_frame_object_is_linked( $this->the_configuration );
        if ( count ( $element_to_which_frame_object_is_linked ) == 0 ) :
            _e( 'Sélectionner d\'abord les éléments de configuration', Oak::$text_domain );
            return;
        endif;
        $settings['frame_object_designation'] = $element_to_which_frame_object_is_linked['frame_object']->object_designation;
        $this->the_configuration = $settings;

        if ( isset( $element_to_which_frame_object_is_linked['field_identifier'] ) ) :
            $value = $element_to_which_frame_object_is_linked['field_content'];
        elseif( isset( $element_to_which_frame_object_is_linked['performance_identifier'] ) ) :
            $value = $settings[ $element_to_which_frame_object_is_linked['frame_object']->object_identifier . '_frame_object_publication_' . $settings['publications_array'] . '_data_of_' . $element_to_which_frame_object_is_linked['performance_identifier'] ];
        elseif( isset( $element_to_which_frame_object_is_linked['quali_identifier'] ) ) :
            $value = $settings[ $element_to_which_frame_object_is_linked['frame_object']->object_identifier . '_frame_object_publication_' . $settings['publications_array'] . '_data_of_' . $element_to_which_frame_object_is_linked['quali_identifier'] ];
        elseif( isset( $element_to_which_frame_object_is_linked['source_identifier'] ) ) :
            $value = $settings[ $element_to_which_frame_object_is_linked['frame_object']->object_identifier . '_frame_object_publication_' . $settings['publications_array'] . '_data_of_' . $element_to_which_frame_object_is_linked['source_identifier'] ];
        elseif( isset( $element_to_which_frame_object_is_linked['object_identifier'] ) ) : 
            $value = '';
        endif;
        
        ?>
        <div class="oak_sidebar_frame_objects_container_single_frame__scroll_to_content_button" value="<?php echo( $value ); ?>">
        <?php
            if ( $settings['icon_or_designation'] == 'icon' ) : ?>
                <i class="fas sidebar_thumbtack fa-thumbtack"></i>
                <?php 
            else: 
                $this->add_render_attribute( 'title', 'class', 'elementor-heading-title' );

                if ( ! empty( $settings['size'] ) ) {
                    $this->add_render_attribute( 'title', 'class', 'elementor-size-' . $settings['size'] );
                }

                $this->add_inline_editing_attributes( 'title' );

                $title = $settings['frame_object_designation'];

                if ( ! empty( $settings['link']['url'] ) ) {
                    $this->add_render_attribute( 'url', 'href', $settings['link']['url'] );

                    if ( $settings['link']['is_external'] ) {
                        $this->add_render_attribute( 'url', 'target', '_blank' );
                    }

                    if ( ! empty( $settings['link']['nofollow'] ) ) {
                        $this->add_render_attribute( 'url', 'rel', 'nofollow' );
                    }

                    $title = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $title );
                }

                $title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'title' ), $title );

                echo $title_html;
            endif;
            ?>
        </div>
        <?php
    }
    
    protected function _content_template() { 
        if ( count( $this->the_configuration ) == 0 ) :
            _e( 'Sélectionner d\'abord les éléments de configuration', Oak::$text_domain );
            return;
        endif;

        $element_to_which_frame_object_is_linked = $this->get_the_element_to_which_frame_object_is_linked( $this->the_configuration );
        if ( count ( $element_to_which_frame_object_is_linked ) == 0 ) :
            _e( 'Sélectionner d\'abord les éléments de configuration', Oak::$text_domain );
            return;
        endif;

        $settings['frame_object_designation'] = $element_to_which_frame_object_is_linked['frame_object']->object_designation;
        if ( isset( $element_to_which_frame_object_is_linked['field_identifier'] ) ) :
            $value = $element_to_which_frame_object_is_linked['field_content'];
        elseif( isset( $element_to_which_frame_object_is_linked['performance_identifier'] ) ) :
            $value = $element_to_which_frame_object_is_linked['data'];
        elseif( isset( $element_to_which_frame_object_is_linked['quali_identifier'] ) ) :
            $value = $element_to_which_frame_object_is_linked['data'];
        elseif( isset( $element_to_which_frame_object_is_linked['source_identifier'] ) ) :
            $value = $element_to_which_frame_object_is_linked['data'];
        elseif( isset( $element_to_which_frame_object_is_linked['object_identifier'] ) ) : 
            $value = '';
        endif;
        ?>
        <div class="oak_sidebar_frame_objects_container_single_frame__scroll_to_content_button" value="<?php echo( $value ); ?>">
            <?php 
            if( $this->the_configuration['icon_or_designation'] == 'icon' ) : ?>
                <i class="fas sidebar_thumbtack fa-thumbtack"></i>
                <?php
            else:
                ?>
                <#
                var title = settings.frame_object_designation;

                if ( '' !== settings.link.url ) {
                    title = '<a href="' + settings.link.url + '">' + title + '</a>';
                }

                view.addRenderAttribute( 'title', 'class', [ 'elementor-heading-title', 'elementor-size-' + settings.size ] );

                view.addInlineEditingAttributes( 'title' );

                var title_html = '<' + settings.header_size  + ' ' + view.getRenderAttributeString( 'title' ) + '>' + title + '</' + settings.header_size + '>';

                print( title_html );
                #>
            <?php
            endif;
            ?>
        </div>
		<?php
    }
    
    public function get_the_element_to_which_frame_object_is_linked( $settings ) {
        $publications_and_frame_objects = Oak_Content_Panel_Widget::make_publications_and_frame_objects();
        $selected_publication_identifier = $settings['publications_array'];

        if ( $selected_publication_identifier == '' ) :
            return array();
        endif;

        $selected_frame_object_identifier = $settings[ 'frame_objects_publication_' . $selected_publication_identifier ];

        if ( $selected_frame_object_identifier == '' ) :
            return array();
        endif;
        
        $selected_element_identifier = $settings[ $selected_frame_object_identifier . '_publication_frame_objects_publication_' . $selected_publication_identifier ];

        if ( $selected_element_identifier == '' ) :
            return array();
        endif;

        foreach( $publications_and_frame_objects as $single_publication_and_frame_object ) :
            if ( $single_publication_and_frame_object['publication']->publication_identifier == $settings['publications_array'] ) :
                foreach( $single_publication_and_frame_object['frame_object_data_within_elements'] as $frame_object_data_within_single_element ) :
                    foreach( $frame_object_data_within_single_element as $key => $value ) :
                        if ( $value == $selected_element_identifier ) :
                            return $frame_object_data_within_single_element;
                        endif;
                    endforeach;
                endforeach;
            endif;
        endforeach;
    }
    
    public static function make_publications_and_frame_objects() {
        $publications_and_frame_objects = [];

        foreach( Oak_Content_Panel_Widget::$post_selected_objects[0] as $object ) :
            // for object fields selectors
            $object_selectors_array = explode( '|', $object->object_selectors );
            foreach( $object_selectors_array as $object_selector_data ) :
                if ( $object_selector_data != '' ) :
                    $field_index = explode( '_', $object_selector_data )[0];
                    $field_identifier = explode( '_', explode( ':', $object_selector_data )[0] )[1];
                    $frame_object_identifier = explode( ':', $object_selector_data )[1];
                    $field_content_property = 'object_' . $field_index . '_' . $field_identifier;
                    $field_content = $object->$field_content_property;
                    
                    // Lets get the frame object now: 
                    $field_frame_object = Oak_Content_Panel_Widget::find_frame_object( $frame_object_identifier );
                    if ( $field_frame_object != null ) :
                        // Find the field 
                        $the_field = null;
                        $field_counter = 0;
                        $found_the_field = false;
                        do {
                            if ( Oak::$fields_without_redundancy[ $field_counter ]->field_identifier == $field_identifier ) :
                                $the_field = Oak::$fields_without_redundancy[ $field_counter ];
                            endif;
                            $field_counter++;
                        } while ( !$found_the_field && $field_counter < count( Oak::$fields_without_redundancy ) );

                        $frame_object_data_within_object = array (
                            'field_index' => $field_index,
                            'field_identifier' => $field_identifier,
                            'field_designation' => $the_field->field_designation,
                            'field_content_property' => $field_content_property,
                            'field_content' => $field_content,
                            'frame_object' => $field_frame_object
                        );

                        $publication_identifier = Oak_Content_Panel_Widget::to_which_publication_frame_object_belongs( $field_frame_object->object_identifier );
                        $publications_and_frame_objects = Oak_Content_Panel_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_object ); 
                    endif;
                endif;
            endforeach;

            // for object forms selectors
            $form_selectors_array = explode( '|', $object->object_form_selectors );
            foreach( $form_selectors_array as $form_selector_data ) :
                if ( $form_selector_data != '' ) :
                    $form_identifier = explode( '_', $form_selector_data )[1];
                    $frame_object_identifier = explode( '_', $form_selector_data )[3];
                    $form_frame_object = Oak_Content_Panel_Widget::find_frame_object( $frame_object_identifier );
                    // Lets get the frame object now: 

                    if ( $form_frame_object != null ) :
                        $found_form = false;
                        $forms_counter = 0;
                        $the_form = null;
                        do {
                            if ( Oak::$forms_without_redundancy[ $forms_counter ]->form_identifier == $form_identifier ) :
                                $found_form = true;
                                $the_form = Oak::$forms_without_redundancy[ $forms_counter ];
                            endif;
                            $forms_counter++;
                        } while ( $forms_counter < count( Oak::$forms_without_redundancy ) && !$found_form );
                        $frame_object_data_within_object = array (
                            'form_identifier' => $form_identifier,
                            'form_designation' => $the_form->form_designation,
                            'frame_object' => $form_frame_object,
                        );

                        $publication_identifier = Oak_Content_Panel_Widget::to_which_publication_frame_object_belongs( $form_frame_object->object_identifier );
                        $publications_and_frame_objects = Oak_Content_Panel_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_object );
                    endif;
                endif;
            endforeach;
            // for object model selector
            if ( $object->object_model_selector != null && $object->object_model_selector != '' ) :
                $model_frame_object = Oak_Content_Panel_Widget::find_frame_object( $object->object_model_selector );
                if ( $model_frame_object != null ) :
                    $frame_object_data_within_object = array(
                        'object_identifier' => $object->object_identifier,
                        'object_designation' => $object->object_designation,
                        'frame_object' => $model_frame_object,
                    );

                    $publication_identifier = Oak_Content_Panel_Widget::to_which_publication_frame_object_belongs( $model_frame_object->object_identifier );
                    $publications_and_frame_objects = Oak_Content_Panel_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_object );
                endif;
            endif;
        endforeach;
        
        foreach( Oak_Content_Panel_Widget::$post_selected_performances as $selected_performance ) :
            $performance_frame_objects = explode( '|', $selected_performance->performance_selectors );
            $publication_identifier = $selected_performance->performance_publication;
            $frame_objects_identifiers = [];
            $performance_frame_objects = explode( '|', $selected_performance->performance_selectors );
            foreach( $performance_frame_objects as $performance_frame_object ) :
                if ( $performance_frame_object != '' ) :
                    $frame_objects_identifiers[] = $performance_frame_object;
                endif;
            endforeach;

            foreach( $frame_objects_identifiers as $frame_object_identifier ) :
                $the_frame_object = Oak_Content_Panel_Widget::find_frame_object( $frame_object_identifier );
                if ( $the_frame_object != null ) :
                    $frame_object_data_within_performance = array(
                        'data' => $selected_performance->performance_data,
                        'performance_designation' => $selected_performance->performance_designation,
                        'performance_identifier' => $selected_performance->performance_identifier,
                        'frame_object' => $the_frame_object
                    );
                    
                    $publication_identifier = Oak_Content_Panel_Widget::to_which_publication_frame_object_belongs( $frame_object_identifier );
                    $publications_and_frame_objects = Oak_Content_Panel_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_performance );
                endif;
            endforeach;
        endforeach;

        foreach( Oak_Content_Panel_Widget::$post_selected_qualis as $selected_quali ) :
            $quali_frame_objects = explode( '|', $selected_quali->quali_frame_objects );
            $publication_identifier = $selected_quali->quali_publication;
            $frame_objects_identifiers = [];
            $quali_frame_objects = explode( '|', $selected_quali->quali_frame_objects );
            foreach( $quali_frame_objects as $quali_frame_object ) :
                if ( $quali_frame_object != '' ) :
                    $frame_objects_identifiers[] = $quali_frame_object;
                endif;
            endforeach;

            foreach( $frame_objects_identifiers as $frame_object_identifier ) :
                $the_frame_object = Oak_Content_Panel_Widget::find_frame_object( $frame_object_identifier );
                if ( $the_frame_object != null ) :
                    $frame_object_data_within_quali = array(
                        'data' => $selected_quali->quali_data,
                        'quali_designation' => $selected_quali->quali_designation,
                        'quali_identifier' => $selected_quali->quali_identifier,
                        'frame_object' => $the_frame_object
                    );

                    $publication_identifier = Oak_Content_Panel_Widget::to_which_publication_frame_object_belongs( $frame_object_identifier );
                    $publications_and_frame_objects = Oak_Content_Panel_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_quali );
                endif;
            endforeach;
        endforeach;

        foreach( Oak_Content_Panel_Widget::$post_selected_sources as $selected_source ) :
            $publication_identifier = $selected_source->source_publication;
            $frame_objects_identifiers = [];
            $source_frame_objects = explode( '|', $selected_source->source_frame_objects );
            foreach( $source_frame_objects as $source_frame_object ) :
                if ( $source_frame_object != '' ) :
                    $frame_objects_identifiers[] = $source_frame_object;
                endif;
            endforeach;

            foreach( $frame_objects_identifiers as $frame_object_identifier ) :
                $the_frame_object = Oak_Content_Panel_Widget::find_frame_object( $frame_object_identifier );
                if ( $the_frame_object != null ) : 
                    $frame_object_data_within_source = array(
                        'data' => $selected_source->source_data,
                        'source_designation' => $selected_source->source_designation,
                        'source_identifier' => $selected_source->source_identifier,
                        'frame_object' => $the_frame_object
                    );

                    $publication_identifier = Oak_Content_Panel_Widget::to_which_publication_frame_object_belongs( $frame_object_identifier );
                    $publications_and_frame_objects = Oak_Content_Panel_Widget::add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_source );
                endif;
            endforeach;
        endforeach;

        return $publications_and_frame_objects;
    }
    
    public static function find_frame_object( $frame_object_identifier ) {
        $incrementer = 0;
        $found_frame_object = false;
        $frame_object = null;
        do {
            if ( Oak::$all_frame_objects_without_redundancy[ $incrementer ]->object_identifier == $frame_object_identifier ) :
                $found_frame_object = true;
                $frame_object = Oak::$all_frame_objects_without_redundancy[ $incrementer ];
            endif;
            $incrementer++;
        } while( $incrementer < count( Oak::$all_frame_objects_without_redundancy ) && !$found_frame_object );

        return $frame_object;
    }

    public static function to_which_publication_frame_object_belongs( $frame_object_identifier ) {
        foreach( Oak::$terms_and_objects as $term_and_object ) :
            if ( $term_and_object->object_identifier == $frame_object_identifier ) :
                foreach( Oak::$all_terms_without_redundancy as $term ) :
                    if ( $term->term_identifier == $term_and_object->term_identifier ) :
                        foreach( Oak::$taxonomies_without_redundancy as $taxonomy ) :
                            if ( $taxonomy->taxonomy_identifier == $term->term_taxonomy_identifier ) :
                                return $taxonomy->taxonomy_publication;
                            endif;
                        endforeach;
                    endif;
                endforeach;
            endif;
        endforeach;

        return '';
    }

    public static function add_publication_and_frame_object( $publications_and_frame_objects, $publication_identifier, $frame_object_data_within_element ) {
        foreach( $publications_and_frame_objects as $key => $single_publication_and_frame_objects ) :
            if ( $single_publication_and_frame_objects['publication']->publication_identifier == $publication_identifier ) :
                // Check if object already exists
                $object_already_exists = false;
                foreach( $single_publication_and_frame_objects['frame_objects_identifiers'] as $frame_object_identifier ) :
                    if( $frame_object_identifier == $frame_object_data_within_element['frame_object']->object_identifier ) :
                        $object_already_exists = true;
                    endif;
                endforeach;

                if( !$object_already_exists ) :
                    $single_publication_and_frame_objects['frame_objects_identifiers'][] = $frame_object_data_within_element['frame_object']->object_identifier;
                endif;
                    $single_publication_and_frame_objects['frame_object_data_within_elements'][] = $frame_object_data_within_element;
                    $publications_and_frame_objects[ $key ] = $single_publication_and_frame_objects;
                
                return $publications_and_frame_objects;
            endif;
        endforeach;
        // This is if publication doesn't already exist in our array
        $the_publication;
        foreach( Oak::$publications_without_redundancy as $publication ) :
            if ( $publication->publication_identifier == $publication_identifier ) :
                $the_publication = $publication;
            endif;
        endforeach;

        $publications_and_frame_objects[] = array(
            'publication' => $the_publication,
            'frame_objects_identifiers' => [ $frame_object_data_within_element['frame_object']->object_identifier ],
            'frame_object_data_within_elements' => [ $frame_object_data_within_element ]
        );

        return $publications_and_frame_objects;
    }

    public static function create_widgets( $widgets_manager ) {
        $content_panel_widget = new Oak_Content_Panel_Widget();
        $widgets_manager->register_widget_type( $content_panel_widget );
    }
}
