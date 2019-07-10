<?php
global $wpdb; 

$quantis_table_name = Oak::$quantis_table_name;

if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
    foreach( Oak::$content_filters['selected_publications'] as $publication_identifier ) :
        $publication_quantis = $wpdb->get_results ( "
            SELECT * 
            FROM  $quantis_table_name
            WHERE quanti_publication = '$publication_identifier'
        " ); 
        Oak::$quantis = array_merge( Oak::$quantis, $publication_quantis );
    endforeach;
else:
    Oak::$quantis = $wpdb->get_results ( "
        SELECT * 
        FROM  $quantis_table_name
    " );
endif;

$reversed_quantis = array_reverse( Oak::$quantis );
$quantis_without_redundancy = [];
foreach( $reversed_quantis as $quanti ) :
    $added = false;
    foreach( $quantis_without_redundancy as $quanti_without_redundancy ) :
        if ( $quanti_without_redundancy->quanti_identifier == $quanti->quanti_identifier) :
            $added = true;
        endif;
    endforeach;

    if ( !$added ) :
        $quantis_without_redundancy[] = $quanti;
    endif;
endforeach;
Oak::$quantis_without_redundancy = $quantis_without_redundancy;