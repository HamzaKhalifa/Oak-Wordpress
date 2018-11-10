<?php 
/* Template Name: Analyse Critique */

get_header();

$analyzes = get_option('dawn_analyzes');
$analyzes_field = get_field_object('analyzes');
$selected_analyze = $analyzes_field['choices'][ get_field('analyzes') ];
$analyzes = get_option('dawn_analyzes');
$analyze; 
for ( $i = 0; $i < sizeof( $analyzes ); $i++ ) :
    if ( $analyzes[$i]['title'] == $selected_analyze ) :
        $analyze = $analyzes[$i];
    endif; 
endfor;

// We are gonna show the analyze data here: 

get_footer();