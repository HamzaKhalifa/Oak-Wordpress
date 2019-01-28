// Global variables
var adding = false;
var quantiData = {};
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
        quantiData = createquantiData(0);
        adding = true;
        openModal('Êtes vous sur de vouloir ajouter cette terminologie?', true);
    });
}

// For the update button 
var updateButton = document.querySelector('.oak_add_field_container__update_button');
if (updateButton) {
    updateButton.addEventListener('click', function () {
        quantiData = createquantiData(DATA.revisions[DATA.revisions.length - 1].quanti_state);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier cette terminologie?', true);
    });
}

// For the register button
var registerButton = document.querySelector('.oak_add_field_container__register_button');
if (registerButton) {
    registerButton.addEventListener('click', function () {
        quantiData = createquantiData(1);
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
        for (var i = 0; i < DATA.quantis.length; i++) {
            if (DATA.quantis[i].designation == designation) {
                openModal('Il existe déjà une organisation avec la désignation: ' + designation);
                ok = false;
            }
        }
        if (ok) {
            var identifierExists = false;
            for (var j = 0; j < DATA.quantis.length; j++) {
                if (DATA.quantis[j].identifier == identifier) {
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
        quantiData = createquantiData(2);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
    });
}

// For the back to draft button: 
var draftButton = document.querySelector('.oak_add_field_container__draft_button');
if (draftButton) {
    draftButton.addEventListener('click', function () {
        quantiData = createquantiData(0);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et renvoyer ce champ à l\'état de Brouillon ?', true);
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
                    console.log(data);
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

// We create while adding the new revision
function createquantiData(state) {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = createIdentifier(designation);
    var publication =  jQuery('.oak_add_field_container__publication').val();
    var object = document.querySelector('.oak_add_field_container__object').value;
    var depends = document.querySelector('.oak_add_field_container__depends').checked;
    var parent = document.querySelector('.oak_add_field_container__parent').value;
    var numerotationType = document.querySelector('.oak_add_field_container__numerotation_type').value;
    var numerotation = document.querySelector('.oak_add_field_container__numerotation').value;
    var description = document.querySelector('.oak_add_field_container__description').value;
    var close = document.querySelector('.oak_add_field_container__close').checked;
    var closeIndicators = jQuery('.oak_add_field_container__close_indicators').val();
    var trashed = false;

    var quantiData = {
        designation,
        identifier,
        publication,
        object,
        depends,
        parent,
        numerotationType,
        numerotation,
        description,
        close,
        closeIndicators,
        state,
        trashed
    }

    return quantiData;
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

        quantiData = createquantiData(DATA.revisions[DATA.revisions.length - 1].quanti_state);

        document.querySelector('.oak_revision_quanti_current_publication').value = quantiData.publication;
        document.querySelector('.oak_revision_quanti_current_object').value = quantiData.object;
        document.querySelector('.oak_revision_quanti_current_depends').value = quantiData.depends;
        document.querySelector('.oak_revision_quanti_current_parent').value = quantiData.parent;
        document.querySelector('.oak_revision_quanti_current_numerotation_type').value = quantiData.numerotationType;
        document.querySelector('.oak_revision_quanti_current_numerotation').value = quantiData.numerotation;
        document.querySelector('.oak_revision_quanti_current_description').value = quantiData.description;
        document.querySelector('.oak_revision_quanti_current_close').value = quantiData.close;
        document.querySelector('.oak_revision_quanti_current_close_indicators').value = quantiData.closeIndicators;
        var state = quantiData.state == 0 ? 'Brouillon' : quantiData.state == 1 ? 'Enregsitré' : 'Diffusé';
        document.querySelector('.oak_revision_quanti_current_state').value = state;
    }
});

// For the browse revisions select button: 
var revisionsButtons = document.querySelectorAll('.oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision');
for (var i = 0; i < revisionsButtons.length; i++) {
    revisionsButtons[i].addEventListener('click', function () {
        for (var j = 0; j < revisionsButtons.length; j++) {
            revisionsButtons[j].classList.remove('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
        }
        this.classList.add('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
        document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container').classList.remove('oak_hidden');

        // Updating the selected revision fields:
        var selectedRevision = DATA.revisions[this.getAttribute('index')];
        revision = selectedRevision;
        console.log('revision', revision);

        var revisionPublicationField = document.querySelector('.oak_revision_quanti_revision_publication');
        var revisionObjectField = document.querySelector('.oak_revision_quanti_revision_object');
        var revisionDependsField = document.querySelector('.oak_revision_quanti_revision_depends');
        var revisionParentField = document.querySelector('.oak_revision_quanti_revision_parent');
        var revisionNumerotationTypeField = document.querySelector('.oak_revision_quanti_revision_numerotation_type');
        var revisionNumerotationField = document.querySelector('.oak_revision_quanti_revision_numerotation');
        var revisionDescriptionField = document.querySelector('.oak_revision_quanti_revision_description');
        var revisionCloseField = document.querySelector('.oak_revision_quanti_revision_close');
        var revisionCloseIndicatorsField = document.querySelector('.oak_revision_quanti_revision_close_indicators');
        var revisionStateField = document.querySelector('.oak_revision_quanti_revision_state');

        revisionPublicationField.value = selectedRevision.quanti_publication;
        revisionObjectField.value = selectedRevision.quanti_object;
        revisionDependsField.value = selectedRevision.quanti_depends;
        revisionParentField.value = selectedRevision.quanti_parent;
        revisionNumerotationTypeField.value = selectedRevision.quanti_numerotation_type;
        revisionNumerotationField.value = selectedRevision.quanti_numerotation;
        revisionDescriptionField.value = selectedRevision.quanti_description;
        revisionCloseField.value = selectedRevision.quanti_close;
        revisionCloseIndicatorsField.value = selectedRevision.quanti_close_indicators;

        var state = selectedRevision.quanti_state == '0' ? 'Brouillon' : selectedRevision.quanti_state == '1' ? 'Enregsitré' : 'Diffusé';
        revisionStateField.value = state;

        // Getting the current revision values;
        var quantiData = createquantiData(DATA.revisions[DATA.revisions.length - 1].quanti_state);

        checkEquals(quantiData.publication == null ? '' : quantiData.publication, selectedRevision.quanti_publication, revisionPublicationField);
        checkEquals(quantiData.object, selectedRevision.quanti_object, revisionObjectField);
        checkEquals(quantiData.depends.toString(), selectedRevision.quanti_depends, revisionDependsField);
        checkEquals(quantiData.parent, selectedRevision.quanti_parent, revisionParentField);
        checkEquals(quantiData.numerotationType, selectedRevision.quanti_numerotation_type, revisionNumerotationTypeField);
        checkEquals(quantiData.numerotation, selectedRevision.quanti_numerotation, revisionNumerotationField);
        checkEquals(quantiData.description, selectedRevision.quanti_description, revisionDescriptionField);
        checkEquals(quantiData.close.toString(), selectedRevision.quanti_close.toString(), revisionCloseField);
        checkEquals(quantiData.closeIndicators == null ? '' : quantidData.closeIndicators, selectedRevision.quanti_close_indicators, revisionCloseIndicatorsField);

        checkEquals(document.querySelector('.oak_revision_quanti_current_state').value, document.querySelector('.oak_revision_quanti_revision_state').value, document.querySelector('.oak_revision_quanti_revision_state'));
    });
}

function checkEquals(value1, value2, field) {
    if (value1 == value2) {
        field.classList.remove('oak_error');
    } else {
        field.classList.add('oak_error');
    }
}

// Checkboxes listeners: 
var parentIndicatorCheckbox = document.querySelector('.oak_add_field_container__depends');
if (parentIndicatorCheckbox.checked) {
    document.querySelector('.oak_add_field_container__parent').parentNode.classList.remove('oak_hidden');
}
parentIndicatorCheckbox.addEventListener('change', function() {
    if (this.checked) {
        document.querySelector('.oak_add_field_container__parent').parentNode.classList.remove('oak_hidden');
    } else {
        document.querySelector('.oak_add_field_container__parent').parentNode.classList.add('oak_hidden');
    }
});

var closeIndicatorCheckbox = document.querySelector('.oak_add_field_container__close');
if (closeIndicatorCheckbox.checked) {
    document.querySelector('.oak_add_field_container__close_indicators').parentNode.classList.remove('oak_hidden');
}
closeIndicatorCheckbox.addEventListener('change', function() {
    if (this.checked) {
        document.querySelector('.oak_add_field_container__close_indicators').parentNode.classList.remove('oak_hidden');
    } else {
        document.querySelector('.oak_add_field_container__close_indicators').parentNode.classList.add('oak_hidden');
    }
});

// designation select listener
handleDesignationSelectsListeners();
function handleDesignationSelectsListeners() {
    var designationsSelects = document.querySelectorAll('.oak_add_quanti_forms_list_horizontal__designation_select');
    for (var i = 0; i < designationsSelects.length; i++) {
        designationsSelects[i].setAttribute('index', i);
        var theParentOfTheParent = designationsSelects[i].parentNode.parentNode;
        theParentOfTheParent.querySelector('.oak_add_quanti_field_identifier').value = createIdentifier(designationsSelects[i].value);
        designationsSelects[i].addEventListener('change', function () {
            var theParentOfTheParent = this.parentNode.parentNode;
            theParentOfTheParent.querySelector('.oak_add_quanti_field_identifier').value = createIdentifier(this.value);
        });
    }
}

// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text');
    var cancelButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_cancel_button_container__text');
    var confirmButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
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
    var modalContainer = document.querySelector('.oak_object_model_add_formula_modal_container__modal');
    var revisionsContent = document.querySelector('.oak_object_model_add_formula_modal_container_modal_content__revisions_content');
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

    var confirmButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text');

    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_object_model_add_formula_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    var addButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container');
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

var okButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container');
okButtonContainer.addEventListener('click', function () {
    closeModals();
});

function closeModals() {

    setTimeout(function () {
        document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
        document.querySelector('.oak_object_model_add_formula_modal_container_modal_content__revisions_content').classList.add('oak_hidden');
    }, 500);

    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
    adding = canceling = updating = browsingRevisions = false;
}

function setLoading() {
    openModal();
    document.querySelector('.oak_loader').classList.remove('oak_hidden');
    document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.add('oak_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function () {
        document.querySelector('.oak_loader').classList.add('oak_hidden');
        document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.remove('oak_hidden');
    }, 1000);
}

handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function () {
        if (adding || updating) {
            closeModals();
            setLoading();
            console.log(quantiData);
            jQuery(document).ready(function () {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_quanti',
                        'data': quantiData,
                    },
                    success: function (data) {
                        DATA.quantis.push(quantiData);
                        doneLoading();
                        window.location.reload();
                    },
                    error: function (error) {
                        doneLoading();
                    }
                });
            })
        }
        if (canceling) {
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_quantis_list');
        }
        if (browsingRevisions) {
            revision.designation = revision.quanti_designation;
            revision.identifier = revision.quanti_identifier;
            revision.publication = revision.quanti_publication;
            revision.object = revision.quanti_object;
            revision.depends = revision.quanti_depends;
            revision.parent = revision.quanti_parent;
            revision.description = revision.quanti_description;
            revision.close = revision.quanti_close;
            revision.closeIndicators = revision.quanti_close_indicators;
            revision.state = revision.quanti_state;
            revision.trashed = revision.quanti_trashed;
            closeModals();
            setLoading();
            jQuery(document).ready(function () {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_quanti',
                        'data': revision,
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

    var cancelButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function () {
        closeModals();
    });
}

function backToList() {
    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
}
