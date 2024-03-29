<?php
$charset_collate = Oak::$charset_collate;

$sources_table_name = Oak::$sources_table_name;
$source_sql = "CREATE TABLE $sources_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    source_designation varchar(555) DEFAULT '' NOT NULL,
    source_identifier varchar(555) DEFAULT '' NOT NULL,
    source_selector varchar(555),
    source_locked varchar(555),
    source_trashed varchar(555),
    source_state varchar(555),
    source_modification_time datetime,
    source_content_language varchar(10) DEFAULT 'fr',
    source_short_title TEXT,
    source_long_title TEXT,
    source_illustration LONGTEXT,
    source_description LONGTEXT,
    source_publication TEXT,
    source_object TEXT,
    source_type TEXT,
    source_internal_type TEXT,
    source_pdf_publication TEXT,
    source_internal_button_text TEXT,
    source_post TEXT,
    source_link_object TEXT,
    source_link TEXT,
    source_link_title TEXT,
    source_synchronized TEXT,
    source_frame_objects TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $source_sql );