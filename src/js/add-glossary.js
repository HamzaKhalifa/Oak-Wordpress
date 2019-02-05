// Global variables
var adding = false;
var glossaryData = {};
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
        glossaryData = createGlossaryData(0);
        adding = true;
        openModal('Êtes vous sur de vouloir ajouter cette terminologie?', true);
    });
}

// For the update button 
var updateButton = document.querySelector('.oak_add_field_container__update_button');
if (updateButton) {
    updateButton.addEventListener('click', function () {
        glossaryData = createGlossaryData(DATA.revisions[DATA.revisions.length - 1].glossary_state);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier cette terminologie?', true);
    });
}

// For the register button
var registerButton = document.querySelector('.oak_add_field_container__register_button');
if (registerButton) {
    registerButton.addEventListener('click', function () {
        glossaryData = createGlossaryData(1);
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
        for (var i = 0; i < DATA.glossaries.length; i++) {
            if (DATA.glossaries[i].designation == designation) {
                openModal('Il existe déjà une organisation avec la désignation: ' + designation);
                ok = false;
            }
        }
        if (ok) {
            var identifierExists = false;
            for (var j = 0; j < DATA.glossaries.length; j++) {
                if (DATA.glossaries[j].identifier == identifier) {
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
        glossaryData = createGlossaryData(2);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
    });
}

// For the back to draft button: 
var draftButton = document.querySelector('.oak_add_field_container__draft_button');
if (draftButton) {
    draftButton.addEventListener('click', function () {
        glossaryData = createGlossaryData(0);
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
function createGlossaryData(state) {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = createIdentifier(designation);
    var publications =  jQuery('.oak_add_field_container__publication').val();
    var publication = '';
    if (publications != null) {
        for(var i = 0; i < publications.length; i++) {
            var delimiter = '|';
            if ( i == publications.length - 1 )
                delimiter = '';
    
            publication += publications[i] + delimiter;
        }
    }
    
    var object = document.querySelector('.oak_add_field_container__object').value;
    var depends = document.querySelector('.oak_add_field_container__depends').checked;
    var parent = document.querySelector('.oak_add_field_container__parent').value;
    var definition = document.querySelector('.oak_add_field_container__definition').value;
    var close = document.querySelector('.oak_add_field_container__close').checked;
    var closeIndicators = document.querySelector('.oak_add_field_container__close_indicators').value;
    var trashed = false;

    var glossaryData = {
        designation,
        identifier,
        publication,
        object,
        depends,
        parent,
        definition,
        close,
        closeIndicators,
        state,
        trashed
    };
    console.log(glossaryData);

    return glossaryData;
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

        glossaryData = createGlossaryData(DATA.revisions[DATA.revisions.length - 1].glossary_state);

        document.querySelector('.oak_revision_glossary_current_publication').value = glossaryData.publication;
        document.querySelector('.oak_revision_glossary_current_object').value = glossaryData.object;
        document.querySelector('.oak_revision_glossary_current_depends').value = glossaryData.depends;
        document.querySelector('.oak_revision_glossary_current_parent').value = glossaryData.parent;
        document.querySelector('.oak_revision_glossary_current_definition').value = glossaryData.definition;
        document.querySelector('.oak_revision_glossary_current_close').value = glossaryData.close;
        document.querySelector('.oak_revision_glossary_current_close_indicators').value = glossaryData.closeIndicators;
        var state = glossaryData.state == 0 ? 'Brouillon' : glossaryData.state == 1 ? 'Enregsitré' : 'Diffusé';
        document.querySelector('.oak_revision_glossary_current_state').value = state;
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

        var revisionPublicationField = document.querySelector('.oak_revision_glossary_revision_publication');
        var revisionObjectField = document.querySelector('.oak_revision_glossary_revision_object');
        var revisionDependsField = document.querySelector('.oak_revision_glossary_revision_depends');
        var revisionParentField = document.querySelector('.oak_revision_glossary_revision_parent');
        var revisionDefinitionField = document.querySelector('.oak_revision_glossary_revision_definition');
        var revisionCloseField = document.querySelector('.oak_revision_glossary_revision_close');
        var revisionCloseIndicatorsField = document.querySelector('.oak_revision_glossary_revision_close_indicators');
        var revisionStateField = document.querySelector('.oak_revision_glossary_revision_state');

        revisionPublicationField.value = selectedRevision.glossary_publication;
        revisionObjectField.value = selectedRevision.glossary_object;
        revisionDependsField.value = selectedRevision.glossary_depends;
        revisionParentField.value = selectedRevision.glossary_parent;
        revisionDefinitionField.value = selectedRevision.glossary_definition;
        revisionCloseField.value = selectedRevision.glossary_close;
        revisionCloseIndicatorsField.value = selectedRevision.glossary_close_indicators;

        var state = selectedRevision.glossary_state == '0' ? 'Brouillon' : selectedRevision.glossary_state == '1' ? 'Enregsitré' : 'Diffusé';
        revisionStateField.value = state;

        // Getting the current revision values;
        var glossaryData = createGlossaryData(DATA.revisions[DATA.revisions.length - 1].glossary_state);

        checkEquals(glossaryData.publication == null ? '' : glossaryData.publication, selectedRevision.glossary_publication, revisionPublicationField);
        checkEquals(glossaryData.object, selectedRevision.glossary_object, revisionObjectField);
        checkEquals(glossaryData.depends, selectedRevision.glossary_depends, revisionDependsField);
        checkEquals(glossaryData.parent, selectedRevision.glossary_parent, revisionParentField);
        checkEquals(glossaryData.definition, selectedRevision.glossary_definition, revisionDefinitionField);
        checkEquals(glossaryData.close, selectedRevision.glossary_close, revisionCloseField);
        checkEquals(glossaryData.closeIndicators, selectedRevision.glossary_close_indicators, revisionCloseIndicatorsField);

        checkEquals(document.querySelector('.oak_revision_glossary_current_state').value, document.querySelector('.oak_revision_glossary_revision_state').value, document.querySelector('.oak_revision_glossary_revision_state'));
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
    var designationsSelects = document.querySelectorAll('.oak_add_glossary_forms_list_horizontal__designation_select');
    for (var i = 0; i < designationsSelects.length; i++) {
        designationsSelects[i].setAttribute('index', i);
        var theParentOfTheParent = designationsSelects[i].parentNode.parentNode;
        theParentOfTheParent.querySelector('.oak_add_glossary_field_identifier').value = createIdentifier(designationsSelects[i].value);
        designationsSelects[i].addEventListener('change', function () {
            var theParentOfTheParent = this.parentNode.parentNode;
            theParentOfTheParent.querySelector('.oak_add_glossary_field_identifier').value = createIdentifier(this.value);
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
            jQuery(document).ready(function () {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_glossary',
                        'data': glossaryData,
                    },
                    success: function (data) {
                        DATA.glossaries.push(glossaryData);
                        doneLoading();
                        console.log(data);
                        // window.location.reload();
                    },
                    error: function (error) {
                        doneLoading();
                    }
                });
            })
        }
        if (canceling) {
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_glossaries_list');
        }
        if (browsingRevisions) {
            revision.designation = revision.glossary_designation;
            revision.identifier = revision.glossary_identifier;
            revision.publication = revision.glossary_publication;
            revision.object = revision.glossary_object;
            revision.depends = revision.glossary_depends;
            revision.parent = revision.glossary_parent;
            revision.definition = revision.glossary_definition;
            revision.close = revision.glossary_close;
            revision.closeIndicators = revision.glossary_close_indicators;
            revision.state = revision.glossary_state;
            revision.trashed = revision.glossary_trashed;
            closeModals();
            setLoading();
            jQuery(document).ready(function () {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_glossary',
                        'data': revision,
                    },
                    success: function (data) {
                        doneLoading();
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
