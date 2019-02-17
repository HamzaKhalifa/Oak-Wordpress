// Global variables
var adding = false;
var objectData = {};
var canceling = false;
var updating = false;
var browsingRevisions = false;
var revision = {};

// For the add button
var addButton = document.querySelector('.oak_add_field_container__add_button');
if (addButton) {
    addButton.addEventListener('click', function () {
        var ok = checkOk();
        if (!ok)
            return;
        
        if (testIdentifierExists()) 
            openModal('L’identifiant que vous venez d\'entrer a déjà été utilisé pour un autre objet !');
        else {
            objectData = createObjectData(0);
            adding = true;
            openModal('Êtes vous sur de vouloir ajouter cette terminologie?', true);
        }
    });
}

// For the update button 
var updateButton = document.querySelector('.oak_add_field_container__update_button');
if (updateButton) {
    updateButton.addEventListener('click', function () {
        if (testIdentifierExists()) 
            openModal('L’identifiant que vous venez d\'entrer a déjà été utilisé pour un autre objet !');
        else {
            objectData = createObjectData(DATA.revisions[DATA.revisions.length - 1].object_state);
            updating = true;
            openModal('Êtes vous sûr de vouloir modifier cette terminologie?', true);
        }
    });
}

// For the register button
var registerButton = document.querySelector('.oak_add_field_container__register_button');
if (registerButton) {
    registerButton.addEventListener('click', function () {
        if (testIdentifierExists()) 
            openModal('L’identifiant que vous venez d\'entrer a déjà été utilisé pour un autre objet !');
        else {
            objectData = createObjectData(1);
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
        }
    });
}

function checkOk() {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = designation.replace(/[^a-zA-Z ]/g, '');
    identifier = identifier.replace(/\s/g, '');

    ok = true;
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    if (designation.trim() == '') {
        openModal('Veuillez entrer la désignation d\'abord', false);
        ok = false;
    } else {
        for (var i = 0; i < DATA.objects.length; i++) {
            if (DATA.objects[i].designation == designation) {
                openModal('Il existe déjà une organisation avec la désignation: ' + designation);
                ok = false;
            }
        }
        if (ok) {
            var identifierExists = false;
            for (var j = 0; j < DATA.objects.length; j++) {
                if (DATA.objects[j].identifier == identifier) {
                    identifierExists = true;
                    ok = false;
                }
            }
            if (identifierExists) {
                openModal('Il existe déjà un champ avec l\'identifiant: ' + identifier);
            } else {
                if (identifier.trim() == '') {
                    openModal('Veuillez entrer la désignation d\'abord', false);
                    ok = false;
                }
            }
        }
    }
    return ok;
}

// For the broadcast button
var broadcastButton = document.querySelector('.oak_add_field_container__broadcast_button');
if (broadcastButton) {
    broadcastButton.addEventListener('click', function () {
        if (testIdentifierExists()) 
            openModal('L’identifiant que vous venez d\'entrer a déjà été utilisé pour un autre objet !');
        else {
            objectData = createObjectData(2);
            updating = true;
            openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
        }
    });
}

// For the back to draft button: 
var draftButton = document.querySelector('.oak_add_field_container__draft_button');
if (draftButton) {
    draftButton.addEventListener('click', function () {
        if (testIdentifierExists()) 
            openModal('L’identifiant que vous venez d\'entrer a déjà été utilisé pour un autre objet !');
        else {
            objectData = createObjectData(0);
            updating = true;
            openModal('Êtes vous sûr de vouloir modifier et renvoyer ce champ à l\'état de Brouillon ?', true);
        }
    });
}

// For the trash button
var trashButton = document.querySelector('.oak_add_field_container__trash_button');
if (trashButton) {
    trashButton.addEventListener('click', function () {
        setLoading();
        jQuery(document).ready(function () {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'data': DATA.currentField.field_identifier,
                    'action': 'oak_send_field_to_trash',
                },
                success: function (data) {
                    doneLoading();
                    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_add_field');
                },
                error: function (error) {
                    console.log(error);
                    doneLoading();
                }
            });
        });
    });
}

