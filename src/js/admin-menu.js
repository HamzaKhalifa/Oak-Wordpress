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


// For the submenu
handleSubMenu();
function handleSubMenu() {
    var menuElements = document.querySelectorAll('.oak_admin_menu_element');
    for (var i = 0; i < menuElements.length; i++) {
        menuElements[i].addEventListener('click', function() {
            submenuClick(this);
        });
    }
    var submenuElements = document.querySelectorAll('.oak_admin_menu_sub_element');
    for (var i = 0; i < submenuElements.length; i++) {
        submenuElements[i].addEventListener('click', function() {
            submenuClick(this);
        });
    }
}

function submenuClick(element) {
    if (containsClass(element.nextSibling.nextSibling, 'oak_admin_menu_element__sub_menu')) {
        var submenu = element.nextSibling.nextSibling;
        if (containsClass(submenu, 'oak_hidden')) {
            submenu.classList.remove('oak_hidden');
        } else {
            submenu.classList.add('oak_hidden');
        }
    }
}

function containsClass(element, className) {
    if (element) {
        for (var i = 0; i < element.classList.length; i++) {
            if (className == element.classList[i]) 
                return true;
        }
    }
    return false;
}
