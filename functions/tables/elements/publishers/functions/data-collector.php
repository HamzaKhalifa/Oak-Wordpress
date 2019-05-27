<?php
global $wpdb;

$publishers_table_name = Oak::$publishers_table_name;
Oak::$publishers = $wpdb->get_results ( "
    SELECT * 
    FROM  $publishers_table_name
" );
$reversed_publishers = array_reverse( Oak::$publishers );
$publishers_without_redundancy = [];
foreach( $reversed_publishers as $publisher ) :
    $added = false;
    foreach( $publishers_without_redundancy as $publisher_without_redundancy ) :
        if ( $publisher_without_redundancy->publisher_identifier == $publisher->publisher_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $publishers_without_redundancy[] = $publisher;
    endif;
endforeach;
Oak::$publishers_without_redundancy = $publishers_without_redundancy;