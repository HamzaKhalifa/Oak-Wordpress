<div class="oak_chat_menu oak_chat_menu_hidden">

    <form class="oak_chat_menu__authentication">
        <h2 class="oak_chat_menu__title"><?php _e( 'Authentification', Oak::$text_domain ); ?></h2>
        <input type="text" placeholder="<?php _e( 'Email', Oak::$text_domain ); ?>" class="oak_chat_input oak_chat_email">
        <input type="password" placeholder="<?php _e( 'Mot de passe', Oak::$text_domain ); ?>" class="oak_chat_input oak_chat_password">
        <input type="text" placeholder="<?php _e( 'Nom d\'utilisateur', Oak::$text_domain ); ?>" class="oak_chat_input oak_chat_username">
        <button class="oak_chat_login_or_register_button"><?php _e( 'Login/Register' ); ?></button>
        <span class="oak_chat_authentication__error_message"></span>
    </form>

    <div class="oak_chat_authenticated">
        <button class="oak_chat_sign_out_button"><?php _e( 'Deconnexion', Oak::$text_domain ); ?></button>

        <h2 class="oak_chat_menu__title"><?php _e( 'Utilisateurs', Oak::$text_domain ); ?></h2>

        <div class="oak_chat_menu__single_user_view">
            <img class="oak_chat_menu__single_user_profile_image" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/user.png' ); ?>" alt="">
            <span class="oak_chat_menu_single_user__name">Thomas</span>
        </div>

        <div class="oak_chat_menu__single_user_view">
            <img class="oak_chat_menu__single_user_profile_image" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/user.png' ); ?>" alt="">
            <span class="oak_chat_menu_single_user__name">Dolores</span>
        </div>
    </div>

    <div class="oak_chat_loader_container oak_hidden">
        <h2 class="oak_chat_loader_container__loading_message"></h2>
        <div class="oak_loader chat_loader"></div>
    </div>
    
    
</div>