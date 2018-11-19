<?php 
/* Template Name: Analyse Critique */

include get_template_directory() . '/template-parts/critical-analyzes-front/header.php';

$analyzes = get_option('dawn_analyzes');
$analyzes_field = get_field_object('analyzes');
$selected_analyze = $analyzes_field['choices'][ get_field('analyzes') ];
$analyzes = get_option('dawn_analyzes');
$analysis; 
for ( $i = 0; $i < sizeof( $analyzes ); $i++ ) :
    if ( $analyzes[$i]['title'] == $selected_analyze ) :
        $analysis = $analyzes[$i];
        echo('<pre>');
        // var_dump( $analysis );
        echo('</pre>');
    endif;
endfor;

if ( $analysis )
    include get_template_directory() . '/template-parts/critical-analyzes-front/content.php';

include get_template_directory() . '/template-parts/critical-analyzes-front/footer.php';
