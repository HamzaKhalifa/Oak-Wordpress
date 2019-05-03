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

// For wordpress menu button 
var adminMenuOpen = false;
handleWordpressMenuButton();
function handleWordpressMenuButton() {
    var wordpressMenuButton = document.querySelector('.oak_admin_menu_fixed_button');
    wordpressMenuButton.addEventListener('click', function() {
        document.querySelector('#adminmenuwrap').style.display = adminMenuOpen == true ? 'none' : 'block';
        adminMenuOpen = !adminMenuOpen;
    });
}

// Initializing language: 
initializeSiteLanguage();
function initializeSiteLanguage() {
    var languagesOptions = document.querySelectorAll('.oak_stystem_bar_language_option');
    for (var i = 0; i < languagesOptions.length; i++) {
        if (languagesOptions[i].value == DATA.siteLanguage) {
            languagesOptions[i].selected = true;
        }
    }
}

// For the sticky app bar
handleStickyMenu();
function handleStickyMenu() {
    var header = document.querySelector('.oak_element_header');
    var headerHeight = header.offsetHeight;

    var containerHeader = document.querySelector('.oak_add_element_container__header');
    var elementsList = document.querySelector('.oak_elements_list');
    var elementTopDropDown = containerHeader ? containerHeader : elementsList;

    var defaultMargin = parseInt(window.getComputedStyle(elementTopDropDown).getPropertyValue('margin-top'));
    var droppedDownMargin = defaultMargin + headerHeight;

    var topLimit = document.querySelector('#wpwrap').offsetTop;
    handleScroll();
    window.addEventListener('scroll', function() {
        handleScroll();
    })

    function handleScroll() {
        if (window.pageYOffset > topLimit) {
            header.classList.add('oak_element_header__sticky');
            elementTopDropDown.style.marginTop = droppedDownMargin + 'px';
        } else {
            header.classList.remove('oak_element_header__sticky');
            elementTopDropDown.style.marginTop = defaultMargin + 'px'; 
        }
    }
}
