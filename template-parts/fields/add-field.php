<div class="oak_add_field_container">
    <h3 class="oak_add_field_container__title"><?php _e( 'Ajouter un champ', Oak::$text_domain ); ?></h3>

    <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
        <label class="oak_add_field_container__label" for="designation"><?php _e( 'Désignation: ', Oak::$text_domain ); ?></label> 
        <input name="designation" type="text" class="oak_add_field_container__input oak_add_field_container__designation">
    </div>

    <div class="oak_add_field_container__field_container oak_add_field_container__identifier_container">
        <label class="oak_add_field_container__label" for="identifier"><?php _e( 'Identifiant: ', Oak::$text_domain ); ?></label> 
        <input name="identifier" type="text" class="oak_add_field_container__input oak_add_field_container__identifier">
    </div>

    <div class="oak_add_field_container__horizontal_container">
        <div class="oak_add_field_container__field_container oak_add_field_container__type_container">
            <label class="oak_add_field_container__label" for="nature"><?php _e( 'Nature/Type: ', Oak::$text_domain ); ?></label> 
            <select name="nature" type="text" class="oak_add_field_container__input oak_add_field_container__type">
                <option value="text">Text</option>
                <option value="textarea">Textarea</option>
                <option value="number">Number</option>
                <option value="email">Email</option>
                <option value="url">Url</option>
                <option value="password">Mot de passe</option>
                <option value="image">Image</option>
                <option value="file">Fichier</option>
                <option value="gallery">Gallerie</option>
                <option value="select">Select</option>
                <option value="checkbox">Checkbox</option>
            </select>
        </div>

        <div class="oak_add_field_container__field_container oak_add_field_container__function_container">
            <label class="oak_add_field_container__label" for="function"><?php _e( 'Fonction: ', Oak::$text_domain ); ?></label> 
            <select name="function" type="text" class="oak_add_field_container__input oak_add_field_container__function">
                <option value="Information/Description">Information/Description</option>
                <option value="Exemple">Exempel</option>
                <option value="Illustration">Illustration</option>
            </select>
        </div>
    </div>

    <div class="oak_add_field_container__field_container oak_add_field_container__default_value_container">
        <label class="oak_add_field_container__label" for="default-value"><?php _e( 'Valeur par défaut: ', Oak::$text_domain ); ?></label> 
        <input name="default-value" class="oak_add_field_container__input oak_add_field_container__default_value"></textarea>
    </div>

    <div class="oak_add_field_container__field_container oak_add_field_container__instructions_container">
        <label class="oak_add_field_container__label oak_add_field_container__label_instruction" for="instructions"><?php _e( 'Consignes de remplissage: ', Oak::$text_domain ); ?></label> 
        <textarea cols="30" rows="5" name="instructions" class="oak_add_field_container__input oak_add_field_container__instructions"></textarea>
    </div>

    <!-- If text or Textarea or number or Email or Url or Password -->
    <div class="oak_add_field_container__field_container oak_add_field_container__placeholder_container">
        <label class="oak_add_field_container__label" for="placeholder"><?php _e( 'Placeholder: ', Oak::$text_domain ); ?></label> 
        <input name="placeholder" type="text" class="oak_add_field_container__input oak_add_field_container__placeholder">
    </div>

    <!-- If textarea -->
    <div class="oak_add_field_container__horizontal_container">
        <div class="oak_add_field_container__field_container oak_add_field_container__before_container">
            <label class="oak_add_field_container__label" for="before"><?php _e( 'Avant: ', Oak::$text_domain ); ?></label> 
            <input name="before" type="text" class="oak_add_field_container__input oak_add_field_container__before">
        </div>

        <!-- If number or gallery-->
        <div class="oak_add_field_container__field_container oak_add_field_container__after_container">
            <label class="oak_add_field_container__label" for="after"><?php _e( 'Après: ', Oak::$text_domain ); ?></label> 
            <input name="after" type="text" class="oak_add_field_container__input oak_add_field_container__after">
        </div>
    </div>

    <!-- If text or textarea -->
    <div class="oak_add_field_container__horizontal_container">
        <div class="oak_add_field_container__field_container oak_add_field_container__max_length_container">
            <label class="oak_add_field_container__label" for="max-length"><?php _e( 'Longeur maximale: ', Oak::$text_domain ); ?></label> 
            <input name="max-length" type="number" class="oak_add_field_container__input oak_add_field_container__max_length">
        </div>

        <div class="oak_add_field_container__field_container oak_add_field_container__selector_container">
            <label class="oak_add_field_container__label" for="selector"><?php _e( 'Sélecteur de cadres RSE: ', Oak::$text_domain ); ?></label> 
            <input name="selector" type="check" class="oak_add_field_container__input oak_add_field_container__selector">
        </div>
    </div>

    <div class="oak_add_field_container__field_container oak_add_field_container__width_container">
        <label class="oak_add_field_container__label" for="width"><?php _e( 'Largeur en Pourcentage: ', Oak::$text_domain ); ?></label> 
        <input name="width" type="number" value="50" class="oak_add_field_container__input oak_add_field_container__width">
    </div>

    <div class="oak_add_field_container__add_button">
        <span><?php _e( 'Ajouter', Oak::$text_domain ); ?></span>
    </div>

    <div class="oak_add_field_container__fields_list">
        <?php 
        $fields = get_option('oak_custom_fields') ? get_option('oak_custom_fields') : [];
        foreach( $fields as $field ) : ?>
            <div class="oak_add_field_container__saved_field_container">
                <span><?php echo( $field['designation'] ); ?></span>
                <i field-identifier='<?php echo( $field['identifier'] ); ?>' class="oak_add_field_container__saved_field_container__delete_button fas fa-minus"></i>
            </div>
        <?php
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