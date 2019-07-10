<?php
global $wpdb;

$glossaries_table_name = Oak::$glossaries_table_name;

if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
    foreach( Oak::$content_filters['selected_publications'] as $publication_identifier ) :
        $publication_glossaries = $wpdb->get_results ( "
            SELECT * 
            FROM  $glossaries_table_name
            WHERE glossary_publication = '$publication_identifier'
        " ); 
        Oak::$glossaries = array_merge( Oak::$glossaries, $publication_glossaries );
    endforeach;
else:
    Oak::$glossaries = $wpdb->get_results ( "
        SELECT * 
        FROM  $glossaries_table_name
    " );
endif;

$reversed_glossaries = array_reverse( Oak::$glossaries );
$glossaries_without_redundancy = [];
foreach( $reversed_glossaries as $glossary ) :
    $added = false;
    foreach( $glossaries_without_redundancy as $glossary_without_redundancy ) :
        if ( $glossary_without_redundancy->glossary_identifier == $glossary->glossary_identifier) :
            $added = true;
        endif;
    endforeach;

    if ( !$added ) :
        $glossaries_without_redundancy[] = $glossary;
    endif;
endforeach;
Oak::$glossaries_without_redundancy = $glossaries_without_redundancy;