<?php 
// the property type here means type in the database (so a select is gonna have a type of text. So are the images and the files)
include_once get_template_directory() . '/functions/tables/constants/social-medias.php';

Oak::$publications_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucune Publication sélectionnée', Oak::$text_domain ) ) ];
Oak::$frame_publications_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucune Publication sélectionnée', Oak::$text_domain ) ) ];
Oak::$pdf_publications_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucune Publication sélectionnée', Oak::$text_domain ) ) ];
foreach( Oak::$publications_without_redundancy as $publication ) :
    Oak::$publications_array[] = array( 'value' => $publication->publication_identifier, 'innerHTML' => $publication->publication_designation );
    if ( $publication->publication_report_or_frame == 'frame' ) :
        Oak::$frame_publications_array[] = array( 'value' => $publication->publication_identifier, 'innerHTML' => $publication->publication_designation );
    endif;
    if ( $publication->publication_format == 'pdf' ) :
        Oak::$pdf_publications_array[] = array( 'value' => $publication->publication_identifier, 'innerHTML' => $publication->publication_designation );
    endif;
endforeach;

Oak::$all_posts_and_pages_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun(e) posts/page sélectionné(e)', Oak::$text_domain ) ) ];
if ( isset( $_GET['elements'] ) && $_GET['elements'] == 'sources' ) :
    $all_posts_and_pages = Oak::oak_get_all_posts_and_pages();
    foreach( $all_posts_and_pages as $post_or_page ) :
        Oak::$all_posts_and_pages_array[] = array('value' => $post_or_page->ID, 'innerHTML' => $post_or_page->post_title );
    endforeach;
endif;

Oak::$organizations_array = [ array( 'value' => '', 'innerHTML' => 'Aucune organisation sélectionnée' ) ];
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

include get_template_directory() . '/functions/tables/constants/countries.php';

Oak::$languages = [ array( 'value' => '0', 'innerHTML' => __( 'Aucune langue sélectionnée' ) ) ];
Oak::$languages_names = Oak::oak_get_languages();

// if ( isset( $_GET['elements'] ) && ( $_GET['elements'] == 'publications' || $_GET['elements'] == 'organizations' || $_GET['elements'] == 'performances' ) ) :
    Oak::$countries_names = Oak::oak_get_countries_names();
    
    foreach( Oak::$languages_names as $langauge_name ) :
        Oak::$languages[] = array( 'value' => $langauge_name, 'innerHTML' => $langauge_name );
    endforeach;
// endif;

Oak::$objects_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun objet sélectionné', Oak::$text_domain ) ) ];
foreach( Oak::$all_objects_without_redundancy as $object ) :
    Oak::$objects_array[] = array( 'value' => $object->object_identifier, 'innerHTML' => $object->object_designation );
endforeach;

Oak::$frame_objects_array = [ array ( 'value' => '0', 'innerHTML' => __( 'Aucun objet sélectionné', Oak::$text_domain ) ) ];
foreach( Oak::$all_frame_objects_without_redundancy as $object ) :
    Oak::$frame_objects_array[] = array( 'value' => $object->object_identifier, 'innerHTML' => $object->object_designation );
endforeach;

include_once get_template_directory() . '/functions/tables/constants/years.php';

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

if ( get_option( 'oak_corn' ) == 'false' ) :
    Publishers::properties_initialization();
endif;

if ( isset( $_GET['elements'] ) ) :
    if ( $_GET['elements'] == 'graphs' ) :
        Graphs::properties_initialization();
    endif;
endif;

// For filters: 
Organizations::initialize_filters();