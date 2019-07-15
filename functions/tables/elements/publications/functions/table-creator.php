<?php
$charset_collate = Oak::$charset_collate;

$publications_table_name = Oak::$publications_table_name;
$publications_sql = "CREATE TABLE $publications_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    publication_designation varchar(555) DEFAULT '' NOT NULL,
    publication_identifier varchar(555) DEFAULT '' NOT NULL,
    publication_selector varchar(555),
    publication_locked varchar(555),
    publication_trashed varchar(555),
    publication_state varchar(555),
    publication_modification_time datetime,
    publication_content_language varchar(10) DEFAULT 'fr',
    publication_organization varchar(555),
    publication_year varchar(555),
    publication_headpiece varchar(555),
    publication_format varchar(555),
    publication_file varchar(555),
    publication_description LONGTEXT,
    publication_report_or_frame varchar(555),
    publication_local varchar(555),
    publication_country varchar(555),
    publication_report_type varchar(555),
    publication_frame_type varchar(555),
    publication_corporate_type varchar(555),
    publication_sectorial_frame varchar(555),
    publication_sectors varchar(555),
    publication_language varchar(555),
    publication_gri_type varchar(555),
    publication_sectorial_supplement varchar(555),
    publication_synchronized TEXT,
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $publications_sql );