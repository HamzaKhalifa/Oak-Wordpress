// Global variables
var adding = false;
var canceling = false;
var updating = false;
var browsingRevisions = false;
var revision = {};
var table = DATA.table;
var elementData = {};
var properties = DATA.properties 
for (var i = 0; i < properties.length; i++) {
    elementData[DATA.table + '_' + properties[i].name] = '';
}

// For the text fields animation
textFieldsAnimations();
function textFieldsAnimations() {
    var textFields = document.querySelectorAll('.oak_text_field_container');
    for(var i = 0; i < textFields.length; i++) {
        textFields[i].addEventListener('click', function() {
            this.querySelector('input').focus();
        });
    }

    // Add the focus listener for the input
    var inputs = document.querySelectorAll('.oak_text_field');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('focus', function() {
            var textFields = document.querySelectorAll('.oak_text_field_container');
            for(var i = 0; i < textFields.length; i++) {
                if (!jQuery(textFields[i].querySelector('input')).is(':focus')) {
                    if ( textFields[i].querySelector('input').value == '')
                        unfocusTextField(textFields[i]);
                    else 
                        unfocusTextFieldButSomethingWritten(textFields[i]);
                }   
            }
            focusTextField(this);
        });
    }
}

function focusTextField(input) {
    var textField = input.parentNode;
    removeSomethingWrittenClasses(textField);
    textField.querySelector('.oak_text_field_placeholder').classList.add('oak_text_field_placeholder_focused');
    if (textField.querySelector('input').inputMode != 'focus')
        textField.querySelector('input').focus();
    textField.querySelector('.text_field_line').classList.add('text_field_line_focused');
}

function unfocusTextFieldButSomethingWritten(textField) {
    textField.querySelector('.oak_text_field_placeholder').classList.add('oak_text_field_placeholder_not_focused_but_something_written');
    textField.querySelector('.text_field_line').classList.add('text_field_line_not_focused_but_something_written');
}

function removeSomethingWrittenClasses(textField) {
    textField.querySelector('.oak_text_field_placeholder').classList.remove('oak_text_field_placeholder_not_focused_but_something_written');
    textField.querySelector('.text_field_line').classList.remove('text_field_line_not_focused_but_something_written');
}

function unfocusTextField(textField) {
    textField.querySelector('.oak_text_field_placeholder').classList.remove('oak_text_field_placeholder_focused');
    textField.querySelector('.text_field_line').classList.remove('text_field_line_focused');
} 

windowClick();
function windowClick() {
    jQuery(document).ready(function() {
        window.addEventListener('click', function() {
            var textFields = document.querySelectorAll('.oak_text_field_container');
            for(var i = 0; i < textFields.length; i++) {
                if (!jQuery(textFields[i].querySelector('input')).is(':focus') && textFields[i].querySelector('input').value == '') {
                    unfocusTextField(textFields[i]);
                }
            }
        })
    });
}

// For the select container listener and checkboxes (unfocus all other textfields) 
otherInputsListeners();
function otherInputsListeners() {
    var selectContainers = document.querySelectorAll('.oak_select_container');
    for (var i = 0; i < selectContainers.length; i++) {
        selectContainers[i].addEventListener('click', function() {
            unfocusAllTextFields();
        });
    }
    
    var inputs = document.querySelectorAll('input');
    var checkboxes = [];
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].getAttribute('type') == 'checkbox') {
            checkboxes.push(inputs[i]);
        }
    }
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function() {
            unfocusAllTextFields();
        });
    }
}

function unfocusAllTextFields() {
    var textFields = document.querySelectorAll('.oak_text_field_container');
    for(var i = 0; i < textFields.length; i++) {
        if ( textFields[i].querySelector('input').value == '')
            unfocusTextField(textFields[i]);
        else 
            unfocusTextFieldButSomethingWritten(textFields[i]);
    }
}
 
// For the add button
addButton();
function addButton() {
    var addButton = document.querySelector('.oak_add_element_container__add_button');
    if (addButton) {
        addButton.addEventListener('click', function() {
            var ok = checkOk();
            if (!ok)
                return;
            elementData = createElementData(0);
            adding = true;
            openModal('Êtes vous sur de vouloir ajouter ce champ?', true);
        });    
    }
}

