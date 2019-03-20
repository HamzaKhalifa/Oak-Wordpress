<div class="oak_elements_list_top_container">
    <div class="oak_element_header">
        <div class="oak_element_header_left">
            <i class="oak_menu_icon oak_menu_icon__cancel_icon fas fa-long-arrow-alt-left"></i>
            <h3 class="oak_element_header_title"><?php echo( $title ); ?></h3>
            <div class="oak_list_add_button">
                <i class="fas fa-plus"></i>
            </div>
        </div>

        <div class="oak_element_header_right">
            <i class="oak_menu_icon oak_menu_smaller_icon oak_elemnt_header_right_edit_button oak_hidden fas fa-pen"></i>
            <i class="oak_menu_icon oak_menu_smaller_icon oak_element_header_right_upload_button fas fa-upload"></i>
            <i class="oak_menu_icon oak_menu_smaller_icon oak_element_header_right_download_button fas fa-download"></i>
            <i class="oak_menu_icon oak_menu_smaller_icon oak_element_header_right_copy_button oak_hidden fas fa-copy"></i>
            <i class="oak_menu_icon oak_menu_smaller_icon oak_element_header_right_delete_button oak_hidden fas fa-trash-alt"></i>
            <i class="oak_menu_icon oak_menu_smaller_icon oak_element_header_right_restore_button oak_hidden far fa-window-restore"></i>
        </div>
    </div>

    <div class="oak_grouped_actions">    
        <select class="oak_grouped_actions__element oak_grouped_actions__all_natures" name="" id="">
            <option value="all-natures"><?php _e( 'Toutes les natures', Oak::$text_domain ); ?></option>
            <option value="Texte"><?php _e( 'Texte', Oak::$text_domain ); ?></option>
            <option value="Zone de Texte"><?php _e( 'Zone de Texte', Oak::$text_domain ); ?></option>
            <option value="Image"><?php _e( 'Image', Oak::$text_domain ); ?></option>
            <option value="Fichier"><?php _e( 'Fichier', Oak::$text_domain ); ?></option>
        </select>

        <select class="oak_grouped_actions__element oak_grouped_actions__all_functions" name="" id="">
            <option value="all-functions"><?php _e( 'Toutes les fonctions', Oak::$text_domain ); ?></option>
            <option value="Information/Description">Information/Description</option>
            <option  value="Exemple">Exemple</option>
            <option value="Illustration">Illustration</option>
        </select>

        <select class="oak_grouped_actions__element oak_trash_list_select" name="" id="">
            <option value="not-trashed"><?php _e( 'Non supprimé', Oak::$text_domain ); ?></option>
            <option value="trashed"><?php _e( 'Corbeille', Oak::$text_domain ); ?></option>
        </select>
    </div>
    
    <div class="oak_elements_list">
        <div class="oak_list_row oak_list_row__first_row">
            <div class="oak_list_row__container">
                <input class="oak_passiv oak_list_titles_container__checkbox oak_select_all_checkbox" type="checkbox">
                <span class="oak_passiv oak_list_titles_container__title"><?php _e( 'Désignation', Oak::$text_domain ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <span class="oak_passiv oak_list_titles_container__title"><?php echo( $first_property['title'] ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <span class="oak_passiv oak_list_titles_container__title"><?php echo( $second_property['title'] ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <span class="oak_passiv oak_list_titles_container__title"><?php echo( $third_property['title'] ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <i class="fas fa-file-invoice"></i>
                <span class="oak_passiv oak_list_titles_container__title"><?php _e( 'Dernière modification', Oak::$text_domain ); ?></span>
            </div>
        </div>

        <?php
        foreach( $elements as $element ) :
            $identifier_property = $table . '_identifier';
            $designation_property = $table . '_designation';
            $trashed_property = $table . '_trashed';
            $modification_time_property = $table . '_modification_time';
            $the_first_property = $first_property['property'];
            $the_second_property = $second_property['property'];
            $the_third_property = $third_property['property'];
        ?>
            <div <?php if( $table == 'object' ) : echo('model-identifier="' . $element->object_model_identifier . '"'); endif; ?> identifier="<?php echo( $element->$identifier_property ); ?>" trashed="<?php echo( $element->$trashed_property ); ?>" class="oak_list_row <?php if ( $element->$trashed_property == 'true' ) : echo('oak_hidden'); endif; ?>">
                <div class="oak_list_row__container">
                    <input class="oak_list_titles_container__checkbox" type="checkbox">
                    <span class="oak_list_titles_container__title oak_list_titles_container__the_title"><?php echo( esc_attr( $element->$designation_property ) ); ?></span>
                </div>

                <div class="oak_list_row__container">
                    <span class="oak_list_titles_container__title oak_list_nature"><?php echo( esc_attr( $element->$the_first_property ) ); ?></span>
                </div>

                <div class="oak_list_row__container">
                    <span class="oak_list_titles_container__title oak_list_function"><?php echo( esc_attr( $element->$the_second_property ) ); ?></span>
                </div>

                <div class="oak_list_row__container">
                    <span class="oak_list_titles_container__title"><?php echo( esc_attr( $element->$the_third_property ) ); ?></span>
                </div>
                
                <div class="oak_list_row__container">
                    <span class="oak_list_titles_container__title"><?php echo( esc_attr( $element->$modification_time_property ) ); ?></span>
                </div>
            </div>
        <?php
        endforeach;
        ?>
        
    </div>
</div>


<!-- For the modal -->
<div class="oak_add_element_modal_container">
    <div class="oak_add_element_modal_container__modal">
        <div class="oak_add_element_modal_container_modal__title_container">
            <h3 class="oak_add_element_modal_container_modal_title_container__title"></h3>
        </div>
        <div class="oak_add_element_modal_container_modal__models_list">
            <?php 
                foreach( Oak::$models_without_redundancy as $model ) : ?>
                    <div class="oak_modal_select_model_button" model-identifier="<?php echo( $model->model_identifier ); ?>">
                        <span class="oak_modal_select_model_button__span"><?php echo( $model->model_designation ); ?></span>
                        <i class="oak_admin_menu_element__arrow fas fa-caret-right"></i>
                    </div>
                <?php
                endforeach;
            ?>
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
                    Oui
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