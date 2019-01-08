<div class="oak_manage_tax_container">
    <div class="oak_tax_add_formula_container">
        <h3><?php _e( 'Ajouter une Taxonomie', Oak::$text_domain ); ?></h3>

        <div class="oak_tax_add_formula">

            <div class="oak_tax_add_formula__element">
                <label class="oak_tax_add_formula_element__label" for="slug"><?php  _e( 'Slug:', Oak::$text_domain ); ?></label>
                <input type="text" name="slug" class="oak_tax_add_formula_element__slug">
            </div>
            
            <div class="oak_tax_add_formula__element">
                <label class="oak_tax_add_formula_element__label" for="name"><?php _e( 'Nom de la Taxonomie:', Oak::$text_domain ); ?></label>
                <input type="text" name="name" id="oak_tax_name_input" class="oak_tax_add_formula_element__name">
            </div>

            <div class="oak_tax_add_formula__element">
                <label class="oak_tax_add_formula_element__label" for="single_name"><?php _e( 'Nom au singulier:', Oak::$text_domain ); ?></label>
                <input type="text" name="single_name" id="oak_tax_single_name_input" class="oak_tax_add_formula_element__single_name">
            </div>

            <div class="oak_tax_add_formula__element">
                <label class="publications-select" for="single_name"><?php _e('Modèle (CPT/Page):', Oak::$text_domain); ?></label>
                <?php
                $cpts = get_option('oak_custom_post_types') ? get_option('oak_custom_post_types') : [];
                ?>
                <select name="cpts-select" multiple class="oak_tax_add_formula_element__select_cpts">
                    <?php
                    foreach( $cpts as $single_cpt ) :
                        $name = str_replace( '\\', '', $single_cpt['name']);
                    ?>
                        <option value="<?php echo( $single_cpt['slug'] ); ?>"><?php echo( $name ); ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </div>

            <h3 class="acf-fields-select"><?php _e('Champs spécifiques', Oak::$text_domain); ?></h3>
            <div class="oak_tax_add_formula__element">
                <?php 
                $fields = get_option('oak_custom_fields') ? get_option('oak_custom_fields') : [];
                foreach( $fields as $field ) : ?>
                    <div class="oak_tax_add_formula_element__field_container">
                        <span class="oak_tax_add_formula_element_field_container__field_name"><?php echo( $field['designation'] ); ?></span>
                        <i class="fas fa-plus"></i>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>

            <div class="oak_tax_add_formula_element__specific_fields_container">
                <!-- This is gonna contain the fields -->
            </div>

            <button class="oak_tax_add_formula__add_button"><?php _e( 'Sauvegarder', Oak::$text_domain ); ?></button>
        </div>
    </div>

    <div class="oak_tax_list">
        <h3><?php _e( 'Liste des taxonomies:', Oak::$text_domain ); ?></h3>
        <?php $taxonomies = get_taxonomies(false, 'objects');
        $custom_taxonomies = get_option('oak_taxonomies') ? get_option('oak_taxonomies') : [];
        foreach ( $taxonomies as $key => $taxonomy ) : ?>
            <div class="oak_taxt_list__single_taxt">
                <span><?php echo( $taxonomy->name ); ?></span>
                <?php
                $exists = false;
                foreach( $custom_taxonomies as $custom_taxonomy ) :
                    if ( $custom_taxonomy['slug'] == $taxonomy->name )
                        $exists = true;
                endforeach;
                if ( $exists ) : ?>
                    <i class="fas fa-minus oak_tax_list_delete"></i>
                <?php
                endif;
                ?>
            </div>
            <?php
        endforeach;
        ?>
    </div>
</div>

<!-- For the modal -->
<div class="oak_tax_add_formula_modal_container">
    <div class="oak_tax_add_formula_modal_container__modal">
        <div class="oak_tax_add_formula_modal_container_modal__title_container">
            <h3 class="oak_tax_add_formula_modal_container_modal_title_container__title"></h3>
        </div>
        <span class="oak_tax_add_formula_modal_container_modal__error"></span>
        <div class="oak_tax_add_formula_modal_container_modal_buttons_container">
            <div class="oak_tax_add_formula_modal_container_modal_buttons_container__cancel_button_container">
                <span class="oak_tax_add_formula_modal_container_modal_buttons_container_cancel_button_container__text" >
                    Annuler
                </span>
            </div>
            
            <div class="oak_tax_add_formula_modal_container_modal_buttons_container__add_button_container">
                <span class="oak_tax_add_formula_modal_container_modal_buttons_container_add_button_container__text" >
                    Ajouter
                </span>
            </div>

            <div class="oak_tax_add_formula_modal_container_modal_buttons_container__ok_button_container">
                <span class="oak_tax_add_formula_modal_container_modal_buttons_container_add_button_container__text" >
                    Ok
                </span>
            </div>
        </div>
        
    </div>
    <div class="oak_loader oak_hidden"></div>
</div>