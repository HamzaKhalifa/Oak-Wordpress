<?php
// Gettig all terms and frame terms (terms that are instances of a taxonomy that is associated to a freme publication)
global $wpdb; 

foreach( Oak::$taxonomies_without_redundancy as $taxonomy ) :
    $table_name = $wpdb->prefix . 'oak_taxonomy_' . $taxonomy->taxonomy_identifier;
    // lets get all the terms: 
    $terms = $wpdb->get_results( "
        SELECT *
        FROM $table_name
    ");
    $terms = array_reverse( $terms );
    foreach( $terms as $term ) :
        $term->term_taxonomy_identifier = $taxonomy->taxonomy_identifier;
        $added = false;
        foreach( Oak::$all_terms_without_redundancy as $added_term ) :
            if ( $added_term->term_identifier == $term->term_identifier ) :
                $added = true;
            endif;
        endforeach;
        if ( !$added ) :
            Oak::$all_terms_without_redundancy[] = $term;

            if ( in_array( $taxonomy->taxonomy_publication, Oak::$frame_publications_identifiers ) ) :
                Oak::$frame_terms_identifiers[] = $term->term_identifier;
            endif;
        endif;
    endforeach;

    Oak::$all_terms = array_merge( Oak::$all_terms, $terms );
endforeach;

// Getting current taxonomy terms: 
if ( isset( $_GET['taxonomy_identifier'] ) ) :
    $term_table_name = $wpdb->prefix . 'oak_taxonomy_' . $_GET['taxonomy_identifier'];
    Oak::$terms = $wpdb->get_results ( "
        SELECT *
        FROM $term_table_name
    " );
    $reversed_terms = array_reverse( Oak::$terms  );
    foreach( $reversed_terms as $term ) :
        $added = false;
        foreach( Oak::$terms_without_redundancy as $term_without_redundancy ) :
            if ( $term_without_redundancy->term_identifier == $term->term_identifier) :
                $added = true;
            endif;
        endforeach;
        if ( !$added ) :
            Oak::$terms_without_redundancy[] = $term;
        endif;
    endforeach;
endif;