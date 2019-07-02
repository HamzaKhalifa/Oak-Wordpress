<div class="oak_system_bar">
    <div class="oak_system_bar__content">
        <div class="oak_content_filters_container">
            <div class="oak_select_container">
                <span class="text_field_description"><?php _e( 'Etapes', Oak::$text_domain ); ?></span>
                <div class="additional_container">
                    <select multiple class="oak_system_bar__steps_select">
                        <option <?php if ( in_array( '0', Oak::$content_filters['selected_steps'] ) ) : echo('selected'); endif; ?> class="oak_select_container__multiple_select_option" value="0"><?php _e( 'Tout', Oak::$text_domain ); ?></option>
                        <option <?php if ( in_array( 'content_library', Oak::$content_filters['selected_steps'] ) ) : echo('selected'); endif; ?> class="oak_select_container__multiple_select_option" value="content_library"><?php _e( 'Librarie de contenu', Oak::$text_domain ); ?></option>
                        <option <?php if ( in_array( 'editing', Oak::$content_filters['selected_steps'] ) ) : echo('selected'); endif; ?> class="oak_select_container__multiple_select_option" value="editing"><?php _e( 'Editing', Oak::$text_domain ); ?></option>
                        <option <?php if ( in_array( 'publishing', Oak::$content_filters['selected_steps'] ) ) : echo('selected'); endif; ?> class="oak_select_container__multiple_select_option" value="publishing"><?php _e( 'Publishing', Oak::$text_domain ); ?></option>
                    </select>
                </div>
                <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
            </div>

            <div class="oak_select_container">
                <span class="text_field_description"><?php _e( 'Publications', Oak::$text_domain ); ?></span>
                <div class="additional_container">
                    <select multiple class="oak_system_bar__publications_select">
                        <option <?php if ( in_array( '0', Oak::$content_filters['selected_publications'] ) ) : echo('selected'); endif; ?> class="oak_select_container__multiple_select_option" value="0"><?php _e( 'Toutes les publications', Oak::$text_domain ); ?></option>
                        <?php 
                        foreach( Oak::$publications_without_redundancy as $publication ) : ?>
                            <option <?php if ( in_array( $publication->publication_identifier, Oak::$content_filters['selected_publications'] ) ) : echo('selected'); endif; ?> class="oak_select_container__multiple_select_option" value="<?php echo( $publication->publication_identifier ); ?>"><?php echo( $publication->publication_designation ); ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
            </div>

            <span class="oak_content_type_filter_button"><?php _e( 'Filtrer', Oak::$text_domain ); ?></span>
        </div>

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
        <img class="oak_system_bar_icon oak_chat_menu_button" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/user.png' ); ?>" alt="">
    </div>
</div>