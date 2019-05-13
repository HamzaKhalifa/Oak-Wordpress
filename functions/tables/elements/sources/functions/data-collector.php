<?php
global $wpdb; 

$sources_table_name = Oak::$sources_table_name;
Oak::$sources = $wpdb->get_results ( "
    SELECT * 
    FROM  $sources_table_name
" );
$reversed_sources = array_reverse( Oak::$sources );
$sources_without_redundancy = [];
foreach( $reversed_sources as $goodpractice ) :
    $added = false;
    foreach( $sources_without_redundancy as $goodpractice_without_redundancy ) :
        if ( $goodpractice_without_redundancy->goodpractice_identifier == $goodpractice->goodpractice_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $sources_without_redundancy[] = $goodpractice;
    endif;
endforeach;
Oak::$sources_without_redundancy = $sources_without_redundancy;