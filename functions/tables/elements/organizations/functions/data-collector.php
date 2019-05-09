<?php
global $wpdb;

$organizations_table_name = Oak::$organizations_table_name;
Oak::$organizations = $wpdb->get_results ( "
    SELECT * 
    FROM  $organizations_table_name
" );
$reversed_organizations = array_reverse( Oak::$organizations );
$organizations_without_redundancy = [];
foreach( $reversed_organizations as $organization ) :
    $added = false;
    foreach( $organizations_without_redundancy as $organization_without_redundancy ) :
        if ( $organization_without_redundancy->organization_identifier == $organization->organization_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $organizations_without_redundancy[] = $organization;
    endif;
endforeach;
Oak::$organizations_without_redundancy = $organizations_without_redundancy;