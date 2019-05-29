<?php
$charset_collate = Oak::$charset_collate;

$taxonomies_table_name = Oak::$taxonomies_table_name;
$taxonomies_sql = "CREATE TABLE $taxonomies_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    taxonomy_designation varchar(555) DEFAULT '' NOT NULL,
    taxonomy_identifier varchar(555) DEFAULT '' NOT NULL,
    taxonomy_selector varchar(555),
    taxonomy_locked varchar(555),
    taxonomy_trashed varchar(555),
    taxonomy_state varchar(555),
    taxonomy_modification_time datetime,
    taxonomy_content_language varchar(10) DEFAULT 'fr',
    taxonomy_description LONGTEXT,
    taxonomy_structure varchar(555),
    taxonomy_numerotation varchar(555),
    taxonomy_title varchar(555),
    taxonomy_term_description LONGTEXT,
    taxonomy_color varchar(555),
    taxonomy_brand varchar(555),
    taxonomy_publication varchar(555),
    taxonomy_synchronized varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $taxonomies_sql );