<?php 
acf_add_local_field_group(
    array (
        'key' => 'glossary',
        'title' => 'Gloassaire',
        'fields' => array (
            array (
                'key' => 'slug_publication_glossary',
                'label' => 'Publication(s) dont est issue la terminologie',
                'name' => 'slug_publication_glossary',
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
                'key' => 'slug_object_glossary',
                'label' => 'L\'objet auquel appartient la terminologie',
                'name' => 'slug_object_glossary',
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
                'key' => 'parent_glossary',
                'label' => 'Terminologie dépendante d’une autre',
                'name' => 'parent_glossary',
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
                'key' => 'slug_parent_glossary',
                'label' => 'Terminologie de niveau supérieur',
                'name' => 'slug_parent_glossary',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array (
                    array(
                        'field' => 'parent_glossary',
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
                'post_type' => 'glossary',
                'allow_null' => 0,
                'multiple' => 0,
                'return_format' => 'object',
            ),
            array (
                'key' => 'def_glossary',
                'label' => 'Défnition de la terminologie',
                'name' => 'def_glossary',
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
                'placholder' => 'Définition'
            ),

            array (
                'key' => 'prox_glossary',
                'label' => 'Terminologie(s) proche(s) de la terminologie défnie',
                'name' => 'prox_glossary',
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
                'key' => 'slug_prox_lossary',
                'label' => 'Indicateur(s) proches de l’indicateur en question',
                'name' => 'slug_prox_lossary',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'prox_glossary', 'operator' => '==', 'value' => '1'
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
                    'value' => 'glossary',
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