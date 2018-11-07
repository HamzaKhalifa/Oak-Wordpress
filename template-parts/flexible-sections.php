<?php 
$data = get_fields();
$flexible_sections = $data['flexible_sections'];

foreach( $flexible_sections as $flexible_section ) :
    switch ( $flexible_section['acf_fc_layout'] ) :
        case 'section_paragraph_image' :
            include get_template_directory() . '/template-parts/sections/paragraph_image.php';
            break;
        case 'section_title_paragraph_image' :
            include get_template_directory() . '/template-parts/sections/title_paragraph_image.php';
            break;
        default :
        break;
    endswitch;
endforeach;