// For the identifier input update
var designationInput = document.querySelector('.oak_add_field_container__designation');
var identifierInput = document.querySelector('.oak_add_field_container__identifier');
designationInput.oninput = function () {
    identifierInput.value = createIdentifier(designationInput.value);
}

function testIdentifierExists() {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = createIdentifier(designation);

    if (DATA.revisions.length == 0) {
        for(var i = 0; i < DATA.allObjectsWithoutRedundancy.length; i++) {
            console.log(DATA.allObjectsWithoutRedundancy[i].object_identifier);
            if (DATA.allObjectsWithoutRedundancy[i].object_identifier == identifier) {
                return true
            }
        }
    }
    return false;
}

// We create while adding the new revision
function createObjectData(state) {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = createIdentifier(designation);

    var trashed = false;

    var additionalFields = document.querySelectorAll('.oak_additional_field');
    var additionalFieldsData = [];
    for (var i = 0; i < additionalFields.length; i++) {
        var columnName = additionalFields[i].getAttribute('column-name');
        var type = additionalFields[i].getAttribute('field-type');
        var value = type == 'Image' ? additionalFields[i].parentNode.querySelector('img').getAttribute('src') : type == 'Fichier' ? additionalFields[i].getAttribute('value') : additionalFields[i].value;
        additionalFieldsData.push({
            columnName,
            value,
            type
        });
    }

    var objectData = {
        designation,
        identifier,
        state,
        trashed,
        additionalFieldsData
    }

    return objectData;
}

function createIdentifier(designation) {
    var identifier = designation.replace(/[^a-zA-Z ]/g, '');
    identifier = identifier.replace(/\s/g, '');
    return identifier.toLowerCase();
}

function whichChild(elem) {
    var i = 0;
    while ((elem = elem.previousSibling) != null)++i;
    return i;
}

// for the browse revisions button:
browseRevisionsButton = document.querySelector('.oak_add_field_big_container_tabs_single_tab_section_state__browse');
browseRevisionsButton.addEventListener('click', function () {
    if (DATA.revisions.length > 0) {
        browsingRevisions = true;
        openModal('Liste des révisions', true);
        // Changing the modal's width

        objectData = createObjectData(DATA.revisions[DATA.revisions.length - 1].object_state);

        var additionalFields = document.querySelectorAll('.oak_additional_field');
        var additionalFieldsCurrent = document.querySelectorAll('.oak_additional_field_current');
        for (var i = 0; i < additionalFields.length; i++) {
            additionalFieldsCurrent[i].value = additionalFields[i].value;
        }

        // document.querySelector('.oak_revision_object_current_publication').value = objectData.publication;

        var state = objectData.state == 0 ? 'Brouillon' : objectData.state == 1 ? 'Enregsitré' : 'Diffusé';
        document.querySelector('.oak_revision_object_current_state').value = state;
    }
});