// For the update button 
updateButton();
function updateButton() {
    var updateButton = document.querySelector('.oak_add_element_container__update_button');
    if (updateButton) {
        updateButton.addEventListener('click', function() {
            elementData = createElementData(DATA.revisions[DATA.revisions.length - 1].field_state);
            updating = true;
            openModal('Êtes vous sûr de vouloir modifier ce champ?', true);
        });
    }
}

// For the register button
registerButton();
function registerButton() {
    var registerButton = document.querySelector('.oak_add_element_container__register_button');
    if (registerButton) {
        registerButton.addEventListener('click', function() {
            elementData = createElementData(1);
            if (DATA.revisions.length == 0) {
                // adding for the first time
                var ok = checkOk();
                if (!ok)
                    return;
                adding = true;
            } else {
                updating = true;
            }
            openModal('Êtes vous sûr de vouloir ajouter ce champ à la liste des champs enregistrés?', true);
        });
    }
}

function checkOk() {
    ok = true;
    var designation = document.querySelector('.designation_input').value;
    if (designation.trim() == '') {
        openModal('Veuillez entrer la désignation d\'abord', false);
        ok = false;
    } 
    return ok;
}

// For the broadcast button
broadcastButton();
function broadcastButton() {
    var theBroadcastButton = document.querySelector('.oak_add_element_container__broadcast_button');
    if (theBroadcastButton) {
        theBroadcastButton.addEventListener('click', function() {
            elementData = createElementData(2);
            updating = true;
            openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
        });
    }
}

// For the back to draft button: 
draftButton();
function draftButton() {
    var draftButton = document.querySelector('.oak_add_element_container__draft_button');
    if (draftButton) {
        draftButton.addEventListener('click', function() {
            elementData = createElementData(0);
            updating = true;
            openModal('Êtes vous sûr de vouloir modifier et renvoyer ce champ à l\'état de Brouillon ?', true);
        });
    }
}

// For the identifier input
if (DATA.revisions < 1)
    createIdentifier();

function createIdentifier() {
    var text = "";
    var possible = "abcdefghijklmnopqrstuvwxyz0123456789";
  
    for (var i = 0; i < 20; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));
      
    var identifierInput = document.querySelector('.identifier_input');
    identifierInput.value = text;
}

// For the trash button
// trashButton();
// function trashButton() {
//     var trashButton = document.querySelector('.oak_add_element_container__trash_button');
//     if (trashButton) {
//         trashButton.addEventListener('click', function() {
//             setLoading();
//             jQuery(document).ready(function() {
//                 jQuery.ajax({
//                     url: DATA.ajaxUrl,
//                     type: 'POST', 
//                     data: {
//                         'data': DATA.currentField.field_identifier,
//                         'action': 'oak_send_field_to_trash',
//                     },
//                     success: function(data) {
//                         console.log(data);
//                         doneLoading();
//                         window.location.replace(DATA.adminUrl + 'admin.php?page=oak_add_' + table);
//                     },
//                     error: function(error) {
//                         console.log(error);
//                         doneLoading();
//                     }
//                 });
//             });
//         });
//     }
// }

// We create while adding the new revision
function createElementData(state) {
    var keys = getKeys(elementData);
    for(var i = 0; i < properties.length; i++) {
        if (document.querySelector('.' + properties[i].name + '_input')) {
            if (properties[i].input_type == 'text' || properties[i].input_type == 'select')
                elementData[keys[i]] = document.querySelector('.' + properties[i].name + '_input').value.toString();
            else if (properties[i].input_type == 'image' || properties[i].input_type == 'file')
                elementData[keys[i]] = document.querySelector('.' + properties[i].name + '_input').getAttribute('src').toString();
            else if (properties[i].input_type == 'checkbox') 
                elementData[keys[i]] = document.querySelector('.' + properties[i].name + '_input').checked.toString();
        }
    }
    if (state != 0)
        elementData[table + '_state'] = state ? state.toString() : DATA.revisions[DATA.revisions.length - 1][table + '_state'].toString();
    else 
        elementData[table + '_state'] = state.toString();

    // Manage trashed and locked
    elementData[table + '_trashed'] = 'false';
    elementData[table + '_locked'] = 'false';

    // Manage other elements 
    if (DATA.otherElementProperties) {
        var otherElements = [];
        var otherElementsDesignationContainers = document.querySelectorAll('.oak_other_elements_single_elements_container__single_element');
        for (var i = 0; i < otherElementsDesignationContainers.length; i++) {
            otherElements.push({
                elementIdentifier: otherElementsDesignationContainers[i].querySelector('.oak_other_elements_select').value,
                elementOtherDesignation: otherElementsDesignationContainers[i].querySelector('.designation_input').value,
                elementRequired: otherElementsDesignationContainers[i].querySelector('.selector_input').checked,
                elementIndex: i,
                revisionNumber: DATA.revisions.length + 1
            });
        }
        elementData.otherElements = otherElements;
        elementData.otherElementsProperties = DATA.otherElementProperties;
        elementData[table + '_revision_number'] = DATA.revisions.length + 1;
    }

    return elementData;
}

