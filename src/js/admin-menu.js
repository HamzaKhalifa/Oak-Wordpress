// To show and close the menu
(function() {
    var menuBurger = document.querySelector('.oak_menu_burger');
    var adminMenu = document.querySelector('.oak_admin_menu');
    var menuLayer = document.querySelector('.oak_admin_menu__layer');
    var menuOpen = false;
    menuBurger.addEventListener('click', function() {
        if (menuOpen) {
            adminMenu.classList.remove('oak_admin_menu_shown');
            menuLayer.classList.remove('oak_admin_menu_layer__shown');
            menuOpen = false;
        } else {
            adminMenu.classList.add('oak_admin_menu_shown');
            menuLayer.classList.add('oak_admin_menu_layer__shown');
            menuOpen = true;
        }
        // menuOpen = !menuOpen;
    });

    var menuLayer = document.querySelector('.oak_admin_menu__layer');
    menuLayer.addEventListener('click', function() {
        adminMenu.classList.remove('oak_admin_menu_shown');
        this.classList.remove('oak_admin_menu_layer__shown');
        menuOpen = false;
    });
})();
