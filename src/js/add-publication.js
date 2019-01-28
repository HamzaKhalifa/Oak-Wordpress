// Global variables
var adding = false;
var publicationData = {};
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
        publicationData = createPublicationData(0);
        adding = true;
        openModal('Êtes vous sur de vouloir ajouter cette Publication?', true);
    });
}

// For the update button 
var updateButton = document.querySelector('.oak_add_field_container__update_button');
if (updateButton) {
    updateButton.addEventListener('click', function () {
        publicationData = createPublicationData(DATA.revisions[DATA.revisions.length - 1].publication_state);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier cette Publication?', true);
    });
}

// For the register button
var registerButton = document.querySelector('.oak_add_field_container__register_button');
if (registerButton) {
    registerButton.addEventListener('click', function () {
        publicationData = createPublicationData(1);
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
        for (var i = 0; i < DATA.publications.length; i++) {
            if (DATA.publications[i].designation == designation) {
                openModal('Il existe déjà une organisation avec la désignation: ' + designation);
                ok = false;
            }
        }
        if (ok) {
            var identifierExists = false;
            for (var j = 0; j < DATA.publications.length; j++) {
                if (DATA.publications[j].identifier == identifier) {
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
        publicationData = createPublicationData(2);
        updating = true;
        openModal('Êtes vous sûr de vouloir modifier et diffuser ce champ ?', true);
    });
}

// For the back to draft button: 
var draftButton = document.querySelector('.oak_add_field_container__draft_button');
if (draftButton) {
    draftButton.addEventListener('click', function () {
        publicationData = createPublicationData(0);
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
function createPublicationData(state) {
    var designation = document.querySelector('.oak_add_field_container__designation').value;
    var identifier = createIdentifier(designation);
    var organization = document.querySelector('.oak_add_field_container__designation').value;
    var year = document.querySelector('.oak_add_field_container__year').value;
    var headpiece = document.querySelector('.oak_add_field_container__headpiece_img').getAttribute('src');
    var format = document.querySelector('.oak_add_field_container__format').value;
    var file = document.querySelector('.oak_add_field_container__file').value;
    var description = document.querySelector('.oak_add_field_container__description').value;
    var reportOrFrame = document.querySelector('.oak_add_field_container__report_or_frame').value;
    var local = document.querySelector('.oak_add_field_container__local').checked;
    var country = document.querySelector('.oak_add_field_container__country').value;
    var reportType = document.querySelector('.oak_add_field_container__report_type').value;
    var frameType = document.querySelector('.oak_add_field_container__frame_type').value;
    var sectorialFrame = document.querySelector('.oak_add_field_container__sectorial_frame').value;
    var sectors = document.querySelector('.oak_add_field_container__sectors').value;
    var language = document.querySelector('.oak_add_field_container__language').value;
    var griType = document.querySelector('.oak_add_field_container__gri_type').value;
    var sectorialSupplement = document.querySelector('.oak_add_field_container__sectorial_supplement').value;
    var trashed = false;

    var publicationData = {
        designation,
        identifier,
        organization,
        year,
        headpiece,
        format,
        file,
        description,
        reportOrFrame,
        local,
        country,
        reportType,
        frameType,
        sectorialFrame,
        sectors,
        language,
        griType,
        sectorialSupplement,
        state,
        trashed
    }

    return publicationData;
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

        publicationData = createPublicationData(DATA.revisions[DATA.revisions.length - 1].publication_state);

        document.querySelector('.oak_revision_publication_current_organization').value = publicationData.organization;
        document.querySelector('.oak_revision_publication_current_year').value = publicationData.year;
        document.querySelector('.oak_revision_publication_current_headpiece').value = publicationData.headpiece;
        document.querySelector('.oak_revision_publication_current_format').value = publicationData.format;

        document.querySelector('.oak_revision_publication_current_file').value = publicationData.file;
        document.querySelector('.oak_revision_publication_current_description').value = publicationData.description;
        document.querySelector('.oak_revision_publication_current_report_or_frame').value = publicationData.reportOrFrame;

        document.querySelector('.oak_revision_publication_current_local').value = publicationData.local;
        document.querySelector('.oak_revision_publication_current_country').value = publicationData.country;
        document.querySelector('.oak_revision_publication_current_report_type').value = publicationData.reportType;
        document.querySelector('.oak_revision_publication_current_frame_type').value = publicationData.frameType;
        document.querySelector('.oak_revision_publication_current_sectorial_frame').value = publicationData.sectorialFrame;
        document.querySelector('.oak_revision_publication_current_sectors').value = publicationData.sectors;
        document.querySelector('.oak_revision_publication_current_language').value = publicationData.language;
        document.querySelector('.oak_revision_publication_current_gri_type').value = publicationData.griType;
        document.querySelector('.oak_revision_publication_current_sectorial_supplement').value = publicationData.sectorialSupplement;
        var state = publicationData.state == 0 ? 'Brouillon' : publicationData.state == 1 ? 'Enregsitré' : 'Diffusé';
        document.querySelector('.oak_revision_publication_current_state').value = state;
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


        var revisionOrganizationField = document.querySelector('.oak_revision_publication_revision_organization');
        var revisionYearField = document.querySelector('.oak_revision_publication_revision_year');
        var revisionHeadpieceField = document.querySelector('.oak_revision_publication_revision_headpiece');
        var revisionFormatField = document.querySelector('.oak_revision_publication_revision_format');
        var revisionFileField = document.querySelector('.oak_revision_publication_revision_file');
        var revisionDescriptionField = document.querySelector('.oak_revision_publication_revision_description');
        var revisionReportOrFrameField = document.querySelector('.oak_revision_publication_revision_report_or_frame');
        var revisionLocalField = document.querySelector('.oak_revision_publication_revision_local');
        var revisionCountryField = document.querySelector('.oak_revision_publication_revision_country');
        var revisionReportTypeField = document.querySelector('.oak_revision_publication_revision_report_type');
        var revisionFrameTypeField = document.querySelector('.oak_revision_publication_revision_frame_type');
        var revisionSectorialFrameField = document.querySelector('.oak_revision_publication_revision_sectorial_frame');
        var revisionSectorsField = document.querySelector('.oak_revision_publication_revision_sectors');
        var revisionLanguageField = document.querySelector('.oak_revision_publication_revision_language');
        var revisionGriTypeField = document.querySelector('.oak_revision_publication_revision_gri_type');
        var revisionSectorialSupplementField = document.querySelector('.oak_revision_publication_revision_sectorial_supplement');
        var revisionStateField =  document.querySelector('.oak_revision_publication_revision_state');

        revisionOrganizationField.value = selectedRevision.publication_organization;
        revisionYearField.value = selectedRevision.publication_year;
        revisionHeadpieceField.value = selectedRevision.publication_headpiece;
        revisionFormatField.value = selectedRevision.publication_format;
        revisionFileField.value = selectedRevision.publication_file;
        revisionDescriptionField.value = selectedRevision.publication_description;
        revisionReportOrFrameField.value = selectedRevision.publication_report_or_frame;
        revisionLocalField.value = selectedRevision.publication_local;
        revisionCountryField.value = selectedRevision.publication_country;
        revisionReportTypeField.value = selectedRevision.publication_report_type;
        revisionFrameTypeField.value = selectedRevision.publication_frame_type;
        revisionSectorialFrameField.value = selectedRevision.publication_sectorial_frame;
        revisionSectorsField.value = selectedRevision.publication_sectors;
        revisionLanguageField.value = selectedRevision.publication_language;
        revisionGriTypeField.value = selectedRevision.publication_gri_type;
        revisionSectorialSupplementField.value = selectedRevision.publication_sectorial_supplement;

        var state = selectedRevision.publication_state == '0' ? 'Brouillon' : selectedRevision.publication_state == '1' ? 'Enregsitré' : 'Diffusé';
        revisionStateField.value = state;

        // Getting the current revision values;
        var publicationData = createPublicationData(DATA.revisions[DATA.revisions.length - 1].publication_state);

        checkEquals(publicationData.organization, selectedRevision.publication_organization, revisionOrganizationField);
        checkEquals(publicationData.year, selectedRevision.publication_year, revisionYearField);
        checkEquals(publicationData.headpiece, selectedRevision.publication_headpiece, revisionHeadpieceField);
        checkEquals(publicationData.format, selectedRevision.publication_format, revisionFormatField);
        checkEquals(publicationData.file, selectedRevision.publication_file, revisionFileField);
        checkEquals(publicationData.description, selectedRevision.publication_description, revisionDescriptionField);
        checkEquals(publicationData.local, selectedRevision.publication_local, revisionLocalField);
        checkEquals(publicationData.country, selectedRevision.publication_country, revisionCountryField);
        checkEquals(publicationData.reportType, selectedRevision.publication_report_type, revisionReportTypeField);
        checkEquals(publicationData.frameType, selectedRevision.publication_frame_type, revisionFrameTypeField);
        checkEquals(publicationData.sectorialFrame, selectedRevision.publication_sectorial_frame, revisionSectorialFrameField);
        checkEquals(publicationData.sectors, selectedRevision.publication_sectors, revisionSectorsField);
        checkEquals(publicationData.language, selectedRevision.publication_language, revisionLanguageField);
        checkEquals(publicationData.griType, selectedRevision.publication_gri_type, revisionGriTypeField);
        checkEquals(publicationData.sectorialSupplement, selectedRevision.publication_sectorial_supplement, revisionSectorialSupplementField);
        checkEquals(publicationData.state, selectedRevision.publication_state, revisionStateField);

        checkEquals(document.querySelector('.oak_revision_publication_current_state').value, document.querySelector('.oak_revision_publication_revision_state').value, document.querySelector('.oak_revision_publication_revision_state'));
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
    var designationsSelects = document.querySelectorAll('.oak_add_publication_forms_list_horizontal__designation_select');
    for (var i = 0; i < designationsSelects.length; i++) {
        designationsSelects[i].setAttribute('index', i);
        var theParentOfTheParent = designationsSelects[i].parentNode.parentNode;
        theParentOfTheParent.querySelector('.oak_add_publication_field_identifier').value = createIdentifier(designationsSelects[i].value);
        designationsSelects[i].addEventListener('change', function () {
            var theParentOfTheParent = this.parentNode.parentNode;
            theParentOfTheParent.querySelector('.oak_add_publication_field_identifier').value = createIdentifier(this.value);
        });
    }
}

// For the report or frame select
var reportOrFrameSelect = document.querySelector('.oak_add_field_container__report_or_frame');
reportOrFrameSelect.addEventListener('change', function() {
    var reportType = document.querySelector('.oak_add_field_container__report_type_container');
    var frameType = document.querySelector('.oak_add_field_container__frame_type_container');
    var sectorialFrame = document.querySelector('.oak_add_field_container__sectorial_frame_container');
    var sectors = document.querySelector('.oak_add_field_container__sectors_container');
    var griType = document.querySelector('.oak_add_field_container__gri_type_container');
    var sectorialSupplement = document.querySelector('.oak_add_field_container__sectorial_supplement_container');
    if (reportOrFrameSelect.value == 'report') {
        reportType.classList.remove('oak_hidden');
        griType.classList.remove('oak_hidden');
        sectorialSupplement.classList.remove('oak_hidden');
        frameType.classList.add('oak_hidden');
        sectorialFrame.classList.add('oak_hidden');
        sectors.classList.add('oak_hidden');
    } else {
        reportType.classList.add('oak_hidden');
        griType.classList.add('oak_hidden');
        sectorialSupplement.classList.add('oak_hidden');
        frameType.classList.remove('oak_hidden');
        sectorialFrame.classList.remove('oak_hidden');
        sectors.classList.remove('oak_hidden');
    }
});

// For the local publication listener 
var localPublication = document.querySelector('.oak_add_field_container__local');
localPublication.addEventListener('change', function() {
    var countrySelect = document.querySelector('.oak_country_select_container');
    if (localPublication.checked) {
        countrySelect.classList.remove('oak_hidden');
    } else {
        countrySelect.classList.add('oak_hidden');
    }
});

// For the sectorial frame listener:
var sectorialFrameCheckbox = document.querySelector('.oak_add_field_container__sectorial_frame');
sectorialFrameCheckbox.addEventListener('change', function() {
    var sectorsSelectorContainer = document.querySelector('.oak_add_field_container__sectors_container');
    if (this.checked) {
        sectorsSelectorContainer.classList.remove('oak_hidden');
    } else {
        sectorsSelectorContainer.classList.add('oak_hidden');
    }
});

function readUrl(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            if (this.getAttribute('name') = 'headpiece')
                document.querySelector('.oak_add_field_container__headpiece_img').setAttribute('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
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
                        'action': 'oak_register_publication',
                        'data': publicationData,
                    },
                    success: function (data) {
                        DATA.publications.push(publicationData);
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
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_publications_list');
        }
        if (browsingRevisions) {
            revision.designation = revision.publication_designation;
            revision.identifier = revision.publication_identifier;
            revision.acronym = revision.publication_acronym;
            revision.logo = revision.publication_logo;
            revision.description = revision.publication_description;
            revision.url = revision.publication_url;
            revision.address = revision.publication_address;
            revision.country = revision.publication_country;
            revision.company = revision.publication_company;
            revision.type = revision.publication_type;
            revision.side = revision.publication_side;
            revision.sectors = revision.publication_sectors;
            revision.state = revision.publication_state;
            revision.trashed = revision.publication_trashed;

            closeModals();
            setLoading();
            jQuery(document).ready(function () {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_publication',
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
