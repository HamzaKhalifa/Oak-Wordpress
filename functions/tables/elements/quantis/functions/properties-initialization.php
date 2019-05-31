<?php
Quantis::$properties = array (
    array(
        'name' => 'publication', 
        'property_name' => 'quanti_publication', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$publications_array,
        'placeholder' => __( 'Publication(s) dont est issue l\'Idicateur: ', Oak::$text_domain ),
        'description' => __( 'Publication(s) dont est issue l\'Idicateur: ', Oak::$text_domain ),
        'width' => '50'
    ),
    array(
        'name' => 'object',
        'property_name' => 'quanti_object',
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$objects_array,
        'placeholder' => __( 'L\'objet auquel appartient l\'indicateur: ', Oak::$text_domain ), 
        'description' => __( 'L\'objet auquel appartient l\'indicateur: ', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'depends', 
        'property_name' => 'quanti_depends', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Indicateur dépendant d’une autre:', Oak::$text_domain ), 
        'description' => __( 'Indicateur dépendant d’une autre:', Oak::$text_domain ), 
        'width' => '100',
        'condition' => true
    ),
    array(
        'name' => 'parent', 
        'property_name' => 'quanti_parent', 
        'type' => 'text',
        'input_type' => 'select_with_filters',
        'select_multiple' => 'true',
        'can_add_more' => 'true',
        'choices' => Oak::$quantis_array,
        'filters' => [
            array(
                'description' => __( 'Publications Cadres RSE', Oak::$text_domain ),
                'choices' => Oak::$frame_publications_array,
                'name' => 'publication'
            ),
            array(
                'description' => __( 'Object', Oak::$text_domain ),
                'choices' => Oak::$objects_array,
                'name' => 'object'
            )
        ],
        'placeholder' => __( 'Indicateurs de niveau supérieur:', Oak::$text_domain ), 
        'description' => __( 'Indicateurs de niveau supérieur:', Oak::$text_domain ), 
        'width' => '100',
        'depends' => array (
            array( 'name' => 'depends', 'values' => array( 'true' ) )
        )
    ),
    array(
        'name' => 'parent_object', 
        'property_name' => 'quanti_parent_object', 
        'type' => 'text',

        'input_type' => 'select_with_filters',
        'select_multiple' => 'true',
        'can_add_more' => 'true',
        'choices' => Oak::$objects_array,
        'filters' => [
            // array(
            //     'description' => __( 'Publications Cadres RSE', Oak::$text_domain ),
            //     'choices' => Oak::$frame_publications_array,
            //     'name' => 'publication'
            // ),
            // array(
            //     'description' => __( 'Object', Oak::$text_domain ),
            //     'choices' => Oak::$objects_array,
            //     'name' => 'object'
            // )
        ],

        'placeholder' => __( 'Objets de niveau supérieur:', Oak::$text_domain ), 
        'description' => __( 'Objets de niveau supérieur:', Oak::$text_domain ), 
        'width' => '100',
        'depends' => array(
            array( 'name' => 'depends', 'values' => array( 'true' ) )
        )
    ),
    array(
        'name' => 'numerotation_type', 
        'property_name' => 'quanti_numerotation_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => '1', 'innerHTML' => '1' ),
            array( 'value' => 'I', 'innerHTML' => 'I' ),
            array( 'value' => 'a', 'innerHTML' => 'a' ),
            array( 'value' => '1.a', 'innerHTML' => '1.a' ),
        ),
        'placeholder' => __( 'Type de numérotation', Oak::$text_domain ), 
        'description' => __( 'Type de numérotation', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'numerotation', 
        'property_name' => 'quanti_numerotation', 
        'type' => 'text',
        'input_type' => 'number',
        'placeholder' => __( 'Numérotation', Oak::$text_domain ), 
        'description' => __( 'Numérotation', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'description', 
        'property_name' => 'quanti_description', 
        'type' => 'text',
        'input_type' => 'textarea',
        'placeholder' => __( 'Description', Oak::$text_domain ), 
        'description' => __( 'Description', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'close', 
        'property_name' => 'quanti_close', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Indicateurs proches', Oak::$text_domain ), 
        'description' => __( 'Indicateurs proches', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true
    ),
    array(
        'name' => 'close_indicators', 
        'property_name' => 'quanti_close_indicators', 
        'type' => 'text',
        'input_type' => 'select_with_filters',
        'can_add_more' => 'true',
        'select_multiple' => 'true',
        'choices' => Oak::$quantis_and_qualis,
        'filters' => [
            array(
                'description' => __( 'Type d\'indicateur', Oak::$text_domain ),
                'choices' => array( 
                    array ( 'value' => '0', 'innerHTML' => __( 'Aucun type d\'indicateur n\'est sélectionné', Oak::$text_domain ) ), 
                    array ( 'value' => 'quanti', 'innerHTML' => __( 'Quantitative', Oak::$text_domain ) ), 
                    array ( 'value' => 'quali', 'innerHTML' => __( 'Qualitative', Oak::$text_domain ) )
                ),
                'name' => 'indicator_type'
            ),
            array(
                'description' => __( 'Publications Cadres RSE', Oak::$text_domain ),
                'choices' => Oak::$frame_publications_array,
                'name' => 'publication'
            ),
            array(
                'description' => __( 'Object', Oak::$text_domain ),
                'choices' => Oak::$objects_array,
                'name' => 'object'
            )
        ],
        'placeholder' => __( 'Indicateurs proches', Oak::$text_domain ), 
        'description' => __( 'Indicateurs proches', Oak::$text_domain ), 
        'width' => '100',
        'depends' => array (
            array( 'name' => 'close', 'values' => array( 'true' ) )
        )
    ),
    array (
        'name' => 'close_objects', 
        'property_name' => 'quanti_close_objects', 
        'type' => 'text',
        'input_type' => 'select_with_filters',
        'can_add_more' => 'true',
        'select_multiple' => 'true',
        'choices' => Oak::$objects_array,
        'filters' => [
            // array (
            //     'description' => __( 'Type d\'indicateur', Oak::$text_domain ),
            //     'choices' => array( 
            //         array ( 'value' => '0', 'innerHTML' => __( 'Aucun type d\'indicateur n\'est sélectionné', Oak::$text_domain ) ), 
            //         array ( 'value' => 'quanti', 'innerHTML' => __( 'Quantitative', Oak::$text_domain ) ), 
            //         array ( 'value' => 'quanti', 'innerHTML' => __( 'quantitative', Oak::$text_domain ) )
            //     ),
            //     'name' => 'indicator_type'
            // ),
            // array(
            //     'description' => __( 'Publications Cadres RSE', Oak::$text_domain ),
            //     'choices' => Oak::$frame_publications_array,
            //     'name' => 'publication'
            // ),
            // array(
            //     'description' => __( 'Object', Oak::$text_domain ),
            //     'choices' => Oak::$objects_array,
            //     'name' => 'object'
            // )
        ],
        'placeholder' => __( 'Objets proches', Oak::$text_domain ), 
        'description' => __( 'Objets proches', Oak::$text_domain ), 
        'width' => '100',
        'depends' => array (
            array( 'name' => 'close', 'values' => array( 'true' ) )
        )
    ),
    array (
        'name' => 'frame_objects', 
        'property_name' => 'quanti_frame_objects', 
        'type' => 'text',
        'input_type' => 'select_with_filters',
        'can_add_more' => 'true',
        'select_multiple' => 'true',
        'choices' => Oak::$frame_objects_array,
        'filters' => [
        ],
        'placeholder' => __( 'Objets Cadres RSE', Oak::$text_domain ), 
        'description' => __( 'Objets Cadres RSE', Oak::$text_domain ), 
        'width' => '100',
        'depends' => array (
            array( 'name' => 'close', 'values' => array( 'true' ) )
        )
    ),
);