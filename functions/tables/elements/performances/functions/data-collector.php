<?php
global $wpdb;

$performances_table_name = Oak::$performances_table_name;

if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
    foreach( Oak::$content_filters['selected_publications'] as $publication_identifier ) :
        $publication_performances = $wpdb->get_results ( "
            SELECT * 
            FROM  $performances_table_name
            WHERE performance_publication = '$publication_identifier'
        " ); 
        Oak::$performances = array_merge( Oak::$performances, $publication_performances );
    endforeach;
else:
    Oak::$performances = $wpdb->get_results ( "
        SELECT * 
        FROM  $performances_table_name
    " );
endif;

$reversed_performances = array_reverse( Oak::$performances );
$performances_without_redundancy = [];
foreach( $reversed_performances as $performance ) :
    $added = false;
    foreach( $performances_without_redundancy as $performance_without_redundancy ) :
        if ( $performance_without_redundancy->performance_identifier == $performance->performance_identifier) :
            $added = true;
        endif;
    endforeach;

    if ( !$added ) :
        $performances_without_redundancy[] = $performance;
    endif;
endforeach;
Oak::$performances_without_redundancy = $performances_without_redundancy;