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
    if ( !$added ) :
        $sources_without_redundancy[] = $source;

        $source_objects = explode( '|', $source->source_object );
        if ( count( $source_objects ) > 0 && $source->source_publication === '0' ) :
            Oak::oak_automatic_element_publication_association( $source, $source_objects, 'source_publication', Oak::$sources_table_name );
        endif;
    endif;
endforeach;
Oak::$sources_without_redundancy = $sources_without_redundancy;