<div class="oak_object_model">
    <div class="oak_object_model_add_formula">
        <h1><?php _e('Ajouter un modèle d\'objet'); ?></h1>
        <div class="oak_object_model_add_formula__element">
            <label class="oak_object_model_add_formula_element__label" for="slug"><?php  _e( 'Slug:', Oak::$text_domain ); ?></label>
            <input type="text" name="slug" class="oak_object_model_add_formula_element__slug">
        </div>

        <div class="oak_object_model_add_formula__element">
            <label class="oak_object_model_add_formula_element__label" for="slug"><?php _e( 'Nom:', Oak::$text_domain ); ?></label>
            <input type="text" name="slug" class="oak_object_model_add_formula_element__name">
        </div>

        <div class="oak_object_model_add_formula__element">
            <label class="oak_object_model_add_formula_element__label" for="slug"><?php _e( 'Nom au singulier:', Oak::$text_domain ); ?></label>
            <input type="text" name="slug" class="oak_object_model_add_formula_element__singular_name">
        </div>

        <div class="oak_object_model_add_formula__element">
            <label class="oak_object_model_add_formula_element__label" for="slug"><?php _e( 'Description:', Oak::$text_domain ); ?></label>
            <input type="text" name="slug" class="oak_object_model_add_formula_element__description">
        </div>

        <div class="oak_object_model_add_formula__element">
            <label class="oak_object_model_add_formula_element__label" for="slug"><?php  _e( 'Icone:', Oak::$text_domain ); ?></label>
            <input type="text" name="slug" class="oak_object_model_add_formula_element__icon" placeholder="<?php _e( 'dashicons', Oak::$text_domain ); ?>">
        </div>

        <div class="oak_object_model_add_formula__element">
            <label class="oak_object_model_add_formula_element__label" for="single_name"><?php _e('Publication à laquelle appartient l\'objet: ', Oak::$text_domain); ?></label>
            <?php
            $the_query = new WP_Query( array( 'post_type'=> 'publication' ) );
            $publications = $the_query->posts;
            ?>
            <select name="publications-select" class="oak_object_model_add_formula_element__select_publication">
                <?php
                foreach( $publications as $single_publication ) : 
                    $post_title = str_replace('\\', '', $single_publication->post_title);
                ?>
                    <option value="<?php echo( $single_publication->ID ); ?>"><?php echo( $post_title ); ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>

        <div class="oak_object_model_add_formula__element">
            <label class="oak_object_model_add_formula_element__label" for="single_name"><?php _e('L\'ensemble des indicateurs à lesquelles l\'objet pourra être associé: ', Oak::$text_domain); ?></label>
            <?php
            $the_query = new WP_Query( array( 'post_type'=> 'quali_indic' ) );
            $the_query_quanti = new WP_Query( array( 'post_type'=> 'quanti_indic' ) );
            $quali_indicators = $the_query->posts;
            $quanti_indicators = $the_query_quanti->posts;
            $indicators = array_merge( $quali_indicators, $quanti_indicators );
            ?>
            <select multiple name="indicators-select" class="oak_object_model_add_formula_element__select_indicators">
                <?php
                foreach ( $indicators as $single_indicator ) : ?>
                    <option value="<?php echo( $single_indicator->ID ); ?>"><?php echo( $single_indicator->post_title ); ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>

        <h3 class="acf-fields-select"><?php _e('Champs spécifiques', Oak::$text_domain); ?></h3>
        <div class="oak_object_model_add_formula__element">
            
            <!-- <div class="oak_object_model_add_formula_element__field_container">
                <span class="oak_object_model_add_formula_element_field_container__field_name">Selecteur pour type</span>
                <i class="fas fa-plus"></i>
            </div> -->
            <div class="oak_object_model_add_formula_element__field_container">
                <span class="oak_object_model_add_formula_element_field_container__field_name">Essentiel</span>
                <i class="fas fa-plus"></i>
            </div>

            <!-- <div class="oak_object_model_add_formula_element__field_container">
                <span class="oak_object_model_add_formula_element_field_container__field_name">Couleur</span>
                <i class="fas fa-plus"></i>
            </div> -->
        </div>

        <div class="oak_object_model_add_formula_element__specific_fields_container">
            <!-- This is gonna contain the fields -->
        </div>

        <button class="oak_object_model_add_formula__save"><?php _e( 'Sauvegarder', Oak::$text_domain ); ?></button>
    </div>

    <div class="oak_object_model__custom_post_types_lists">
        <h1 class="oak_object_model_custom_post_types_lists__title"><?php _e('Liste des modèles d\'objets'); ?></h1>
        <?php
        $custom_post_types = get_option('oak_custom_post_types') ? get_option('oak_custom_post_types') : [];
        foreach( $custom_post_types as $custom_post_type ) : ?>
            <div class="oak_object_model__custom_post_types_lists__single_post_type_container">
                <span class="oak_object_model__custom_post_types_lists_single_post_type_container__name"><?php echo( $custom_post_type['slug'] ); ?></span>
                <i class="oak_object_model__custom_post_types_lists_single_post_type_container__delete_button fas fa-minus"></i>
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
    <div class="oak_loader oak_hidden"></div>
</div>