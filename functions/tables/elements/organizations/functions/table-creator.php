<?php
$charset_collate = Oak::$charset_collate;

$organizations_table_name = Oak::$organizations_table_name;
$organizations_sql = "CREATE TABLE $organizations_table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    organization_designation varchar(555) DEFAULT '' NOT NULL,
    organization_identifier varchar(555) DEFAULT '' NOT NULL,
    organization_selector varchar(555),
    organization_locked varchar(555),
    organization_trashed varchar(555),
    organization_state varchar(555),
    organization_modification_time datetime,
    organization_content_language varchar(10) DEFAULT 'fr',
    organization_acronym varchar(555),
    organization_logo varchar(555),
    organization_description LONGTEXT,
    organization_url varchar(555),
    organization_address varchar(555),
    organization_country varchar(555),
    organization_company varchar(555),
    organization_type varchar(555),
    organization_side varchar(555),
    organization_sectors varchar(555),
    PRIMARY KEY (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $organizations_sql );