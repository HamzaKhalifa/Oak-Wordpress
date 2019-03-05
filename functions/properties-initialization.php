<?php 
// the property type here means type in the database (so a select is gonna have a type of text. So are the images and the files)

$publications_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucune Publication sélectionnée', Oak::$text_domain ) ) ];
foreach( Oak::$publications_without_redundancy as $publication ) :
    $publications_array[] = array( 'value' => $publication->publication_identifier, 'innerHTML' => $publication->publication_designation );
endforeach;

$organizations_array = [];
foreach( Oak::$organizations_without_redundancy as $organization ) :
    $organizations_array[] = array( 'value' => $organization->organization_identifier, 'innerHTML' => $organization->organization_designation );
endforeach;

$glossaries_array = [];
$glossaries_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucune terminologie sélectionnée', Oak::$text_domain ) ) ];
foreach( Oak::$glossaries_without_redundancy as $glossary ) :
    $glossaries_array[] = array( 'value' => $glossary->glossary_identifier, 'innerHTML' => $glossary->glossary_designation );
endforeach;

$qualis_array = [];
$qualis_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun indicateur sélectionné', Oak::$text_domain ) ) ];
foreach( Oak::$qualis_without_redundancy as $quali ) :
    $qualis_array[] = array( 'value' => $quali->quali_identifier, 'innerHTML' => $quali->quali_designation );
endforeach;

$quantis_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun indicateur sélectionné', Oak::$text_domain ) ) ];
foreach( Oak::$quantis_without_redundancy as $quanti ) :
    $quantis_array[] = array( 'value' => $quanti->quanti_identifier, 'innerHTML' => $quanti->quanti_designation );
endforeach;

$countries = array();
$languages = array();
if ( isset( $_GET['elements'] ) && ( $_GET['elements'] == 'publications' || $_GET['elements'] == 'organizations' ) ) :
    $countries_names = Oak::oak_get_countries_names();
    
    foreach( $countries_names as $country_name ) :
        $countries[] = array( 'value' => $country_name, 'innerHTML' => $country_name );
    endforeach;

    $languages_names = Oak::oak_get_languages();
    foreach( $languages_names as $langauge_name ) :
        $languages[] = array( 'value' => $langauge_name, 'innerHTML' => $langauge_name );
    endforeach;
endif;

// $objects_array = Oak::$all_objects_without_redundancy;
$objects_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun objet sélectionné', Oak::$text_domain ) ) ];
foreach( Oak::$all_objects_without_redundancy as $object ) :
    $objects_array[] = array( 'value' => $object->object_identifier, 'innerHTML' => $object->object_designation );
endforeach;

