<?php 
acf_add_local_field_group(
    array (
        'key' => 'activities',
        'title' => 'Secteur D\'activité',
        'fields' => array (
            array (
                'key' => 'acronym_activity',
                'label' => 'Acronyme',
                'name' => 'acronym_activity',
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
                'default_value' => '',
                // Specific for field type
                'placeholder' => 'Acronyme',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
                'readonly' => 0,
                'disabled' => 0,
            ),

            array (
                'key' => 'code_activity',
                'label' => 'Code du secteur d’activité',
                'name' => 'code_activity',
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
                'key' => 'org_activity',
                'label' => 'Organisation éditrice du secteur d’activité',
                'name' => 'org_activity',
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
                'post_type' => 'organization',
                'allow_null' => 0,
                'multiple' => 1,
                'return_format' => 'object',
            ),

            array (
                'key' => 'country_activity',
                'label' => 'Pays dans le(s)quel(s) s\'applique le secteur d’activité',
                'name' => 'country_activity',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'company_org', 'operator' => '==', 'value' => '1'
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
                'post_type' => 'country',
                'allow_null' => 0,
                'multiple' => 1,
                'return_format' => 'object',
            ),

            array (
                'key' => 'supp_activity',
                'label' => 'Existence d’un supplément sectoriel',
                'name' => 'supp_activity',
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
                'key' => 'slug_publication',
                'label' => 'Suppléments sectoriels liés (Publications)',
                'name' => 'slug_publication',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'supp_activity', 'operator' => '==', 'value' => '1'
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
                'post_type' => 'publication',
                'allow_null' => 0,
                'multiple' => 1,
                'return_format' => 'object',
            ),

            array (
                'key' => 'link_activity',
                'label' => 'Autres secteurs d’activité équivalents',
                'name' => 'link_activity',
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
                'taxonomy' => 'org_activity',
                'field_type' => 'checkbox',
                'allow_null' => 0,
                'load_save_terms' => 1,
                'return_format' => 'id',
                'add_term' => 1
            ),

        ),
        'location' => array (
            array (
                array (
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'org_activity',
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