<?php
global $wpdb;

$publications_table_name = Oak::$publications_table_name;
Oak::$publications = $wpdb->get_results ( "
    SELECT * 
    FROM  $publications_table_name
" );
$reversed_publications = array_reverse( Oak::$publications );
$publications_without_redundancy = [];
foreach( $reversed_publications as $publication ) :
    $added = false;
    foreach( $publications_without_redundancy as $publication_without_redundancy ) :
        if ( $publication_without_redundancy->publication_identifier == $publication->publication_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $publications_without_redundancy[] = $publication;
    endif;

    if ( $publication->publication_report_or_frame == 'frame' ) :
        Oak::$frame_publications_identifiers[] = $publication->publication_identifier;
    endif;

endforeach;
Oak::$publications_without_redundancy = $publications_without_redundancy;
