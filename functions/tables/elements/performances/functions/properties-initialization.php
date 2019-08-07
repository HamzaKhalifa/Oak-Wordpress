<?php
Performances::$properties = array(
    array ( 
        'name' => 'quantis', 
        'property_name' => 'performance_quantis', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$quantis_array,
        'placeholder' => __( 'Indicteurs', Oak::$text_domain ), 
        'description' => __( 'Indicteurs.', Oak::$text_domain ), 
        'width' => '100',
    ),
    array ( 
        'name' => 'type', 
        'property_name' => 'performance_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array (
            array( 'value' => 'distance', 'innerHTML' => __( 'Distance', Oak::$text_domain ) ),
            array( 'value' => 'volume', 'innerHTML' => __( 'Volume', Oak::$text_domain ) ),
            array( 'value' => 'mass', 'innerHTML' => __( 'Masse', Oak::$text_domain ) ),
            array( 'value' => 'energy', 'innerHTML' => __( 'Energie', Oak::$text_domain ) ),
            array( 'value' => 'energy_consumption', 'innerHTML' => __( 'Consommation d\'Energie', Oak::$text_domain ) ),
            array( 'value' => 'co2_emission', 'innerHTML' => __( 'Emission de CO2', Oak::$text_domain ) ),
            array( 'value' => 'surface', 'innerHTML' => __( 'Surface', Oak::$text_domain ) ),
            array( 'value' => 'money', 'innerHTML' => __( 'Monnaie', Oak::$text_domain ) ),
            array( 'value' => 'ratio', 'innerHTML' => __( 'Part', Oak::$text_domain ) ),
            array( 'value' => 'raw', 'innerHTML' => __( 'Brut', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Type', Oak::$text_domain ), 
        'description' => __( 'Type.', Oak::$text_domain ), 
        'width' => '25',
        'condition' => true,
        'line' => 'beginning'
    ),
    array (
        'name' => 'distance_unity_filter', 
        'property_name' => 'performance_distance_unity_filter', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'm', 'innerHTML' => __( 'Mètre', Oak::$text_domain ) ),
            array( 'value' => 'ft', 'innerHTML' => __( 'Foot', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Distance', Oak::$text_domain ), 
        'description' => __( 'Unité de Distance.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'distance' ) )
        ),
        'condition' => true,
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'distance_unity_meter', 
        'property_name' => 'performance_distance_unity_meter', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'mm', 'innerHTML' => __( 'Mm', Oak::$text_domain ) ),
            array( 'value' => 'cm', 'innerHTML' => __( 'Cm', Oak::$text_domain ) ),
            array( 'value' => 'dm', 'innerHTML' => __( 'Dm', Oak::$text_domain ) ),
            array( 'value' => 'm', 'innerHTML' => __( 'M', Oak::$text_domain ) ),
            array( 'value' => 'dekam', 'innerHTML' => __( 'Dm', Oak::$text_domain ) ),
            array( 'value' => 'hm', 'innerHTML' => __( 'Hm', Oak::$text_domain ) ),
            array( 'value' => 'km', 'innerHTML' => __( 'Km', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Distance', Oak::$text_domain ), 
        'description' => __( 'Unité de Distance.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'distance' ) ),
            array( 'name' => 'distance_unity_filter', 'values' => array( 'm' ) ),
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'distance_unity_feet', 
        'property_name' => 'performance_distance_unity_feet', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'inch', 'innerHTML' => __( 'Inch', Oak::$text_domain ) ),
            array( 'value' => 'foot', 'innerHTML' => __( 'Foot', Oak::$text_domain ) ),
            array( 'value' => 'yard', 'innerHTML' => __( 'Yard', Oak::$text_domain ) ),
            array( 'value' => 'chain', 'innerHTML' => __( 'Chain', Oak::$text_domain ) ),
            array( 'value' => 'furlong', 'innerHTML' => __( 'Furlong', Oak::$text_domain ) ),
            array( 'value' => 'mile', 'innerHTML' => __( 'Mile', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Distance', Oak::$text_domain ), 
        'description' => __( 'Unité de Distance.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'distance' ) ),
            array( 'name' => 'distance_unity_filter', 'values' => array( 'ft' ) ),
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'volume_unity_filter', 
        'property_name' => 'performance_volume_unity_filter', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'm3', 'innerHTML' => __( 'M^3/Dm^3/Cm^3', Oak::$text_domain ) ),
            array( 'value' => 'l', 'innerHTML' => __( 'L/Dl/Cl', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Volume', Oak::$text_domain ), 
        'description' => __( 'Unité de Volume.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'volume' ) )
        ),
        'condition' => true,
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'volume_unity_meter', 
        'property_name' => 'performance_volume_unity_meter', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'm3', 'innerHTML' => __( 'M^3', Oak::$text_domain ) ),
            array( 'value' => 'dm3', 'innerHTML' => __( 'Dm^3', Oak::$text_domain ) ),
            array( 'value' => 'cm3', 'innerHTML' => __( 'Cm^3', Oak::$text_domain ) ),
            array( 'value' => 'mm3', 'innerHTML' => __( 'MM^3', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Volume', Oak::$text_domain ), 
        'description' => __( 'Unité de Volume.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array (
            array( 'name' => 'type', 'values' => array( 'volume' ) ),
            array( 'name' => 'volume_unity_filter', 'values' => array( 'm3' ) ),
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'volume_unity_leter', 
        'property_name' => 'performance_volume_unity_leter', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'l', 'innerHTML' => __( 'L', Oak::$text_domain ) ),
            array( 'value' => 'dl', 'innerHTML' => __( 'Dl', Oak::$text_domain ) ),
            array( 'value' => 'cl', 'innerHTML' => __( 'Cl', Oak::$text_domain ) ),
            array( 'value' => 'ml', 'innerHTML' => __( 'Ml', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Volume', Oak::$text_domain ), 
        'description' => __( 'Unité de Volume.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'volume' ) ),
            array( 'name' => 'volume_unity_filter', 'values' => array( 'l' ) ),
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'mass_unity_filter', 
        'property_name' => 'performance_mass_unity_filter', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'kg', 'innerHTML' => __( 'T/Kg', Oak::$text_domain ) ),
            array( 'value' => 'lb', 'innerHTML' => __( 'Lb', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Masse', Oak::$text_domain ), 
        'description' => __( 'Unité de Masse.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'mass' ) )
        ),
        'condition' => true,
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'mass_unity_kg', 
        'property_name' => 'performance_mass_unity_kg', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 't', 'innerHTML' => __( 'Tonnes', Oak::$text_domain ) ),
            array( 'value' => 'kg', 'innerHTML' => __( 'Kg', Oak::$text_domain ) ),
            array( 'value' => 'hg', 'innerHTML' => __( 'Cl', Oak::$text_domain ) ),
            array( 'value' => 'dekag', 'innerHTML' => __( 'Dg', Oak::$text_domain ) ),
            array( 'value' => 'g', 'innerHTML' => __( 'G', Oak::$text_domain ) ),
            array( 'value' => 'dg', 'innerHTML' => __( 'Dg', Oak::$text_domain ) ),
            array( 'value' => 'cg', 'innerHTML' => __( 'Cg', Oak::$text_domain ) ),
            array( 'value' => 'mg', 'innerHTML' => __( 'Mg', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Masse', Oak::$text_domain ), 
        'description' => __( 'Unité de Masse.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'mass' ) ),
            array( 'name' => 'mass_unity_filter', 'values' => array( 'kg' ) ),
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'mass_unity_lb', 
        'property_name' => 'performance_mass_unity_lb', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'lb', 'innerHTML' => __( 'Lb', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Masse', Oak::$text_domain ), 
        'description' => __( 'Unité de Masse.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array (
            array( 'name' => 'type', 'values' => array( 'mass' ) ),
            array( 'name' => 'mass_unity_filter', 'values' => array( 'lb' ) ),
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'energy_unity_filter', 
        'property_name' => 'performance_energy_unity_filter', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'w', 'innerHTML' => __( 'W/KW', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité d\'Energie', Oak::$text_domain ), 
        'description' => __( 'Unité d\'Energie.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'energy' ) )
        ),
        'condition' => true,
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'energy_unity_watt', 
        'property_name' => 'performance_energy_unity_watt', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'w', 'innerHTML' => __( 'W', Oak::$text_domain ) ),
            array( 'value' => 'kw', 'innerHTML' => __( 'Kw', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité d\'Energie', Oak::$text_domain ), 
        'description' => __( 'Unité d\'Energie.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'energy' ) ),
            array( 'name' => 'energy_unity_filter', 'values' => array( 'w' ) ),
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'energy_consumption_unity_filter', 
        'property_name' => 'performance_energy_consumption_unity_filter', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'w', 'innerHTML' => __( 'W/KW', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité d\'Energie', Oak::$text_domain ), 
        'description' => __( 'Unité d\'Energie.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'energy_consumption' ) )
        ),
        'condition' => true,
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'energy_consumption_unity_watt', 
        'property_name' => 'performance_energy_unity_watt', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array (
            array( 'value' => 'w', 'innerHTML' => __( 'W', Oak::$text_domain ) ),
            array( 'value' => 'kw', 'innerHTML' => __( 'Kw', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité d\'Energie', Oak::$text_domain ), 
        'description' => __( 'Unité d\'Energie.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'energy_consumption' ) ),
            array( 'name' => 'energy_unity_filter', 'values' => array( 'w' ) ),
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'co2_emission_unity_filter', 
        'property_name' => 'performance_co2_emission_unity_filter', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 't_eq_co2', 'innerHTML' => __( 'T Eq CO2', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité d\'Emission de CO2', Oak::$text_domain ), 
        'description' => __( 'Unité d\'Emission de CO2.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'co2_emission' ) )
        ),
        'condition' => true,
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'co2_emission_unity_tonne', 
        'property_name' => 'performance_co2_emission_unity_tonne', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array (
            array( 'value' => 't_eq_co2', 'innerHTML' => __( 'T Eq CO2', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité d\'Emission de CO2', Oak::$text_domain ), 
        'description' => __( 'Unité d\'Emission de CO2.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'co2_emission' ) ),
            array( 'name' => 'co2_emission_unity_filter', 'values' => array( 't_eq_co2' ) ),
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'surface_unity_filter', 
        'property_name' => 'performance_surface_unity_filter', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'm3', 'innerHTML' => __( 'M^3', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Surface', Oak::$text_domain ), 
        'description' => __( 'Unité de Surface.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'surface' ) )
        ),
        'condition' => true,
        'line' => 'dont_return'
    ),
    array (
        'name' => 'surface_unity_meter',
        'property_name' => 'performance_surface_unity_meter',
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array (
            array( 'value' => 'mm3', 'innerHTML' => __( 'Mm^3', Oak::$text_domain ) ),
            array( 'value' => 'cm3', 'innerHTML' => __( 'Cm^3', Oak::$text_domain ) ),
            array( 'value' => 'dm3', 'innerHTML' => __( 'Dm^3', Oak::$text_domain ) ),
            array( 'value' => 'm3', 'innerHTML' => __( 'M^3', Oak::$text_domain ) ),
            array( 'value' => 'dekam3', 'innerHTML' => __( 'Dm^3', Oak::$text_domain ) ),
            array( 'value' => 'hm3', 'innerHTML' => __( 'Hm^3', Oak::$text_domain ) ),
            array( 'value' => 'km3', 'innerHTML' => __( 'Km^3', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Surface', Oak::$text_domain ), 
        'description' => __( 'Unité de Surface.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'surface' ) ),
            array( 'name' => 'surface_unity_filter', 'values' => array( 'm3' ) ),
        ),
        'line' => 'dont_return'
    ),
    array (
        'name' => 'money_unity', 
        'property_name' => 'performance_money_unity', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => '€', 'innerHTML' => __( '€', Oak::$text_domain ) ),
            array( 'value' => '$', 'innerHTML' => __( '$', Oak::$text_domain ) ),
            array( 'value' => 'billion_fcfa', 'innerHTML' => __( 'Milliards FCFA', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Monnaie', Oak::$text_domain ), 
        'description' => __( 'Unité de Monnaie.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'money' ) )
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'ratio_unity', 
        'property_name' => 'performance_ratio_unity', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => '%', 'innerHTML' => __( '%', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Unité de Ratio', Oak::$text_domain ), 
        'description' => __( 'Unité de Ratio.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'ratio' ) )
        ),
        'line' => 'dont_return'
    ),
    array ( 
        'name' => 'raw_unity', 
        'property_name' => 'performance_raw_unity', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => '0', 'innerHTML' => __( 'Brut', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Brut', Oak::$text_domain ), 
        'description' => __( 'Brut.', Oak::$text_domain ), 
        'width' => '25',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'raw' ) )
        ),
        'line' => 'dont_return'
    ),
    array (
        'name' => 'business_line', 
        'property_name' => 'performance_business_line', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$business_line,
        'placeholder' => __( 'Périmètre métier', Oak::$text_domain ), 
        'description' => __( 'Périmètre métier.', Oak::$text_domain ), 
        'width' => '25',
        'line' => 'dont_return'
        // 'line' => 'end_of_line'
    ),
    array (
        'name' => 'country', 
        'property_name' => 'performance_country', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$countries,
        'placeholder' => __( 'Pays/Région', Oak::$text_domain ), 
        'description' => __( 'Pays/Région.', Oak::$text_domain ), 
        'width' => '25',
        'hidden' => get_option('oak_which_perimeter') == false || get_option('oak_which_perimeter') == 0 ? 'false' : 'true',
        'line' => 'dont_return'
    ),
    array (
        'name' => 'region', 
        'property_name' => 'performance_region', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$regions,
        'placeholder' => __( 'Région', Oak::$text_domain ), 
        'description' => __( 'Région.', Oak::$text_domain ), 
        'width' => '25',
        'hidden' => get_option('oak_which_perimeter') == false || get_option('oak_which_perimeter') != 1 ? 'true' : 'false',
        'line' => 'dont_return'
    ),
    array (
        'name' => 'custom_perimeter',
        'property_name' => 'performance_custom_perimeter', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$custom_perimeter,
        'placeholder' => __( 'Périmètre personalisé', Oak::$text_domain ), 
        'description' => __( 'Périmètre personalisé.', Oak::$text_domain ), 
        'width' => '25',
        'hidden' => get_option('oak_which_perimeter') == false || get_option('oak_which_perimeter') != 2 ? 'true' : 'false',
        'line' => 'end_of_line'
    ),
);



$performance_other_properties = array(
    array ( 
        'name' => 'publication', 
        'property_name' => 'performance_publication', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$publications_array,
        'placeholder' => __( 'Publication', Oak::$text_domain ), 
        'description' => __( 'Publication.', Oak::$text_domain ), 
        'width' => '50'
    ),
    array (
        'name' => 'objects', 
        'property_name' => 'performance_objects', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'true',
        'choices' => Oak::$objects_array,
        'placeholder' => __( 'Objects liés', Oak::$text_domain ), 
        'description' => __( 'Objects liés.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array (
        'name' => 'frame_objects', 
        'property_name' => 'performance_frame_objects', 
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
    ),
);

Performances::$properties = array_merge( Performances::$properties, $performance_other_properties );