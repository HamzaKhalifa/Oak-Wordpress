var publications = [];
var allData = [];
var step = 'organization';
var selectedData = {
    organization: null,
    publications: [],
    framePublications: [],
    taxonomies: [],
    terms: [],
    models: [],
    objects: [],
    forms: [],
    fields: [],
    glossaries: [],
    qualis: [],
    quantis: [],
    goodpractices: [],
    performances: [],
    sources: [],
    formsAndFields: [],
    modelsAndForms: [],
};

var steps = [];

(function() {
    setLoading();
    jQuery(document).ready(function() {
        jQuery.ajax({
            url: DATA.centralUrl,
            type: 'POST',
            data: {
                'action': 'oak_get_all_data_for_corn',
                'data': ''
            },
            success: function(data) {
                console.log(data);
                doneLoading();
                allData = data.data;
                // exportToJson(allData.allTerms);

                populateImportContainer(
                    'Organisations',
                    allData.organizationsWithoutRedundancy, 
                    ['Nom de l\'organisation', 'Pays du siège', 'Type', 'Secteur d\'activité'],
                    ['organization_identifier', 'organization_designation', 'organization_country', 'organization_type', 'organization_sectors'],
                    'organization',
                    'organization'
                );
            },
            error: function(error) {
                console.log(error);
                doneLoading();
            } 
        });
    });

    function exportToJson (objecToDownload) {
        let filename = "export.json";
        let contentType = "application/json;charset=utf-8;";
        // if (window.navigator && window.navigator.msSaveOrOpenBlob) {
        //     var blob = new Blob([decodeURIComponent(encodeURI(JSON.stringify(objecToDownload)))], { type: contentType });
        //     navigator.msSaveOrOpenBlob(blob, filename);
        // } else {
            var a = document.createElement('a');
            a.download = filename;
            a.href = 'data:' + contentType + ',' + encodeURIComponent(JSON.stringify(objecToDownload));
            a.target = '_blank';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        // }
    }

    function populateImportContainer(title, data, dataInfo, dataFields, dataType, nextStep, publicationsThatBelongNumber, fromCancel) {
        var cancelButton = document.querySelector('.next_button_container_cancel');
        if ( dataType == 'organization' ) {
            cancelButton.classList.add('oak_hidden');
        } else {
            cancelButton.classList.remove('oak_hidden');
        }
        if (!fromCancel)
            steps.push({title, data, dataInfo, dataFields, dataType, nextStep, publicationsThatBelongNumber});
        document.querySelector('.next_button_container_next').classList.add('oak_hidden');
        document.querySelector('.screen_title').innerHTML = title;
        var importContainer = document.querySelector('.import_container');
        var styleAddedToTitle = dataType == 'organization' ? 'style="margin-left: 35px;"' : dataType == 'publication' ? 'style="margin-left: 35px;"' : '';
        var oakHidden = dataType == 'organization' ? 'oak_hidden' : dataType == 'publication' ? 'oak_hidden' : '';
        importContainer.innerHTML = '<div class="import_container__line">'
            + '<div class="import_container_line__checkbox_container">'
            + '<input type="checkbox" class="import_container__element_checkbox ' + oakHidden + '">'
            + '<h4 ' + styleAddedToTitle + ' class="import_container_line_column_value import_container_line__title">' + dataInfo[0] + '</h4>'
            + '</div>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + dataInfo[1] + '</h4>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + dataInfo[2] + '</h4>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + dataInfo[3] + '</h4>'
            + '</div>';

        for (var i = 0; i < data.length; i++) {
            var additionalContent = '';
            if (i == publicationsThatBelongNumber) {
                additionalContent = '<h2 class="oak_other_publications_title">Autres Publications (N\'appartenant pas à l\'organisation "' + selectedData.organization.organization_designation + '"): </h2>';
            }

            var newLine = '<div class="import_container__line" identifier="' + data[i][dataFields[0]] + '">'
            + '<div class="import_container_line__checkbox_container">'
            + '<input type="checkbox" class="import_container__element_checkbox">'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + data[i][dataFields[1]] + '</h4>'
            + '</div>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + data[i][dataFields[2]] + '</h4>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + data[i][dataFields[3]] + '</h4>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + data[i][dataFields[4]] + '</h4>'
            + '</div>'
            importContainer.innerHTML = importContainer.innerHTML + additionalContent + newLine;
        }
        checkBoxes = importContainer.querySelectorAll('.import_container__element_checkbox');
        for (var i = 0; i < checkBoxes.length; i++) {
            checkBoxes[i].setAttribute('index', i);
            checkBoxes[i].addEventListener('change', function() {
                var atLeastOneIsChecked = false;
                for (var j = 0; j < checkBoxes.length; j++) {
                    // Check only one for organization and publication
                    if ((dataType == 'organization' || dataType == 'publication') && j != this.getAttribute('index') && this.checked ) {
                        checkBoxes[j].checked = false;
                    }
                    if (checkBoxes[j].checked) {
                        atLeastOneIsChecked = true;
                    }
                }
                var buttonNext = document.querySelector('.next_button_container_next');
                if ( step == 'frame_publications' ) {
                    buttonNext.classList.remove('oak_hidden');
                } else {
                    if (atLeastOneIsChecked)
                    buttonNext.classList.remove('oak_hidden');
                    else
                        buttonNext.classList.add('oak_hidden');
                }
                
            });
        }

        // Handle all checkboxes selection: 
        importContainer.querySelector('.import_container__element_checkbox').addEventListener('change', function() {
            if (this.checked) {
                var allCheckBoxes = importContainer.querySelectorAll('.import_container__element_checkbox');
                for (var i = 0; i < allCheckBoxes.length; i++) {
                    allCheckBoxes[i].checked = true;
                }
            }
        });

        step = nextStep;
    }

    handleCancelButton();
    function handleCancelButton() {
        var cancelButtonContainer = document.querySelector('.next_button_container_cancel');
        cancelButtonContainer.addEventListener('click', function() {
            if (steps.length > 0) {
                populateImportContainer(
                    steps[steps.length - 2].title,
                    steps[steps.length - 2].data,
                    steps[steps.length - 2].dataInfo,
                    steps[steps.length - 2].dataFields,
                    steps[steps.length - 2].dataType,
                    steps[steps.length - 2].nextStep,
                    steps[steps.length - 2].publicationsThatBelongNumber,
                    true
                )
            }
            steps.splice(steps.length - 1, 1);
        });
    }

    (function() {
        var nextButton = document.querySelector('.next_button_container_next');
        nextButton.addEventListener('click', function() {
            switch(step) {
                case 'organization':
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    var foundAChecked = false;
                    var i = 0;
                    var organizationName = ''
                    var organizationIdentifier = '';
                    do {
                        if (checkBoxes[i].checked) {
                            foundAChecked = true;
                            organizationName = checkBoxes[i].parentNode.querySelector('.import_container_line__title').innerHTML;
                            organizationIdentifier = checkBoxes[i].parentNode.parentNode.getAttribute('identifier');
                        }
                        i++;
                    } while (i < checkBoxes.length && !foundAChecked);
                    var publicationsThatBelongToOrganization = [];
                    var publicationsThatDontBelongToOrganization = [];
                    // Filtering publications by selected organization: 
                    for (var i = 0; i < allData.publicationsWithoutRedundancy.length; i++) {
                        // if (allData.publicationsWithoutRedundancy[i].publication_report_or_frame == 'report') {
                            if (allData.publicationsWithoutRedundancy[i].publication_organization == organizationIdentifier) {
                                allData.publicationsWithoutRedundancy[i].belongsToOrganization = true;
                                publicationsThatBelongToOrganization.push(allData.publicationsWithoutRedundancy[i]);
                            } else {
                                allData.publicationsWithoutRedundancy[i].belongsToOrganization = false;
                                publicationsThatDontBelongToOrganization.push(allData.publicationsWithoutRedundancy[i]);
                            }
                        // }
                    }
                    var publicationsThatBelongNumber = publicationsThatBelongToOrganization.length;
                
                    var publicationsToShow = [];
                    for (var i = 0; i < publicationsThatBelongToOrganization.length; i++) {
                        publicationsToShow.push(publicationsThatBelongToOrganization[i]);
                    }
                    for (var i = 0; i < publicationsThatDontBelongToOrganization.length; i++) {
                        publicationsToShow.push(publicationsThatDontBelongToOrganization[i]);
                    }

                    for (var i = 0; i < allData.organizationsWithoutRedundancy.length; i++) {
                        if (allData.organizationsWithoutRedundancy[i].organization_identifier == organizationIdentifier) {
                            selectedData.organization = allData.organizationsWithoutRedundancy[i];
                        }
                    }
                    populateImportContainer(
                        'Publications - ' + organizationName,
                        publicationsToShow, 
                        ['Titre de la publication', 'Pays', 'Type', 'Année'],
                        ['publication_identifier', 'publication_designation', 'publication_country', 'publication_format', 'publication_year'],
                        'publications',
                        'publications',
                        publicationsThatBelongNumber
                    );
                break;
                case 'publications':
                    var publicationsIdentifiers = [];
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    for (var i = 0; i < checkBoxes.length; i++) {
                        if (checkBoxes[i].checked) {
                            publicationsIdentifiers.push(checkBoxes[i].parentNode.parentNode.getAttribute('identifier'));
                        }
                    }
                    for (var i = 0; i < allData.publicationsWithoutRedundancy.length; i++) {
                        if (publicationsIdentifiers.indexOf(allData.publicationsWithoutRedundancy[i].publication_identifier) != -1) {
                            // selectedData.publications.push(allData.publicationsWithoutRedundancy[i]);
                            selectedData.publications = addElementAndOtherLanguagesInstancses(allData.publicationsWithoutRedundancy[i].publication_identifier, selectedData.publications, allData.publications, 'publication');
                        }
                    }
                    var taxonomiesToShow = [];
                    for (var i = 0; i < publicationsIdentifiers.length; i++) {
                        for (var j = 0; j < allData.taxonomiesWithoutRedundancy.length; j++) {
                            if (allData.taxonomiesWithoutRedundancy[j].taxonomy_publication == publicationsIdentifiers[i]) {
                                taxonomiesToShow.push(allData.taxonomiesWithoutRedundancy[j]);
                            }
                        }
                    }
                    populateImportContainer(
                        'Taxonomies',
                        taxonomiesToShow, 
                        ['Designation', 'Structure', 'Description', 'Dérnière modification'],
                        ['taxonomy_identifier', 'taxonomy_designation', 'taxonomy_structure', 'taxonomy_description', 'taxonomy_modification_time'],
                        'taxonomy',
                        'taxonomy'
                    );
                break;
                case 'taxonomy':
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    var taxonomiesIdentifiers = [];
                    for (var i = 0; i < checkBoxes.length; i++) {
                        if (checkBoxes[i].checked) {
                            taxonomiesIdentifiers.push(checkBoxes[i].parentNode.parentNode.getAttribute('identifier'));
                        }
                    }
                    var termsToPush = [];
                    for (var i = 0; i < allData.taxonomiesWithoutRedundancy.length; i++) {
                        if (taxonomiesIdentifiers.indexOf(allData.taxonomiesWithoutRedundancy[i].taxonomy_identifier) != -1 ) {
                            // selectedData.taxonomies.push(allData.taxonomiesWithoutRedundancy[i]);
                            selectedData.taxonomies = addElementAndOtherLanguagesInstancses(allData.taxonomiesWithoutRedundancy[i].taxonomy_identifier, selectedData.taxonomies, allData.taxonomies, 'taxonomy');
                            for (var j = 0; j < allData.allTerms.length; j++) {
                                if (allData.allTerms[j].taxonomy_identifier == allData.taxonomiesWithoutRedundancy[i].taxonomy_identifier) {
                                    var addedTermsIdentifiers = [];
                                    for (var n = allData.allTerms[j].terms.length; n >= 0; n--) {
                                        var term = allData.allTerms[j].terms[n];
                                        if (term != null) {
                                            term.term_taxonomy_designation = allData.taxonomiesWithoutRedundancy[i].taxonomy_designation;
                                            term.term_taxonomy_identifier = allData.taxonomiesWithoutRedundancy[i].taxonomy_identifier;
                                        }
                                        if (term != null && addedTermsIdentifiers.indexOf(term.term_identifier) == -1) {
                                            addedTermsIdentifiers.push(term.term_identifier);
                                            termsToPush.push(term);
                                        } 
                                    }
                                }
                            }
                        }
                    }
                    populateImportContainer(
                        'Termes',
                        termsToPush,
                        ['Designation', 'Taxonomie', 'Description', 'Dérnière modification'],
                        ['term_identifier', 'term_designation', 'term_taxonomy_designation', 'term_description', 'term_modification_time'],
                        'term',
                        'term'
                    );
                break;
                case 'term': 
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    var termIdentifiers = [];
                    for (var i = 0; i < checkBoxes.length; i++) {
                        if (checkBoxes[i].checked) {
                            termIdentifiers.push(checkBoxes[i].parentNode.parentNode.getAttribute('identifier'));
                        }
                    }
                    
                    for (var i = 0; i < selectedData.publications.length; i++) {
                        if ( i == selectedData.publications.length - 1 )
                            addPublicationData(selectedData.publications[i].publication_identifier, termIdentifiers);
                        else 
                            addPublicationData(selectedData.publications[i].publication_identifier, []);
                    }

                    // For the terms and objects (Gotta filter this some day)
                    selectedData.termsAndObjects = allData.termsAndObjects;

                    console.log('selected Data', selectedData);

                    setLoading();
                    startGame();
                    setLoadingPercentage('0%', 'Suppression des données..');
                    sendAjaxRequest({},'corn_delete_everything', function(success) {
                        if (success) {
                            setLoadingPercentage('5%', 'Enregistrement des organisations...');
                            sendAjaxRequest({ elements: [selectedData.organization], tableName: DATA.organizationsTableName, properties: DATA.organizationsProperties }, 'corn_save_element_request', function(success) {
                                if (success) {
                                    setLoadingPercentage('10%', 'Enregistrement des publications...');
                                    sendAjaxRequest({ elements: selectedData.publications, tableName: DATA.publicationsTableName, properties: DATA.publicationsProperties }, 'corn_save_element_request', function(success) {
                                        if (success) {
                                            setLoadingPercentage('15%', 'Enregistrement des champs...');
                                            sendAjaxRequest({ elements: selectedData.fields, tableName: DATA.fieldsTableName, properties: DATA.fieldsProperties  }, 'corn_save_element_request', function(success) {
                                                if (success) {
                                                    setLoadingPercentage('20%', 'Enregistrement des formulaires...');
                                                    sendAjaxRequest({ elements: selectedData.forms, tableName: DATA.formsTableName, properties: DATA.formsProperties  }, 'corn_save_element_request', function(success) {
                                                        if (success) {  
                                                            setLoadingPercentage('25%', 'Enregistrement des modèles...');
                                                            sendAjaxRequest({ elements: selectedData.models, tableName: DATA.modelsTableName, properties: DATA.modelsProperties  }, 'corn_save_element_request', function(success) {
                                                                if (success) {  
                                                                    setLoadingPercentage('30%', 'Enregistrement des taxonomies...');
                                                                    sendAjaxRequest({ elements: selectedData.taxonomies, tableName: DATA.taxonomiesTableName, properties: DATA.taxonomiesProperties  }, 'corn_save_element_request', function(success) {
                                                                        if (success) {  
                                                                            setLoadingPercentage('35%', 'Enregistrement des terminologies...');
                                                                            sendAjaxRequest({ elements: selectedData.glossaries, tableName: DATA.glossariesTableName, properties: DATA.glossariesProperties  }, 'corn_save_element_request', function(success) {
                                                                                if (success) {  
                                                                                    setLoadingPercentage('40%', 'Enregistrement des indicateurs qualitatifs...');
                                                                                    sendAjaxRequest({ elements: selectedData.qualis, tableName: DATA.qualisTableName, properties: DATA.qualisProperties  }, 'corn_save_element_request', function(success) {
                                                                                        if (success) {  
                                                                                            setLoadingPercentage('45%', 'Enregistrement des indicateurs quantatifs...');
                                                                                            sendAjaxRequest({ elements: selectedData.quantis, tableName: DATA.quantisTableName, properties: DATA.quantisProperties  }, 'corn_save_element_request', function(success) {
                                                                                                if (success) {  
                                                                                                    setLoadingPercentage('50%', 'Enregistrement des bonnes pratiques...');
                                                                                                    sendAjaxRequest({ elements: selectedData.goodpractices, tableName: DATA.goodpracticesTableName, properties: DATA.goodpracticesProperties  }, 'corn_save_element_request', function(success) {
                                                                                                        if (success) {  
                                                                                                            setLoadingPercentage('55%', 'Enregistrement des données de performances...');
                                                                                                            sendAjaxRequest({ elements: selectedData.performances, tableName: DATA.performancesTableName, properties: DATA.performancesProperties  }, 'corn_save_element_request', function(success) {
                                                                                                                if (success) {  
                                                                                                                    setLoadingPercentage('60%', 'Enregistrement des sources...');
                                                                                                                    sendAjaxRequest({ elements: selectedData.sources, tableName: DATA.sourcesTableName, properties: DATA.sourcesProperties  }, 'corn_save_element_request', function(success) {
                                                                                                                        if (success) {  
                                                                                                                            setLoadingPercentage('70%', 'Enregistrement des liaisons entre termes et objets...');
                                                                                                                            sendAjaxRequest({ elements: selectedData.termsAndObjects, tableName: DATA.termsAndObjectsTableName }, 'corn_save_element_request', function(success) {
                                                                                                                                if (success) {  
                                                                                                                                    setLoadingPercentage('75%', 'Enregistrement des liaisons entre formulaires et champs...');
                                                                                                                                    sendAjaxRequest({ elements: selectedData.formsAndFields, tableName: DATA.formsAndFieldsTableName }, 'corn_save_element_request', function(success) {
                                                                                                                                        if (success) {  
                                                                                                                                            setLoadingPercentage('80%', 'Enregistrement des liasons entre modèles et formulaires...');
                                                                                                                                            sendAjaxRequest({ elements: selectedData.modelsAndForms, tableName: DATA.modelsAndFormsTableName }, 'corn_save_element_request', function(success) {
                                                                                                                                                if (success) {  
                                                                                                                                                    setLoadingPercentage('85%', 'Création des tables des modèles...');
                                                                                                                                                    sendAjaxRequest({ models: selectedData.models, fields: selectedData.fields, objects: selectedData.objects }, 'create_models_tables', function(success) {
                                                                                                                                                        if (success) {
                                                                                                                                                            setLoadingPercentage('90%', 'Enregistrement des objets...');
                                                                                                                                                            sendAjaxRequest({ elements: selectedData.objects, tableName: '' }, 'corn_save_element_request', function(success) {
                                                                                                                                                                if (success) {  
                                                                                                                                                                    setLoadingPercentage('95%', 'Création des tables des taxonomies...');
                                                                                                                                                                    sendAjaxRequest({ taxonomies: selectedData.taxonomies }, 'create_taxonomies_tables', function(success) {
                                                                                                                                                                        if (success) {  
                                                                                                                                                                            setLoadingPercentage('98%', 'Enregistrement des termes des taxonomies...');
                                                                                                                                                                            sendAjaxRequest({ elements: selectedData.terms, tableName: '' }, 'corn_save_element_request', function(success) {
                                                                                                                                                                                if (success) {  
                                                                                                                                                                                    setLoadingPercentage('100%', 'Suppression des images inutiles...');
                                                                                                                                                                                    sendAjaxRequest({}, 'delete_images_that_are_not_needed', function(success) {
                                                                                                                                                                                        if (success) {  
                                                                                                                                                                                            setLoadingPercentage('100%', 'Création des termes des taxonomies');
                                                                                                                                                                                            doneLoading();
                                                                                                                                                                                            openModal('Enregistrement effectué avec succès !');
                                                                                                                                                                                        } else {
                                                                                                                                                                                            doneLoading();
                                                                                                                                                                                            setLoadingPercentage('0%', 'Erreur avec la suppression des images inutiles');
                                                                                                                                                                                            endGame();
                                                                                                                                                                                        }
                                                                                                                                                                                    });
                                                                                                                                                                                } else {
                                                                                                                                                                                    doneLoading();
                                                                                                                                                                                    setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des termes');
                                                                                                                                                                                }
                                                                                                                                                                            });
                                                                                                                                                                        } else {
                                                                                                                                                                            doneLoading();
                                                                                                                                                                            setLoadingPercentage('0%', 'Erreur avec la céation des tables des taxonomies');
                                                                                                                                                                        }
                                                                                                                                                                    });
                                                                                                                                                                } else {
                                                                                                                                                                    doneLoading();
                                                                                                                                                                    setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des objets');
                                                                                                                                                                }
                                                                                                                                                            });
                                                                                                                                                        } else {
                                                                                                                                                            doneLoading();
                                                                                                                                                            setLoadingPercentage('0%', 'Erreur avec la création des tables des modèles');
                                                                                                                                                        }
                                                                                                                                                    });
                                                                                                                                                } else {
                                                                                                                                                    doneLoading();
                                                                                                                                                    setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Liasons modèles et formulaires');
                                                                                                                                                }
                                                                                                                                            });
                                                                                                                                        } else {
                                                                                                                                            doneLoading();
                                                                                                                                            setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Liasons formulaires et champs');
                                                                                                                                        }
                                                                                                                                    });
                                                                                                                                } else {
                                                                                                                                    doneLoading();
                                                                                                                                    setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Liasons termes et objets');
                                                                                                                                }
                                                                                                                            });
                                                                                                                        } else {
                                                                                                                            doneLoading();
                                                                                                                            setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Sources');
                                                                                                                        }
                                                                                                                    });
                                                                                                                } else {
                                                                                                                    doneLoading();
                                                                                                                    setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Données de performances');
                                                                                                                }
                                                                                                            });
                                                                                                        } else {
                                                                                                            doneLoading();
                                                                                                            setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Bonnes pratiques');
                                                                                                        }
                                                                                                    });
                                                                                                } else {
                                                                                                    doneLoading();
                                                                                                    setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Indicateurs Quantitatifs');
                                                                                                }
                                                                                            });
                                                                                        } else {
                                                                                            doneLoading();
                                                                                            setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Indicateurs Qualitatifs');
                                                                                        }
                                                                                    });
                                                                                } else {
                                                                                    doneLoading();
                                                                                    setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Terminologies');
                                                                                }
                                                                            });
                                                                        } else {
                                                                            doneLoading();
                                                                            setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Taxonomies');
                                                                        }
                                                                    });
                                                                } else {
                                                                    doneLoading();
                                                                    setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Modèles');
                                                                }
                                                            });
                                                        } else {
                                                            doneLoading();
                                                            setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Formulaires');
                                                        }
                                                    });
                                                } else {
                                                    doneLoading();
                                                    setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des Champs');
                                                }
                                            });
                                        } else {
                                            doneLoading();
                                            setLoadingPercentage('0%', 'Erreur avec l\'enregistrement des publications');
                                        }
                                    });
                                } else {
                                    doneLoading();
                                    setLoadingPercentage('0%', 'Erreur avec l\'enregistrement de l\'organisation');
                                }
                            });
                        } else {
                            doneLoading();
                            setLoadingPercentage('0%', 'Erreur avec la suppression des données');
                        }
                    }); 
                    
                    // jQuery(document).ready(function() {
                    //     jQuery.ajax({
                    //         type: 'POST',
                    //         url: DATA.ajaxUrl,
                    //         data: {
                    //             'selectedData': JSON.stringify(selectedData),
                    //             'action': 'corn_save_data'
                    //         },
                    //         success: function(data) {
                    //             console.log(data);
                    //             doneLoading();
                    //             openModal('L\'import a été effectué avec succès');
                    //         },
                    //         error: function(error) {
                    //             console.log(error);
                    //             doneLoading();
                    //         }
                    //     });
                    // });
                break;
            }
        });
    })()
})();

