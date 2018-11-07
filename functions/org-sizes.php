<?php 
acf_add_local_field_group(
    array (
        'key' => 'sizes',
        'title' => 'Tailles',
        'fields' => array (
            array (
                'key' => 'acronym_org_size',
                'label' => 'Acronyme',
                'name' => 'acronym_org_size',
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
                'key' => 'country',
                'label' => 'Pays',
                'name' => 'country',
                'type' => 'post_object',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
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
                'key' => 'headcount_org_size',
                'label' => 'Nombre minimum ou maximum d’employés',
                'name' => 'headcount_org_size',
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
                'key' => 'min_headcount_org_size',
                'label' => 'Nombre minimum d’employés',
                'name' => 'min_headcount_org_size',
                'type' => 'number',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        'field' => 'headcount_org_size', 'operator' => '==', 'value' => '1'
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
                'key' => 'max_headcount_org_size',
                'label' => 'Nombre maximum d’employés',
                'name' => 'max_headcount_org_size',
                'type' => 'number',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        'field' => 'headcount_org_size', 'operator' => '==', 'value' => '1'
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
                'key' => 'turnover_org_size',
                'label' => 'Nombre minimum ou maximum de chiffre d’affaire',
                'name' => 'turnover_org_size',
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
                'key' => 'min_turnover_orgSize',
                'label' => 'Chiffre d’affaire minimum',
                'name' => 'min_turnover_orgSize',
                'type' => 'number',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        'field' => 'turnover_org_size', 'operator' => '==', 'value' => '1'
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
                'key' => 'max_turnover_orgSize',
                'label' => 'Chiffre d’affaire maximum',
                'name' => 'max_turnover_orgSize',
                'type' => 'number',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        'field' => 'turnover_org_size', 'operator' => '==', 'value' => '1'
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
                'key' => 'balancesheet_org_size',
                'label' => 'Bilan minimum ou maximum',
                'name' => 'balancesheet_org_size',
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
                'key' => 'min_balancesheet_org_size',
                'label' => 'Bilan minimum',
                'name' => 'min_balancesheet_org_size',
                'type' => 'number',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        'field' => 'balancesheet_org_size', 'operator' => '==', 'value' => '1'
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
                'key' => 'maxBalancesheet_org_size',
                'label' => 'Bilan maximum',
                'name' => 'maxBalancesheet_org_size',
                'type' => 'number',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        'field' => 'balancesheet_org_size', 'operator' => '==', 'value' => '1'
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
                'key' => 'multinational_org_size',
                'label' => 'Statut de multinationale de la taille d’organisation',
                'name' => 'multinational_org_size',
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
        ),
        'location' => array (
            array (
                array (
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'org_size',
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