<?php 
$custom_taxonomies = get_option('dawn_taxonomies') ? get_option('dawn_taxonomies') : [];
foreach ($custom_taxonomies as $custom_taxonomy) :
    $fields = explode( ',', $custom_taxonomy['fields'] );
    $field_group_fields = [];

    $numberTimesParent = 0;
    $numberTimesType = 0;
    $numberTimesColor = 0;

    foreach( $fields as $field ) :
        $field_values = explode( ':', $field);
        $field_name = $field_values['0'];
        switch ( $field_name ) : 
            case 'Parent' :
                $numberTimesParent++;
                $key = 'slug_parent_' . $custom_taxonomy['slug'] . $numberTimesParent;
                $field_group_fields[] = array (
                    'key' => $key,
                    'label' => __('Parent', Dawn::$text_domain),
                    'name' => $key,
                    'name' => 'slug_parent_' . $custom_taxonomy['slug'],
                    'type' => 'taxonomy',
                    'prefix' => '',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '50%',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    // Specific for field type
                    'taxonomy' => $custom_taxonomy['slug'],
                    'field_type' => 'checkbox',
                    'allow_null' => 1,
                    'load_save_terms' => 1,
                    'return_format' => 'id',
                    'add_term' => 1
                );
            break;
            case 'Selecteur pour type' :
                $numberTimesType++;
                $choices = explode( '|', $field_values['1'] );
                $field_group_fields[] = array (
                    'key' => 'slug_type' . $custom_taxonomy['slug'] . $numberTimesType,
                    'label' => __('Type', Dawn::$text_domain),
                    'name' => 'slug_type' . $custom_taxonomy['slug'] . $numberTimesType,
                    'type' => 'select',
                    'prefix' => '',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => $choices,        
                    'allow_null' => 0, 
                    'multiple' => 1,  
                    'ui' => 0,
                    'ajax' => 0,
                );
            break;
            case 'Couleur' :
                $numberTimesColor++;
                $field_group_fields[] = array (
                    'key' => 'slug_color_' . $custom_taxonomy['slug'] . $numberTimesColor,
                    'label' => __('Couleur', Dawn::$text_domain),
                    'name' => 'slug_color_' . $custom_taxonomy['slug'] . $numberTimesColor,
                    'type' => 'text',
                    'prefix' => '',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '100%',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '#FFFFFF',
                    // Specific for field type
                    'placeholder' => 'example: #FFFFFF',
                );
            break;
        endswitch;
    endforeach;
    acf_add_local_field_group(
        array (
            'key' => $custom_taxonomy['slug'],
            'title' => $custom_taxonomy['name'],
            'fields' => $field_group_fields,
            'location' => array (
                array (
                    array (
                        'param' => 'taxonomy',
                        'operator' => '==',
                        'value' => $custom_taxonomy['slug'],
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => ''
        )
    );
    endforeach;