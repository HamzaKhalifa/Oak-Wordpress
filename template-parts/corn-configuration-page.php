<div class="oak_configuration_page">
    <div id="elementor-template-library-tabs-wrapper" class="nav-tab-wrapper">
        <a class="nav-tab nav-tab-active" href=""><?php _e( 'Généraux', Oak::$text_domain ); ?></a>
        <a class="nav-tab" href="#"><?php _e( 'System Bar', Oak::$text_domain ); ?></a>
        <a class="nav-tab" href="#"><?php _e( 'App Bar', Oak::$text_domain ); ?></a>
        <a class="nav-tab" href="#"><?php _e( 'Footer Bar', Oak::$text_domain ); ?></a>
        <a class="nav-tab" href="#"><?php _e( 'Style', Oak::$text_domain ); ?></a>		
    </div>

    <div class="oak_configuration_page__general_config oak_tab_0">
        <div class="oak_configuration_page__single_parameter">
            <h2><?php _e( 'Logo', Oak::$text_domain ); ?></h2>
            <?php 
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            ?>
            <div class="oak_configuration_page_single_parameter__input_container">
                <input type="hidden" class="oak_configuration_site_logo__input oak_configuration_image_input" value="<?php echo $heading_picture; ?>" />
                <span id="oak_site_change_logo_button" class="oak_button oak_configuration_button"><?php _e( 'Choisir une image', Oak::$text_domain ); ?></span>
                <img class="oak_configuration_site_logo" src="<?php echo $image[0]; ?>" />
            </div>
        </div>

        <div class="oak_configuration_page__single_parameter">
            <h2><?php _e( 'Infos du Site', Oak::$text_domain ); ?></h2>
            <?php
            $tag_line = get_bloginfo( 'description' );
            $site_title = get_bloginfo( 'name' );
            $organization_name = get_option( 'oak_organization_name' ) == false ? '' : get_option( 'oak_organization_name' );
            if ( count( Oak::$organizations_without_redundancy ) > 0 && get_option( 'oak_organization_name' ) == false ) :
                $organization_name = Oak::$organizations_without_redundancy[ count( Oak::$organizations_without_redundancy ) - 1 ]->organization_designation;
            endif;
            ?>
            <div class="oak_configuration_page_single_parameter__input_container">
                <div class="oak_text_field_container">
                    <div class="additional_container">
                        <input class="oak_text_field oak_configuration_page__tagline" value="<?php echo( $tag_line ); ?>">
                    </div>
                    <span class="oak_text_field_placeholder"><?php _e( 'Slogon' ); ?></span>
                    <div class="text_field_line <?php if ( $tag_line != '' ) : echo( 'text_field_line_not_focused_but_something_written' ); endif; ?>"></div>
                    <span class="text_field_description"><?php _e( 'Slogon', Oak::$text_domain ); ?></span>
                </div>
            </div>

            <div class="oak_configuration_page_single_parameter__input_container">
                <div class="oak_text_field_container">
                    <div class="additional_container">
                        <input class="oak_text_field oak_configuration_page__site_title" value="<?php echo( $site_title ); ?>">
                    </div>
                    <span class="oak_text_field_placeholder"><?php _e( 'Titre' ); ?></span>
                    <div class="text_field_line <?php if ( $tag_line != '' ) : echo( 'text_field_line_not_focused_but_something_written' ); endif; ?>"></div>
                    <span class="text_field_description"><?php _e( 'Titre', Oak::$text_domain ); ?></span>
                </div>
            </div>

            <div class="oak_configuration_page_single_parameter__input_container">
                <div class="oak_text_field_container">
                    <div class="additional_container">
                        <input class="oak_text_field oak_configuration_page__organization_name" value="<?php echo( $organization_name ); ?>">
                    </div>
                    <span class="oak_text_field_placeholder"><?php _e( 'Nom de l\'Organisation' ); ?></span>
                    <div class="text_field_line <?php if ( $organization_name != '' ) : echo( 'text_field_line_not_focused_but_something_written' ); endif; ?>"></div>
                    <span class="text_field_description"><?php _e( 'Nom de l\'Organisation', Oak::$text_domain ); ?></span>
                </div>
            </div>
        </div>

        <div class="oak_configuration_page__single_parameter">
            <h2><?php _e( 'Icon', Oak::$text_domain ); ?></h2>
            <?php 
            $site_icon = get_site_icon_url();
            ?>
            <div class="oak_configuration_page_single_parameter__input_container">
                <input type="hidden" class="oak_site_icon__input oak_configuration_image_input" value="<?php echo $site_icon; ?>" />
                <span id="oak_site_change_icon_button" class="oak_button oak_configuration_button"><?php _e( 'Choisir une image', Oak::$text_domain ); ?></span>
                <img class="oak_configuration_site_icon oak_configuration_image" src="<?php echo $site_icon; ?>" />
            </div>
        </div>
    </div>

    <span class="oak_button oak_configuration_page__save_general_settings_button"><?php _e( 'Sauvegarder', Oak::$text_domain ); ?></span>

</div>


<!-- For the modal -->
<div class="oak_add_element_modal_container">
    <div class="oak_add_element_modal_container__modal">
        <div class="oak_add_element_modal_container_modal__title_container">
            <h3 class="oak_add_element_modal_container_modal_title_container__title"></h3>
        </div>
        
        <span class="oak_add_element_modal_container_modal__error"></span>
        <div class="oak_add_element_modal_container_modal__buttons_container">
            <div class="oak_add_element_modal_container_modal_buttons_container__cancel_button_container">
                <span class="oak_add_element_modal_container_modal_buttons_container_cancel_button_container__text" >
                    Annuler
                </span>
            </div>
            
            <div class="oak_add_element_modal_container_modal_buttons_container__add_button_container">
                <span class="oak_add_element_modal_container_modal_buttons_container_add_button_container__text" >
                    Sauvergarder
                </span>
            </div>

            <div class="oak_add_element_modal_container_modal_buttons_container__ok_button_container">
                <span class="oak_add_element_modal_container_modal_buttons_container_add_button_container__text" >
                    Ok
                </span>
            </div>
        </div>
        
    </div>
    <div class="oak_loader"></div>
</div>