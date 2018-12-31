<?php 
acf_add_local_field_group(
    array (
        'key' => 'quanti_indic',
        'title' => 'Indicateur Quantitatif',
        'fields' => array (
            array (
                'key' => 'slug_publication_quanti',
                'label' => 'Publication dont est issu l’indicateur',
                'name' => 'slug_publication_quanti',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'post_type' => 'publication',
                'allow_null' => 0,
                'multiple' => 0,
                'return_format' => 'object',
            ),

            array (
                'key' => 'slug_object_quanti',
                'label' => 'L\'objet auquel appartient l’indicateur',
                'name' => 'slug_object_quanti',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'post_type' => 'post',
                'allow_null' => 0,
                'multiple' => 0,
                'return_format' => 'object',
            ),

            array (
                'key' => 'parent_indic_quanti',
                'label' => 'Indicateur dépendant d’un autre indicateur',
                'name' => 'parent_indic_quanti',
                'type' => 'true_false',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'message' => 0,
            ),

            array (
                'key' => 'slug_parent_indic_quanti',
                'label' => 'Indicateur quanti de niveau supérieur',
                'name' => 'slug_parent_indic_quanti',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array (
                    array(
                        'field' => 'parent_indic',
                        'operator' => '==',
                        'value' => '1'
                    )
                ),
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'post_type' => 'quanti_indic',
                'allow_null' => 0,
                'multiple' => 0,
                'return_format' => 'object',
            ),

            array (
                'key' => 'code_type_quanti_indic',
                'label' => 'Type de numérotation',
                'name' => 'code_type_quanti_indic',
                'type' => 'select',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'choices' => array(
                    'I', 
                    '1', 
                    'A',
                    'a'
                ),
                'message' => 0,
                'multiple' => 0
            ),

            array (
                'key' => 'code_quanti_indic',
                'label' => 'Numérotation de l’indicateur',
                'name' => 'code_quanti_indic',
                'type' => 'number',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'message' => 0,
            ),

            array (
                'key' => 'desc_quanti_indic',
                'label' => __( 'Description de la publication', Oak::$text_domain ),
                'name' => 'desc_quanti_indic',
                'type' => 'textarea',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'placeholder' => 'Description de la publication'
            ),

            array (
                'key' => 'prox_indic_quanti',
                'label' => 'Indicateur proche d’un ou plusieurs indicateur(s)',
                'name' => 'prox_indic_quanti',
                'type' => 'true_false',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'message' => 0,
            ),

            array (
                'key' => 'slug_prox_indic_quanti',
                'label' => 'Indicateur(s) proches de l’indicateur en question',
                'name' => 'slug_prox_indic_quanti',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'prox_indic_quanti', 'operator' => '==', 'value' => '1'
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'post_type' => 'quali_indic',
                'allow_null' => 0,
                'multiple' => 1,
                'return_format' => 'object',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'quanti_indic',
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