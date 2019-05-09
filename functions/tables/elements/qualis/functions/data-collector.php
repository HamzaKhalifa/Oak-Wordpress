<?php
global $wpdb;

$qualis_table_name = Oak::$qualis_table_name;
Oak::$qualis = $wpdb->get_results ( "
    SELECT * 
    FROM  $qualis_table_name
" );
$reversed_qualis = array_reverse( Oak::$qualis );
$qualis_without_redundancy = [];
foreach( $reversed_qualis as $quali ) :
    $added = false;
    foreach( $qualis_without_redundancy as $quali_without_redundancy ) :
        if ( $quali_without_redundancy->quali_identifier == $quali->quali_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $qualis_without_redundancy[] = $quali;
    endif;
endforeach;
Oak::$qualis_without_redundancy = $qualis_without_redundancy;