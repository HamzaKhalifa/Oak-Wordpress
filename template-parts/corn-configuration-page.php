<div class="oak_configuration_page">
    <div id="elementor-template-library-tabs-wrapper" class="nav-tab-wrapper">
        <a class="nav-tab nav-tab-active" href=""><?php _e( 'Généraux', Oak::$text_domain ); ?></a>
        <a class="nav-tab" href="#"><?php _e( 'System Bar', Oak::$text_domain ); ?></a>
        <a class="nav-tab" href="#"><?php _e( 'App Bar', Oak::$text_domain ); ?></a>
        <a class="nav-tab" href="#"><?php _e( 'Nav Bar', Oak::$text_domain ); ?></a>
        <a class="nav-tab" href="#"><?php _e( 'Style', Oak::$text_domain ); ?></a>		
    </div>

    <div class="oak_configuration_page__general_config oak_tab oak_tab_0">
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

        <div class="oak_configuration_page__single_parameter">
            <h2><?php _e( 'Régénérer les indexes', Oak::$text_domain ); ?></h2>
            <?php 
            ?>
            <div class="oak_configuration_page_single_parameter__input_container">
                <span id="oak_regenerate_indexes_button" class="oak_button oak_configuration_button"><?php _e( 'Régénérer les indexes', Oak::$text_domain ); ?></span>
            </div>
        </div>

        <span class="oak_button oak_configuration_page__save_general_settings_button"><?php _e( 'Sauvegarder', Oak::$text_domain ); ?></span>
    </div>

    <div class="oak_configuration_page__system_bar_config oak_tab oak_tab_1 oak_hidden">
        <div class="oak_configuration_page__single_parameter">
        <?php
            $stored_social_media = get_option('oak_social_media_data') != false ? get_option('oak_social_media_data') : [];  
            foreach( Oak::$social_medias as $key => $social_media ) :
                $url = $show_social_media_url = '';
                $show_social_media_url = isset( $stored_social_media[ $key ] ) ? $stored_social_media[ $key ]['checked'] : '';
                $url = isset( $stored_social_media[ $key ] ) ? $stored_social_media[ $key ]['value'] : '';
            ?>
                <div class="oak_configuration_page_single_parameter__input_container">
                    <input type="checkbox" class="<?php echo( 'social_media_' . $social_media['name'] . '_checkbox' ); ?>" <?php if( $show_social_media_url == 'true' ) : echo( 'checked' ); endif; ?>>
                    <div class="oak_text_field_container">
                        <div class="additional_container">
                            <input class="oak_text_field oak_configuration_page__site_title <?php echo( 'social_media_' . $social_media['name'] ); ?>" value="<?php echo( $url ); ?>">
                        </div>
                        <span class="oak_text_field_placeholder"><?php echo( $social_media['title'] ); ?></span>
                        <div class="text_field_line"></div>
                        <span class="text_field_description"><?php _e( 'Titre', Oak::$text_domain ); ?></span>
                    </div>
                </div>
            <?php
            endforeach;
        ?>
        </div>
        <div class="oak_configuration_page__single_parameter">
            <div class="oak_select_container">
                <?php $background_color = get_option( 'oak_social_system_bar_background_color' ) != false ? get_option( 'oak_social_system_bar_background_color' ) : ''; ?>
                <div class="color_additional_container">
                    <input type="text" class="oak_social_media_background_color_configuration" value="<?php echo( $background_color ); ?>">
                </div>
                <div class="text_field_line"></div>
                <span class="text_field_description"><?php _e( 'Couleur du background', Oak::$text_domain ); ?></span>
            </div>
        </div>

        <span class="oak_button oak_configuration_page__save_system_bar_settings_button"><?php _e( 'Sauvegarder', Oak::$text_domain ); ?></span>
    </div>

    <div class="oak_configuration_page__system_bar_config oak_tab oak_tab_2 oak_hidden">
        <div class="oak_configuration_page__single_parameter">
        <?php
            $app_bar_parameters = array(
                array( 'name' => 'oak_show_logo', 'title' => __( 'Logo', Oak::$text_domain ) ),
                array( 'name' => 'oak_show_organization_name', 'title' => __( 'Nom de l’organisation', Oak::$text_domain ) ),
                array( 'name' => 'oak_show_site_title', 'title' => __( 'Titre du Site', Oak::$text_domain ) ),
            );
            foreach( $app_bar_parameters as $single_app_bar_parameter ) :
                $checked = get_option( $single_app_bar_parameter['name'] ) != false ? get_option( $single_app_bar_parameter['name'] ) : 'false';
            ?>
                <div class="oak_configuration_page_single_parameter__input_container">
                    <input type="checkbox" id="<?php echo( $single_app_bar_parameter['name'] ); ?>" class="<?php echo( $single_app_bar_parameter['name'] ); ?> oak_app_bar_configuration_checkbox" <?php if( get_option( $single_app_bar_parameter['name'] ) == 'true' ) : echo( 'checked' ); endif; ?>>
                    <span class="text_field_description"><?php echo( $single_app_bar_parameter['title'] ); ?></span>
                </div>
            <?php
            endforeach;
        ?>
        </div>
        <div class="oak_configuration_page__single_parameter">
            <div class="oak_select_container">
                <?php $background_color = get_option( 'oak_app_bar_background_color' ) != false ? get_option( 'oak_app_bar_background_color' ) : ''; ?>
                <div class="color_additional_container">
                    <input type="text" value="<?php echo ( $background_color ); ?>" class="oak_app_bar_background_color" value="">
                </div>
                <div class="text_field_line"></div>
                <span class="text_field_description"><?php _e( 'Couleur du background', Oak::$text_domain ); ?></span>
            </div>
        </div>

        <span class="oak_button oak_configuration_page__save_app_bar_settings_button"><?php _e( 'Sauvegarder', Oak::$text_domain ); ?></span>
    </div>

    <div class="oak_configuration_page__nav_bar_config oak_tab oak_tab_3 oak_hidden">
        <?php
            $menus = Oak::oak_get_all_wordpress_menus();
            foreach( $menus as $menu ) :
            ?>
                <div class="oak_configuration_page__single_menu_container" menu-slug="<?php echo( $menu->slug ); ?>">
                    <h2 class="oak_configuration_page_nav_bar_config__menu_title"><?php echo( $menu->name ); ?></h2>

                    <div class="oak_color_container">
                        <span class="oak_color_description"><?php _e( 'Couleur du background: ', Oak::$text_domain ); ?></span>
                        <div class="additional_container">
                            <input class="oak_text_field color_input" value="">
                        </div>
                    </div>

                    <div class="oak_color_container">
                        <span class="oak_color_description"><?php _e( 'Couleur de la font: ', Oak::$text_domain ); ?></span>
                        <div class="additional_container">
                            <input class="oak_text_field color_input" value="">
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        ?>

        <span class="oak_button oak_configuration_page__save_nav_bar_settings_button"><?php _e( 'Sauvegarder', Oak::$text_domain ); ?></span>
            
    </div>

    <div class="oak_configuration_page__style_config oak_tab oak_tab_4 oak_hidden">
        <?php
        $color_weights = array(
            array( 'name' => 'oak_color_0', 'title' => __( 'Couleur', Oak::$text_domain ) ),
            array( 'name' => 'oak_light0', 'title' => __( 'Light', Oak::$text_domain ) ),
            array( 'name' => 'oak_dark_0', 'title' => __( 'Dark', Oak::$text_domain ) ),
            array( 'name' => 'oak_50_0', 'title' => __( '50', Oak::$text_domain ) ),
            array( 'name' => 'oak_100_0', 'title' => __( '100', Oak::$text_domain ) ),
            array( 'name' => 'oak_200_0', 'title' => __( '200', Oak::$text_domain ) ),
            array( 'name' => 'oak_300_0', 'title' => __( '300', Oak::$text_domain ) ),
            array( 'name' => 'oak_400_0', 'title' => __( '400', Oak::$text_domain ) ),
            array( 'name' => 'oak_500_0', 'title' => __( '500', Oak::$text_domain ) ),
            array( 'name' => 'oak_600_0', 'title' => __( '600', Oak::$text_domain ) ),
            array( 'name' => 'oak_700_0', 'title' => __( '700', Oak::$text_domain ) ),
            array( 'name' => 'oak_800_0', 'title' => __( '800', Oak::$text_domain ) ),
            array( 'name' => 'oak_900_0', 'title' => __( '900', Oak::$text_domain ) ),
        )
        ?>
        <div class="oak_configuration_page__colors_container">
            <div class="oak_configuration_page__single_color_container">
                <div class="oak_configuration_page_single_color_container__primary_container">
                    <h2 class="oak_colors_configuration_title"><?php _e( 'Primary', Oak::$text_domain ); ?></h2>
                    <?php 
                    foreach( $color_weights as $weight ) : ?>

                        <div class="oak_color_container">
                            <span class="oak_color_description"><?php echo( $weight['title'] ); ?></span>
                            <div class="additional_container">
                                <input class="oak_text_field color_input" value="">
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
                <div class="oak_configuration_page_single_color_container__secondary_container">
                    <h2 class="oak_colors_configuration_title"><?php _e( 'Secondary', Oak::$text_domain ); ?></h2>
                    <?php 
                    foreach( $color_weights as $weight ) : ?>
                        <div class="oak_color_container">
                            <span class="oak_color_description"><?php echo( $weight['title'] ); ?></span>
                            <div class="additional_container">
                                <input class="oak_text_field color_input" value="">
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
        <div class="oak_list_add_button oak_configuration_page__add_style_button">
            <i class="fas fa-plus"></i>
        </div>

        <span class="oak_button oak_configuration_page__save_styles"><?php _e( 'Sauvegarder', Oak::$text_domain ); ?></span>
    </div>

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