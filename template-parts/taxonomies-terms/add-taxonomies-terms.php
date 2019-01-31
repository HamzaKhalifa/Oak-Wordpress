<?php
include get_template_directory() . '/template-parts/oak-admin-header.php'; 
$taxonomy_identifier = explode( '_', $_GET['page'] )[3];
$which_taxonomy;
foreach( Oak::$taxonomies_without_redundancy as $tax ) :
    if ( $tax->taxonomy_identifier == $taxonomy_identifier ) :
        $which_taxonomy = $tax;
    endif;
endforeach;
?>

<div class="oak_add_field_container__header">
    <img class="oak_add_field_container_header_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
    <h3 class="oak_add_field_container__title"><?php _e( 'Ajouter une Terminologie', Oak::$text_domain ); ?></h3>
</div>

<div class="oak_add_field_big_container">
    <div class="oak_add_field_container">
        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="designation"><?php _e( 'Désignation du terme: ', Oak::$text_domain ); ?></label> 
                <input name="designation" <?php if ( count( $revisions ) > 0 ) : echo('disabled'); endif; ?> type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->term_designation ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__designation">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="identifier"><?php _e( 'Identifiant Unique: ', Oak::$text_domain ); ?></label> 
                <input disabled name="identifier" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->term_identifier ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__identifier">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container <?php if ( $which_taxonomy->taxonomy_numerotation != 'true' ) : echo('oak_hidden'); endif; ?>">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation"><?php _e( 'Numerotation du terme: ', Oak::$text_domain ); ?></label> 
                <input class="oak_add_field_container__input oak_add_field_container__numerotation" type="number" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->term_numerotation ); endif; ?>">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container <?php if ( $which_taxonomy->taxonomy_title != 'true' ) : echo('oak_hidden'); endif; ?> ">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation"><?php _e( 'Titre du terme: ', Oak::$text_domain ); ?></label> 
                <input class="oak_add_field_container__input oak_add_field_container__term_title" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->term_title ); endif; ?>">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container <?php if ( $which_taxonomy->taxonomy_term_description != 'true' ) : echo('oak_hidden'); endif; ?>">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="description"><?php _e( 'Description du terme: ', Oak::$text_domain ); ?></label> 
                <textarea class="oak_add_field_container__input oak_add_field_container__description" name="description" id="" cols="30" rows="10"><?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->term_description ); endif; ?></textarea>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container <?php if ( $which_taxonomy->taxonomy_color != 'true' ) : echo('oak_hidden'); endif; ?> ">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation"><?php _e( 'Couleur du terme: ', Oak::$text_domain ); ?></label> 
                <input type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->term_color ); else : echo('#bada55'); endif; ?>" class="oak_add_field_container__color" />
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container <?php if ( $which_taxonomy->taxonomy_logo != 'true' ) : echo('oak_hidden'); endif; ?> ">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation"><?php _e( 'Logo du terme: ', Oak::$text_domain ); ?></label> 
                <input class="oak_add_field_container__input oak_add_field_container__logo" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( $revisions[ count( $revisions ) - 1 ]->term_logo ); endif; ?>">
            </div>
        </div>
        
        <div class="oak_add_field_container__buttons">
            <div class="oak_add_field_container_buttons__right_buttons">
                <?php 
                if ( isset( $_GET['term_identifier'] ) ) : ?>
                    <div class="oak_add_field_container__trash_button">
                        <span><?php _e( 'Envoyer à la corbeille', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>

                <?php 
                if ( isset( $_GET['term_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->term_state == 1 ) : ?>
                    <div class="oak_add_field_container__draft_button">
                        <span><?php _e( 'Retour à l\'état de Brouillon', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>
                

                <?php 
                if ( isset( $_GET['term_identifier'] ) ) : 
                    $add_text = '';
                    if ( $revisions[ count( $revisions ) - 1 ]->term_state == 0 ) :
                        $add_text = 'Sauvegarder le brouillon';
                    elseif ( $revisions[ count( $revisions ) - 1 ]->term_state == 1 ) :
                        $add_text = 'Enregistrer';
                    else :
                        $add_text = 'Mettre à jour';
                    endif;
                    ?>
                    <div class="oak_add_field_container__update_button">
                        <span><?php echo( $add_text ); ?></span>
                    </div>
                <?php
                else : ?>
                    <div class="oak_add_field_container__add_button">
                        <span><?php _e( 'Ajouter au Brouillon', Oak::$text_domain ); ?></span>
                    </div>
                <?php
                endif; 
                ?>
                
                <div class="oak_add_field_container__register_button <?php if ( isset( $_GET['term_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->term_state == 1 ) : echo( 'oak_hidden' ); endif; ?>">
                    <?php 
                    $text = 'Enregistrer';
                    if ( isset( $_GET['term_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->term_state == '2' ) :
                        $text = 'Retour à l\'état enregistré';
                    endif;
                    ?>
                    <span><?php echo( $text ); ?></span>
                </div>

                <?php
                if ( isset( $_GET['term_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->term_state == '1' ) : ?>
                    <div class="oak_add_field_container__broadcast_button">
                        <span><?php _e( 'Diffuser', Oak::$text_domain ); ?></span>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
    
    <div class="oak_add_field_big_container__tabs">
        <div class="oak_add_field_big_container_tabs__titles">
            <h4 class="oak_add_field_big_container_tabs_titles__single_title oak_add_field_big_container_tabs_titles__single_title_selected"><?php _e( 'Champ', Oak::$text_domain ); ?></h4>
        </div>

        <div class="oak_add_field_big_container_tabs__single_tab">
            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Status et Visibilité: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state_label"><?php _e( 'Etat: ', Oak::$text_domain ); ?></span>
                    <?php 
                    $state = 'Brouillon';
                    if ( isset( $_GET['term_identifier'] ) ) :
                        if ( $revisions[ count( $revisions ) - 1 ]->term_state == 0 ) : 
                            $state = 'Brouillon';
                        elseif ( $revisions[ count( $revisions ) - 1 ]->term_state == '1' ) :
                            $state = 'Enregistré';
                        else : 
                            $state = 'Diffusé';
                        endif;
                    endif;
                    ?>
                    <span><?php echo( $state ); ?></span>
                </div>

                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state_label"><?php _e( 'Révisions: ', Oak::$text_domain ); ?></span>
                    <div class="oak_add_field_big_container_tabs_single_tab_section_state__info_container">
                        <span><?php 
                            if ( count( $revisions ) > 0 ) :
                                echo( count( $revisions ) - 1 );
                            else :
                                echo('0');
                            endif; 
                            ?>
                        </span>
                        <span class="oak_add_field_big_container_tabs_single_tab_section_state__browse">
                            <?php _e( 'Parcourir', Oak::$text_domain ); ?>
                        </span>
                    </div>
                </div>
                <?php
                    $registration_date = $broadcast_date = __( 'Pas encore', Oak::$text_domain );

                    if ( count( $revisions ) > 0 ) :
                        $last_revision = $revisions[ count( $revisions ) - 1 ];
                        if ( $last_revision->term_state == 1 ) :
                            $registration_date = $last_revision->term_modification_time;
                        elseif ( $last_revision->term_state == 2 ) :
                            $broadcast_date = $last_revision->term_modification_time;
                            $index = 0;
                            for ( $i = count( $revisions ) - 2; $i >= 0; $i-- ) :
                                if ( $revisions[ $i ]->term_state == 1 ) :
                                    $registration_date = $revisions[ $i ]->term_modification_time;
                                endif;
                            endfor;
                        endif;
                    endif;
                ?>
                
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state_label"><?php _e( 'Enregistré le: ', Oak::$text_domain ); ?></span>
                    <?php 
                    ?>
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state__info"><?php echo( $registration_date ); ?></span>
                </div>

                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state_label"><?php _e( 'Diffusé le: ', Oak::$text_domain ); ?></span>
                    <?php 
                    ?>
                    <span class="oak_add_field_big_container_tabs_single_tab_section_state__info"><?php echo( $broadcast_date ); ?></span>
                </div>
            </div>

            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Organisations: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>

            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Organisations: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>

            <div class="oak_add_field_big_container_tabs_single_tab__section">
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'terms: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- For the modal -->
<div class="oak_object_model_add_formula_modal_container">
    <div class="oak_object_model_add_formula_modal_container__modal">
        <div class="oak_object_model_add_formula_modal_container_modal__title_container">
            <h3 class="oak_object_model_add_formula_modal_container_modal_title_container__title"></h3>
        </div>

        <div class="oak_object_model_add_formula_modal_container__modal_content">

            <!-- For the browse revisions functionality -->
            <div class="oak_object_model_add_formula_modal_container_modal_content__revisions_content oak_hidden">
                <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content__current">
                    <h3><?php _e( 'Données Actuelle', Oak::$text_domain); ?></h3>
                    <!-- List of fields here -->
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Numérotation:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_current_numerotation" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Titre:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_current_title" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Description:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_current_description" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Couleur:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_current_color" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Logo:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_current_logo" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label for="state"><?php _e( 'Etat:', Oak::$text_domain ); ?></label>
                        <input name="state" type="text" disabled class="oak_revision_term_current_state" value="">
                    </div>

                </div>

                <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content__revision_data_container">
                    <h3><?php _e( 'Données de la révision', Oak::$text_domain); ?></h3>
                    <!-- List of forms here -->
                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Numérotation:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_revision_numerotation" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Titre:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_revision_title" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Description:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_revision_description" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Couleur:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_revision_color" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Logo:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_revision_logo" value="">
                    </div>

                    <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_revision_data_container__single_data">
                        <label><?php _e( 'Etat:', Oak::$text_domain ); ?></label>
                        <input type="text" disabled class="oak_revision_term_revision_state" value="">
                    </div>
                    
                </div>

                <div class="oak_object_model_add_formula_modal_container_modal_content_revisions_content__list_of_revisions">
                    <h3><?php _e( 'Liste des révisions', Oak::$text_domain ); ?></h3>
                    <?php 
                    foreach( $revisions as $key => $revision ) : 
                        if ( $key != count( $revisions ) - 1 ) :
                        ?>
                            <div index="<?php echo( $key ) ?>" class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                <span class="oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( $revision->term_modification_time ); ?></span>
                            </div>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
            <!-- Done with the browse revisions Functionality -->
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