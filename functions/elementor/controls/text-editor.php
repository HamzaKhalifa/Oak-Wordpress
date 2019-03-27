<?php
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
        'default' => $this->get_widget_options()['value'],
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