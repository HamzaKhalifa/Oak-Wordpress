<div class="oak_configuration_page">
    <h1 class="oak_configuration_page__title"><?php _e( 'Page de configuration', Oak::$text_domain ); ?></h1>
    <div class="oak_configuration_page_field_container">
        <label class="oak_configuration_page__label" for="checkbox"><?php _e( 'Corn', Oak::$text_domain ); ?></label>
        <input <?php if( get_option( 'oak_corn' ) == 'true' ) : echo('checked'); endif; ?> type="checkbox" name="checkbox" class="oak_configuration_page_checkbox">
    </div>
    <div class="oak_configuration_page_field_container oak_configuration_page_central_url_field_container <?php if( get_option( 'oak_corn' ) != 'true' ) : echo('oak_hidden'); endif; ?>">
        <label class="oak_configuration_page__label" for="central-url"><?php _e( 'Veuillez entrer l\'URL du central: ' ); ?></label>
        <input value="<?php echo( get_option('oak_central_url') ); ?>" type="text" class="oak_configuration_page_field_container__url_input" name="central-url">
    </div>
    <span class="oak_configuration_page_save_central_url_button"><?php _e( 'Sauvegarder', Oak::$text_domain ); ?></span>
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