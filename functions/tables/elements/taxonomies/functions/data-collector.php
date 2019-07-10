<?php
global $wpdb;

$taxonomies_table_name = Oak::$taxonomies_table_name;

if ( !in_array( '0', Oak::$content_filters['selected_publications'] ) ) :
    foreach( Oak::$content_filters['selected_publications'] as $publication_identifier ) :
        $publication_taxonomies = $wpdb->get_results ( "
            SELECT * 
            FROM  $taxonomies_table_name
            WHERE taxonomy_publication = '$publication_identifier'
        " );
        Oak::$taxonomies = array_merge( Oak::$taxonomies, $publication_taxonomies );
    endforeach;
else:
    Oak::$taxonomies = $wpdb->get_results ( "
        SELECT * 
        FROM  $taxonomies_table_name
    " );
endif;

$reversed_taxonomies = array_reverse( Oak::$taxonomies );
$taxonomies_without_redundancy = [];

foreach( $reversed_taxonomies as $taxonomy ) :
    $added = false;
    foreach( $taxonomies_without_redundancy as $taxonomy_without_redundancy ) :
        if ( $taxonomy_without_redundancy->taxonomy_identifier == $taxonomy->taxonomy_identifier) :
            $added = true;
        endif;
    endforeach;

    if ( !$added ) :
        $taxonomies_without_redundancy[] = $taxonomy;
    endif;
endforeach;
Oak::$taxonomies_without_redundancy = $taxonomies_without_redundancy;