$years = array(
    array ( 'value' => '1990', 'innerHTML' => '1990' ),
    array ( 'value' => '1991', 'innerHTML' => '1991' ),
    array ( 'value' => '1992', 'innerHTML' => '1992' ),
    array ( 'value' => '1993', 'innerHTML' => '1993' ),
    array ( 'value' => '1994', 'innerHTML' => '1994' ),
    array ( 'value' => '1995', 'innerHTML' => '1995' ),
    array ( 'value' => '1996', 'innerHTML' => '1996' ),
    array ( 'value' => '1997', 'innerHTML' => '1997' ),
    array ( 'value' => '1998', 'innerHTML' => '1998' ),
    array ( 'value' => '1999', 'innerHTML' => '1999' ),
    array ( 'value' => '2000', 'innerHTML' => '2000' ),
    array ( 'value' => '2001', 'innerHTML' => '2001' ),
    array ( 'value' => '2002', 'innerHTML' => '2002' ),
    array ( 'value' => '2003', 'innerHTML' => '2003' ),
    array ( 'value' => '2004', 'innerHTML' => '2004' ),
    array ( 'value' => '2005', 'innerHTML' => '2005' ),
    array ( 'value' => '2006', 'innerHTML' => '2006' ),
    array ( 'value' => '2007', 'innerHTML' => '2007' ),
    array ( 'value' => '2008', 'innerHTML' => '2008' ),
    array ( 'value' => '2009', 'innerHTML' => '2009' ),
    array ( 'value' => '2010', 'innerHTML' => '2010' ),
    array ( 'value' => '2011', 'innerHTML' => '2011' ),
    array ( 'value' => '2012', 'innerHTML' => '2012' ),
    array ( 'value' => '2013', 'innerHTML' => '2013' ),
    array ( 'value' => '2014', 'innerHTML' => '2014' ),
    array ( 'value' => '2015', 'innerHTML' => '2015' ),
    array ( 'value' => '2016', 'innerHTML' => '2016' ),
    array ( 'value' => '2017', 'innerHTML' => '2017' ), 
    array ( 'value' => '2018', 'innerHTML' => '2018' ),
    array ( 'value' => '2019', 'innerHTML' => '2019' ),
    array ( 'value' => '2020', 'innerHTML' => '2020' ),
    array ( 'value' => '2021', 'innerHTML' => '2021' ),
    array ( 'value' => '2022', 'innerHTML' => '2022' ),
    array ( 'value' => '2023', 'innerHTML' => '2023' ),
    array ( 'value' => '2024', 'innerHTML' => '2024' ),
    array ( 'value' => '2025', 'innerHTML' => '2025' ),
    array ( 'value' => '2026', 'innerHTML' => '2026' ),
    array ( 'value' => '2027', 'innerHTML' => '2027' ),
    array ( 'value' => '2028', 'innerHTML' => '2028' ),
    array ( 'value' => '2029', 'innerHTML' => '2029' ),
    array ( 'value' => '2030', 'innerHTML' => '2030' ),
    array ( 'value' => '2031', 'innerHTML' => '2031' ),
    array ( 'value' => '2032', 'innerHTML' => '2032' ),
    array ( 'value' => '2033', 'innerHTML' => '2033' ),
    array ( 'value' => '2034', 'innerHTML' => '2034' ),
    array ( 'value' => '2035', 'innerHTML' => '2035' ),
    array ( 'value' => '2036', 'innerHTML' => '2036' ),
    array ( 'value' => '2037', 'innerHTML' => '2037' ),
    array ( 'value' => '2038', 'innerHTML' => '2038' ),
    array ( 'value' => '2039', 'innerHTML' => '2039' ),
    array ( 'value' => '2040', 'innerHTML' => '2040' ),
    array ( 'value' => '2041', 'innerHTML' => '2041' ),
    array ( 'value' => '2042', 'innerHTML' => '2042' ),
    array ( 'value' => '2043', 'innerHTML' => '2043' ),
    array ( 'value' => '2044', 'innerHTML' => '2044' ),
    array ( 'value' => '2045', 'innerHTML' => '2045' ),
    array ( 'value' => '2046', 'innerHTML' => '2046' ),
    array ( 'value' => '2047', 'innerHTML' => '2047' ),
    array ( 'value' => '2048', 'innerHTML' => '2048' ),
    array ( 'value' => '2049', 'innerHTML' => '2049' ),
    array ( 'value' => '2050', 'innerHTML' => '2050' ),
    array ( 'value' => '2051', 'innerHTML' => '2051' ),
    array ( 'value' => '2052', 'innerHTML' => '2052' ),
    array ( 'value' => '2053', 'innerHTML' => '2053' ),
    array ( 'value' => '2054', 'innerHTML' => '2054' ),
    array ( 'value' => '2055', 'innerHTML' => '2055' ),
    array ( 'value' => '2056', 'innerHTML' => '2056' ),
    array ( 'value' => '2057', 'innerHTML' => '2057' ),
    array ( 'value' => '2058', 'innerHTML' => '2058' ),
    array ( 'value' => '2059', 'innerHTML' => '2059' ),
    array ( 'value' => '2060', 'innerHTML' => '2060' ),
    array ( 'value' => '2061', 'innerHTML' => '2061' ),
    array ( 'value' => '2062', 'innerHTML' => '2062' ),
    array ( 'value' => '2063', 'innerHTML' => '2063' ),
    array ( 'value' => '2064', 'innerHTML' => '2064' ),
    array ( 'value' => '2065', 'innerHTML' => '2065' ),
    array ( 'value' => '2066', 'innerHTML' => '2066' ),
    array ( 'value' => '2067', 'innerHTML' => '2067' ),
    array ( 'value' => '2068', 'innerHTML' => '2068' ),
    array ( 'value' => '2069', 'innerHTML' => '2069' ),
    array ( 'value' => '2070', 'innerHTML' => '2070' ),
    array ( 'value' => '2071', 'innerHTML' => '2071' ),
    array ( 'value' => '2072', 'innerHTML' => '2072' ),
    array ( 'value' => '2073', 'innerHTML' => '2073' ),
    array ( 'value' => '2074', 'innerHTML' => '2074' ),
    array ( 'value' => '2075', 'innerHTML' => '2075' ),
    array ( 'value' => '2076', 'innerHTML' => '2076' ),
    array ( 'value' => '2077', 'innerHTML' => '2077' ),
    array ( 'value' => '2078', 'innerHTML' => '2078' ),
    array ( 'value' => '2079', 'innerHTML' => '2079' ),
    array ( 'value' => '2080', 'innerHTML' => '2080' ),
    array ( 'value' => '2081', 'innerHTML' => '2081' ),
    array ( 'value' => '2082', 'innerHTML' => '2082' ),
    array ( 'value' => '2083', 'innerHTML' => '2083' ),
    array ( 'value' => '2084', 'innerHTML' => '2084' ),
    array ( 'value' => '2085', 'innerHTML' => '2085' ),
    array ( 'value' => '2086', 'innerHTML' => '2086' ),
    array ( 'value' => '2087', 'innerHTML' => '2087' ),
    array ( 'value' => '2088', 'innerHTML' => '2088' ),
    array ( 'value' => '2089', 'innerHTML' => '2089' ),
    array ( 'value' => '2090', 'innerHTML' => '2090' ),
    array ( 'value' => '2091', 'innerHTML' => '2091' ),
    array ( 'value' => '2092', 'innerHTML' => '2092' ),
    array ( 'value' => '2093', 'innerHTML' => '2093' ),
    array ( 'value' => '2094', 'innerHTML' => '2094' ),
    array ( 'value' => '2095', 'innerHTML' => '2095' ),
    array ( 'value' => '2096', 'innerHTML' => '2096' ),
    array ( 'value' => '2097', 'innerHTML' => '2097' ),
    array ( 'value' => '2098', 'innerHTML' => '2098' ),
    array ( 'value' => '2099', 'innerHTML' => '2099' ),
    array ( 'value' => '2100', 'innerHTML' => '2100' ),
    array ( 'value' => '2101', 'innerHTML' => '2101' ),
    array ( 'value' => '2102', 'innerHTML' => '2102' ),
    array ( 'value' => '2103', 'innerHTML' => '2103' ),
    array ( 'value' => '2104', 'innerHTML' => '2104' ),
    array ( 'value' => '2105', 'innerHTML' => '2105' ),
    array ( 'value' => '2106', 'innerHTML' => '2106' ),
    array ( 'value' => '2107', 'innerHTML' => '2107' ),
    array ( 'value' => '2108', 'innerHTML' => '2108' ),
    array ( 'value' => '2109', 'innerHTML' => '2109' ),
    array ( 'value' => '2110', 'innerHTML' => '2110' ),
    array ( 'value' => '2111', 'innerHTML' => '2111' ),
    array ( 'value' => '2112', 'innerHTML' => '2112' ),
    array ( 'value' => '2113', 'innerHTML' => '2113' ),
    array ( 'value' => '2114', 'innerHTML' => '2114' ),
    array ( 'value' => '2115', 'innerHTML' => '2115' ),
    array ( 'value' => '2116', 'innerHTML' => '2116' ),
    array ( 'value' => '2117', 'innerHTML' => '2117' ), 
    array ( 'value' => '2118', 'innerHTML' => '2118' ),
    array ( 'value' => '2119', 'innerHTML' => '2119' ),
    array ( 'value' => '2120', 'innerHTML' => '2120' ),
    array ( 'value' => '2121', 'innerHTML' => '2121' ),
    array ( 'value' => '2122', 'innerHTML' => '2122' ),
    array ( 'value' => '2123', 'innerHTML' => '2123' ),
    array ( 'value' => '2124', 'innerHTML' => '2124' ),
    array ( 'value' => '2125', 'innerHTML' => '2125' ),
    array ( 'value' => '2126', 'innerHTML' => '2126' ),
    array ( 'value' => '2127', 'innerHTML' => '2127' ),
    array ( 'value' => '2128', 'innerHTML' => '2128' ),
    array ( 'value' => '2129', 'innerHTML' => '2129' ),
    array ( 'value' => '2130', 'innerHTML' => '2130' ),
    array ( 'value' => '2131', 'innerHTML' => '2131' ),
    array ( 'value' => '2132', 'innerHTML' => '2132' ),
    array ( 'value' => '2133', 'innerHTML' => '2133' ),
    array ( 'value' => '2134', 'innerHTML' => '2134' ),
    array ( 'value' => '2135', 'innerHTML' => '2135' ),
    array ( 'value' => '2136', 'innerHTML' => '2136' ),
    array ( 'value' => '2137', 'innerHTML' => '2137' ),
    array ( 'value' => '2138', 'innerHTML' => '2138' ),
    array ( 'value' => '2139', 'innerHTML' => '2139' ),
    array ( 'value' => '2140', 'innerHTML' => '2140' ),
    array ( 'value' => '2141', 'innerHTML' => '2141' ),
    array ( 'value' => '2142', 'innerHTML' => '2142' ),
    array ( 'value' => '2143', 'innerHTML' => '2143' ),
    array ( 'value' => '2144', 'innerHTML' => '2144' ),
    array ( 'value' => '2145', 'innerHTML' => '2145' ),
    array ( 'value' => '2146', 'innerHTML' => '2146' ),
    array ( 'value' => '2147', 'innerHTML' => '2147' ),
    array ( 'value' => '2148', 'innerHTML' => '2148' ),
    array ( 'value' => '2149', 'innerHTML' => '2149' ),
    array ( 'value' => '2150', 'innerHTML' => '2150' ),
    array ( 'value' => '2151', 'innerHTML' => '2151' ),
    array ( 'value' => '2152', 'innerHTML' => '2152' ),
    array ( 'value' => '2153', 'innerHTML' => '2153' ),
    array ( 'value' => '2154', 'innerHTML' => '2154' ),
    array ( 'value' => '2155', 'innerHTML' => '2155' ),
    array ( 'value' => '2156', 'innerHTML' => '2156' ),
    array ( 'value' => '2157', 'innerHTML' => '2157' ),
    array ( 'value' => '2158', 'innerHTML' => '2158' ),
    array ( 'value' => '2159', 'innerHTML' => '2159' ),
    array ( 'value' => '2160', 'innerHTML' => '2160' ),
    array ( 'value' => '2161', 'innerHTML' => '2161' ),
    array ( 'value' => '2162', 'innerHTML' => '2162' ),
    array ( 'value' => '2163', 'innerHTML' => '2163' ),
    array ( 'value' => '2164', 'innerHTML' => '2164' ),
    array ( 'value' => '2165', 'innerHTML' => '2165' ),
    array ( 'value' => '2166', 'innerHTML' => '2166' ),
    array ( 'value' => '2167', 'innerHTML' => '2167' ),
    array ( 'value' => '2168', 'innerHTML' => '2168' ),
    array ( 'value' => '2169', 'innerHTML' => '2169' ),
    array ( 'value' => '2170', 'innerHTML' => '2170' ),
    array ( 'value' => '2171', 'innerHTML' => '2171' ),
    array ( 'value' => '2172', 'innerHTML' => '2172' ),
    array ( 'value' => '2173', 'innerHTML' => '2173' ),
    array ( 'value' => '2174', 'innerHTML' => '2174' ),
    array ( 'value' => '2175', 'innerHTML' => '2175' ),
    array ( 'value' => '2176', 'innerHTML' => '2176' ),
    array ( 'value' => '2177', 'innerHTML' => '2177' ),
    array ( 'value' => '2178', 'innerHTML' => '2178' ),
    array ( 'value' => '2179', 'innerHTML' => '2179' ),
    array ( 'value' => '2180', 'innerHTML' => '2180' ),
    array ( 'value' => '2181', 'innerHTML' => '2181' ),
    array ( 'value' => '2182', 'innerHTML' => '2182' ),
    array ( 'value' => '2183', 'innerHTML' => '2183' ),
    array ( 'value' => '2184', 'innerHTML' => '2184' ),
    array ( 'value' => '2185', 'innerHTML' => '2185' ),
    array ( 'value' => '2186', 'innerHTML' => '2186' ),
    array ( 'value' => '2187', 'innerHTML' => '2187' ),
    array ( 'value' => '2188', 'innerHTML' => '2188' ),
    array ( 'value' => '2189', 'innerHTML' => '2189' ),
    array ( 'value' => '2190', 'innerHTML' => '2190' ),
    array ( 'value' => '2191', 'innerHTML' => '2191' ),
    array ( 'value' => '2192', 'innerHTML' => '2192' ),
    array ( 'value' => '2193', 'innerHTML' => '2193' ),
    array ( 'value' => '2194', 'innerHTML' => '2194' ),
    array ( 'value' => '2195', 'innerHTML' => '2195' ),
    array ( 'value' => '2196', 'innerHTML' => '2196' ),
    array ( 'value' => '2197', 'innerHTML' => '2197' ),
    array ( 'value' => '2198', 'innerHTML' => '2198' ),
    array ( 'value' => '2199', 'innerHTML' => '2199' ),
    array ( 'value' => '3000', 'innerHTML' => '3000' ),
);

