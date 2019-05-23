<?php
global $wpdb; 

$quantis_table_name = Oak::$quantis_table_name;
Oak::$quantis = $wpdb->get_results ( "
    SELECT * 
    FROM  $quantis_table_name
" );
$reversed_quantis = array_reverse( Oak::$quantis );
$quantis_without_redundancy = [];
foreach( $reversed_quantis as $quanti ) :
    $added = false;
    foreach( $quantis_without_redundancy as $quanti_without_redundancy ) :
        if ( $quanti_without_redundancy->quanti_identifier == $quanti->quanti_identifier) :
            $added = true;
        endif;
    endforeach;

    if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
        if ( !in_array( $quanti->quanti_publication, Oak::$content_filters['selected_publications'] ) ) :
            $added = true;
        endif;
    endif;

    if ( !$added ) :
        $quantis_without_redundancy[] = $quanti;
    endif;
endforeach;
Oak::$quantis_without_redundancy = $quantis_without_redundancy;