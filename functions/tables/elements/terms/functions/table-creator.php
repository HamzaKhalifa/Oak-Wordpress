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
endforeach;