// For the browse revisions select button: 
var revisionsButtons = document.querySelectorAll('.oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions__single_revision');
for (var i = 0; i < revisionsButtons.length; i++) {
    revisionsButtons[i].addEventListener('click', function () {
        for (var j = 0; j < revisionsButtons.length; j++) {
            revisionsButtons[j].classList.remove('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
        }
        this.classList.add('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
        document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container').classList.remove('oak_hidden');

        // Updating the selected revision fields:
        var selectedRevision = DATA.revisions[this.getAttribute('index')];
        revision = selectedRevision;

        var revisionStateField = document.querySelector('.oak_revision_object_revision_state');

        var additionalFieldsCurrent = document.querySelectorAll('.oak_additional_field_current');
        var additionalFieldsRevision = document.querySelectorAll('.additional_field_revision');
        for (var i = 0; i < additionalFieldsRevision.length; i++) {
            var columnName = additionalFieldsRevision[i].getAttribute('column-name');
            additionalFieldsRevision[i].value = selectedRevision[columnName];
        }

        for (var i = 0; i < additionalFieldsCurrent.length; i++) {
            checkEquals(additionalFieldsCurrent[i].value, additionalFieldsRevision[i].value, additionalFieldsRevision[i]);
        }

        var state = selectedRevision.object_state == '0' ? 'Brouillon' : selectedRevision.object_state == '1' ? 'Enregsitré' : 'Diffusé';
        revisionStateField.value = state;

        checkEquals(document.querySelector('.oak_revision_object_current_state').value, document.querySelector('.oak_revision_object_revision_state').value, document.querySelector('.oak_revision_object_revision_state'));
    });
}

function checkEquals(value1, value2, field) {
    if (value1 == value2) {
        field.classList.remove('oak_error');
    } else {
        field.classList.add('oak_error');
    }
}

// designation select listener
handleDesignationSelectsListeners();
function handleDesignationSelectsListeners() {
    var designationsSelects = document.querySelectorAll('.oak_add_object_forms_list_horizontal__designation_select');
    for (var i = 0; i < designationsSelects.length; i++) {
        designationsSelects[i].setAttribute('index', i);
        var theParentOfTheParent = designationsSelects[i].parentNode.parentNode;
        theParentOfTheParent.querySelector('.oak_add_object_field_identifier').value = createIdentifier(designationsSelects[i].value);
        designationsSelects[i].addEventListener('change', function () {
            var theParentOfTheParent = this.parentNode.parentNode;
            theParentOfTheParent.querySelector('.oak_add_object_field_identifier').value = createIdentifier(this.value);
        });
    }
}

function readUrl(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            if (input.getAttribute('field-type') == 'Image') {
                input.parentNode.querySelector('img').setAttribute('src', e.target.result);
            } else if (input.getAttribute('field-type') == 'Fichier') {
                input.setAttribute('value', e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
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
    if (twoButtons) {
        addButtonContainer.style.display = 'flex';
        cancelButtonContainer.style.display = 'flex';
        okButtonContainer.style.display = 'none';
    } else {
        addButtonContainer.style.display = 'none';
        cancelButtonContainer.style.display = 'none';
        okButtonContainer.style.display = 'flex';
    }
}

var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');
okButtonContainer.addEventListener('click', function () {
    closeModals();
});

function closeModals() {

    setTimeout(function () {
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
    setTimeout(function () {
        document.querySelector('.oak_loader').classList.add('oak_hidden');
        document.querySelector('.oak_add_element_modal_container__modal').classList.remove('oak_hidden');
    }, 1000);
}

handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function () {
        if (adding || updating) {
            console.log(objectData);
            closeModals();
            setLoading();
            jQuery(document).ready(function () {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_object',
                        'data': objectData,
                        'modelIdentifier': DATA.modelIdentifier
                    },
                    success: function (data) {
                        DATA.objects.push(objectData);
                        doneLoading();
                        console.log(data);
                        window.location.reload();
                    },
                    error: function (error) {
                        doneLoading();
                    }
                });
            })
        }
        if (canceling) {
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_objects_list');
        }
        if (browsingRevisions) {
            revision.designation = revision.object_designation;
            revision.identifier = revision.object_identifier;
            revision.state = revision.object_state;
            revision.trashed = revision.object_trashed;
            revision.additionalFieldsData = [];
            var additionalFieldsRevision = document.querySelectorAll('.additional_field_revision');
            for (var i = 0; i < additionalFieldsRevision.length; i++) {
                var type = additionalFieldsRevision[i].getAttribute('field-type');
                var value = type == 'Image' ? additionalFieldsRevision[i].parentNode.querySelector('img').getAttribute('src') : type == 'Fichier' ? additionalFieldsRevision[i].getAttribute('value') : additionalFieldsRevision[i].value;
                revision.additionalFieldsData.push({
                    columnName: additionalFieldsRevision[i].getAttribute('column-name'),
                    value,
                    type
                });
            }
            closeModals();
            setLoading();
            jQuery(document).ready(function () {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_object',
                        'data': revision,
                        'modelIdentifier': DATA.modelIdentifier
                    },
                    success: function (data) {
                        doneLoading();
                        console.log(data);
                        window.location.reload();
                    },
                    error: function (error) {
                        doneLoading();
                    }
                });
            })
        }
    });

    var cancelButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function () {
        closeModals();
    });
}

function backToList() {
    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
}