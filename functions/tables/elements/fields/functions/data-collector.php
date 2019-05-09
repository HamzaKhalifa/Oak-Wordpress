<?php 
global $wpdb; 

$fields_table_name = Oak::$fields_table_name;
Oak::$fields = $wpdb->get_results ( "
    SELECT * 
    FROM  $fields_table_name
" );
$reversed_fields = array_reverse( Oak::$fields );
$fields_without_redundancy = [];
foreach( $reversed_fields as $field ) :
    $added = false;
    foreach( $fields_without_redundancy as $field_without_redundancy ) :
        if ( $field_without_redundancy->field_identifier == $field->field_identifier ) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $fields_without_redundancy[] = $field;
    endif;
endforeach;
Oak::$fields_without_redundancy = $fields_without_redundancy;