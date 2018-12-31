<?php 
acf_add_local_field_group(
    array (
        'key' => 'publications',
        'title' => 'Publication',
        'fields' => array (

            array (
                'key' => 'slug_org',
                'label' => 'Organisation émettrice de la publication',
                'name' => 'slug_org',
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
                'key' => 'pub_year',
                'label' => __('Année de la Publication', Oak::$text_domain),
                'name' => 'pub_year',
                'type' => 'number',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' =>0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'return_format' => 'array',
                'library' => 'all',
                'min_size' => 0,
                'placeholder' => __('Exemple: 2019', Oak::$text_domain)
            ),

            array (
                'key' => 'cover_publication',
                'label' => 'Vignette',
                'name' => 'cover_publication',
                'type' => 'image',
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
            ),

            array (
                'key' => 'pub_format',
                'label' => __('Format de publication', Oak::$text_domain ),
                'name' => 'pub_format',
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
                'choices' => array(
                    'Fichier PDF', 
                    'ePub',
                    'web'
                ),        
                'allow_null' => 0, 
                'multiple' => 0,  
                'ui' => 0,
                'ajax' => 0,
            ),

            array (
                'key' => 'pub_url',
                'label' => __('URL de la publication', Oak::$text_domain ),
                'name' => 'pub_url',
                'type' => 'url',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'pub_format', 'operator' => '>', 'value' => '0', 
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'Fichier PDF', 
                    'ePub',
                    'web'
                ),        
                'allow_null' => 0,  
                'ui' => 0,
                'ajax' => 0,
            ),

            array (
                'key' => 'file_publication',
                'label' => 'Fichier de la publication',
                'name' => 'file_publication',
                'type' => 'file',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'pub_format', 'operator' => '==', 'value' => '0', 
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'min_size' => 0,
                'max_size' => 0,
                'mime_types' => '',
                // Specific for field type
            ),

            array (
                'key' => 'pub_des',
                'label' => __('Description', Oak::$text_domain),
                'name' => 'pub_des',
                'type' => 'textarea',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' =>0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'return_format' => 'array',
                'library' => 'all',
                'min_size' => 0,
                'placeholder' => __('Description', Oak::$text_domain)
            ),

            array (
                'key' => 'report_publication',
                'label' => 'Rapport d’entreprise ou Cadre RSE',
                'name' => 'report_publication',
                'type' => 'select',
                'prefix' => '',
                'instructions' => __('Contactes CRM', Oak::$text_domain),
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'Rapport d’entreprise',
                    'Cadre RSE'
                ),        
                'allow_null' => 0, 
                'multiple' => 0,  
                'ui' => 0,
                'ajax' => 0,
            ),

            array (
                'key' => 'type_manager',
                'label' => 'Type de cadres',
                'name' => 'type_manager',
                'type' => 'select',
                'prefix' => '',
                'instructions' => __('Contactes CRM', Oak::$text_domain),
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'report_publication', 'operator' => '==', 'value' => '1', 
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'Cadres universels',
                    'Normes et initiatives sectorielles (Déploiement)',
                    'Lignes directrices et cadres de référence (Reporting)',
                    'Initiatives d’évaluation (Notation)',
                    'Notation extra-financière (Classement)'
                ),        
                'allow_null' => 0, 
                'multiple' => 0,  
                'ui' => 0,
                'ajax' => 0,
            ),

            array (
                'key' => 'sectorial_publication',
                'label' => 'Cadre sectoriel?',
                'name' => 'sectorial_publication',
                'type' => 'true_false',
                'prefix' => '',
                'instructions' => 'Spécifier si l\'organisation est de type entreprise ou non',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'report_publication', 'operator' => '==', 'value' => '1', 
                        )
                    )
                ),
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
                'key' => 'sector_publication',
                'label' => 'Secteur d\'activité du Cadre',
                'name' => 'sector_publication',
                'type' => 'taxonomy',
                'prefix' => '',
                'instructions' => 'Secteur d\'Activité',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'sectorial_publication', 'operator' => '==', 'value' => '1'
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
                'key' => 'local_publication',
                'label' => 'Publication locale?',
                'name' => 'local_publication',
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
                'key' => 'countries',
                'label' => 'Pays de la Publication',
                'name' => 'countries',
                'type' => 'select',
                'prefix' => '',
                // 'instructions' => 'Pays',
                'required' => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'local_publication', 'operator' => '==', 'value' => '1'
                        )
                    )
                ),
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
                'key' => 'type_report',
                'label' => 'Type de rapport',
                'name' => 'type_report',
                'type' => 'select',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'report_publication', 'operator' => '==', 'value' => '0', 
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'Document de référence',
                    'Rapport annuel',
                    'Reporting intégré',
                    'Initiatives d’évaluation (Notation)',
                    'Reporting RSE'
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'ajax' => 0,
            ),

            array (
                'key' => 'language_publication',
                'label' => 'Langue de la publication',
                'name' => 'language_publication',
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
                'choices' => array(
                ),        
                'allow_null' => 0, 
                'multiple' => 0,  
                'ui' => 0,
                'ajax' => 0,
            ),

            array (
                'key' => 'gri_type',
                'label' => 'Type GRI de rapport',
                'name' => 'gri_type',
                'type' => 'select',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'report_publication', 'operator' => '==', 'value' => '0', 
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    '',
                    'Non - GRI',
                    'Citing – GRI',
                    'GRI – Referenced',
                    'GRI – Standards',
                ),        
                'allow_null' => 0,
                'multiple' => 0,  
                'ui' => 0,
                'ajax' => 0,
            ),

            array (
                'key' => 'conform_option',
                'label' => 'Option de conformité',
                'name' => 'conform_option',
                'type' => 'select',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'gri_type', 'operator' => '>', 'value' => '1', 
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'Essentielle',
                    'Exhaustive',
                    'Non-applicable',
                ),        
                'allow_null' => 0,
                'multiple' => 0,  
                'ui' => 0,
                'ajax' => 0,
            ),

            array (
                'key' => 'sect_supp',
                'label' => 'Supplément sectoriel',
                'name' => 'sect_supp',
                'type' => 'select',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'report_publication', 'operator' => '==', 'value' => '0', 
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    '',
                    'Services d’électricité (EUSS)',
                    'Services financiers (FSSS)',
                    'Préparation alimentaire (FPSS)',
                    'Mines et métaux (MMSS)',
                    'ONG (NGOSS)',
                    'Opérateurs aéroportuaires (AOSS)',
                    'Construction et Immobilier (CRESS)',
                    'Organisateur événementiels (EOSS)',
                    'Pétrole et gaz (OGSS)',
                    'Médias (MSS)',
                    'Non-utilisé',
                    'Non-applicables'
                ),        
                'allow_null' => 0,
                'multiple' => 0,  
                'ui' => 0,
                'ajax' => 0,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'publication',
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