<?php
global $wpdb; 

$sources_table_name = Oak::$sources_table_name;
Oak::$sources = $wpdb->get_results ( "
    SELECT * 
    FROM  $sources_table_name
" );
$reversed_sources = array_reverse( Oak::$sources );
$sources_without_redundancy = [];
foreach( $reversed_sources as $source ) :
    $added = false;
    foreach( $sources_without_redundancy as $source_without_redundancy ) :
        if ( $source_without_redundancy->source_identifier == $source->source_identifier) :
            $added = true;
        endif;
    endforeach;

    if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
        if ( !in_array( $source->source_publication, Oak::$content_filters['selected_publications'] ) ) :
            $added = true;
        endif;
    endif;

    if ( !$added ) :
        $sources_without_redundancy[] = $source;
    endif;
endforeach;
Oak::$sources_without_redundancy = $sources_without_redundancy;