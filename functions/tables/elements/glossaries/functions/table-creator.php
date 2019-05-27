<?php
$charset_collate = Oak::$charset_collate;

$glossaries_table_name = Oak::$glossaries_table_name;
$glossaries_sql = "CREATE TABLE $glossaries_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    glossary_designation varchar(555) DEFAULT '' NOT NULL,
    glossary_identifier varchar(555) DEFAULT '' NOT NULL,
    glossary_selector varchar(555),
    glossary_locked varchar(555),
    glossary_trashed varchar(555),
    glossary_state varchar(555),
    glossary_modification_time datetime,
    glossary_content_language varchar(10) DEFAULT 'fr',
    glossary_publication varchar(555),
    glossary_object varchar(555),
    glossary_depends varchar(555),
    glossary_parent varchar(555),
    glossary_definition LONGTEXT,
    glossary_close varchar(555),
    glossary_close_indicators varchar(555),
    glossary_synchronized TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $glossaries_sql );