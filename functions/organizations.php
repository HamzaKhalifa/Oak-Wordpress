<?php 
acf_add_local_field_group( array (
    'key' => 'organization',
    'title' => 'Organisation',
    'fields' => array (
        
        array (
            'key' => 'accro_org',
            'label' => __( 'Acronyme de l\'organisation', Dawn::$text_domain ),
            'name' => 'accro_org',
            'type' => 'text',
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
            'placeholder' => __( 'Acronyme de l\'organisation', Dawn::$text_domain )
            // Specific for field type
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
            'key' => 'org_description',
            'label' => __( 'Description de l\'organisation', Dawn::$text_domain ),
            'name' => 'org_description',
            'type' => 'textarea',
            'prefix' => '',
            'instructions' => 'Description',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '100%',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => __( 'Description', Dawn::$text_domain )
            // Specific for field type
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
                'width' => '100%',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            // Specific for field type
            'placeholder' => 'exemple: http://hamzakhalifa.com',
        ),

        array (
            'key' => 'address_country',
            'label' => __( 'Adresse du siège de l\'Organisation', Dawn::$text_domain ),
            'name' => 'address_country',
            'type' => 'text',
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
            'placeholder' => __( 'Adresse du siège de l\'organisation', Dawn::$text_domain )
            // Specific for field type
        ),

        array (
            'key' => 'countries',
            'label' => 'Pays du siège de l’organisation',
            'name' => 'countries',
            'type' => 'select',
            'prefix' => '',
            // 'instructions' => 'Pays',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '50%',
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

        array (
            'key' => 'org_type',
            'label' => __( 'Type', Dawn::$text_domain ),
            'name' => 'org_type',
            'type' => 'select',
            'prefix' => '',
            'instructions' => 'Type de l\'organisation',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '100%',
                'class' => '',
                'id' => '',
            ),
            'choices' => array( 
                'privée',
                'publique',
                'Coopérative',
                'Filiale',
                'Institution publique',
                'Organisation à but non lucratif',
                'Partenariat'
            ),
            'default_value' => '',
            'placeholder' => __( 'Description', Dawn::$text_domain )
            // Specific for field type
        ),

        array (
            'key' => 'parent_org',
            'label' => 'Organisation mère',
            'name' => 'parent_org',
            'type' => 'post_object',
            'prefix' => '',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'org_type', 'operator' => '==', 'value' => '3'
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
            'post_type' => 'organization',
            'allow_null' => 0,
            'multiple' => 1,
            'return_format' => 'object',
        ),

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
                        'field' => 'company_org', 'operator' => '==', 'value' => '1', 
                        'field' => 'org_type', 'operator' => '<', 'value' => '4', 
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