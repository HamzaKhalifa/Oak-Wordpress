<?php 
acf_add_local_field_group(
    array (
        'key' => 'quali_indic',
        'title' => 'Indicateur Qualitatif',
        'fields' => array (
            array (
                'key' => 'slug_publication_quali',
                'label' => 'Publication dont est issu l’indicateur',
                'name' => 'slug_publication_quali',
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
                'key' => 'slug_object_quali',
                'label' => 'L\'objet auquel appartient l’indicateur',
                'name' => 'slug_object_quali',
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
                'key' => 'parent_indic_quali',
                'label' => 'Indicateur dépendant d’un autre indicateur',
                'name' => 'parent_indic_quali',
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
                'key' => 'slug_parent_indic_quali',
                'label' => 'Indicateur quali de niveau supérieur',
                'name' => 'slug_parent_indic_quali',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'parent_indic_quali', 'operator' => '==', 'value' => '1'
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
                'multiple' => 0,
                'return_format' => 'object',
            ),

            array (
                'key' => 'code_type_quali_indic',
                'label' => 'Type de numérotation',
                'name' => 'code_type_quali_indic',
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
                'key' => 'code_quali_indic',
                'label' => 'Numérotation de l’indicateur',
                'name' => 'code_quali_indic',
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
                'key' => 'desc_quali_indic',
                'label' => 'Description de la publication',
                'name' => 'desc_quali_indic',
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
                'key' => 'prox_indic_quali',
                'label' => 'Indicateur proche d’un ou plusieurs indicateur(s)',
                'name' => 'prox_indic_quali',
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
                'key' => 'slug_prox_indic_quali',
                'label' => 'Indicateur(s) proches de l’indicateur en question',
                'name' => 'slug_prox_indic_quali',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'prox_indic_quali', 'operator' => '==', 'value' => '1'
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
                    'value' => 'quali_indic',
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