// for the browse revisions button:
browseRevisionsButton();
function browseRevisionsButton() {
    theBrowseRevisionsButton = document.querySelector('.oak_add_element_big_container_tabs_single_tab_section_state__browse');
    theBrowseRevisionsButton.addEventListener('click', function() {
        browsingRevisions = true;
        openModal('Liste des révisions', true);

        elementData = createElementData();
        for (var i = 0; i < properties.length; i++) {
            document.querySelector('.oak_revision_' + properties[i].name + '_field_current').value = elementData[table + '_' + properties[i].name];
        }
    });
}

// For the browse revisions select button: 
browseRevisionsSelectButton();
function browseRevisionsSelectButton() {
    var revisionsButtons = document.querySelectorAll('.oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions__single_revision');
    for( var i = 0; i < revisionsButtons.length; i++ ) {
        revisionsButtons[i].addEventListener('click', function(){
            for (var j = 0; j < revisionsButtons.length; j++) {
                revisionsButtons[j].classList.remove('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
            }
            this.classList.add('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
            document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container').classList.remove('oak_hidden');

            // Updating the selected revision fields:
            var selectedRevision = DATA.revisions[this.getAttribute('index')];
            revision = selectedRevision;

            for (var i = 0; i < properties.length; i++) {
                document.querySelector('.oak_revision_' + properties[i].name + '_field').value = selectedRevision[table + '_' + properties[i].name];
                checkEquals(document.querySelector('.oak_revision_' + properties[i].name + '_field_current').value, document.querySelector('.oak_revision_' + properties[i].name + '_field').value, document.querySelector('.oak_revision_' + properties[i].name + '_field'));
            }
        });
    }
}

function checkEquals(value1, value2, field) {
    if (value1 == value2) {
        field.classList.remove('oak_error');
    } else {
        field.classList.add('oak_error');
    }
}

var getKeys = function(obj){
    var keys = [];
    for(var key in obj){
       keys.push(key);
    }
    return keys;
}

// Everything related to other elements (table relationships like forms using fields and models using forms)
var singleElementContainer;
if (DATA.otherElementProperties) 
    getSingleElementContainer();
function getSingleElementContainer() {
    singleElementContainer = document.querySelector('.oak_other_elements_single_elements_container__single_element').innerHTML;
    document.querySelector('.oak_other_elements_single_elements_container__single_element').remove();
}

if (DATA.otherElementProperties)
    initializeElements();
function initializeElements() {
    if (DATA.revisions.length > 0) {
        var otherElements = DATA.otherElementProperties.associative_tab_instances;
        for (var i = 0; i < otherElements.length; i++) {
            if ( otherElements[i][table + '_identifier'] == DATA.revisions[DATA.revisions.length - 1][table + '_identifier'] 
                && otherElements[i][table + '_revision_number'] == DATA.revisions[DATA.revisions.length - 1][table + '_revision_number'] ) {
                    addOtherElement(otherElements[i]);
            }
        }
    }
}

if (DATA.otherElementProperties)
    addOtherElementButton();
function addOtherElementButton() {
    document.querySelector('.oak_other_elements_container__add_button').addEventListener('click', function() {
        addOtherElement();
    });
}

function addOtherElement(data) {
    var otherElementsContainer = document.querySelector('.oak_other_elements_container');
    var newElement = document.createElement('div');
    newElement.className = 'oak_other_elements_single_elements_container__single_element oak_other_elements_single_elements_container__single_element_not_checked';
    newElement.innerHTML = singleElementContainer;
    otherElementsContainer.append(newElement);

    if (data) {
        var elementsSelect = newElement.querySelector('.oak_other_elements_select');
        elementsSelect.value = data[DATA.otherElementProperties.table + '_identifier'];
        newElement.querySelector('.designation_input').value = data[DATA.otherElementProperties.table + '_designation'];
        console.log('required', data[DATA.otherElementProperties.table + '_required']);
        newElement.querySelector('.selector_input').checked = data[DATA.otherElementProperties.table + '_required'] == 'true' ? true : false;
    }

    handleOtherElementsCheckboxes();
    textFieldsAnimations();
    handleOtherElementsFilters();
}

handleOtherElementsCheckboxes();
function handleOtherElementsCheckboxes() {
    var checkboxes = document.querySelectorAll('.oak_add_other_elements_list_single_element__chekcbox');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', function() {
            checkboxClickListener(this);
        });
    }
}

