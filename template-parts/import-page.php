<div class="oak_import_page">

    <div class="import_header import_header_screen_title_container">
        <div class="import_header__left_side">
            <i class="import_header_right_side__search_icon fas fa-times"></i>
            <h4 class="import_header_left_side__title screen_title"><?php _e( 'Organisations', Oak::$text_domain ); ?></h4>
        </div>
    </div>

    <div class="import_container">
        <div class="import_container__line">
            <div class="import_container_line__checkbox_container">
                <input type="checkbox" class="import_container__element_checkbox">
                <h4 class="import_container_line_column_value import_container_line__title"><?php _e( 'Nom de l\'organisation', Oak::$text_domain ); ?></h4>
            </div>
            <h4 class="import_container_line_column_value import_container_line__title"><?php _e( 'Pays du siège', Oak::$text_domain ); ?></h4>
            <h4 class="import_container_line_column_value import_container_line__title"><?php _e( 'Type', Oak::$text_domain ); ?></h4>
            <h4 class="import_container_line_column_value import_container_line__title"><?php _e( 'Secteur d\'activité', Oak::$text_domain ); ?></h4>
        </div>
    </div>

    <div class="next_button_container">
        <span class="next_button_container_next oak_hidden"><?php _e( 'Etape suivante', Oak::$text_domain ); ?></span>
    </div>




    <!-- <div class="oak_import_page_field">
        <label for="publications-select"><?php _e( 'Publications', Oak::$text_domain ); ?></label>
        <select class="oak_import_page__publications_select" multiple name="publications-select" id="">
        </select>

        <span class="oak_import_page_button oak_import_page_field__import_button"><?php _e( 'Importer', Oak::$text_domain ); ?></span>
        <span class="some_selector">
        </span>
    </div> -->
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