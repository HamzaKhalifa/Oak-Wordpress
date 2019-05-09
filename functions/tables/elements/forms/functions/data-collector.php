<?php
global $wpdb;

$forms_table_name = Oak::$forms_table_name;
Oak::$forms = $wpdb->get_results ( "
    SELECT * 
    FROM  $forms_table_name
" );
$reversed_forms = array_reverse( Oak::$forms );
$forms_without_redundancy = [];
foreach( $reversed_forms as $form ) :
    $added = false;
    foreach( $forms_without_redundancy as $form_without_redundancy ) :
        if ( $form_without_redundancy->form_identifier == $form->form_identifier) :
            $added = true;
        endif;
    endforeach;
    if ( !$added ) :
        $forms_without_redundancy[] = $form;
    endif;

    // For form attributes:
    $form_attributes_Array = explode( ',', $form->form_attributes );
    foreach( $form_attributes_Array as $attribute ) :
        $exists = false;
        foreach( Forms::$attributes as $oak_attribute ) :
            if ( $oak_attribute == $attribute || $attribute == '' )
                $exists = true;
        endforeach;
        if ( !$exists ) :
            Forms::$attributes[] = $attribute;
        endif;
    endforeach;
endforeach;
Oak::$forms_without_redundancy = $forms_without_redundancy;