function checkboxClickListener(checkbox) {
    var checkboxes = document.querySelectorAll('.oak_add_other_elements_list_single_element__chekcbox');
    if (checkbox.checked) {
        checkbox.parentNode.parentNode.classList.remove('oak_other_elements_single_elements_container__single_element_not_checked');
    } else {
        checkbox.parentNode.parentNode.classList.add('oak_other_elements_single_elements_container__single_element_not_checked');
    }
    var numberOfChecked = 0;
    for (var j = 0; j < checkboxes.length; j++) {
        if (checkboxes[j].checked) 
            numberOfChecked++;
    }
    // Check the number of checked checkboxes
    document.querySelector('.oak_number_of_other_selected_elements').innerHTML = numberOfChecked;
    var elementHeadder = document.querySelector('.oak_element_header');
    var otherElementsButtons = document.querySelector('.oak_element_header_right_other_elements_buttons');
    var elementHeaderRightButtons = document.querySelector('.oak_element_header_right');
    if (numberOfChecked == 0) {
        elementHeadder.classList.remove('oak_element_header_at_least_one_selected');
        elementHeaderRightButtons.classList.remove('oak_hidden');
        otherElementsButtons.classList.add('oak_hidden');
    } else {
        elementHeadder.classList.add('oak_element_header_at_least_one_selected');
        elementHeaderRightButtons.classList.add('oak_hidden');
        otherElementsButtons.classList.remove('oak_hidden');
    }
}

function handleOtherElementsFilters() {
    for (var i = 0; i < DATA.otherElementProperties.filters.length; i++) {
        var selects = document.querySelectorAll('.' + DATA.otherElementProperties.filters[i].filter_name);
        for (var j = 0; j < selects.length; j++) {
            selects[j].addEventListener('change', function() {
                filterOtherElements(this.parentNode.parentNode.parentNode);
            });
        }
    }
}

function filterOtherElements(otherElementContainer) {
    var otherElementsOptions = otherElementContainer.querySelector('.oak_other_elements_select').querySelectorAll('option');
    for (var j = 0; j < otherElementsOptions.length; j++) {
        hide = false;
        for (var i = 0; i < DATA.otherElementProperties.filters.length; i++) {
            var filterValue = otherElementContainer.querySelector('.' + DATA.otherElementProperties.filters[i].filter_name).value;
            if (filterValue != 0) {
                for (var m = 0; m < DATA.otherElementProperties.elements.length; m++) {
                    if (DATA.otherElementProperties.elements[m][DATA.otherElementProperties.table + '_identifier'] == otherElementsOptions[j].value) {
                        if (DATA.otherElementProperties.elements[m][DATA.otherElementProperties.filters[i].name_in_database] != filterValue) {
                            hide = true;
                        }
                    }
                }
            } 
        }
        if (hide) {
            otherElementsOptions[j].classList.add('oak_hidden');
        } else {
            otherElementsOptions[j].classList.remove('oak_hidden');
        }
    }
}

// For the cancel button on the header: 
headerCancelButton();
function headerCancelButton() {
    var cancelButton = document.querySelector('.oak_menu_icon__cancel_icon');
    cancelButton.addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.oak_add_other_elements_list_single_element__chekcbox');
        var numberOfChecked = 0;
        for (var j = 0; j < checkboxes.length; j++) {
            if (checkboxes[j].checked) 
                numberOfChecked++;
        }
        if (numberOfChecked == 0) {
            window.location.replace(DATA.adminUrl + '?page=oak_elements_list&elements=' + DATA.tableInPlural + '&listorformula=list');
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
                checkboxClickListener(checkboxes[i]);
            }
        }
    });
}

