<?php
$charset_collate = Oak::$charset_collate;
global $wpdb;

foreach( Oak::$taxonomies_without_redundancy as $taxonomy ) :
    $table_name = $wpdb->prefix . 'oak_taxonomy_' . $taxonomy->taxonomy_identifier;
    $terms_sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        term_designation varchar(555) DEFAULT '' NOT NULL,
        term_identifier varchar(555) DEFAULT '' NOT NULL,
        term_selector varchar(555),
        term_locked varchar(555),
        term_trashed varchar(555),
        term_state varchar(555),
        term_modification_time datetime,
        term_content_language varchar(10) DEFAULT 'fr',
        term_numerotation varchar(555),
        term_title varchar(555),
        term_description LONGTEXT,
        term_color varchar(555),
        term_logo varchar(555),
        term_order varchar(555),
        term_parent varchar(555),
        term_synchronized TEXT,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $terms_sql );

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