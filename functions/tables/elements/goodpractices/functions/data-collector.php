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
    if ( !$added ) :
        $goodpractices_without_redundancy[] = $goodpractice;

        // $goodpractice_objects = explode( '|', $goodpractice->goodpractice_objects );
        // if ( count( $goodpractice_objects ) > 0 && $goodpractice->goodpractice_publication === '0' ) :
        //     Oak::oak_automatic_element_publication_association( $goodpractice, $goodpractice_objects, 'goodpractice_publication', Oak::$goodpractices_table_name );
        // endif;
    endif;
endforeach;
Oak::$goodpractices_without_redundancy = $goodpractices_without_redundancy;