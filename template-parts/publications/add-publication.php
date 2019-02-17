<?php
include get_template_directory() . '/template-parts/oak-admin-header.php'; 
?>

<div class="oak_add_field_container__header">
    <img class="oak_add_field_container_header_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
    <h3 class="oak_add_field_container__title"><?php _e( 'Ajouter une Publication', Oak::$text_domain ); ?></h3>
</div>
    
<div class="oak_add_field_big_container">
    <div class="oak_add_field_container">
        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="designation"><?php _e( 'Désignation de la publication: ', Oak::$text_domain ); ?></label> 
                <input name="designation" <?php if ( count( $revisions ) > 0 ) : echo('disabled'); endif; ?> type="text" value="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->publication_designation ) ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__designation">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="identifier"><?php _e( 'Identifiant Unique: ', Oak::$text_domain ); ?></label> 
                <input disabled name="identifier" type="text" value="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->publication_identifier ) ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__identifier">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="organization"><?php _e( 'Organisation émettrice de la publication: ', Oak::$text_domain ); ?></label> 
                <select class="oak_add_field_container__organization" name="" id="">
                    <?php 
                    foreach( Oak::$organizations as $organization ) : ?>
                        <option <?php if( count( $revisions ) > 1 ) : if( $revisions[ count( $revisions ) - 1 ]->publication_organization == $organization->organization_identifier ) : echo('selected'); endif; endif; ?> value="<?php echo ( $organization->organization_identifier ) ?>"><?php echo( $organization->organization_designation ); ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="year"><?php _e( 'Année de la publication: ', Oak::$text_domain ); ?></label> 
                <input name="year" type="number" value="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->publication_year ) ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__year">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="headpiece"><?php _e( 'Vignette: ', Oak::$text_domain ); ?></label> 
                <input name="headpiece" type="file" class="oak_add_logo" onChange="readUrl(this)">
                <img src="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->publication_headpiece ) ); endif; ?>" class="oak_add_field_container__headpiece_img" alt="">
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="format"><?php _e( 'Format de la publication: ', Oak::$text_domain ); ?></label>
                <select name="format" type="text" class="oak_add_field_container__input oak_add_field_container__format">
                    <option value="pdf-file"><?php _e( 'Fichier PDF', Oak::$text_domain ); ?></option>
                    <option value="epub"><?php _e( 'ePub', Oak::$text_domain ); ?></option>
                    <option value="web"><?php _e( 'WEB', Oak::$text_domain ); ?></option>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="file"><?php _e( 'Fichier de la publication: ', Oak::$text_domain ); ?></label> 
                <input name="file" type="file" src="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->publication_file ) ); endif; ?>" class="oak_add_field_container__input oak_add_field_container__file">
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="description"><?php _e( 'Description: ', Oak::$text_domain ); ?></label> 
                <textarea class="oak_add_field_container__input oak_add_field_container__description" name="description" id="" cols="30" rows="10"><?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->publication_description ) ); endif; ?></textarea>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="report-or-frame"><?php _e( 'Rapport d’entreprise ou Cadre RSE: ', Oak::$text_domain ); ?></label>
                <select name="report-or-frame" class="oak_add_field_container__input oak_add_field_container__report_or_frame">
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_report_or_frame == 'report' ) : echo('selected'); endif; endif; ?> value="report"><?php _e( 'Rapport d\'entreprise', Oak::$text_domain ) ?></option>
                    <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_report_or_frame == 'frame' ) : echo('selected'); endif; endif; ?> value="frame"><?php _e( 'Cadre RSE' ) ?></option>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container oak_add_field_container__frame_type_container <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_report_or_frame != 'frame' ) : echo('oak_hidden'); endif; endif; if( count( $revisions ) <= 0 ) : echo('oak_hidden'); endif; ?>" >
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
            <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="frame-type"><?php _e( 'Type de cadre: ', Oak::$text_domain ); ?></label>
                <select name="frame-type" type="text" class="oak_add_field_container__input oak_add_field_container__frame_type">
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'universal-frame' ) : echo('selected'); endif; endif; ?> value="universal-frame"><?php _e( 'Cadres universels', Oak::$text_domain ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'normes-and-sectorial-initiatives' ) : echo('selected'); endif; endif; ?>value="normes-and-sectorial-initiatives"><?php _e( 'Normes et inititives sectorielles (Déploiement)', Oak::$text_domain ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'directive-lines' ) : echo('selected'); endif; endif; ?>value="directive-lines"><?php _e( 'Lignes directrices et cadres de référence (Reporting)', Oak::$text_domain ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'evaluation-initiatives' ) : echo('selected'); endif; endif; ?>value="evaluation-initiatives"><?php _e( 'Initiatives d\'évaluation (Notation)', Oak::$text_domain ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'extra-finantial-notation' ) : echo('selected'); endif; endif; ?>value="extra-finantial-notation"><?php _e( 'Notation extra financière (Classement)', Oak::$text_domain ); ?></option>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container oak_add_field_container__report_type_container <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_report_or_frame == 'frame' ) : echo('oak_hidden'); endif; endif; ?>">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
            <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="frame-type"><?php _e( 'Type de rapport: ', Oak::$text_domain ); ?></label>
                <select name="frame-type" type="text" class="oak_add_field_container__input oak_add_field_container__report_type">
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'reference-document' ) : echo('selected'); endif; endif; ?> value="reference-document"><?php _e( 'Document de référence', Oak::$text_domain ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'annual-report' ) : echo('selected'); endif; endif; ?>value="annual-report"><?php _e( 'Rapport annuel', Oak::$text_domain ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'integrated-reporting' ) : echo('selected'); endif; endif; ?>value="integrated-reporting"><?php _e( 'Reporting intégré', Oak::$text_domain ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'evaluation-initiatives' ) : echo('selected'); endif; endif; ?>value="evaluation-initiatives"><?php _e( 'Initiatives d’évaluation (Notation)', Oak::$text_domain ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'rse-reporting' ) : echo('selected'); endif; endif; ?>value="rse-reporting"><?php _e( 'Reporting RSE', Oak::$text_domain ); ?></option>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container oak_add_field_container__sectorial_frame_container <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_report_or_frame != 'frame' ) : echo('oak_hidden'); endif; endif; if( count( $revisions ) <= 0 ) : echo('oak_hidden'); endif;?>">
            <div class="oak_add_field_container__field_container oak_left_field oak_add_field_container__designation_container">
                <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="frame-type"><?php _e( 'Cadre sectoriel ? ', Oak::$text_domain ); ?></label>
                    <input <?php if ( count( $revisions ) > 0 ) : if( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_frame == 'true' ) : echo('checked'); endif; endif; ?> type="checkbox" class="oak_add_field_container__sectorial_frame">
                </div>
            </div>

            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container oak_add_field_container__sectors_container <?php if( count( $revisions ) > 0 ) : if( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_frame != 'true' ) : echo('oak_hidden'); endif; else : echo('oak_hidden'); endif; ?> ">
                <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="sectors"><?php _e( 'Secteur d\'activité du Cadre: ', Oak::$text_domain ); ?></label>
                    <input value="<?php if ( count( $revisions ) > 0 ) : echo ( esc_attr( $revisions[ count( $revisions ) - 1 ]->publication_sectors ) ); endif; ?>" type="text" class="oak_add_field_container__sectors">
                </div>
            </div>
        </div>

        
        <div class="oak_add_field_container__horizontal_container oak_add_field_container__local_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container oak_left_field">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="local"><?php _e( 'Publication locale ? ', Oak::$text_domain ); ?></label> 
                <input name="local" type="checkbox" <?php if ( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->publication_local == 'true' ) : echo('checked'); endif; ?> class="oak_add_field_container__input oak_add_field_container__local">
            </div>
            <?php 
            $countries = Oak::oak_get_countries_names();
            ?>
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container oak_country_select_container <?php if ( count( $revisions ) > 0 && $revisions[ count( $revisions ) - 1 ]->publication_local != 'true' ) : echo('oak_hidden'); endif; if( count( $revisions ) <= 0 ) : echo('oak_hidden'); endif; ?>">
                <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="sectors"><?php _e( 'Pays de la publication: ', Oak::$text_domain ); ?></label> 
                <select class="oak_add_field_container__country" id="">
                    <?php 
                        foreach( $countries as $country ) : ?>
                            <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_country == $country ) : echo('selected'); endif; endif; ?> value="<?php echo( $country ); ?>"><?php echo( $country ); ?></option>
                            <?php
                        endforeach;
                    ?>
                </select>
            </div>
        </div>


        <div class="oak_add_field_container__horizontal_container">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
            <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="frame-type"><?php _e( 'Langue de la publication ? ', Oak::$text_domain ); ?></label>
                <?php 
                $languages = Oak::oak_get_languages();
                ?>
                <select class="oak_add_field_container__language" id="">
                    <?php 
                        foreach( $languages as $language ) : ?>
                            <option <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_language == $language ) : echo('selected'); endif; endif; ?> value="<?php echo( $language ); ?>"><?php echo( $language ); ?></option>
                            <?php
                        endforeach;
                    ?>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container oak_add_field_container__gri_type_container <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_report_or_frame == 'frame' ) : echo('oak_hidden'); endif; endif; ?>">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
            <label class="oak_add_field_container__label oak_add_field_container__label_designation" for="gri-type"><?php _e( 'Type GRI de rapport', Oak::$text_domain ); ?></label>
                <select class="oak_add_field_container__gri_type" id="">
                    <option value=""></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'no-gri' ) : echo('selected'); endif; endif; ?> value="no-gri"><?php _e( 'Non - GRI' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'citing-gri' ) : echo('selected'); endif; endif; ?> value="citing-gri"><?php _e( 'Citing - GRI' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'gri-referenced' ) : echo('selected'); endif; endif; ?> value="gri-referenced'"><?php _e( 'GRI - Referenced' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_gri_type == 'gri-standards' ) : echo('selected'); endif; endif; ?> value="gri-standards"><?php _e( 'GRI - Standards' ); ?></option>
                </select>
            </div>
        </div>

        <div class="oak_add_field_container__horizontal_container oak_add_field_container__sectorial_supplement_container <?php if ( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_report_or_frame == 'frame' ) : echo('oak_hidden'); endif; endif; ?>">
            <div class="oak_add_field_container__field_container oak_add_field_container__designation_container">
            <label class="oak_add_field_container__label oak_add_field_container__label_designation"><?php _e( 'Supplément sectoriel', Oak::$text_domain ); ?></label>
                <select class="oak_add_field_container__sectorial_supplement" id="">
                    <option value=""></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'euss' ) : echo('selected'); endif; endif; ?> value="euss"><?php _e( 'Services d’électricité (EUSS)' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'fsss' ) : echo('selected'); endif; endif; ?> value="fsss"><?php _e( 'Services financiers (FSSS)' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'fpsss' ) : echo('selected'); endif; endif; ?> value="fpsss"><?php _e( 'Préparation alimentaire (FPSS)' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'mmss' ) : echo('selected'); endif; endif; ?> value="mmss"><?php _e( 'Mines et métaux (MMSS)' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'ngoss' ) : echo('selected'); endif; endif; ?> value="ngoss"><?php _e( 'ONG (NGOSS)' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'aoss' ) : echo('selected'); endif; endif; ?> value="aoss"><?php _e( 'Opérateurs aéroportuaires (AOSS)' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'cress' ) : echo('selected'); endif; endif; ?> value="cress"><?php _e( 'Construction et Immobilier (CRESS)' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'eoss' ) : echo('selected'); endif; endif; ?> value="eoss"><?php _e( 'Organisateur événementiels (EOSS)' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'ogss' ) : echo('selected'); endif; endif; ?> value="ogss"><?php _e( 'Pétrole et gaz (OGSS)' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'mss' ) : echo('selected'); endif; endif; ?> value="mss"><?php _e( 'Médias (MSS)' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'not-used' ) : echo('selected'); endif; endif; ?> value="not-used"><?php _e( 'Non-utilisé' ); ?></option>
                    <option <?php if( count( $revisions ) > 0 ) : if ( $revisions[ count( $revisions ) - 1 ]->publication_sectorial_supplement == 'not-applicable' ) : echo('selected'); endif; endif; ?> value="not-applicable"><?php _e( 'Non-applicables' ); ?></option>

                </select>
            </div>
        </div>

        <div class="oak_add_field_container__buttons">
            <div class="oak_add_field_container_buttons__right_buttons">
                <?php 
                if ( isset( $_GET['publication_identifier'] ) ) : ?>
                    <div class="oak_add_field_container__trash_button">
                        <span><?php _e( 'Envoyer à la corbeille', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>

                <?php 
                if ( isset( $_GET['publication_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->publication_state == 1 ) : ?>
                    <div class="oak_add_field_container__draft_button">
                        <span><?php _e( 'Retour à l\'état de Brouillon', Oak::$text_domain ); ?></span>
                    </div>
                <?php 
                endif;
                ?>
                

                <?php 
                if ( isset( $_GET['publication_identifier'] ) ) : 
                    $add_text = '';
                    if ( $revisions[ count( $revisions ) - 1 ]->publication_state == 0 ) :
                        $add_text = 'Sauvegarder le brouillon';
                    elseif ( $revisions[ count( $revisions ) - 1 ]->publication_state == 1 ) :
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
                
                <div class="oak_add_field_container__register_button <?php if ( isset( $_GET['publication_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->publication_state == 1 ) : echo( 'oak_hidden' ); endif; ?>">
                    <?php 
                    $text = 'Enregistrer';
                    if ( isset( $_GET['publication_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->publication_state == '2' ) :
                        $text = 'Retour à l\'état enregistré';
                    endif;
                    ?>
                    <span><?php echo( $text ); ?></span>
                </div>

                <?php
                if ( isset( $_GET['publication_identifier'] ) && $revisions[ count( $revisions ) - 1 ]->publication_state == '1' ) : ?>
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
                    if ( isset( $_GET['publication_identifier'] ) ) :
                        if ( $revisions[ count( $revisions ) - 1 ]->publication_state == 0 ) : 
                            $state = 'Brouillon';
                        elseif ( $revisions[ count( $revisions ) - 1 ]->publication_state == '1' ) :
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
                        if ( $last_revision->publication_state == 1 ) :
                            $registration_date = $last_revision->publication_modification_time;
                        elseif ( $last_revision->publication_state == 2 ) :
                            $broadcast_date = $last_revision->publication_modification_time;
                            $index = 0;
                            for ( $i = count( $revisions ) - 2; $i >= 0; $i-- ) :
                                if ( $revisions[ $i ]->publication_state == 1 ) :
                                    $registration_date = $revisions[ $i ]->publication_modification_time;
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
                <h5 class="oak_add_field_big_container_tabs_single_tab_section__title"><?php _e( 'Publications: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_field_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_field_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- For the modal -->
<div class="oak_add_element_modal_container">
    <div class="oak_add_element_modal_container__modal">
        <div class="oak_add_element_modal_container_modal__title_container">
            <h3 class="oak_add_element_modal_container_modal_title_container__title"></h3>
        </div>

        <div class="oak_add_element_modal_container_modal__content">

            <!-- For the browse revisions functionality -->
            <div class="oak_add_element_modal_container_modal_content__revisions_content oak_hidden">
                <div class="oak_add_element_modal_container_modal_content__revisions_content__current">
                    <h3><?php _e( 'Données Actuelle', Oak::$text_domain); ?></h3>
                    <!-- List of fields here -->
                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="organization"><?php _e( 'Organisation:', Oak::$text_domain ); ?></label>
                        <input name="organization" type="text" disabled class="oak_revision_publication_current_organization" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="year"><?php _e( 'Année:', Oak::$text_domain ); ?></label>
                        <input name="year" type="text" disabled class="oak_revision_publication_current_year" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="headpiece"><?php _e( 'Vignette:', Oak::$text_domain ); ?></label>
                        <input name="headpiece" type="text" disabled class="oak_revision_publication_current_headpiece" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="format"><?php _e( 'Format:', Oak::$text_domain ); ?></label>
                        <input name="format" type="text" disabled class="oak_revision_publication_current_format" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="file"><?php _e( 'Fichier:', Oak::$text_domain ); ?></label>
                        <input name="file" type="text" disabled class="oak_revision_publication_current_file" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="description"><?php _e( 'Description:', Oak::$text_domain ); ?></label>
                        <input name="description" type="text" disabled class="oak_revision_publication_current_description" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="report-or-frame"><?php _e( 'Rapport ou cadres RSE:', Oak::$text_domain ); ?></label>
                        <input name="report-or-frame" type="text" disabled class="oak_revision_publication_current_report_or_frame" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="local"><?php _e( 'Local:', Oak::$text_domain ); ?></label>
                        <input name="local" type="text" disabled class="oak_revision_publication_current_local" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="country"><?php _e( 'Pays:', Oak::$text_domain ); ?></label>
                        <input name="country" type="text" disabled class="oak_revision_publication_current_country" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="report-type"><?php _e( 'Type de rapport:', Oak::$text_domain ); ?></label>
                        <input name="report-type" type="text" disabled class="oak_revision_publication_current_report_type" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="frame-type"><?php _e( 'Type de cadre:', Oak::$text_domain ); ?></label>
                        <input name="frame-type" type="text" disabled class="oak_revision_publication_current_frame_type" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="sectorial-frame"><?php _e( 'Cadres sectoriels:', Oak::$text_domain ); ?></label>
                        <input name="sectorial-frame" type="text" disabled class="oak_revision_publication_current_sectorial_frame" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="sectors"><?php _e( 'Secteurs:', Oak::$text_domain ); ?></label>
                        <input name="sectors" type="text" disabled class="oak_revision_publication_current_sectors" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="language"><?php _e( 'Langue:', Oak::$text_domain ); ?></label>
                        <input name="language" type="text" disabled class="oak_revision_publication_current_language" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="gri-type"><?php _e( 'Type GRI:', Oak::$text_domain ); ?></label>
                        <input name="gri-type" type="text" disabled class="oak_revision_publication_current_gri_type" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="sectorial-supplement"><?php _e( 'Supplément séctoriel:', Oak::$text_domain ); ?></label>
                        <input name="sectorial-supplement" type="text" disabled class="oak_revision_publication_current_sectorial_supplement" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="state"><?php _e( 'Etat:', Oak::$text_domain ); ?></label>
                        <input name="state" type="text" disabled class="oak_revision_publication_current_state" value="">
                    </div>
                    
                </div>

                <div class="oak_add_element_modal_container_modal_content_revisions_content__revision_data_container">
                    <h3><?php _e( 'Données de la révision', Oak::$text_domain); ?></h3>
                    <!-- List of forms here -->
                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="organization"><?php _e( 'Organisation', Oak::$text_domain ); ?></label>
                        <input name="organization" type="text" disabled class="oak_revision_publication_revision_organization" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="year"><?php _e( 'Année:', Oak::$text_domain ); ?></label>
                        <input name="year" type="text" disabled class="oak_revision_publication_revision_year" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="headpiece"><?php _e( 'Vignette:', Oak::$text_domain ); ?></label>
                        <input name="headpiece" type="text" disabled class="oak_revision_publication_revision_headpiece" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="format"><?php _e( 'Format:', Oak::$text_domain ); ?></label>
                        <input name="format" type="text" disabled class="oak_revision_publication_revision_format" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="file"><?php _e( 'Fichier:', Oak::$text_domain ); ?></label>
                        <input name="file" type="text" disabled class="oak_revision_publication_revision_file" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="description"><?php _e( 'Description:', Oak::$text_domain ); ?></label>
                        <input name="description" type="text" disabled class="oak_revision_publication_revision_description" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="report-or-frame"><?php _e( 'Rapport ou Cadre RSE:', Oak::$text_domain ); ?></label>
                        <input name="report-or-frame" type="text" disabled class="oak_revision_publication_revision_report_or_frame" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="local"><?php _e( 'Local:', Oak::$text_domain ); ?></label>
                        <input name="local" type="text" disabled class="oak_revision_publication_revision_local" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="country"><?php _e( 'Pays:', Oak::$text_domain ); ?></label>
                        <input name="country" type="text" disabled class="oak_revision_publication_revision_country" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="report-type"><?php _e( 'Type de rapport:', Oak::$text_domain ); ?></label>
                        <input name="report-type" type="text" disabled class="oak_revision_publication_revision_report_type" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="frame-type"><?php _e( 'Type de cadres:', Oak::$text_domain ); ?></label>
                        <input name="frame-type" type="text" disabled class="oak_revision_publication_revision_frame_type" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="sectorial-frame"><?php _e( 'Cadres sectoriels:', Oak::$text_domain ); ?></label>
                        <input name="sectorial-frame" type="text" disabled class="oak_revision_publication_revision_sectorial_frame" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="sectors"><?php _e( 'Secteurs:', Oak::$text_domain ); ?></label>
                        <input name="sectors" type="text" disabled class="oak_revision_publication_revision_sectors" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="language"><?php _e( 'Langue:', Oak::$text_domain ); ?></label>
                        <input name="language" type="text" disabled class="oak_revision_publication_revision_language" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="gri-type"><?php _e( 'Type GRI:', Oak::$text_domain ); ?></label>
                        <input name="gri-type" type="text" disabled class="oak_revision_publication_revision_gri_type" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="sectorial-supplement"><?php _e( 'Supplément séctoriel:', Oak::$text_domain ); ?></label>
                        <input name="sectorial-supplement" type="text" disabled class="oak_revision_publication_revision_sectorial_supplement" value="">
                    </div>

                    <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                        <label for="state"><?php _e( 'Etat:', Oak::$text_domain ); ?></label>
                        <input name="state" type="text" disabled class="oak_revision_publication_revision_state" value="">
                    </div>
                    
                </div>

                <div class="oak_add_element_modal_container_modal_content_revisions_content__list_of_revisions">
                    <h3><?php _e( 'Liste des révisions', Oak::$text_domain ); ?></h3>
                    <?php 
                    foreach( $revisions as $key => $revision ) : 
                        if ( $key != count( $revisions ) - 1 ) :
                        ?>
                            <div index="<?php echo( $key ) ?>" class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                <span class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( $revision->publication_modification_time ); ?></span>
                            </div>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
            <!-- Done with the browse revisions Functionality -->
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
                    Ajouter
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