<div class="oak_reporting_safety_view">
    <h1 class="oak_reporting_safety__title"><?php _e( 'Reporting Safety', Oak::$text_domain ); ?></h1>
    <div class="oak_reporting_safety__configuration">
        <h2 class="oak_reporting_safety__configuration_tittle"><?php _e( 'Configuration', Oak::$text_domain ); ?></h2>
        <div class="oak_reporting_safety__configuration_element">
            <span class="oak_reporting_safety__configuration_label"><?php _e( 'Ajax URL du site de backup', Oak::$text_domain ); ?></span>
            <?php 
            $bakcup_ajax_url = get_option( 'oak_backup_ajax_url' ) ? get_option( 'oak_backup_ajax_url' ) : '';
            ?>
            <input type="text" class="oak_reporting_safety__backup_instance_ajax_url" value="<?php echo( $bakcup_ajax_url ); ?>">
        </div>
        <span class="oak_reporting_safety__configuration_save_button oak_button"><?php _e( 'Sauvergarder la configuration', Oak::$text_domain ); ?></span>
    </div>
    <span class="reporting_safety__generate_sql_file_button oak_button"><?php _e( 'Générer Fichier SQL', Oak::$text_domain ); ?></span>
</div>