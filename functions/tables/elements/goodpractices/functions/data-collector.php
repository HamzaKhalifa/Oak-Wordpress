<?php
global $wpdb; 

$goodpractices_table_name = Oak::$goodpractices_table_name;
Oak::$goodpractices = $wpdb->get_results ( "
    SELECT * 
    FROM  $goodpractices_table_name
" );
$reversed_goodpractices = array_reverse( Oak::$goodpractices );
$goodpractices_without_redundancy = [];
foreach( $reversed_goodpractices as $goodpractice ) :
    $added = false;
    foreach( $goodpractices_without_redundancy as $goodpractice_without_redundancy ) :
        if ( $goodpractice_without_redundancy->goodpractice_identifier == $goodpractice->goodpractice_identifier) :
            $added = true;
        endif;
    endforeach;

    if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
        if ( !in_array( $goodpractice->goodpractice_publication, Oak::$content_filters['selected_publications'] ) ) :
            $added = true;
        endif;
    endif;

    if ( !$added ) :
        $goodpractices_without_redundancy[] = $goodpractice;
    endif;
endforeach;
Oak::$goodpractices_without_redundancy = $goodpractices_without_redundancy;