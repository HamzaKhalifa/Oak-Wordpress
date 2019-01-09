<?php 
$custom_post_types = get_option('oak_custom_post_types') ? get_option('oak_custom_post_types') : [];

foreach ( $custom_post_types as $custom_post_type ) :
    $fields = explode( ',', $custom_post_type['fields'] );
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
            $identifier = $field_properties['identifier'] . '_' . $custom_post_type['slug'] . $key;
            $field_group_fields[] = array (
                'key' => $identifier,
                'label' => $field_properties['designation'],
                'name' => $identifier,
                'type' => $field_properties['type'],
                // 'prefix' => '',
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
        //     case 'Essentiel' :
        //         $numberTimesEssential++;
        //         $key = 'essential_' . $custom_post_type['slug'] . $numberTimesEssential;
        //         $field_group_fields[] = array (
        //             'key' => $key,
        //             'label' => 'Élément d’information essentiel',
        //             'name' => $key,
        //             'type' => 'true_false',
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
        //             'message' => 0,
        //         );
    
        //         $field_group_fields[] = array (
        //             'key' => 'exhaustif_' . $custom_post_type['slug'] . $numberTimesEssential,
        //             'label' => 'Élément d’information exhaustif',
        //             'name' => 'exhaustif_' . $custom_post_type['slug'] . $numberTimesEssential,
        //             'type' => 'true_false',
        //             'prefix' => '',
        //             'instructions' => '',
        //             'required' => 0,
        //             'conditional_logic' => array(
        //                 array(
        //                     array(
        //                         'field' => $key, 'operator' => '==', 'value' => '1'
        //                     )
        //                 )
        //             ),
        //             'wrapper' => array (
        //                 'width' => '50%',
        //                 'class' => '',
        //                 'id' => '',
        //             ),
        //             'default_value' => '1',
        //             // Specific for field type
        //             'message' => 0,
        //         );
                
        //     break;
        // endswitch;
    endforeach;
    acf_add_local_field_group(
        array (
            'key' => $custom_post_type['slug'],
            'title' => $custom_post_type['name'],
            'fields' => $field_group_fields,
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => $custom_post_type['slug'],
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