function sendAjaxRequest(data, functionName, callback) {
    jQuery(document).ready(function() {
        jQuery.ajax({
            type: 'POST',
            url: DATA.ajaxUrl,
            data: {
                'data': JSON.stringify(data),
                'action': functionName
            },
            success: function(data) {
                console.log(data);
                callback(true);
            },
            error: function(error) {
                console.log(error);
                callback(false);
            }
        });
    });
}

function addPublicationData(publicationIdentifier, termIdentifiers) {
    var addedTermsIdentifiers = [];
    for (var i = 0; i < termIdentifiers.length; i++) {
        for (var j = allData.allTerms.length - 1; j >= 0; j--) {
            for (var m = allData.allTerms[j].terms.length - 1; m >= 0; m--) {
                if (termIdentifiers.indexOf(allData.allTerms[j].terms[m].term_identifier) != -1) {
                    if (allData.allTerms[j].terms[m]) {
                        // Lets check if the term hasnt been added already to avoid getting revisions: 
                        if (addedTermsIdentifiers.indexOf(allData.allTerms[j].terms[m].term_identifier) == -1) {
                            addedTermsIdentifiers.push(allData.allTerms[j].terms[m].term_identifier);
                            selectedData.terms.push(allData.allTerms[j].terms[m]);
                            // Lets get the objects associated to these terms:
                            for(var n = 0; n < allData.termsAndObjects.length; n++) {
                                if (allData.termsAndObjects[n].term_identifier == allData.allTerms[j].terms[m].term_identifier) {
                                    var objectIdentifier = allData.termsAndObjects[n].object_identifier;
                                    //  Lets add that object to our list of objects
                                    addObject(objectIdentifier);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    // Lets get the good practices: 
    for (var i = 0; i < allData.goodpracticesWithoutRedundancy.length; i++) {
        goodpracticePublicationIdentifier = allData.goodpracticesWithoutRedundancy[i].goodpractice_publication;
        if (goodpracticePublicationIdentifier == publicationIdentifier) {
            selectedData.goodpractices = addGoodpractice(selectedData.goodpractices, allData.goodpracticesWithoutRedundancy[i].goodpractice_identifier, allData.goodpracticesWithoutRedundancy[i] );
        }
    }

    // Lets get the performances: 
    for (var i = 0; i < allData.performancesWithoutRedundancy.length; i++) {
        performancePublicationIdentifier = allData.performancesWithoutRedundancy[i].performance_publication;
        if (performancePublicationIdentifier == publicationIdentifier) {
            selectedData.performances = addPerformance(selectedData.performances, allData.performancesWithoutRedundancy[i].performance_identifier, allData.performancesWithoutRedundancy[i] );
        }
    }

    // Lets get the sources: 
    for (var i = 0; i < allData.sourcesWithoutRedundancy.length; i++) {
        sourcePublicationIdentifier = allData.sourcesWithoutRedundancy[i].source_publication;
        if (sourcePublicationIdentifier == publicationIdentifier) {
            selectedData.sources = addSource(selectedData.sources, allData.sourcesWithoutRedundancy[i].source_identifier, allData.sourcesWithoutRedundancy[i] );
        }
    }

    // Lets get the glossaries: 
    for (var i = 0; i < allData.glossariesWithoutRedundancy.length; i++) {
        glossaryPublicationIdentifier = allData.glossariesWithoutRedundancy[i].glossary_publication;
        if (glossaryPublicationIdentifier == publicationIdentifier) {
            selectedData.glossaries = addGlossary(selectedData.glossaries, allData.glossariesWithoutRedundancy[i].glossary_identifier, allData.glossariesWithoutRedundancy[i] );
        }
    }

    // Lets get the qualis:
    for (var i = 0; i < allData.qualisWithoutRedundancy.length; i++) {
        qualiPublicationIdentifier = allData.qualisWithoutRedundancy[i].quali_publication;
        if (qualiPublicationIdentifier == publicationIdentifier) {
            selectedData.qualis = addIndicator(selectedData.qualis, allData.qualisWithoutRedundancy[i].quali_identifier, 'quali', allData.qualisWithoutRedundancy[i] );
        }
    }

    // Lets get the quantis
    for (var i = 0; i < allData.quantisWithoutRedundancy.length; i++) {
        quantiPublicationIdentifier = allData.quantisWithoutRedundancy[i].quanti_publication;
        if (quantiPublicationIdentifier == publicationIdentifier) {
            selectedData.quantis = addIndicator(selectedData.quantis, allData.quantisWithoutRedundancy[i].quanti_identifier, 'quanti', allData.quantisWithoutRedundancy[i] );
        }
    }
} 

function addObject(objectIdentifier) {
    for (var k = 0; k < allData.allObjects.length; k++) {
        for (var l = allData.allObjects[k].objects.length - 1; l >= 0; l--) {
            if (allData.allObjects[k].objects[l].object_identifier == objectIdentifier) {
               allData.allObjects[k].objects[l].model = allData.allObjects[k].model_identifier;
               var exists = false;
               for (var p = 0; p < selectedData.objects.length; p++) {
                   if (selectedData.objects[p].object_identifier == allData.allObjects[k].objects[l].object_identifier )
                       exists = true;
               }
               if (!exists) {
                   selectedData.objects = addElementAndOtherLanguagesInstancses(allData.allObjects[k].objects[l].object_identifier, selectedData.objects, allData.allObjects[k].objects, 'object');
                //    selectedData.objects.push(allData.allObjects[k].objects[l]);
                   // if the object is added, then we are gonna add its model here: 
                   for (var q = 0; q < allData.modelsWihoutRedundancy.length; q++) {
                       if (allData.allObjects[k].objects[l].model == allData.modelsWihoutRedundancy[q].model_identifier) {
                           var exists = false;
                           for (var r = 0; r < selectedData.models.length; r++) {
                               if (selectedData.models[r].model_identifier == allData.modelsWihoutRedundancy[q].model_identifier) {
                                   exists = true;
                               }
                           }
                           if (!exists) {
                            //    selectedData.models.push(allData.modelsWihoutRedundancy[q]);
                               selectedData.models = addElementAndOtherLanguagesInstancses(allData.modelsWihoutRedundancy[q].model_identifier, selectedData.models, allData.models, 'model');
                               // Now that we added the model, lets add the models_and_forms instances related to it: 
                               for (var i = 0; i < allData.modelsAndForms.length; i++) {
                                   if (allData.modelsAndForms[i].model_identifier == allData.modelsWihoutRedundancy[q].model_identifier) {
                                       selectedData.modelsAndForms.push(allData.modelsAndForms[i]);
                                   }
                               }
                               var model = allData.modelsWihoutRedundancy[q];
                               // Lets get the model's forms now: 
                               var formsIdentifiers = [];
                               for (var z = 0; z < allData.modelsAndForms.length; z++) {
                                   if ( allData.modelsAndForms[z].model_identifier == model.model_identifier ) {
                                       formsIdentifiers.push(allData.modelsAndForms[z].form_identifier);
                                   }
                               }
                               for (var e = 0; e < formsIdentifiers.length; e++) {
                                   var formIdentifier = formsIdentifiers[e];
                                   var exists = false;
                                   for (var f = 0; f < selectedData.forms.length; f++) {
                                       if (selectedData.forms[f].form_identifier == formIdentifier) {
                                           exists = true;
                                       }
                                   }
                                   if (!exists) {
                                       // Lets get the form data by form identifier
                                       for (var g = 0; g < allData.formsWithoutRedundancy.length; g++) {
                                           if (allData.formsWithoutRedundancy[g].form_identifier == formIdentifier) {
                                               selectedData.forms.push(allData.formsWithoutRedundancy[g]);
                                               selectedData.forms = addElementAndOtherLanguagesInstancses(allData.formsWithoutRedundancy[g].form_identifier, selectedData.forms, allData.forms, 'form');
                                               // Now that we added the model, lets add the models_and_forms instances related to it:
                                               for (var i = 0; i < allData.formsAndFields.length; i++) {
                                                   if (allData.formsAndFields[i].form_identifier == allData.formsWithoutRedundancy[g].form_identifier) {
                                                       selectedData.formsAndFields.push(allData.formsAndFields[i]);
                                                   }
                                               }
                                               // Now lets get the fields in this form: 
                                               var fieldsIdentifiers = [];
                                               for (var z = 0; z < allData.formsAndFields.length; z++) {
                                                   if ( allData.formsAndFields[z].form_identifier == formIdentifier ) {
                                                       fieldsIdentifiers.push(allData.formsAndFields[z].field_identifier);
                                                   }
                                               }
                                               for (var h = 0; h < fieldsIdentifiers.length; h++) {
                                                   var fieldIdentifier = fieldsIdentifiers[h];
                                                   var exists = false;
                                                   for (var s = 0; s < selectedData.fields.length; s++) {
                                                       if (selectedData.fields[s].field_identifier == fieldIdentifier) {
                                                           exists = true;
                                                       }
                                                   }
                                                   if (!exists) {
                                                       // Lets look for the field based on its identififer:
                                                       for (var t = 0; t < allData.fieldsWithoutRedundancy.length; t++) {
                                                           if (allData.fieldsWithoutRedundancy[t].field_identifier == fieldIdentifier) {
                                                               var theField = allData.fieldsWithoutRedundancy[t];
                                                            //    selectedData.fields.push(theField);
                                                               selectedData.fields = addElementAndOtherLanguagesInstancses(theField.field_identifier, selectedData.fields, allData.fields, 'field');
                                                           }
                                                       }
                                                   }
                                               }
                                           }
                                       }
                                   }
                               }
                           }
                       }
                   }
               } 
            }
        }
    }
}

function addGoodpractice(goodpractices, goodpracticeIdentifier, goodpractice) {
    var exists = false;
    for (var i = 0; i < goodpractices.length; i++) {
        if (goodpractices[i].goodpractice_identifier == goodpracticeIdentifier) {
            exists = true;
            return goodpractices;
        }
    }
    if (!exists) {
        if (!goodpractice) {
        // Lets get the goodpractice
            for (var i = 0; i < allData.goodpracticesWithoutRedundancy.length; i++) {
                if (allData.goodpracticesWithoutRedundancy[i].goodpractice_identifier == goodpracticeIdentifier) {
                    goodpractice = allData.goodpracticesWithoutRedundancy[i];
                }
            }
        }
        if (goodpractice) {
            // goodpractices.push(goodpractice);
            goodpractices = addElementAndOtherLanguagesInstancses(goodpractice.goodpractice_identifier, goodpractices, allData.goodpractices, 'goodpractice');

            if (goodpractice.goodpractice_objects != null) {
                var objectsIdentifiers = goodpractice.goodpractice_objects.split('|');
                for (var j = 0; j < objectsIdentifiers.length; j++) {
                    addObject(objectsIdentifiers[j]);
                }
            }

            if (goodpractice.goodpractice_quantis != null) {
                var quantisIdentifiers = goodpractice.goodpractice_quantis.split('|');
                for (var j = 0; j < quantisIdentifiers.length; j++) {
                    addIndicator(selectedData.quantis, quantisIdentifiers[j], 'quanti');
                }
            }
        }

        return goodpractices;
    }
}

function addPerformance(performances, performanceIdentifier, performance) {
    var exists = false;
    for (var i = 0; i < performances.length; i++) {
        if (performances[i].performance_identifier == performanceIdentifier) {
            exists = true;
            return performances;
        }
    }
    if (!exists) {
        if (!performance) {
        // Lets get the performance
            for (var i = 0; i < allData.performancesWithoutRedundancy.length; i++) {
                if (allData.performancesWithoutRedundancy[i].performance_identifier == performanceIdentifier) {
                    performance = allData.performancesWithoutRedundancy[i];
                }
            }
        }
        if (performance) {
            performances = addElementAndOtherLanguagesInstancses(performance.performance_identifier, performances, allData.performances, 'performance');

            if ( performance.performance_objects != null ) {
                var objectsIdentifiers = performance.performance_objects.split('|');
                for (var j = 0; j < objectsIdentifiers.length; j++) {
                    addObject(objectsIdentifiers[j]);
                }
            }

            if ( performance.performance_quantis != null) {
                var quantisIdentifiers = performance.performance_quantis.split('|');
                for (var j = 0; j < quantisIdentifiers.length; j++) {
                    addIndicator(selectedData.quantis, quantisIdentifiers[j], 'quanti');
                }
            }
        }

        return performances;
    }
}

function addSource(sources, sourceIdentifier, source) {
    var exists = false;
    for (var i = 0; i < sources.length; i++) {
        if (sources[i].source_identifier == sourceIdentifier) {
            exists = true;
            return sources;
        }
    }
    if (!exists) {
        if (!source) {
        // Lets get the source
            for (var i = 0; i < allData.sourcesWithoutRedundancy.length; i++) {
                if (allData.sourcesWithoutRedundancy[i].source_identifier == sourceIdentifier) {
                    source = allData.sourcesWithoutRedundancy[i];
                }
            }
        }
        if (source) {
            sources = addElementAndOtherLanguagesInstancses(source.source_identifier, sources, allData.sources, 'source');

            if ( source.source_object != null ) {
                var objectsIdentifiers = source.source_object.split('|');
                for (var j = 0; j < objectsIdentifiers.length; j++) {
                    addObject(objectsIdentifiers[j]);
                }
            }

            if ( source.source_link_object != null ) {
                var objectsIdentifiers = source.source_link_object.split('|');
                for (var j = 0; j < objectsIdentifiers.length; j++) {
                    addObject(objectsIdentifiers[j]);
                }
            }
        }

        return sources;
    }
}

function addGlossary(glossaries, glossaryIdentifier, glossary) {
    var exists = false;
    for (var i = 0; i < glossaries.length; i++) {
        if (glossaries[i].glossary_identifier == glossaryIdentifier) {
            exists = true;
            return glossaries;
        }
    }
    if (!exists) {
        if (!glossary) {
        // Lets get the glossary
            for (var i = 0; i < allData.glossariesWithoutRedundancy.length; i++) {
                if (allData.glossariesWithoutRedundancy[i].glossary_identifier == glossaryIdentifier) {
                    glossary = allData.glossariesWithoutRedundancy[i];
                }
            }
        }
        if (glossary) {
            // glossaries.push(glossary);
            glossaries = addElementAndOtherLanguagesInstancses(glossary.glossary_identifier, glossaries, allData.glossaries, 'glossary');


            addObject(glossary.glossary_object);

            // Lets get the parent glossary as well: 
            var parentIdentifier = glossary.glossary_parent;
            // Lets get the close glossary too: 
            var closeIdentifier = glossary.glossary_close;

            glossaries = addGlossary(glossaries, parentIdentifier);
            glossaries = addGlossary(glossaries, closeIdentifier);
        }

        return glossaries;
    }
}

function addIndicator(indicators, indicatorIdentifier, whichIndicator, indicator) {
    var exists = false;
    for (var i = 0; i < indicators.length; i++) {
        if (indicators[i][whichIndicator + '_identifier'] == indicatorIdentifier) {
            exists = true;
            return indicators;
        }
    }
    if (!exists) {
        if (!indicator) {
            // Lets get the indicator
            var allDataIndicators = whichIndicator == 'quali' ? allData.qualisWithoutRedundancy : allData.quantisWithoutRedundancy;
            for (var i = 0; i < allDataIndicators.length; i++) {
                if (allDataIndicators[i][whichIndicator + '_identifier'] == indicatorIdentifier) {
                    indicator = allDataIndicators[i];
                }
            }
        }
        if (indicator) {
            // indicators.push(indicator);
            var allTheData = whichIndicator == 'quali' ? allData.qualis : allData.quantis;
            indicators = addElementAndOtherLanguagesInstancses(indicator[whichIndicator + ['_identifier']], indicators, allTheData, whichIndicator);

            addObject(indicator[whichIndicator + '_object']);

            // Lets get the parent indicator as well: 
            var parentIdentifier = indicator[whichIndicator + '_parent'];
            // Lets get the close indicator too: 
            var closeIdentifier = indicator[whichIndicator + '_close_indicators'];

            indicators = addIndicator(indicators, parentIdentifier, whichIndicator);
            indicators = addIndicator(indicators, closeIdentifier, whichIndicator);
        }

        return indicators;
    }
}

// To add other instances of other languages
function addElementAndOtherLanguagesInstancses(elementIdentifier, arrayToAddTo, allInstances, table) {
    var languages = [];
    for (var i = allInstances.length - 1; i >= 0; i--) {
        if(allInstances[i][table + '_identifier'] == elementIdentifier) {
            // check if language was already added: 
            var languageAlreadyAdded = false;
            for (var j = 0; j < languages.length; j++) {
                if (languages[j] == allInstances[i][table + '_content_language']) {
                    languageAlreadyAdded = true;
                }
            }
            if (!languageAlreadyAdded) {
                languages.push(allInstances[i][table + '_content_language']);
                arrayToAddTo.push(allInstances[i]);
            }
        }
    }
    return arrayToAddTo;
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