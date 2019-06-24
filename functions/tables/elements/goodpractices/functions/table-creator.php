<?php
$charset_collate = Oak::$charset_collate;

$goodpractices_table_name = Oak::$goodpractices_table_name;
$goodpractice_sql = "CREATE TABLE $goodpractices_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    goodpractice_designation varchar(555) DEFAULT '' NOT NULL,
    goodpractice_identifier varchar(555) DEFAULT '' NOT NULL,
    goodpractice_selector varchar(555),
    goodpractice_locked varchar(555),
    goodpractice_trashed varchar(555),
    goodpractice_state varchar(555),
    goodpractice_modification_time datetime,
    goodpractice_content_language varchar(10) DEFAULT 'fr',
    goodpractice_short_designation varchar(555),
    goodpractice_description LONGTEXT,
    goodpractice_illustration TEXT,
    goodpractice_link TEXT,
    goodpractice_link_title TEXT,
    goodpractice_publication TEXT,
    goodpractice_objects TEXT,
    goodpractice_quantis TEXT,
    goodpractice_synchronized TEXT,
    goodpractice_frame_objects TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $goodpractice_sql );