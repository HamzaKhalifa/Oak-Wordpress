<?php
global $wpdb;

$glossaries_table_name = Oak::$glossaries_table_name;
Oak::$glossaries = $wpdb->get_results ( "
    SELECT * 
    FROM  $glossaries_table_name
" );
$reversed_glossaries = array_reverse( Oak::$glossaries );
$glossaries_without_redundancy = [];
foreach( $reversed_glossaries as $glossary ) :
    $added = false;
    foreach( $glossaries_without_redundancy as $glossary_without_redundancy ) :
        if ( $glossary_without_redundancy->glossary_identifier == $glossary->glossary_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $glossaries_without_redundancy[] = $glossary;
    endif;
endforeach;
Oak::$glossaries_without_redundancy = $glossaries_without_redundancy;