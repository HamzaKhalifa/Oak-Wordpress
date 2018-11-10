<?php 
acf_add_local_field_group(array (
    'key' => 'critical_analyzes',
    'title' => 'Analyses Critiques',
    'fields' => array (
        array (
            'key' => 'analyzes',
            'label' => 'Analyses',
            'name' => 'analyzes',
            'type' => 'select',
            'prefix' => '',
            'instructions' => 'Ce champ n\'est pris en compte que lorsque le modèle de page selectionnée et celui d\'une analyse critique',
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
            'placeholder' => 'Analyse',
        )
    ),
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
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