<div class="oak_app_bar">
    <div class="oak_app_bar__right_content">
        <i class="oak_menu_icon oak_menu_burger fas fa-bars"></i>
        <h2 class="oak_app_bar__title"><?php _e( 'Librairie de contenu', Oak::$text_domain ); ?></h2>
    </div>
    <div class="oak_app_bar__left_content">
        <form action="?" method="GET">
            <input type="submit" class="oak_app_bar_left_content__search_input oak_hidden" value="<?php _e( 'Soumettre', Oak::$text_domain ); ?>">
            <input name="search_input" placeholder="<?php _e( 'Rechercher', Oak::$text_domain ); ?>" class="oak_element_header_right__search_input oak_hidden" type="text">
            <?php 
            foreach( $_GET as $get_attribute => $value ) : 
                if ( $get_attribute != 'search_input' ) :
            ?>
                <input type="hidden" name="<?php echo( $get_attribute ); ?>" value="<?php echo( $value ); ?>">
            <?php
                endif;
            endforeach;
            ?>
            <input type="hidden" value="0" name="whichpage">
        </form>
        <i class="oak_menu_icon oak_menu_search_icon fas fa-search"></i>
        <i class="oak_menu_icon oak_menu_smaller_icon fas fa-th"></i>
        <i class="oak_menu_icon oak_menu_smaller_icon fas fa-ellipsis-v"></i>
    </div>
</div>