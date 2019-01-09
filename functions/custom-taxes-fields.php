<?php 
$custom_taxonomies = get_option('oak_taxonomies') ? get_option('oak_taxonomies') : [];
foreach ( $custom_taxonomies as $custom_taxonomy ) :
    $fields = explode( ',', $custom_taxonomy['fields'] );
    $field_group_fields = [];

    $saved_fields = get_option('oak_custom_fields') ? get_option('oak_custom_fields') : [];

    foreach( $fields as $key => $field ) :
        $field_values = explode( ':', $field);
        $field_name = $field_values['0'];

        // We are trying to get the field values: 
        $field_properties = [];

        foreach( $saved_fields as $saved_field ) :
            if ( $saved_field['designation'] == $field_name ): 
                $field_properties = $saved_field;
            endif;
        endforeach;

        if ( isset ( $field_properties['identifier'] ) ) : 
            $identifier = $field_properties['identifier'] . '_' . $custom_taxonomy['slug'] . $key;
            $field_group_fields[] = array (
                'key' => $identifier,
                'label' => $field_properties['designation'],
                'name' => $identifier,
                'type' => $field_properties['type'],
                'instructions' => $field_properties['instructions'],
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => $field_properties['defaultValue'],
                // Specific for field type
                'message' => 0,
                'placeholder' => $field_properties['placeholder'],
                'maxlength' => $field_properties['maxLength']
            );
        endif;
        // switch ( $field_name ) : 
        //     case 'Parent' :
        //         $numberTimesParent++;
        //         $key = 'slug_parent_' . $custom_taxonomy['slug'] . $numberTimesParent;
        //         $field_group_fields[] = array (
        //             'key' => $key,
        //             'label' => __('Parent', Oak::$text_domain),
        //             'name' => $key,
        //             'name' => 'slug_parent_' . $custom_taxonomy['slug'],
        //             'type' => 'taxonomy',
        //             'prefix' => '',
        //             'instructions' => '',
        //             'required' => 0,
        //             'conditional_logic' => 0,
        //             'wrapper' => array (
        //                 'width' => '50%',
        //                 'class' => '',
        //                 'id' => '',
        //             ),
        //             'default_value' => '',
        //             // Specific for field type
        //             'taxonomy' => $custom_taxonomy['slug'],
        //             'field_type' => 'checkbox',
        //             'allow_null' => 1,
        //             'load_save_terms' => 1,
        //             'return_format' => 'id',
        //             'add_term' => 1
        //         );
        //     break;
        //     case 'Selecteur pour type' :
        //         $numberTimesType++;
        //         $choices = explode( '|', $field_values['1'] );
        //         $field_group_fields[] = array (
        //             'key' => 'slug_type' . $custom_taxonomy['slug'] . $numberTimesType,
        //             'label' => __('Type', Oak::$text_domain),
        //             'name' => 'slug_type' . $custom_taxonomy['slug'] . $numberTimesType,
        //             'type' => 'select',
        //             'prefix' => '',
        //             'instructions' => '',
        //             'required' => 0,
        //             'conditional_logic' => 0,
        //             'wrapper' => array (
        //                 'width' => '',
        //                 'class' => '',
        //                 'id' => '',
        //             ),
        //             'choices' => $choices,        
        //             'allow_null' => 0, 
        //             'multiple' => 1,  
        //             'ui' => 0,
        //             'ajax' => 0,
        //         );
        //     break;
        //     case 'Couleur' :
        //         $numberTimesColor++;
        //         $field_group_fields[] = array (
        //             'key' => 'slug_color_' . $custom_taxonomy['slug'] . $numberTimesColor,
        //             'label' => __('Couleur', Oak::$text_domain),
        //             'name' => 'slug_color_' . $custom_taxonomy['slug'] . $numberTimesColor,
        //             'type' => 'text',
        //             'prefix' => '',
        //             'instructions' => '',
        //             'required' => 0,
        //             'conditional_logic' => 0,
        //             'wrapper' => array (
        //                 'width' => '100%',
        //                 'class' => '',
        //                 'id' => '',
        //             ),
        //             'default_value' => '#FFFFFF',
        //             // Specific for field type
        //             'placeholder' => 'example: #FFFFFF',
        //         );
        //     break;
        // endswitch;
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