// For other elements Delete button 
otherElementsDeleteButton();
function otherElementsDeleteButton() {
    var deleteButton = document.querySelector('.oak_other_elements_delete_button');
    deleteButton.addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.oak_add_other_elements_list_single_element__chekcbox');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) 
                checkboxes[i].parentNode.parentNode.remove();
        }
    });
}

otherElementsCopyButton();
function otherElementsCopyButton() {
    var copyButton = document.querySelector('.oak_other_elements_copy_button');
    copyButton.addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.oak_add_other_elements_list_single_element__chekcbox');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                var otherElementsContainer = document.querySelector('.oak_other_elements_container');
                var newElement = document.createElement('div');
                newElement.className = 'oak_other_elements_single_elements_container__single_element oak_other_elements_single_elements_container__single_element_not_checked';
                newElement.innerHTML = singleElementContainer;
                newElement.querySelector('.designation_input').value = checkboxes[i].parentNode.parentNode.querySelector('.designation_input').value;
                newElement.querySelector('.selector_input').checked = checkboxes[i].parentNode.parentNode.querySelector('.selector_input').checked;
                newElement.querySelector('.oak_other_elements_select').value = checkboxes[i].parentNode.parentNode.querySelector('.oak_other_elements_select').value;

                otherElementsContainer.append(newElement);

                handleOtherElementsCheckboxes();
                textFieldsAnimations();
            }
        }
    });
}

// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_add_button_container__text');
    var cancelButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_cancel_button_container__text');
    var confirmButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    if (adding) {
        confirmButtonSpan.innerHTML = 'Ajouter';
        confirmButtonContainer.classList.remove('oak_hidden');
        cancelButtonSpan.innerHTML = 'Annuler';
    }
    if (canceling || updating) {
        confirmButtonSpan.innerHTML = 'Oui';
        cancelButtonSpan.innerHTML = 'Non';
        confirmButtonContainer.classList.remove('oak_hidden');
    }
    var modalContainer = document.querySelector('.oak_add_element_modal_container__modal');
    var revisionsContent = document.querySelector('.oak_add_element_modal_container_modal_content__revisions_content');
    if (browsingRevisions) {
        confirmButtonSpan.innerHTML = 'Importer';
        cancelButtonSpan.innerHTML = 'Annuler';
        confirmButtonContainer.classList.add('oak_hidden');
        modalContainer.classList.add('oak_object_model_add_formula_modal_container_modal__big_modal');
        revisionsContent.classList.remove('oak_hidden');
    } else {
        modalContainer.classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
        revisionsContent.classList.add('oak_hidden');
    }

    var confirmButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_add_button_container__text');

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_add_element_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    var addButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');
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

okButton();
function okButton() {
    var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');
    okButtonContainer.addEventListener('click', function() {
        closeModals();
    }); 
}

function closeModals() {
    setTimeout(function() {
        document.querySelector('.oak_add_element_modal_container__modal').classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
        document.querySelector('.oak_add_element_modal_container_modal_content__revisions_content').classList.add('oak_hidden');
    }, 500);

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
    adding = canceling = updating = browsingRevisions = false;
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

handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function() {
        if (adding || updating) {
            closeModals();
            setLoading();
            console.log('Element data', elementData);
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_element',
                        'element': elementData,
                        'table': table
                    },
                    success: function(data) {
                        doneLoading();
                        console.log(data);
                        window.location.reload();
                    },
                    error: function(error) {
                        doneLoading();
                    }
                });
            })
        }
        if (canceling) {
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
        }
        if (browsingRevisions) {
            var revisionWithoutId = {}; 
            var revisionKeys = getKeys(revision);
            for(var i = 0; i < revisionKeys.length; i++) {
                if (revisionKeys[i] != 'id') {
                    revisionWithoutId[revisionKeys[i]] = revision[revisionKeys[i]];
                }
            }
            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_element',
                        'element': revisionWithoutId,
                        'table': table
                    },
                    success: function(data) {
                        doneLoading();
                        window.location.reload();
                    },
                    error: function(error) {
                        doneLoading();
                    }
                });
            })
        }
    });

    var cancelButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function() {
        closeModals();
    });
}

function backToList() {
    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
}