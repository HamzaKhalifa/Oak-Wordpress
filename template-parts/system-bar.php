<div class="oak_system_bar">
    <div class="oak_system_bar__content">
        <?php
        if ( isset( $_GET['elements'] ) && isset( $_GET['listorformula'] ) ) : 
            $languages_codes = Oak::get_languages_codes();
            ?>
            <div class="oak_select_container">
                <span class="text_field_description"><?php _e( 'Langue', Oak::$text_domain ); ?></span>
                <div class="additional_container">
                    <select class="oak_system_bar__languages_select">
                        <option class="oak_stystem_bar_language_option" value="fr"><?php _e( 'French', Oak::$text_domain ); ?></option>
                        <option class="oak_stystem_bar_language_option" value="en"><?php _e( 'English', Oak::$text_domain ); ?></option>
                        <option class="oak_stystem_bar_language_option" value="ar"><?php _e( 'Arabic', Oak::$text_domain ); ?></option>
                        <?php
                        $basic_languages = array('French', 'English', 'Arabic');
                        foreach( $languages_codes['languages'] as $key => $language ) :
                            if ( !in_array( $language, $basic_languages ) ) :
                                ?>
                                <option class="oak_stystem_bar_language_option" value="<?php echo ( $languages_codes['codes'][ $key ] ); ?>"><?php echo( $language ); ?></option>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </select>
                </div>
                <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
            </div>
        <?php
        endif;
        ?>


        <img class="oak_system_bar_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/isivalue.png' ); ?>" alt="">
        <img class="oak_system_bar_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/joro.png' ); ?>" alt="">
        <img class="oak_system_bar_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/user.png' ); ?>" alt="">
    </div>
</div>