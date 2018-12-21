<?php 
$custom_post_types = get_option('dawn_custom_post_types') ? get_option('dawn_custom_post_types') : [];

foreach ( $custom_post_types as $custom_post_type ) :
    $fields = explode( ',', $custom_post_type['fields'] );
    $field_group_fields = [];

    $numberTimesEssential = 0;

    foreach( $fields as $field ) :
        $field_values = explode( ':', $field);
        $field_name = $field_values['0'];
        switch ( $field_name ) : 
            case 'Essentiel' :
                $numberTimesEssential++;
                $key = 'essential_' . $custom_post_type['slug'] . $numberTimesEssential;
                $field_group_fields[] = array (
                    'key' => $key,
                    'label' => 'Élément d’information essentiel',
                    'name' => $key,
                    'type' => 'true_false',
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
                    'message' => 0,
                );
    
                $field_group_fields[] = array (
                    'key' => 'exhaustif_' . $custom_post_type['slug'] . $numberTimesEssential,
                    'label' => 'Élément d’information exhaustif',
                    'name' => 'exhaustif_' . $custom_post_type['slug'] . $numberTimesEssential,
                    'type' => 'true_false',
                    'prefix' => '',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => $key, 'operator' => '==', 'value' => '1'
                            )
                        )
                    ),
                    'wrapper' => array (
                        'width' => '50%',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '1',
                    // Specific for field type
                    'message' => 0,
                );
                
            break;
        endswitch;
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