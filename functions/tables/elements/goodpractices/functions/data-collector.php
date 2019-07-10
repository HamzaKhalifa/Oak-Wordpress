<?php
global $wpdb; 

$goodpractices_table_name = Oak::$goodpractices_table_name;

if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
    foreach( Oak::$content_filters['selected_publications'] as $publication_identifier ) :
        $publication_goodpractices = $wpdb->get_results ( "
            SELECT * 
            FROM  $goodpractices_table_name
            WHERE goodpractice_publication = '$publication_identifier'
        " ); 
        Oak::$goodpractices = array_merge( Oak::$goodpractices, $publication_goodpractices );
    endforeach;
else:
    Oak::$goodpractices = $wpdb->get_results ( "
        SELECT * 
        FROM  $goodpractices_table_name
    " );
endif;

$reversed_goodpractices = array_reverse( Oak::$goodpractices );
$goodpractices_without_redundancy = [];
foreach( $reversed_goodpractices as $goodpractice ) :
    $added = false;
    foreach( $goodpractices_without_redundancy as $goodpractice_without_redundancy ) :
        if ( $goodpractice_without_redundancy->goodpractice_identifier == $goodpractice->goodpractice_identifier) :
            $added = true;
        endif;
    endforeach;

    if ( !$added ) :
        $goodpractices_without_redundancy[] = $goodpractice;
    endif;
endforeach;
Oak::$goodpractices_without_redundancy = $goodpractices_without_redundancy;