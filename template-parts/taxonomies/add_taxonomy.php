<?php 
// var_dump( get_option('dawn_taxonomies') );
?>
<div class="dawn_manage_tax_container">
    <div class="dawn_tax_add_formula_container">
        <h3><?php _e( 'Ajouter une Taxonomie', Dawn::$text_domain ); ?></h3>

        <div class="dawn_tax_add_formula">

            <div class="dawn_tax_add_formula__element">
                <label class="dawn_tax_add_formula_element__label" for="slug"><?php  _e( 'Slug:', Dawn::$text_domain ); ?></label>
                <input type="text" name="slug" class="dawn_tax_add_formula_element__slug">
            </div>
            
            <div class="dawn_tax_add_formula__element">
                <label class="dawn_tax_add_formula_element__label" for="name"><?php _e( 'Nom de la Taxonomie:', Dawn::$text_domain ); ?></label>
                <input type="text" name="name" id="dawn_tax_name_input" class="dawn_tax_add_formula_element__name">
            </div>

            <div class="dawn_tax_add_formula__element">
                <label class="dawn_tax_add_formula_element__label" for="single_name"><?php _e( 'Nom au singulier:', Dawn::$text_domain ); ?></label>
                <input type="text" name="single_name" id="dawn_tax_single_name_input" class="dawn_tax_add_formula_element__single_name">
            </div>

            <div class="dawn_tax_add_formula__element">
                <label class="publications-select" for="single_name"><?php _e('Modèle (CTP/Page):', Dawn::$text_domain); ?></label>
                <?php
                $cpts = get_option('dawn_custom_post_types') ? get_option('dawn_custom_post_types') : [];
                ?>
                <select name="cpts-select" class="dawn_tax_add_formula_element__select_cpts">
                    <?php
                    foreach( $cpts as $single_cpt ) : ?>
                        <option value="<?php echo( $single_cpt['slug'] ); ?>"><?php echo( $single_cpt['name'] ); ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </div>

            <h3 class="acf-fields-select"><?php _e('Champs spécifiques', Dawn::$text_domain); ?></h3>
            <div class="dawn_tax_add_formula__element">
                
                <div class="dawn_tax_add_formula_element__field_container">
                    <span class="dawn_tax_add_formula_element_field_container__field_name">Selecteur pour type</span>
                    <i class="fas fa-plus"></i>
                </div>

                <div class="dawn_tax_add_formula_element__field_container">
                    <span class="dawn_tax_add_formula_element_field_container__field_name">Parent</span>
                    <i class="fas fa-plus"></i>
                </div>

                <div class="dawn_tax_add_formula_element__field_container">
                    <span class="dawn_tax_add_formula_element_field_container__field_name">Couleur</span>
                    <i class="fas fa-plus"></i>
                </div>
            </div>

            <div class="dawn_tax_add_formula_element__specific_fields_container">
                <!-- This is gonna contain the fields -->
            </div>

            <button class="dawn_tax_add_formula__add_button"><?php _e( 'Sauvegarder', Dawn::$text_domain ); ?></button>
        </div>
    </div>

    <div class="dawn_tax_list">
        <h3><?php _e( 'Liste des taxonomies:', Dawn::$text_domain ); ?></h3>
        <?php $taxonomies = get_taxonomies(false, 'objects');
        $custom_taxonomies = get_option('dawn_taxonomies');
        // echo('<pre>');
        // var_dump( $custom_taxonomies );
        // echo('</pre>');
        foreach ( $taxonomies as $key => $taxonomy ) : ?>
            <div class="dawn_taxt_list__single_taxt">
                <span><?php echo( $taxonomy->name ); ?></span>
                <?php
                $exists = false;
                foreach( $custom_taxonomies as $custom_taxonomy ) :
                    if ( $custom_taxonomy['slug'] == $taxonomy->name )
                        $exists = true;
                endforeach;
                if ( $exists ) : ?>
                    <i class="fas fa-minus dawn_tax_list_delete"></i>
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
<div class="dawn_tax_add_formula_modal_container">
    <div class="dawn_tax_add_formula_modal_container__modal">
        <div class="dawn_tax_add_formula_modal_container_modal__title_container">
            <h3 class="dawn_tax_add_formula_modal_container_modal_title_container__title"></h3>
        </div>
        <span class="dawn_tax_add_formula_modal_container_modal__error"></span>
        <div class="dawn_tax_add_formula_modal_container_modal_buttons_container">
            <div class="dawn_tax_add_formula_modal_container_modal_buttons_container__cancel_button_container">
                <span class="dawn_tax_add_formula_modal_container_modal_buttons_container_cancel_button_container__text" >
                    Annuler
                </span>
            </div>
            
            <div class="dawn_tax_add_formula_modal_container_modal_buttons_container__add_button_container">
                <span class="dawn_tax_add_formula_modal_container_modal_buttons_container_add_button_container__text" >
                    Ajouter
                </span>
            </div>

            <div class="dawn_tax_add_formula_modal_container_modal_buttons_container__ok_button_container">
                <span class="dawn_tax_add_formula_modal_container_modal_buttons_container_add_button_container__text" >
                    Ok
                </span>
            </div>
        </div>
        
    </div>
    <div class="dawn_loader dawn_hidden"></div>
</div>