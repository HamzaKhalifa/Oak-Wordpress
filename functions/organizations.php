<?php 
acf_add_local_field_group( array (
    'key' => 'organization',
    'title' => 'Organisation',
    'fields' => array (
        array (
            'key' => 'company_org',
            'label' => 'Une Entreprise?',
            'name' => 'company_org',
            'type' => 'true_false',
            'prefix' => '',
            'instructions' => 'Spécifier si l\'organisation est de type entreprise ou non',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            // Specific for field type
            'message' => 0,
        ),

        // array (
        //     'key' => 'slug_org_size',
        //     'label' => 'Taille',
        //     'name' => 'slug_org_size',
        //     'type' => 'taxonomy',
        //     'prefix' => '',
        //     'instructions' => 'Taille de l\'Entreprise',
        //     'required' => 0,
        //     'conditional_logic' => array(
        //         array(
        //             array(
        //                 'field' => 'company_org', 'operator' => '==', 'value' => '1'
        //             )
        //         )
        //     ),
        //     'wrapper' => array (
        //         'width' => '50%',
        //         'class' => '',
        //         'id' => '',
        //     ),
        //     'default_value' => '',
        //     // Specific for field type
        //     'taxonomy' => 'org_size',
        //     'field_type' => 'checkbox',
        //     'allow_null' => 0,
        //     'load_save_terms' => 1,
        //     'return_format' => 'id',
        //     'add_term' => 1
        // ),

        // array (
        //     'key' => 'slug_org_type',
        //     'label' => 'Type',
        //     'name' => 'slug_org_type',
        //     'type' => 'taxonomy',
        //     'prefix' => '',
        //     'instructions' => 'Type de l\'Entreprise',
        //     'required' => 0,
        //     'conditional_logic' => array(
        //         array(
        //             array(
        //                 'field' => 'company_org', 'operator' => '==', 'value' => '1'
        //             )
        //         )
        //     ),
        //     'wrapper' => array (
        //         'width' => '50%',
        //         'class' => '',
        //         'id' => '',
        //     ),
        //     'default_value' => '',
        //     // Specific for field type
        //     'taxonomy' => 'org_type',
        //     'field_type' => 'checkbox',
        //     'allow_null' => 0,
        //     'load_save_terms' => 1,
        //     'return_format' => 'id',
        //     'add_term' => 1
        // ),

        array (
            'key' => 'listed_org',
            'label' => 'Entreprise cotée',
            'name' => 'listed_org',
            'type' => 'true_false',
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
                'width' => '50%',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            // Specific for field type
            'message' => 0,
        ),

        array (
            'key' => 'slug_activity',
            'label' => 'Secteur d\'activité',
            'name' => 'slug_activity',
            'type' => 'taxonomy',
            'prefix' => '',
            'instructions' => 'Secteur d\'activité de l\'Entreprise',
            'required' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'company_org', 'operator' => '==', 'value' => '1'
                    )
                )
            ),
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

        array (
            'key' => 'website_org',
            'label' => 'Site Internet',
            'name' => 'website_org',
            'type' => 'url',
            'prefix' => '',
            'instructions' => 'Site Internet corporate de l’organisation',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '50%',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            // Specific for field type
            'placeholder' => 'exemple: http://hamzakhalifa.com',
        ),

        array (
            'key' => 'logo_org',
            'label' => 'Logo',
            'name' => 'logo_org',
            'type' => 'image',
            'prefix' => '',
            'instructions' => 'Logo de l\'organisation',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '50%',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            // Specific for field type
        ),

        array (
            'key' => 'countries',
            'label' => 'Pays',
            'name' => 'countries',
            'type' => 'select',
            'prefix' => '',
            // 'instructions' => 'Pays',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
            ),        
            'allow_null' => 0, 
            'multiple' => 0,  
	        'ui' => 0,
	        'ajax' => 0,
        ),

        array (
            'key' => 'contacts',
            'label' => 'Contactes',
            'name' => 'contacts',
            'type' => 'select',
            'prefix' => '',
            'instructions' => __('Contactes CRM', Dawn::$text_domain),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
            ),        
            'allow_null' => 0, 
            'multiple' => 1,  
	        'ui' => 0,
	        'ajax' => 0,
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'organization',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
));