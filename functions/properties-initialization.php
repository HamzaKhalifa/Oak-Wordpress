<?php 
// the property type here means type in the database (so a select is gonna have a type of text. So are the images and the files)
Oak::$social_medias = array(
    array( 'name' => 'facebook', 'title' => __( 'Facebook', Oak::$text_domain ) ),
    array( 'name' => 'twitter', 'title' => __( 'Twitter' , Oak::$text_domain ) ),
    array( 'name' => 'linkedin', 'title' => __( 'Linkedin', Oak::$text_domain ) ),
    array( 'name' => 'youtube', 'title' => __( 'Youtube' , Oak::$text_domain ) ),
    array( 'name' => 'insta', 'title' => __( 'Instagram', Oak::$text_domain ) ),
    array( 'name' => 'contact', 'title' => __( 'Contact' , Oak::$text_domain) ),
    array( 'name' => 'website', 'title' => __( 'Site Web', Oak::$text_domain  ) )
);

Oak::$publications_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucune Publication sélectionnée', Oak::$text_domain ) ) ];
Oak::$frame_publications_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucune Publication sélectionnée', Oak::$text_domain ) ) ];
foreach( Oak::$publications_without_redundancy as $publication ) :
    Oak::$publications_array[] = array( 'value' => $publication->publication_identifier, 'innerHTML' => $publication->publication_designation );
    if ( $publication->publication_report_or_frame == 'frame' ) :
        Oak::$frame_publications_array[] = array( 'value' => $publication->publication_identifier, 'innerHTML' => $publication->publication_designation );
    endif;
endforeach;

Oak::$organizations_array = [];
foreach( Oak::$organizations_without_redundancy as $organization ) :
    Oak::$organizations_array[] = array( 'value' => $organization->organization_identifier, 'innerHTML' => $organization->organization_designation );
endforeach;

Oak::$glossaries_array = [];
Oak::$glossaries_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucune terminologie sélectionnée', Oak::$text_domain ) ) ];
foreach( Oak::$glossaries_without_redundancy as $glossary ) :
    Oak::$glossaries_array[] = array( 'value' => $glossary->glossary_identifier, 'innerHTML' => $glossary->glossary_designation );
endforeach;

Oak::$quantis_and_qualis = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun indicateur sélectionné', Oak::$text_domain ), 'indicator' => '' ), 'data' => null ];

Oak::$qualis_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun indicateur sélectionné', Oak::$text_domain ) ) ];
foreach( Oak::$qualis_without_redundancy as $quali ) :
    $quali->quali_indicator_type = 'quali'; 
    Oak::$qualis_array[] = array( 'value' => $quali->quali_identifier, 'innerHTML' => $quali->quali_designation, 'indicator' => 'quali', 'data' => $quali );
    Oak::$quantis_and_qualis[] = array( 'value' => $quali->quali_identifier, 'innerHTML' => $quali->quali_designation, 'indicator' => 'quali', 'data' => $quali );
endforeach;

Oak::$quantis_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun indicateur sélectionné', Oak::$text_domain ) ) ];
foreach( Oak::$quantis_without_redundancy as $quanti ) :
    $quanti->quanti_indicator_type = 'quanti';
    Oak::$quantis_array[] = array( 'value' => $quanti->quanti_identifier, 'innerHTML' => $quanti->quanti_designation, 'indicator' => 'quanti', 'data' => $quanti );
    Oak::$quantis_and_qualis[] = array( 'value' => $quanti->quanti_identifier, 'innerHTML' => $quanti->quanti_designation, 'indicator' => 'quanti', 'data' => $quanti );
endforeach;

Oak::$terms_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun terme sélectionné', Oak::$text_domain ) ) ];
foreach( Oak::$all_terms_without_redundancy as $term ) :
    Oak::$terms_array[] = array( 'value' => $term->term_identifier, 'innerHTML' => $term->term_designation );
endforeach;

Oak::$countries = array();
Oak::$languages = array();
Oak::$languages_names = Oak::oak_get_languages();

if ( isset( $_GET['elements'] ) && ( $_GET['elements'] == 'publications' || $_GET['elements'] == 'organizations' || $_GET['elements'] == 'performances' ) ) :
    Oak::$countries_names = Oak::oak_get_countries_names();
    
    foreach( Oak::$countries_names as $country_name ) :
        Oak::$countries[] = array( 'value' => $country_name, 'innerHTML' => $country_name );
    endforeach;

    foreach( Oak::$languages_names as $langauge_name ) :
        Oak::$languages[] = array( 'value' => $langauge_name, 'innerHTML' => $langauge_name );
    endforeach;
endif;

// $objects_array = Oak::$all_objects_without_redundancy;
Oak::$objects_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun objet sélectionné', Oak::$text_domain ) ) ];
foreach( Oak::$all_objects_without_redundancy as $object ) :
    Oak::$objects_array[] = array( 'value' => $object->object_identifier, 'innerHTML' => $object->object_designation );
endforeach;

Oak::$years = array(
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


Oak::$business_line = array( array( 'value' => 0, 'innerHTML' => __( 'Aucun périmètre métier selectionné', Oak::$text_domain ) ) );
$business_line_array = get_option('oak_business_line') == false ? '' : get_option('oak_business_line');
$business_line_array = explode( '|', $business_line_array );
foreach( $business_line_array as $single_business_line ) :
    if ( $single_business_line != '' ) :
        Oak::$business_line[] = array( 'value' => $single_business_line, 'innerHTML' => $single_business_line );
    endif;
endforeach;

Oak::$custom_perimeter = array( array( 'value' => 0, 'innerHTML' => __( 'Aucun périmètre selectionné', Oak::$text_domain ) ) );
$custom_perimeter_array = get_option('oak_custom_perimeter') == false ? '' : get_option('oak_custom_perimeter');
$custom_perimeter_array = explode( '|', $custom_perimeter_array );
foreach( $custom_perimeter_array as $single_custom_perimeter ) :
    if ( $single_custom_perimeter != '' ) :
        Oak::$custom_perimeter[] = array( 'value' => $single_custom_perimeter, 'innerHTML' => $single_custom_perimeter );
    endif;
endforeach;

Oak::$regions = array( array( 'value' => 0, 'innerHTML' => 'Aucune région selectionnée' ) );
$regions_array = get_option('oak_regions') == false ? '' : get_option('oak_regions');
$regions_array = explode( '|', $regions_array );
foreach( $regions_array as $single_regions ) :
    if ( $single_regions != '' ) :
        Oak::$regions[] = array( 'value' => $single_regions, 'innerHTML' => $single_regions );
    endif;
endforeach;

Fields::properties_initialization();
Forms::properties_initialization();
Models::properties_initialization();
Taxonomies::properties_initialization();
Organizations::properties_initialization();
Publications::properties_initialization();
Qualis::properties_initialization();
Quantis::properties_initialization();
Good_Practices::properties_initialization();
Performances::properties_initialization();
Sources::properties_initialization();
Terms::properties_initialization();
Glossaries::properties_initialization();