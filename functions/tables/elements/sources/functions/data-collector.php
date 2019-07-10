<?php
global $wpdb; 

$sources_table_name = Oak::$sources_table_name;

if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
    foreach( Oak::$content_filters['selected_publications'] as $publication_identifier ) :
        $publication_sources = $wpdb->get_results ( "
            SELECT * 
            FROM  $sources_table_name
            WHERE source_publication = '$publication_identifier'
        " ); 
        Oak::$sources = array_merge( Oak::$sources, $publication_sources );
    endforeach;
else:
    Oak::$sources = $wpdb->get_results ( "
        SELECT * 
        FROM  $sources_table_name
    " ); 
endif;

$reversed_sources = array_reverse( Oak::$sources );
$sources_without_redundancy = [];

foreach( $reversed_sources as $source ) :
    $added = false;
    foreach( $sources_without_redundancy as $source_without_redundancy ) :
        if ( $source_without_redundancy->source_identifier == $source->source_identifier) :
            $added = true;
        endif;
    endforeach;

    if ( !$added ) :
        $sources_without_redundancy[] = $source;
    endif;
endforeach;
Oak::$sources_without_redundancy = $sources_without_redundancy;