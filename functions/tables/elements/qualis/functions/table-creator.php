<?php
$charset_collate = Oak::$charset_collate;

$qualis_table_name = Oak::$qualis_table_name;
$qualis_sql = "CREATE TABLE $qualis_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    quali_designation varchar(555) DEFAULT '' NOT NULL,
    quali_identifier varchar(555) DEFAULT '' NOT NULL,
    quali_selector varchar(555),
    quali_locked varchar(555),
    quali_trashed varchar(555),
    quali_state varchar(555),
    quali_modification_time datetime,
    quali_content_language varchar(10) DEFAULT 'fr',
    quali_publication varchar(555),
    quali_object varchar(555),
    quali_depends varchar(555),
    quali_parent varchar(555),
    quali_parent_object TEXT,
    quali_numerotation_type varchar(555),
    quali_numerotation varchar(555),
    quali_description LONGTEXT,
    quali_close varchar(555),
    quali_close_indicators varchar(555),
    quali_close_objects TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $qualis_sql );