$field_functions =  array ( 
    array ( 'value' => 'Information/Description', 'innerHTML' => 'Information/Description' ), 
    array ( 'value' => 'Exemple', 'innerHTML' => 'Exemple' ), 
    array ( 'value' => 'Illustration', 'innerHTML' => 'Illustration' )
);

Oak::$field_properties =  array (
    array ( 
        'name' => 'type', 
        'property_name' => 'field_type', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => Oak::$field_types,
        'description' => __( 'Nature des contenus compris dans le champ', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'function', 
        'property_name' => 'field_function', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => $field_functions,
        'description' => __( 'Fonction du champ en tant que message', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'tag', 
        'property_name' => 'field_tag', 
        'type' => 'text', 
        'input_type' => 'text', 
        'placeholder' => __( 'Etiquette (Optionnel)', Oak::$text_domain ), 
        'description' => __( 'Contenu qui apparaitra dans le champ lorsqu\'inactif et non rempli. A défaut, la designation apparaitra.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'help', 
        'property_name' => 'field_help', 
        'type' => 'text', 
        'input_type' => 'text', 
        'placeholder' => __( 'Aide au remplissage (Optionnel)', Oak::$text_domain ), 
        'description' => __( 'Contenu qui apparaitra sous le champ.', Oak::$text_domain ), 'width' => '50' ),
    array ( 
        'name' => 'description', 
        'property_name' => 'field_description', 
        'type' => 'text', 
        'input_type' => 'text', 
        'placeholder' => __( 'Description (Optionnel)', Oak::$text_domain ), 
        'description' => __( 'Instruction liée à la forme comme au fond à apporter au contenu. Elle apparaîtront dans le volet des composants (à droite).', Oak::$text_domain ), 
        'width' => '100' 
    ),
);

$form_structures = array (
    array ( 'value' => 'Structure 1', 'innerHTML' => 'Structure 1' ), 
    array ( 'value' => 'Structure 2', 'innerHTML' => 'Structure 2'), 
    array ( 'value' => 'Structure 3', 'innerHTML' => 'Structure 3' ), 
    array ( 'value' => 'Structure 4', 'innerHTML' => 'Structure 4' ) 
);

Oak::$form_properties =  array (
    array ( 
        'name' => 'structure', 
        'property_name' => 'form_structure', 
        'type' => 'text',
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => $form_structures, 
        'description' => __( 'Structure du formulaire', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array(
        'name' => 'attributes', 
        'property_name' => 'form_attributes', 
        'type' => 'text', 
        'input_type' => 'text', 
        'placeholder' => __( 'Attributs', Oak::$text_domain ), 
        'description' => __( 'Attributs', Oak::$text_domain ), 
        'width' => '50' 
    ),
);

Oak::$form_other_elements = array (
    'title' => __( 'Champs du formulaire', Oak::$text_domain ),
    'first_option' => __( 'Sélectionner un champ', Oak::$text_domain ),
    'description' => __( 'Champ à insérer dans le formulaire', Oak::$text_domain ),
    'new_designation_description' => __( 'Nom du champ dans ce formulaire', Oak::$text_domain ),
    'required_description' => __( 'Champ requis ou non lors du remplissage du formulaire', Oak::$text_domain ),
    
    'elements' => Oak::$fields_without_redundancy,
    'table' => 'field',
    'table_name' => Oak::$forms_and_fields_table_name,
    
    'associative_tab_instances' => Oak::$all_forms_and_fields,

    'element_column_name' => 'form_identifier',
    'other_element_column_name' => 'field_identifier',
    'new_designation_column_name' => 'field_designation',
    'required_colmun_name' => 'field_required',
    'index_property' => 'field_index',

    'filters' => array(
        array( 'name_in_database' => 'field_type', 'filter_name' => 'oak_filter_field_type', 'title' => __( 'Nature des contenus compris dans le champ', Oak::$text_domain ), 'first_option' => 'Aucune nature attribuée', 'choices' => Oak::$field_types ),
        array( 'name_in_database' => 'field_function', 'filter_name' => 'oak_filter_field_function', 'title' => __( 'Fonction du champ en tant que message', Oak::$text_domain ), 'first_option' => 'Aucune fonction attribuée', 'choices' => $field_functions ),
    ),
);

Oak::$model_other_elements = array (
    'title' => __( 'Formulaires du modèle', Oak::$text_domain ),
    'first_option' => __( 'Sélectionner un formulaire', Oak::$text_domain ),
    'description' => __( 'Formulaire à insérer dans le modèle', Oak::$text_domain ),
    'new_designation_description' => __( 'Nom du formulaire dans ce modèle', Oak::$text_domain ),
    'required_description' => __( 'Formulaire requis ou non lors du remplissage de l\'objet', Oak::$text_domain ),
    
    'elements' => Oak::$forms_without_redundancy,
    'table' => 'form',
    'table_name' => Oak::$models_and_forms_table_name,

    'associative_tab_instances' => Oak::$all_models_and_forms,

    'element_column_name' => 'model_identifier',
    'other_element_column_name' => 'form_identifier',
    'new_designation_column_name' => 'form_designation',
    'required_colmun_name' => 'form_required',
    'index_property' => 'form_index',

    'filters' => array(
        array( 'name_in_database' => 'form_structure', 'filter_name' => 'oak_filter_form_structure', 'title' => __( 'Structure du formulaire', Oak::$text_domain ), 'first_option' => 'Aucune structure attribuée', 'choices' => $form_structures ),
        // array( 'name_in_database' => 'field_type', 'filter_name' => 'oak_filter_field_type', 'title' => __( 'Nature des contenus compris dans le champ', Oak::$text_domain ), 'first_option' => 'Aucune nature attribuée', 'choices' => Oak::$field_types ),
        // array( 'name_in_database' => 'field_function', 'filter_name' => 'oak_filter_field_function', 'title' => __( 'Fonction du champ en tant que message', Oak::$text_domain ), 'first_option' => 'Aucune fonction attribuée', 'choices' => $field_functions ),
    ),
);

Oak::$model_properties = array (
    array( 
        'name' => 'types', 
        'property_name' => 'model_types', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => array ( array ( 'value' => 'Type 1', 
        'innerHTML' => 'Type 1' ), array ( 'value' => 'Type 2', 
        'innerHTML' => 'Type 2'), array ( 'value' => 'Type 3', 
        'innerHTML' => 'Type 3' ), array ( 'value' => 'Type 4', 
        'innerHTML' => 'Type 4' ) ), 'description' => __( 'Type du modèle', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array( 
        'name' => 'publications_categories', 
        'property_name' => 'model_publications_categories', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'true', 
        'choices' => array ( 
            array ( 'value' => 'Catégorie 1', 'innerHTML' => 'Catégorie 1' ), 
            array ( 'value' => 'Catégorie 2', 'innerHTML' => 'Catégorie 2'), 
            array ( 'value' => 'Catégorie 3', 'innerHTML' => 'Catégorie 3' ), 
            array ( 'value' => 'Catégorie 4', 'innerHTML' => 'Catégorie 4' ) 
        ), 
        'description' => __( 'Type du modèle', Oak::$text_domain ), 
        'width' => '50' 
    ),
);

Oak::$taxonomy_properties = array(
    array ( 
        'name' => 'description', 
        'property_name' => 'taxonomy_description', 
        'type' => 'text', 
        'input_type' => 'text', 
        'placeholder' => __( 'Description', Oak::$text_domain ), 
        'description' => __( 'Description.', Oak::$text_domain ), 
        'width' => '100'
    ),
    array (
        'name' => 'structure', 
        'property_name' => 'form_structure', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => array ( 
            array ( 'value' => 'Structure 1', 'innerHTML' => 'Structure 1' ), 
            array ( 'value' => 'Structure 2', 'innerHTML' => 'Structure 2'), 
            array ( 'value' => 'Structure 3', 'innerHTML' => 'Structure 3' ), 
            array ( 'value' => 'Structure 4', 'innerHTML' => 'Structure 4' ) 
        ), 
        'description' => __( 'Structure du formulaire', Oak::$text_domain ), 'width' => '50' 
    ),
    array ( 
        'name' => 'publication', 
        'property_name' => 'field_publication', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $publications_array, 
        'description' => __( 'Publications', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'numerotation', 
        'property_name' => 'taxonomy_numerotation', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Numérotation', Oak::$text_domain ), 
        'description' => __( 'Numérotation.', Oak::$text_domain ), 
        'width' => '50'
    ),
    array ( 
        'name' => 'title', 
        'property_name' => 'taxonomy_title', 
        'type' => 'text', 
        'input_type' => 'checkbox',
        'placeholder' => __( 'Titre', Oak::$text_domain ), 
        'description' => __( 'Titre.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array (
        'name' => 'term_description', 
        'property_name' => 'taxonomy_term_description', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Déscription du terme', Oak::$text_domain ),
        'description' => __( 'Déscription du terme.', Oak::$text_domain ),
        'width' => '50'
    ),
    array ( 
        'name' => 'color', 
        'property_name' => 'taxonomy_color', 
        'type' => 'text', 
        'input_type' => 'checkbox',
        'placeholder' => __( 'Couleur', Oak::$text_domain ), 
        'description' => __( 'Couleur.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'brand', 
        'property_name' => 'taxonomy_brand', 
        'type' => 'text', 
        'input_type' => 'checkbox',
        'placeholder' => __( 'Logo', Oak::$text_domain ), 
        'description' => __( 'Logo.', Oak::$text_domain ), 
        'width' => '100' 
    ),
);

Oak::$organization_properties = array(
    array ( 
        'name' => 'acronym', 
        'property_name' => 'organization_acronym', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Acronyme', Oak::$text_domain ), 
        'description' => __( 'Acronyme.', Oak::$text_domain ), 
        'width' => '100'
    ),
    array ( 
        'name' => 'logo', 
        'property_name' => 'organization_logo', 
        'type' => 'text', 
        'input_type' => 'image',
        'placeholder' => __( 'Logo', Oak::$text_domain ), 
        'description' => __( 'Logo.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'description', 
        'property_name' => 'organization_description', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Description', Oak::$text_domain ), 
        'description' => __( 'Description.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'url', 
        'property_name' => 'organization_url', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Url', Oak::$text_domain ), 
        'description' => __( 'Url.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'address', 
        'property_name' => 'organization_address', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Address', Oak::$text_domain ), 
        'description' => __( 'Address.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'country', 
        'property_name' => 'organization_country', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $countries,
        'placeholder' => __( 'Pays', Oak::$text_domain ), 
        'description' => __( 'Pays.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'company', 
        'property_name' => 'organization_company', 
        'type' => 'text', 
        'input_type' => 'checkbox',
        'placeholder' => __( 'Entreprise', Oak::$text_domain ), 
        'description' => __( 'Entreprise.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'type', 
        'property_name' => 'organization_type', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => 'type 1', 'innerHTML' => 'Type 1' ),
            array ( 'value' => 'type 2', 'innerHTML' => 'Type 2' ),
            array ( 'value' => 'type 3', 'innerHTML' => 'Type 3' ),
        ),
        'placeholder' => __( 'Entreprise', Oak::$text_domain ), 
        'description' => __( 'Entreprise.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'side', 
        'property_name' => 'organization_side', 
        'type' => 'text', 
        'input_type' => 'checkbox',
        'placeholder' => __( 'Coté', Oak::$text_domain ), 
        'description' => __( 'Coté.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'sectors', 
        'property_name' => 'organization_sectors', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Secteurs d\'activité', Oak::$text_domain ), 
        'description' => __( 'Secteurs d\'activité', Oak::$text_domain ), 
        'width' => '100' 
    ),
);

Oak::$publication_properties = array (
    array ( 
        'name' => 'organization', 
        'property_name' => 'publication_organization', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $organizations_array, 
        'description' => __( 'Publications', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'year', 
        'property_name' => 'publication_year', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $years,
        'description' => __( 'Année', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'headpiece', 
        'property_name' => 'publication_headpiece', 
        'type' => 'text',
        'input_type' => 'image',
        'description' => __( 'Vignette', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'format', 
        'property_name' => 'publication_format', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'web', 'innerHTML' => 'WEB' ),
            array( 'value' => 'pdf', 'innerHTML' => 'Fichier PDF' ),
            array( 'value' => 'epub', 'innerHTML' => 'ePub' ),
        ),
        'description' => __( 'Format', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true,
    ),
    array (
        'name' => 'file', 
        'property_name' => 'publication_file', 
        'type' => 'text',
        'input_type' => 'file',
        'description' => __( 'Fichier', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'format', 'values' => array( 'pdf', 'epub' ) )
        )
    ),
    array ( 
        'name' => 'description', 
        'property_name' => 'publication_description', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Description', Oak::$text_domain ), 
        'description' => __( 'Description', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'local', 
        'property_name' => 'publication_local', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Publication locale', Oak::$text_domain ), 
        'description' => __( 'Publication locale', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true
    ),
    array (
        'name' => 'country', 
        'property_name' => 'publication_country', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $countries,
        'placeholder' => __( 'Pays', Oak::$text_domain ), 
        'description' => __( 'Pays', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'local', 'values' => array( 'true' ) )
        )
    ),
    array ( 
        'name' => 'language', 
        'property_name' => 'publication_language', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $languages,
        'placeholder' => __( 'Langue', Oak::$text_domain ), 
        'description' => __( 'Langue', Oak::$text_domain ), 
        'width' => '50'
    ),
    array ( 
        'name' => 'report_or_frame', 
        'property_name' => 'publication_report_or_frame', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'report', 'innerHTML' => 'Rapport' ),
            array( 'value' => 'frame', 'innerHTML' => 'Cadres RSE' ),
        ),
        'placeholder' => __( 'Rapport ou Cadres RSE', Oak::$text_domain ), 
        'description' => __( 'Rapport ou Cadres RSE', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true
    ),
    array ( 
        'name' => 'frame_type', 
        'property_name' => 'publication_frame_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => 'universal-frame', 'innerHTML' => __( 'Cadres universels', Oak::$text_domain ) ),
            array ( 'value' => 'normes-and-sectorial-initiatives', 'innerHTML' => __( 'Normes et inititives sectorielles (Déploiement)', Oak::$text_domain ) ),
            array ( 'value' => 'directive-lines', 'innerHTML' => __( 'Lignes directrices et cadres de référence (Reporting)', Oak::$text_domain ) ), 
            array ( 'value' => 'evaluation-initiatives', 'innerHTML' => __( 'Initiatives d\'évaluation (Notation)', Oak::$text_domain ) ),
            array ( 'value' => 'extra-finantial-notation', 'innerHTML' => __( 'Notation extra financière (Classement)', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Type de cadres', Oak::$text_domain ), 
        'description' => __( 'Type de cadres', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'frame' ) )
        )
    ),
    array ( 
        'name' => 'report_type', 
        'property_name' => 'publication_report_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => 'reference-document', 'innerHTML' => __( 'Document de référence', Oak::$text_domain ) ),
            array ( 'value' => 'annual-report', 'innerHTML' => __( 'Rapport annuel', Oak::$text_domain ) ),
            array ( 'value' => 'integrated-reporting', 'innerHTML' => __( 'Reporting intégré', Oak::$text_domain ) ), 
            array ( 'value' => 'evaluation-initiatives', 'innerHTML' => __( 'Initiatives d\'évaluation (Notation)', Oak::$text_domain ) ),
            array ( 'value' => 'extra-finantial-notation', 'innerHTML' => __( 'Notation extra financière (Classement)', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Type de rapport', Oak::$text_domain ), 
        'description' => __( 'Type de rapport', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'report' ) )
        )
    ),
    array ( 
        'name' => 'sectorial_frame', 
        'property_name' => 'publication_sectorial_frame', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Cadre sectoriel', Oak::$text_domain ), 
        'description' => __( 'Cadre sectoriel', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true,
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'frame' ) )
        )
    ),
    array ( 
        'name' => 'sectors', 
        'property_name' => 'publication_sectors', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Secteurs d\'activité', Oak::$text_domain ), 
        'description' => __( 'Secteurs d\'activité', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'frame' ) ),
            array( 'name' => 'sectorial_frame', 'values' => array( 'true' ) )
        )
    ),
    array ( 
        'name' => 'gri_type', 
        'property_name' => 'publication_gri_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'no-gri', 'innerHTML' => 'Non - GRI' ),
            array( 'value' => 'citing-gri', 'innerHTML' => 'Citing - GRI' ),
            array( 'value' => 'gri-referenced', 'innerHTML' => 'GRI - Referenced' ),
            array( 'value' => 'gri-standards', 'innerHTML' => 'GRI - Standards' ),
        ),
        'placeholder' => __( 'Type GRI de rapport', Oak::$text_domain ), 
        'description' => __( 'Type GRI de rapport', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'report' ) )
        )
    ),
    array ( 
        'name' => 'sectorial_supplement', 
        'property_name' => 'publication_sectorial_supplement', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => 'euss', 'innerHTML' => 'Services d’électricité (EUSS)' ),
            array ( 'value' => 'fsss', 'innerHTML' => 'Services financiers (FSSS)' ),
            array ( 'value' => 'fpsss', 'innerHTML' => 'Préparation alimentaire (FPSS)' ),
            array ( 'value' => 'mmss', 'innerHTML' => 'Mines et métaux (MMSS)' ),
            array ( 'value' => 'ngoss', 'innerHTML' => 'ONG (NGOSS)' ),
            array ( 'value' => 'aoss', 'innerHTML' => 'Opérateurs aéroportuaires (AOSS)' ),
            array ( 'value' => 'cress', 'innerHTML' => 'Construction et Immobilier (CRESS)' ),
            array ( 'value' => 'eoss', 'innerHTML' => 'Organisateur événementiels (EOSS)' ),
            array ( 'value' => 'ogss', 'innerHTML' => 'Pétrole et gaz (OGSS)' ),
            array ( 'value' => 'mss', 'innerHTML' => 'Médias (MSS)' ),
        ),
        'placeholder' => __( 'Supplément sectoriel', Oak::$text_domain ), 
        'description' => __( 'Supplément sectoriel', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'report' ) )
        )
    ),
);

Oak::$glossary_properties = array (
    array (
        'name' => 'publication', 
        'property_name' => 'glossary_publication', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $publications_array,
        'placeholder' => __( 'Publication dont est issue la terminologie', Oak::$text_domain ), 
        'description' => __( 'Publication dont est issue la terminologie', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'object', 
        'property_name' => 'glossary_object', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $objects_array,
        'placeholder' => __( 'L\'objet auquel appartient la terminologie', Oak::$text_domain ), 
        'description' => __( 'L\'objet auquel appartient la terminologie', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'depends', 
        'property_name' => 'glossary_depends', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Terminologie dépendante d’une autre:', Oak::$text_domain ), 
        'description' => __( 'Terminologie dépendante d’une autre:', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'parent', 
        'property_name' => 'glossary_parent', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $glossaries_array,
        'placeholder' => __( 'Terminologie de niveau supérieur:', Oak::$text_domain ), 
        'description' => __( 'Terminologie de niveau supérieur:', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'definition', 
        'property_name' => 'glossary_definition', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Définition', Oak::$text_domain ), 
        'description' => __( 'Définition', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'close', 
        'property_name' => 'glossary_close', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $glossaries_array,
        'placeholder' => __( 'Terminologie(s) proche(s) de la terminologie défnie: ', Oak::$text_domain ), 
        'description' => __( 'Terminologie(s) proche(s) de la terminologie défnie: ', Oak::$text_domain ), 
        'width' => '50'
    )
);

Oak::$quali_properties = array (
    array(
        'name' => 'publication', 
        'property_name' => 'quali_publication', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $publications_array,
        'placeholder' => __( 'Publication(s) dont est issue l\'Idicateur: ', Oak::$text_domain ), 
        'description' => __( 'Publication(s) dont est issue l\'Idicateur: ', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'object', 
        'property_name' => 'quali_object', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $objects_array,
        'placeholder' => __( 'L\'objet auquel appartient l\'indicateur: ', Oak::$text_domain ), 
        'description' => __( 'L\'objet auquel appartient l\'indicateur: ', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'depends', 
        'property_name' => 'quali_depends', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Indicateur dépandant d’un autre:', Oak::$text_domain ), 
        'description' => __( 'Indicateur dépandant d’un autre:', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true
    ),
    array(
        'name' => 'parent', 
        'property_name' => 'quali_parent', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $qualis_array,
        'placeholder' => __( 'Indicateur de niveau supérieur:', Oak::$text_domain ), 
        'description' => __( 'Indicateur de niveau supérieur:', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'depends', 'values' => array( 'true' ) )
        )
    ),
    array(
        'name' => 'numerotation_type', 
        'property_name' => 'quali_numerotation_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'I', 'innerHTML' => 'I' ),
            array( 'value' => '1', 'innerHTML' => '1' ),
            array( 'value' => 'A', 'innerHTML' => 'A' ),
            array( 'value' => 'a', 'innerHTML' => 'a' ),
        ),
        'placeholder' => __( 'Type de numérotation', Oak::$text_domain ), 
        'description' => __( 'Type de numérotation', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'numerotation', 
        'property_name' => 'quali_numerotation', 
        'type' => 'text',
        'input_type' => 'number',
        'placeholder' => __( 'Numérotation', Oak::$text_domain ), 
        'description' => __( 'Numérotation', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'description', 
        'property_name' => 'quali_description', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Description', Oak::$text_domain ), 
        'description' => __( 'Description', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'close', 
        'property_name' => 'quali_close',
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Indicateurs proches', Oak::$text_domain ), 
        'description' => __( 'Indicateurs proches', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true,
    ),
    array(
        'name' => 'close_indicators', 
        'property_name' => 'quali_close_indicators', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $qualis_array,
        'placeholder' => __( 'Indicateurs proches', Oak::$text_domain ), 
        'description' => __( 'Indicateurs proches', Oak::$text_domain ), 
        'width' => '100',
        'depends' => array (
            array( 'name' => 'close', 'values' => array( 'true' ) )
        )
    ),
);

Oak::$quanti_properties = array (
    array(
        'name' => 'publication', 
        'property_name' => 'quanti_publication', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $publications_array,
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
        'choices' => $objects_array,
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
        'width' => '50',
        'condition' => true
    ),
    array(
        'name' => 'parent', 
        'property_name' => 'quanti_parent', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $quantis_array,
        'placeholder' => __( 'Indicateur de niveau supérieur:', Oak::$text_domain ), 
        'description' => __( 'Indicateur de niveau supérieur:', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array (
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
            array( 'value' => 'I', 'innerHTML' => 'I' ),
            array( 'value' => '1', 'innerHTML' => '1' ),
            array( 'value' => 'A', 'innerHTML' => 'A' ),
            array( 'value' => 'a', 'innerHTML' => 'a' ),
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
        'input_type' => 'text',
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
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => $quantis_array,
        'placeholder' => __( 'Indicateurs proches', Oak::$text_domain ), 
        'description' => __( 'Indicateurs proches', Oak::$text_domain ), 
        'width' => '100',
        'depends' => array (
            array( 'name' => 'close', 'values' => array( 'true' ) )
        )
    ),
);

Oak::$term_properties = array (
    array(
        'name' => 'numerotation', 
        'property_name' => 'term_numerotation', 
        'type' => 'text',
        'input_type' => 'number',
        'placeholder' => __( 'Numérotation ', Oak::$text_domain ),
        'description' => __( 'Numérotation ', Oak::$text_domain ),
        'width' => '50'
    ),
    array(
        'name' => 'title', 
        'property_name' => 'term_title', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Titre ', Oak::$text_domain ),
        'description' => __( 'Titre ', Oak::$text_domain ),
        'width' => '50'
    ),
    array(
        'name' => 'description', 
        'property_name' => 'term_description', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Déscription ', Oak::$text_domain ),
        'description' => __( 'Déscription ', Oak::$text_domain ),
        'width' => '100'
    ),
    array(
        'name' => 'color', 
        'property_name' => 'term_color', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Couleur ', Oak::$text_domain ),
        'description' => __( 'Couleur ', Oak::$text_domain ),
        'width' => '50'
    ),
    array(
        'name' => 'logo', 
        'property_name' => 'term_logo', 
        'type' => 'text',
        'input_type' => 'image',
        'placeholder' => __( 'Logo ', Oak::$text_domain ),
        'description' => __( 'Logo ', Oak::$text_domain ),
        'width' => '50'
    )
);