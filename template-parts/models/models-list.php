<div class="oak_fields_list_top_container">
    <div class="oak_list_header">
        <img class="oak_list_header__icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
        <h1><?php _e( 'Modèles', Oak::$text_domain ); ?></h1>
        <span class="oak_list_header__add_button oak_list_button"><?php _e( 'Ajouter', Oak::$text_domain ); ?></span>
    </div>
    
    <div class="oak_add_field_container__fields_list">
        <div class="oak_list_row">
            <div class="oak_list_row__container">
                <input class="oak_list_titles_container__checkbox" type="checkbox">
                <span class="oak_list_titles_container__title"><?php _e( 'Nom du modèle', Oak::$text_domain ); ?></span>
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
        $added_models = [];
        foreach( $models as $model ) : 
            $exists = false;
            foreach( $added_models as $added_model ) :
                if ( $model->model_identifier == $added_model->model_identifier ) 
                    $exists = true;
            endforeach;
            if ( !$exists ) :
                $added_models[] = $model;
        ?>
            <div class="oak_list_row">
                <div class="oak_list_row__container">
                    <input class="oak_list_titles_container__checkbox" type="checkbox">
                    <span class="oak_list_titles_container__title"><?php echo( $model->model_designation ); ?></span>
                </div>

                <div class="oak_list_row__container">
                    <span class="oak_list_titles_container__title"><?php echo( $model->model_types ); ?></span>
                </div>

                <div class="oak_list_row__container">
                    <span class="oak_list_titles_container__title"><?php echo( $model->model_publications_categories ); ?></span>
                </div>
                
                <div class="oak_list_row__container">
                    <div class="<?php if ( $model->model_selector ) : echo('oak_dot'); else : echo('oak_dot_false'); endif; ?>"></div>
                </div>

                <div class="oak_list_row__container">
                    <div class="<?php if ( $model->model_selector ) : echo('oak_dot'); else : echo('oak_dot_false'); endif; ?>"></div>
                    <span model-identifier="<?php echo( $model->model_identifier ); ?>" class="oak_list_header__add_button oak_list_button oak_add_field_container_saved_field_container__update_button"><?php _e( 'Accéder', Oak::$text_domain ); ?></span>
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