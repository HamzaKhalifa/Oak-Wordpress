<div class="oak_fields_list_top_container">
    <h1><?php _e( 'Liste des Formulaires', Oak::$text_domain ); ?></h1>
    <div class="oak_add_field_container__fields_list">
        <?php
        $added_forms = [];
        foreach( $forms as $form ) : 
            $exists = false;
            foreach( $added_forms as $added_form ) :
                if ( $form->form_identifier == $added_form->form_identifier ) 
                $exists = true;
            endforeach;
            if ( !$exists ) :
                $added_form[] = $form;
        ?>
            <div class="oak_add_field_container__saved_field_container">
                <i class="oak_add_field_container_saved_field_container__update_button fas fa-cog"></i>
                <span><?php echo( $form->form_designation ); ?></span>
                <i form-identifier='<?php echo( $form->form_identifier ); ?>' class="oak_add_field_container__saved_field_container__delete_button fas fa-minus"></i>
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