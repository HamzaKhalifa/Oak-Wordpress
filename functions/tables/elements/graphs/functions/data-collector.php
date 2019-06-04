<?php 
global $wpdb; 

$graphs = Oak::$graphs_table_name;
Oak::$graphs = $wpdb->get_results ( "
    SELECT * 
    FROM  $graphs
" );
$reversed_graphs = array_reverse( Oak::$graphs );
$graphs_without_redundancy = [];
foreach( $reversed_graphs as $graph ) :
    $added = false;
    foreach( $graphs_without_redundancy as $graph_without_redundancy ) :
        if ( $graph_without_redundancy->graph_identifier == $graph->graph_identifier ) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $graphs_without_redundancy[] = $graph;
    endif;
endforeach;
Oak::$graphs_without_redundancy = $graphs_without_redundancy;