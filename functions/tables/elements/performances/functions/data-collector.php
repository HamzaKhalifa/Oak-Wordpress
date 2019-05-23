<?php
global $wpdb;

$performances_table_name = Oak::$performances_table_name;
Oak::$performances = $wpdb->get_results ( "
    SELECT * 
    FROM  $performances_table_name
" );
$reversed_performances = array_reverse( Oak::$performances );
$performances_without_redundancy = [];
foreach( $reversed_performances as $performance ) :
    $added = false;
    foreach( $performances_without_redundancy as $performance_without_redundancy ) :
        if ( $performance_without_redundancy->performance_identifier == $performance->performance_identifier) :
            $added = true;
        endif;
    endforeach;

    if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
        if ( !in_array( $performance->performance_publication, Oak::$content_filters['selected_publications'] ) ) :
            $added = true;
        endif;
    endif;

    if ( !$added ) :
        $performances_without_redundancy[] = $performance;
    endif;
endforeach;
Oak::$performances_without_redundancy = $performances_without_redundancy;