<div class="oak_fields_list_top_container">
    <div class="oak_list_header">
        <div class="oak_list_header_left">
            <img class="oak_list_header__icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
            <h1><?php _e( 'Champs', Oak::$text_domain ); ?></h1>
            <span class="oak_list_header__add_button oak_list_button"><?php _e( 'Ajouter', Oak::$text_domain ); ?></span>
        </div>

        <div class="oak_list_header_right">
            <input placeholder="<?php _e( 'Rechercher un champ', Oak::$text_domain ); ?>" class="oak_list_header_right__search_input" type="text">
            <i class="oak_list_header_right__icon_button oak_list_header_right_download_button fas fa-download"></i>
            <i class="oak_list_header_right__icon_button oak_list_header_right_upload_button fas fa-upload"></i>
        </div>
    </div>

    <div class="oak_grouped_actions">
        <select class="oak_grouped_actions__element oak_grouped_actions__grouped_actions" name="" id="">
            <option value="grouped-actions"><?php _e( 'Action groupées', Oak::$text_domain ); ?></option>
            <option value="to-trash"><?php _e( 'Supprimer', Oak::$text_domain ); ?></option>
            <option value="export"><?php _e( 'Exporter', Oak::$text_domain ); ?></option>
        </select>

        <span class="oak_list_button oak_list_grouped_actions_button"><?php _e( 'Appliquer', Oak::$text_domain ); ?></span>  
        
        <select class="oak_grouped_actions__element oak_grouped_actions__all_natures" name="" id="">
            <option value="all-natures"><?php _e( 'Toutes les natures', Oak::$text_domain ); ?></option>
            <option value="Texte"><?php _e( 'Texte', Oak::$text_domain ); ?></option>
            <option value="Zone de texte"><?php _e( 'Zone de texte', Oak::$text_domain ); ?></option>
            <option value="Image"><?php _e( 'Image', Oak::$text_domain ); ?></option>
            <option value="Fichier"><?php _e( 'Fichier', Oak::$text_domain ); ?></option>
        </select>

        <select class="oak_grouped_actions__element oak_grouped_actions__all_functions" name="" id="">
            <option value="all-functions"><?php _e( 'Toutes les fonctions', Oak::$text_domain ); ?></option>
            <option value="Information/Description">Information/Description</option>
            <option  value="Exemple">Exemple</option>
            <option value="Illustration">Illustration</option>
        </select>

    </div>
    
    <div class="oak_add_field_container__fields_list">
        <div class="oak_list_row">
            <div class="oak_list_row__container">
                <input class="oak_list_titles_container__checkbox oak_select_all_checkbox" type="checkbox">
                <span class="oak_list_titles_container__title"><?php _e( 'Nom du champ', Oak::$text_domain ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <span class="oak_list_titles_container__title"><?php _e( 'Nature', Oak::$text_domain ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <span class="oak_list_titles_container__title"><?php _e( 'Fonction', Oak::$text_domain ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <img class="oak_list_row_container__img" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/embeded-xp.passiv.png' ); ?>" alt="">
                <span class="oak_passiv oak_list_titles_container__title"><?php _e( 'Sélecteur RSE', Oak::$text_domain ); ?></span>
            </div>

            <div class="oak_list_row__container">
                <i class="fas fa-file-invoice"></i>
                <span class="oak_passiv oak_list_titles_container__title"><?php _e( 'Formulaire', Oak::$text_domain ); ?></span>
            </div>
        </div>

        
        <?php
        $added_fields = [];
        $reversed_fields = array_reverse( $fields, true );
        foreach( $reversed_fields as $field ) :
            $exists = false;
            foreach( $added_fields as $added_field ) :
                if ( $field->field_identifier == $added_field->field_identifier ) 
                    $exists = true;
            endforeach;
            if ( !$exists ) :
                $added_fields[] = $field;
            endif;

            if ( !$exists && $field->field_trashed != 'true' ) :
        ?>
            <div class="oak_list_row">
                <div class="oak_list_row__container">
                    <input class="oak_list_titles_container__checkbox" type="checkbox">
                    <span class="oak_list_titles_container__title oak_list_titles_container__the_title"><?php echo( esc_attr( $field->field_designation ) ); ?></span>
                </div>

                <div class="oak_list_row__container">
                    <span class="oak_list_titles_container__title oak_list_nature"><?php echo( esc_attr( $field->field_type ) ); ?></span>
                </div>

                <div class="oak_list_row__container">
                    <span class="oak_list_titles_container__title oak_list_function"><?php echo( esc_attr( $field->field_function ) ); ?></span>
                </div>
                
                <div class="oak_list_row__container">
                    <div class="<?php if ( $field->field_selector == 'true' ) : echo('oak_dot'); else : echo('oak_dot oak_dot_false'); endif; ?>"></div>
                </div>

                <div class="oak_list_row__container">
                    <div class="<?php if ( $field->field_selector ) : echo('oak_dot'); else : echo('oak_dot oak_dot_false'); endif; ?>"></div>
                    <span field-identifier="<?php echo( esc_attr( $field->field_identifier ) ); ?>" class="oak_list_header__add_button oak_list_button oak_add_field_container_saved_field_container__update_button"><?php _e( 'Accéder', Oak::$text_domain ); ?></span>
                </div>

            </div>
        <?php
            endif;
        endforeach;
        ?>
        
    </div>
</div>


<!-- For the modal -->
<div class="oak_object_model_add_formula_modal_container">
    <div class="oak_object_model_add_formula_modal_container__modal">
        <div class="oak_object_model_add_formula_modal_container_modal__title_container">
            <h3 class="oak_object_model_add_formula_modal_container_modal_title_container__title"></h3>
        </div>
        <span class="oak_object_model_add_formula_modal_container_modal__error"></span>
        <div class="oak_object_model_add_formula_modal_container_modal_buttons_container">
            <div class="oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container">
                <span class="oak_object_model_add_formula_modal_container_modal_buttons_container_cancel_button_container__text" >
                    Annuler
                </span>
            </div>
            
            <div class="oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container">
                <span class="oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text" >
                    Ajouter
                </span>
            </div>

            <div class="oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container">
                <span class="oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text" >
                    Ok
                </span>
            </div>
        </div>
        
    </div>
    <div class="oak_loader"></div>
</div>