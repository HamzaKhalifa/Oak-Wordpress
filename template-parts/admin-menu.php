<div class="oak_admin_menu">

    <div class="oak_admin_menu__head">
        <img class="oak_admin_menu_head__icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/isivalue.png' ); ?>" alt="">
        <h3 class="oak_admin_menu__title">ISIValue</h3>
    </div>

    <img class="oak_admin_menu__joro_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/jörö.png' ); ?>" alt="">
    <h3 class="oak_admin_menu__joro">JÖRÖ</h3>
    <h5 class="oak_admin_menu_central_application" style="color: <?php echo( Oak::$secondary_text_color ); ?>"><?php _e( 'Application centrale', Oak::$text_domain ); ?></h5>
    <hr>
    <br>

    <?php 
        $menu_elements = array(
            array(
                'title' => __( 'Configuration de Oak', Oak::$text_domain ),
                'url' => '?page=oak_materiality_reporting',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Importation des Données', Oak::$text_domain ),
                'url' => '?page=?page=oak_import_page',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Organisations', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=organizations&listorformula=list',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Publications', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=publications&listorformula=list',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Taxonomies', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=taxonomies&listorformula=list',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Modèles', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=models&listorformula=list',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Formes', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=forms&listorformula=list',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Champs', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=fields&listorformula=list',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Indicateurs Quantitatifs', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=quantis&listorformula=list',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Indicateurs Qualitatifs', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=qualis&listorformula=list',
                'icon' => 'fas fa-th-large'
            ),
            array(
                'title' => __( 'Glossaire', Oak::$text_domain ),
                'url' => '?page=oak_elements_list&elements=glossaries&listorformula=list',
                'icon' => 'fas fa-th-large'
            )
        )
    ?>

    <?php 
    foreach( $menu_elements as $element ) : ?>
        <a class="oak_admin_menu_element" href="<?php echo( admin_url( $element['url'] ) ); ?>">
            <div class="oak_admin_menu_element__side_part">
                <i class="oak_admin_menu_element__icon <?php echo( $element['icon'] ); ?>"></i>
                <span class="oak_admin_menu_element__span"><?php echo( $element['title'] ); ?></span>
            </div>
            
            <div class="oak_admin_menu_element__side_part">
                <i class="oak_admin_menu_element__arrow fas fa-caret-right"></i>
            </div>
        </a>
    <?php 
    endforeach; ?>
</div>

<div class="oak_admin_menu__layer"></div>