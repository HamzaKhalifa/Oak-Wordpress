var elementToDelete;
var deleting = false;

// For the add button
var addButton = document.querySelector('.oak_list_button');
addButton.addEventListener('click', function() {
    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_add_field');
});

// Done with the add button

// For the grouped actions select
var groupedActionsSelect = document.querySelector('.oak_grouped_actions__grouped_actions');
var applyGroupedActionButton = document.querySelector('.oak_list_grouped_actions_button');
applyGroupedActionButton.addEventListener('click', function() {
    if (groupedActionsSelect.value == 'to-trash') {
        var designationsToDelete = [];
        var checkBoxes = document.querySelectorAll('.oak_list_titles_container__checkbox');
        for (var i = 1; i < checkBoxes.length; i++) {
            if (checkBoxes[i].checked) {
                designationsToDelete.push(checkBoxes[i].parentNode.querySelector('.oak_list_titles_container__title').innerHTML);
            }
        }
        setLoading();
        jQuery(document).ready(function() {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST', 
                data: {
                    'data': {
                        whichTable: 'field',
                        designations: designationsToDelete
                    },
                    'action': 'oak_send_to_trash'
                },
                success: function(data) {
                    doneLoading();
                    window.location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
        
    }
});
// Done with the grouped action select

// For the select all checkboxes
var selectAllCheckbox = document.querySelector('.oak_select_all_checkbox');
selectAllCheckbox.addEventListener('change', function() {
    var allSelectChecbkBoxes = document.querySelectorAll('.oak_list_titles_container__checkbox');
    for (var i = 0; i < allSelectChecbkBoxes.length; i++) {
        allSelectChecbkBoxes[i].checked = selectAllCheckbox.checked;
    }
});
// Done with the select all checkbox

// For the filters
var allNaturesButton = document.querySelector('.oak_grouped_actions__all_natures');
var allFunctionsButton = document.querySelector('.oak_grouped_actions__all_functions');
var naturesContainers = document.querySelectorAll('.oak_list_nature');
var functionsContainers = document.querySelectorAll('.oak_list_function');
allNaturesButton.addEventListener('change', function() {
    filterResult();
});
allFunctionsButton.addEventListener('change', function() {
    filterResult();
})

function filterResult() {
    var considerNature = false;
    var considerFunction = false;

    if (allNaturesButton.value != 'all-natures') 
        considerNature = true;

    if (allFunctionsButton.value != 'all-functions')
        considerFunction = true;

    for (var i = 0; i < naturesContainers.length; i++) {
        var hide = false;
        
        if (considerNature && naturesContainers[i].innerHTML != allNaturesButton.value) {
            hide = true;
        }

        if (considerFunction && functionsContainers[i].innerHTML != allFunctionsButton.value) {
            hide = true;
        }

        if (hide) {
            naturesContainers[i].parentNode.parentNode.classList.add('oak_hidden');
            naturesContainers[i].parentNode.parentNode.setAttribute('filtered', true);

        } else {
            naturesContainers[i].parentNode.parentNode.classList.remove('oak_hidden');
            naturesContainers[i].parentNode.parentNode.setAttribute('filtered', false);
        }
    }
}
// Done with the all natures button

// For the search button 
var searchButton = document.querySelector('.oak_list_header_right__search_input');
searchButton.oninput = function() {
    var searchedDesignation = document.querySelector('.oak_list_header_right__search_input').value;
    var allDesignationsSpans = document.querySelectorAll('.oak_list_titles_container__the_title');
    for (var i = 0; i < allDesignationsSpans.length; i++) {
        console.log(allDesignationsSpans[i].innerHTML);
        if (allDesignationsSpans[i].parentNode.parentNode.getAttribute('filtered') != 'true') {
            if (searchedDesignation == '') {
                allDesignationsSpans[i].parentNode.parentNode.classList.remove('oak_list_highlighted');
                allDesignationsSpans[i].parentNode.parentNode.classList.remove('oak_hidden');
            } else {
                if (allDesignationsSpans[i].innerHTML.indexOf(searchedDesignation) != -1) {
                    // if (allDesignationsSpans[i].innerHTML == searchedDesignation) {
                    allDesignationsSpans[i].parentNode.parentNode.classList.add('oak_list_highlighted');
                    allDesignationsSpans[i].parentNode.parentNode.classList.remove('oak_hidden');
                    allDesignationsSpans[i].parentNode.parentNode.scrollIntoView();
                } else {
                    allDesignationsSpans[i].parentNode.parentNode.classList.remove('oak_list_highlighted');
                    allDesignationsSpans[i].parentNode.parentNode.classList.add('oak_hidden');
                }
            }
        }
        
    }
}

// For the update buttons: 
manageUpdateButtons();
function manageUpdateButtons() {
    var updateButtons = document.querySelectorAll('.oak_add_field_container_saved_field_container__update_button');
    for (var i = 0; i < updateButtons.length; i++) {
        updateButtons[i].addEventListener('click', function() {
            var whichField;

            for (var j = 0; j < DATA.fields.length; j++) {
                if (DATA.fields[j].field_identifier == this.getAttribute('field-identifier')) {
                    whichField = DATA.fields[j];
                }
            }
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_add_field&field_identifier=' + whichField.field_identifier);
        });
    }
}

// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text');
    if (deleting) {
        confirmButtonSpan.innerHTML = 'Supprimer';
    }

    var confirmButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text');

    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_object_model_add_formula_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    var addButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container');
    if ( twoButtons) {
        addButtonContainer.style.display = 'flex';
        cancelButtonContainer.style.display = 'flex';
        okButtonContainer.style.display = 'none';
    } else {
        addButtonContainer.style.display = 'none';
        cancelButtonContainer.style.display = 'none';
        okButtonContainer.style.display = 'flex';
    }
}

var okButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container');
okButtonContainer.addEventListener('click', function() {
    closeModals();
}); 

function closeModals() {
    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
    deleting = false;
}

function setLoading() {
    openModal();
    document.querySelector('.oak_loader').classList.remove('oak_hidden');
    document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.add('oak_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function() {
        document.querySelector('.oak_loader').classList.add('oak_hidden');
        document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.remove('oak_hidden');
    }, 1000);
}

handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function() {
    });

    var cancelButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function() {
        closeModals();
    });
}