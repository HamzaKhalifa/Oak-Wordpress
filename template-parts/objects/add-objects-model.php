<div class="dawn_object_model">
    <div class="dawn_object_model_add_formula">
        <h1><?php _e('Ajouter un modèle d\'objet'); ?></h1>
        <div class="dawn_object_model_add_formula__element">
            <label class="dawn_object_model_add_formula_element__label" for="slug"><?php  _e( 'Slug:', Dawn::$text_domain ); ?></label>
            <input type="text" name="slug" class="dawn_object_model_add_formula_element__slug">
        </div>

        <div class="dawn_object_model_add_formula__element">
            <label class="dawn_object_model_add_formula_element__label" for="slug"><?php _e( 'Nom:', Dawn::$text_domain ); ?></label>
            <input type="text" name="slug" class="dawn_object_model_add_formula_element__name">
        </div>

        <div class="dawn_object_model_add_formula__element">
            <label class="dawn_object_model_add_formula_element__label" for="slug"><?php _e( 'Nom au singulier:', Dawn::$text_domain ); ?></label>
            <input type="text" name="slug" class="dawn_object_model_add_formula_element__singular_name">
        </div>

        <div class="dawn_object_model_add_formula__element">
            <label class="dawn_object_model_add_formula_element__label" for="slug"><?php _e( 'Description:', Dawn::$text_domain ); ?></label>
            <input type="text" name="slug" class="dawn_object_model_add_formula_element__description">
        </div>

        <div class="dawn_object_model_add_formula__element">
            <label class="dawn_object_model_add_formula_element__label" for="slug"><?php  _e( 'Icone:', Dawn::$text_domain ); ?></label>
            <input type="text" name="slug" class="dawn_object_model_add_formula_element__icon" placeholder="<?php _e( 'dashicons', Dawn::$text_domain ); ?>">
        </div>

        <div class="dawn_object_model_add_formula__element">
            <label class="dawn_object_model_add_formula_element__label" for="single_name"><?php _e('Publication à laquelle appartient l\'objet: ', Dawn::$text_domain); ?></label>
            <?php
            $the_query = new WP_Query( array( 'post_type'=> 'publication' ) );
            $publications = $the_query->posts;
            ?>
            <select name="publications-select" class="dawn_object_model_add_formula_element__select_publication">
                <?php
                foreach( $publications as $single_publication ) : ?>
                    <option value="<?php echo( $single_publication->ID ); ?>"><?php echo( $single_publication->post_title ); ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>

        <div class="dawn_object_model_add_formula__element">
            <label class="dawn_object_model_add_formula_element__label" for="single_name"><?php _e('L\'ensemble des indicateurs à lesquelles l\'objet pourra être associé: ', Dawn::$text_domain); ?></label>
            <?php
            $the_query = new WP_Query( array( 'post_type'=> 'quali_indic' ) );
            $the_query_quanti = new WP_Query( array( 'post_type'=> 'quanti_indic' ) );
            $quali_indicators = $the_query->posts;
            $quanti_indicators = $the_query_quanti->posts;
            $indicators = array_merge( $quali_indicators, $quanti_indicators );
            ?>
            <select multiple name="indicators-select" class="dawn_object_model_add_formula_element__select_indicators">
                <?php
                foreach ( $indicators as $single_indicator ) : ?>
                    <option value="<?php echo( $single_indicator->ID ); ?>"><?php echo( $single_indicator->post_title ); ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>

        <h3 class="acf-fields-select"><?php _e('Champs spécifiques', Dawn::$text_domain); ?></h3>
        <div class="dawn_object_model_add_formula__element">
            
            <!-- <div class="dawn_object_model_add_formula_element__field_container">
                <span class="dawn_object_model_add_formula_element_field_container__field_name">Selecteur pour type</span>
                <i class="fas fa-plus"></i>
            </div> -->
            <div class="dawn_object_model_add_formula_element__field_container">
                <span class="dawn_object_model_add_formula_element_field_container__field_name">Essentiel</span>
                <i class="fas fa-plus"></i>
            </div>

            <!-- <div class="dawn_object_model_add_formula_element__field_container">
                <span class="dawn_object_model_add_formula_element_field_container__field_name">Couleur</span>
                <i class="fas fa-plus"></i>
            </div> -->
        </div>

        <div class="dawn_object_model_add_formula_element__specific_fields_container">
            <!-- This is gonna contain the fields -->
        </div>

        <button class="dawn_object_model_add_formula__save"><?php _e( 'Sauvegarder', Dawn::$text_domain ); ?></button>
    </div>

    <div class="dawn_object_model__custom_post_types_lists">
        <h1 class="dawn_object_model_custom_post_types_lists__title"><?php _e('Liste des modèles d\'objets'); ?></h1>
        <?php
        $custom_post_types = get_option('dawn_custom_post_types') ? get_option('dawn_custom_post_types') : [];
        foreach( $custom_post_types as $custom_post_type ) : ?>
            <div class="dawn_object_model__custom_post_types_lists__single_post_type_container">
                <span class="dawn_object_model__custom_post_types_lists_single_post_type_container__name"><?php echo( $custom_post_type['slug'] ); ?></span>
                <i class="dawn_object_model__custom_post_types_lists_single_post_type_container__delete_button fas fa-minus"></i>
            </div>
            <?php
        endforeach;
        ?>
    </div>
</div>


<!-- For the modal -->
<div class="dawn_object_model_add_formula_modal_container">
    <div class="dawn_object_model_add_formula_modal_container__modal">
        <div class="dawn_object_model_add_formula_modal_container_modal__title_container">
            <h3 class="dawn_object_model_add_formula_modal_container_modal_title_container__title"></h3>
        </div>
        <span class="dawn_object_model_add_formula_modal_container_modal__error"></span>
        <div class="dawn_object_model_add_formula_modal_container_modal_buttons_container">
            <div class="dawn_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container">
                <span class="dawn_object_model_add_formula_modal_container_modal_buttons_container_cancel_button_container__text" >
                    Annuler
                </span>
            </div>
            
            <div class="dawn_object_model_add_formula_modal_container_modal_buttons_container__add_button_container">
                <span class="dawn_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text" >
                    Ajouter
                </span>
            </div>

            <div class="dawn_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container">
                <span class="dawn_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text" >
                    Ok
                </span>
            </div>
        </div>
        
    </div>
    <div class="dawn_loader dawn_hidden"></div>
</div>