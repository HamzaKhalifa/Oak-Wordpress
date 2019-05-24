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
        if (languagesOptions[i].value == ADMIN_MENU_DATA.siteLanguage) {
            languagesOptions[i].selected = true;
        }
    }
}

// For the sticky app bar
handleStickyMenu();
function handleStickyMenu() {
    var header = document.querySelector('.oak_element_header');
    if (!header) 
        return;
        
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

// For the content type filter button
handleContentTypeFilterButton();
console.log(ADMIN_MENU_DATA.currentUser);
function handleContentTypeFilterButton() {
    var contentFilterButton = document.querySelector('.oak_content_type_filter_button');
    contentFilterButton.addEventListener('click', function() {
        jQuery(document).ready(function() {
            var selectedPublicationsIdentifiers = jQuery('.oak_system_bar__publications_select').val();
            var selectedSteps = jQuery('.oak_system_bar__steps_select').val();

            setLoading();
            jQuery.ajax({
                type: 'POST', 
                url: ADMIN_MENU_DATA.ajaxUrl,
                data: {
                    'action': 'oak_register_fitler_content_variables',
                    'selected_steps': selectedSteps,
                    'selected_publications': selectedPublicationsIdentifiers,
                    'currentUser': ADMIN_MENU_DATA.currentUser
                },
                success: function(data) {
                    console.log(data);
                    doneLoading();
                    window.location.reload();
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        });
    });
}


// Everything related to our modal
function openModal(title, twoButtons) {
    var confirmButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_add_element_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    if ( twoButtons) {
        confirmButtonContainer.style.display = 'flex';
        cancelButtonContainer.style.display = 'flex';
        okButtonContainer.style.display = 'none';
    } else {
        confirmButtonContainer.style.display = 'none';
        cancelButtonContainer.style.display = 'none';
        okButtonContainer.style.display = 'flex';
    }
}

handleModalOkButton();
function handleModalOkButton() {
    var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');
    okButtonContainer.addEventListener('click', function() {
        closeModals();
    });
}

function closeModals() {
    setTimeout(function() {
        document.querySelector('.oak_add_element_modal_container__modal').classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
    }, 500);

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
}

function setLoading() {
    openModal();
    document.querySelector('.oak_loader').classList.remove('oak_hidden');
    document.querySelector('.oak_add_element_modal_container__modal').classList.add('oak_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function() {
        document.querySelector('.oak_loader').classList.add('oak_hidden');
        document.querySelector('.oak_add_element_modal_container__modal').classList.remove('oak_hidden');
    }, 1000);
}