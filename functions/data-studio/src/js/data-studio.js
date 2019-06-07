var publications = [];
var allData = DATA.allData;
var step = 'organization';
var selectedData = {
    organization: null,
    publications: [],
    quantis: [],
    performances: [],
    graph: null,
    labels: [],
    values: []
};
var choosingGraph = false;
var chosenGraphData = {
    labels: [],
    data: [],
    graph: '',
    title: ''
}
var graphs = [
    { graph_identifier: 'line', graph_designation: 'Line', graph_type: '--', graphe_nothing: '--', graph_nothing: '' },
    { graph_identifier: 'bar', graph_designation: 'Bar', graph_type: '--', graphe_nothing: '--', graph_nothing: '' },
    { graph_identifier: 'radar', graph_designation: 'Radar', graph_type: '--', graphe_nothing: '--', graph_nothing: '' },
    { graph_identifier: 'doughnut', graph_designation: 'Doughnut', graph_type: '--', graphe_nothing: '--', graph_nothing: '' },
    { graph_identifier: 'pie', graph_designation: 'Pie', graph_type: '--', graphe_nothing: '--', graph_nothing: '' },
    { graph_identifier: 'polarArea', graph_designation: 'Polar Area', graph_type: '--', graphe_nothing: '--', graph_nothing: '' },
    { graph_identifier: 'bubble', graph_designation: 'Bubble', graph_type: '--', graphe_nothing: '--', graph_nothing: '' },
    { graph_identifier: 'scatter', graph_designation: 'Scatter', graph_type: '--', graphe_nothing: '--', graph_nothing: '' },
    { graph_identifier: 'scatter', graph_designation: 'Area', graph_type: '--', graphe_nothing: '--', graph_nothing: '' },
    { graph_identifier: '9', graph_designation: 'Mixed', graph_type: '--', graphe_nothing: '--', graph_nothing: '' },
]

var steps = [];

(function() {
    populateImportContainer(
        'Organisations',
        DATA.allData.organizations.organizationsWithoutRedundancy, 
        ['Nom de l\'organisation', 'Pays du siège', 'Type', 'Secteur d\'activité'],
        ['organization_identifier', 'organization_designation', 'organization_country', 'organization_type', 'organization_sectors'],
        'organization',
        'organization'
    );

    function populateImportContainer(title, data, dataInfo, dataFields, dataType, nextStep, publicationsThatBelongNumber, fromCancel) {
        var cancelButton = document.querySelector('.next_button_container_cancel');
        if ( dataType == 'organization' ) {
            cancelButton.classList.add('oak_hidden');
        } else {
            cancelButton.classList.remove('oak_hidden');
        }

        if (fromCancel) {
            document.querySelector('.oak_graphs_configuration').classList.add('oak_hidden');
        } else {
            steps.push({title, data, dataInfo, dataFields, dataType, nextStep, publicationsThatBelongNumber});
        }
            
        document.querySelector('.next_button_container_next').classList.add('oak_hidden');
        document.querySelector('.screen_title').innerHTML = title;
        var importContainer = document.querySelector('.import_container');
        var styleAddedToTitle = dataType == 'organization' ? 'style="margin-left: 35px;"' : dataType == 'publication' ? 'style="margin-left: 35px;"' : '';
        var oakHidden = dataType == 'organization' ? 'oak_hidden' : dataType == 'publication' ? 'oak_hidden' : dataType == 'graph' ? 'oak_hidden' : '';
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
                    if ((dataType == 'organization' || dataType == 'publication' || dataType == 'graph') && j != this.getAttribute('index') && this.checked ) {
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
                    for (var i = 0; i < allData.publications.publicationsWithoutRedundancy.length; i++) {
                        if (allData.publications.publicationsWithoutRedundancy[i].publication_organization == organizationIdentifier) {
                            allData.publications.publicationsWithoutRedundancy[i].belongsToOrganization = true;
                            publicationsThatBelongToOrganization.push(allData.publications.publicationsWithoutRedundancy[i]);
                        } else {
                            allData.publications.publicationsWithoutRedundancy[i].belongsToOrganization = false;
                            publicationsThatDontBelongToOrganization.push(allData.publications.publicationsWithoutRedundancy[i]);
                        }
                    }
                    var publicationsThatBelongNumber = publicationsThatBelongToOrganization.length;
                
                    var publicationsToShow = [];
                    for (var i = 0; i < publicationsThatBelongToOrganization.length; i++) {
                        publicationsToShow.push(publicationsThatBelongToOrganization[i]);
                    }
                    for (var i = 0; i < publicationsThatDontBelongToOrganization.length; i++) {
                        publicationsToShow.push(publicationsThatDontBelongToOrganization[i]);
                    }

                    for (var i = 0; i < allData.organizations.organizationsWithoutRedundancy.length; i++) {
                        if (allData.organizations.organizationsWithoutRedundancy[i].organization_identifier == organizationIdentifier) {
                            selectedData.organization = allData.organizations.organizationsWithoutRedundancy[i];
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
                    selectedData.publications = [];
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    for (var i = 0; i < checkBoxes.length; i++) {
                        if (checkBoxes[i].checked) {
                            publicationsIdentifiers.push(checkBoxes[i].parentNode.parentNode.getAttribute('identifier'));
                        }
                    }
                    for (var i = 0; i < allData.publications.publicationsWithoutRedundancy.length; i++) {
                        if (publicationsIdentifiers.indexOf(allData.publications.publicationsWithoutRedundancy[i].publication_identifier) != -1) {
                            selectedData.publications.push(allData.publications.publicationsWithoutRedundancy[i]);
                        }
                    }
                    var quantisToShow = [];
                    for (var i = 0; i < publicationsIdentifiers.length; i++) {
                        for (var j = 0; j < allData.quantis.quantisWithoutRedundancy.length; j++) {
                            if (allData.quantis.quantisWithoutRedundancy[j].quanti_publication == publicationsIdentifiers[i]) {
                                quantisToShow.push(allData.quantis.quantisWithoutRedundancy[j]);
                            }
                        }
                    }
                    populateImportContainer(
                        'Indicateurs de performance',
                        quantisToShow, 
                        ['Designation', 'Type de Numérotation', 'Numérotation', 'Description'],
                        ['quanti_identifier', 'quanti_designation', 'quanti_numerotation_type', 'quanti_numerotation', 'quanti_description'],
                        'quanti',
                        'quanti'
                    );
                break;
                case 'quanti':
                    selectedData.quantis = [];
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    var quantisIdentifiers = [];
                    for (var i = 0; i < checkBoxes.length; i++) {
                        if (checkBoxes[i].checked) {
                            for (var j = 0; j < allData.quantis.quantisWithoutRedundancy.length; j++) {
                                if (allData.quantis.quantisWithoutRedundancy[j].quanti_identifier == checkBoxes[i].parentNode.parentNode.getAttribute('identifier')) {
                                    selectedData.quantis.push(allData.quantis.quantisWithoutRedundancy[j]);
                                }
                            }
                            quantisIdentifiers.push(checkBoxes[i].parentNode.parentNode.getAttribute('identifier'));
                        }
                    }
                    var performancesToShow = [];
                    for (var i = 0; i < allData.performances.performancesWithoutRedundancy.length; i++) {
                        var performanceQuantis = allData.performances.performancesWithoutRedundancy[i].performance_quantis.split('|');
                        for (var j = 0; j < performanceQuantis.length; j++) {
                            if (quantisIdentifiers.indexOf(performanceQuantis[j]) != -1 ) {
                                // selectedData.performances.push(allData.performances.performancesWithoutRedundancy[i]);
                                performancesToShow.push(allData.performances.performancesWithoutRedundancy[i]);
                            }
                        }
                    }
                    populateImportContainer(
                        'Données de performance',
                        performancesToShow,
                        // selectedData.performances,
                        ['Designation', 'Type', 'Périmètre metier', 'Dérnière modification'],
                        ['performance_identifier', 'performance_designation', 'performance_type', 'performance_business_line', 'performance_modification_time'],
                        'performance',
                        'performance'
                    );
                break;
                case 'performance':
                    selectedData.performances = [];
                    console.log('performances', selectedData.performances);
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    for (var i = 0; i < checkBoxes.length; i++) {
                        if (checkBoxes[i].checked) {
                            for (var j = 0; j < allData.performances.performancesWithoutRedundancy.length; j++) {
                                if (allData.performances.performancesWithoutRedundancy[j].performance_identifier == checkBoxes[i].parentNode.parentNode.getAttribute('identifier')) {
                                    selectedData.performances.push(allData.performances.performancesWithoutRedundancy[j]);
                                }
                            }
                        }
                    }
                    populateImportContainer(
                        'Type de graphique',
                        graphs,
                        ['Designation', 'Type', '--', '--'],
                        ['graph_identifier', 'graph_designation', 'graph_type', 'graph_nothing', 'graph_nothing'],
                        'graph',
                        'graph'
                    );
                break;
                case 'graph':
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    for (var i = 0; i < checkBoxes.length; i++) {
                        if (checkBoxes[i].checked) {
                            var graphIdentifer = checkBoxes[i].parentNode.parentNode.getAttribute('identifier');
                            for (var j = 0; j < graphs.length; j++) {
                                if (graphs[j].graph_identifier == graphIdentifer) {
                                    selectedData.graph = graphs[j];
                                }
                            }
                        }
                    }
                    handleGraphConfigurationScreen();
                break;
            }
        });
    })()
})();

function handleGraphConfigurationScreen() {
    document.querySelector('.oak_graphs_configuration').classList.remove('oak_hidden');
    var importContainer = document.querySelector('.import_container');
    importContainer.innerHTML = '';
    
    // Empty chart container
    document.querySelector('.oak_graphs_configuration__chart_container').innerHTML= '';

    // Empty label containers
    var labelsContainer = document.querySelector('.oak_graphs_configuration_configuration_element_container__labels');
    labelsContainer.innerHTML = '';

    for (var i = 0; i < selectedData.quantis.length; i++) {
        var singleLabel = document.createElement('span');
        singleLabel.className = 'oak_graphs_configuration_label oak_graphs_configuration_element_container__single_element';
        singleLabel.innerHTML = selectedData.quantis[i].quanti_designation;
        singleLabel.setAttribute('identifier', selectedData.quantis[i].quanti_identifier);
        selectedData.labels.push(selectedData.quantis[i].quanti_designation);
        selectedData.labels.push({
            labelDesignation: selectedData.quantis[i].quanti_designation,
            labelIdentifier: selectedData.quantis[i].quanti_identifier
        });

        labelsContainer.append(singleLabel);
    }

    var performancesContainer = document.querySelector('.oak_graphs_configuration_configuration_element_container__performances');
    performancesContainer.innerHTML = '';
    for (var i = 0; i < selectedData.performances.length; i++) {

        var singlePerformance = document.createElement('div');
        singlePerformance.className = 'oak_graphs_configuration_configuration_element_container_performances__single_performance_container';
        singlePerformance.setAttribute('identifier', selectedData.performances[i].performance_identifier);

        var performanceTitleContainer = document.createElement('div');
        performanceTitleContainer.className = 'oak_performance_container';

        var performanceCheckbox = document.createElement('input');
        performanceCheckbox.setAttribute('type', 'checkbox');
        performanceCheckbox.className = 'oak_performance_checkbox';

        var performanceTitle = document.createElement('h3');
        performanceTitle.className = 'oak_performance_title';
        performanceTitle.innerHTML = selectedData.performances[i].performance_designation;

        performanceTitleContainer.append(performanceCheckbox);
        performanceTitleContainer.append(performanceTitle);

        singlePerformance.append(performanceTitleContainer);
        var results = [];
        if (selectedData.performances[i].performance_results != null)
            results = selectedData.performances[i].performance_results.split('|');

        var yearsData = [];
        for (var j = 0; j < results.length; j++) {
            var singleYear = document.createElement('span');
            singleYear.className = 'oak_graphs_configuration_year oak_graphs_configuration_element_container__single_element';
            var yearData = results[j].split(':');
            yearsData.push(yearData);
            singleYear.setAttribute('year', yearData[0]);
            singleYear.setAttribute('value', yearData[1]);
            singleYear.innerHTML = 'Année ' + yearData[0] + ': ' + yearData[1];
            
            singlePerformance.append(singleYear);
        }

        for (var j = 0; j < selectedData.quantis.length; j++) {
            if (selectedData.quantis[j].quanti_identifier == selectedData.performances[i].performance_quantis) {
                selectedData.values.push({
                    labelDesignation: selectedData.quantis[j].quanti_designation,
                    labelIdentifier: selectedData.quantis[j].quanti_identifier,
                    performanceDesignation: selectedData.performances[i].performance_designation,
                    performanceIdentifier: selectedData.performances[i].performance_identifier,
                    yearsData: yearsData
                });

                performanceTitle.innerHTML = selectedData.performances[i].performance_designation + ' (' + selectedData.quantis[j].quanti_designation + ')';
            }
        }

        performancesContainer.append(singlePerformance);
    }
    
    handleConfigurationElementsListeners();

    generateChart({
        graph: selectedData.graph.graph_identifier,
        labels: selectedData.labels,
        values: selectedData.values
    })
}

function generateChart(config) {
    console.log('config', config);
    var allDataGraphData = {
        selectedLabels: [],
        selectedPerformances: [],
    };
    // Generating graphs for each specific data (values by year): 
    for (var i = 0; i < config.labels.length; i++) {
        var isSelected = false;
        var labels = document.querySelectorAll('.oak_graphs_configuration_label');
        for (var j = 0; j < labels.length; j++) {
            if (labels[j].getAttribute('identifier') == config.labels[i].labelIdentifier && containsClass(labels[j], 'oak_graphs_configuration_element_container_single_element__considered')) 
                isSelected = true;
        }
        if (isSelected) {
            allDataGraphData.selectedLabels.push(config.labels[i].labelDesignation);
            for (var j = 0; j < config.values.length; j++) {
                if (config.values[j].labelIdentifier == config.labels[i].labelIdentifier) {
                    enteredOnce = true;
                    var actualLabels = [];
                    var actualData = [];
                    var performanceContainers = document.querySelectorAll('.oak_graphs_configuration_configuration_element_container_performances__single_performance_container');
                    var performanceContainer = null;

                    // Lets look for the performance container associated with the current value to see if it is checked.
                    for (var k = 0; k < performanceContainers.length; k++) {
                        if (performanceContainers[k].getAttribute('identifier') == config.values[j].performanceIdentifier) {
                            performanceContainer = performanceContainers[k];
                        }
                        // var title = performanceContainers[k].querySelector('h3').innerHTML;
                        // if (title == config.values[j].performanceDesignation + ' (' + config.labels[i] + ')') {
                        //     performanceContainer = performanceContainers[k];
                        // }
                    }
                    if (performanceContainer && performanceContainer.querySelector('.oak_performance_checkbox').checked == true) {
                        allDataGraphData.selectedPerformances.push({
                            labelDesignation: config.labels[i].labelDesignation,
                            labelIdentifier: config.labels[i].labelIdentifier,
                            performanceDesignation: config.values[j].performanceDesignation,
                            performanceIdentifier: config.values[j].performanceIdentifier,
                            performanceValues: []
                        });
                        for (var k = 0; k < config.values[j].yearsData.length; k++) {
                            var yearsContainers = performanceContainer.querySelectorAll('.oak_graphs_configuration_year');
                            for (var m = 0; m < yearsContainers.length; m++) {
                                console.log('test', config.values[j].yearsData[k]);
                                if (yearsContainers[m].getAttribute('year') == config.values[j].yearsData[k][0] && yearsContainers[m].getAttribute('value') == config.values[j].yearsData[k][1]
                                    && containsClass(yearsContainers[m], 'oak_graphs_configuration_element_container_single_element__considered')) {
                                    actualLabels.push(config.values[j].yearsData[k][0]);
                                    actualData.push(config.values[j].yearsData[k][1]);
                                    allDataGraphData.selectedPerformances[allDataGraphData.selectedPerformances.length - 1].performanceValues.push({
                                        year: config.values[j].yearsData[k][0],
                                        value: config.values[j].yearsData[k][1]
                                    })
                                }
                            }
                        }
                        var graphTitle = config.values[j].labelDesignation + ';\n' + config.values[j].performanceDesignation;
                        var chartCanvas = createChartCanvas(actualLabels, actualData, config.graph, graphTitle);
                        createChart(chartCanvas, config.graph, graphTitle, actualLabels, actualData, {});
                    }
                }
            }
        }
    }

    // Generating graphs for each specific label (average year values or last year value by data):
    for (var i = 0; i < allDataGraphData.selectedLabels.length; i++) {
        var actualLabels = [];
        var actualData = [];
        var actualAverageData = [];
        for (var j = 0; j < allDataGraphData.selectedPerformances.length; j++) {

            if (allDataGraphData.selectedPerformances[j].labelDesignation == allDataGraphData.selectedLabels[i]) {
                actualLabels.push(allDataGraphData.selectedPerformances[j].performanceDesignation);
                var averageValue = 0;
                var sum = 0;
                for (var k = 0; k < allDataGraphData.selectedPerformances[j].performanceValues.length; k++) {
                    sum += parseFloat(allDataGraphData.selectedPerformances[j].performanceValues[k].value);
                }
                if ( allDataGraphData.selectedPerformances[j].performanceValues.length > 0 ) {
                    averageValue = parseFloat(sum) / parseFloat(allDataGraphData.selectedPerformances[j].performanceValues.length);
                }
                var lastYearValue = 0;
                if ( allDataGraphData.selectedPerformances[j].performanceValues[allDataGraphData.selectedPerformances[j].performanceValues.length - 1] )
                    var lastYearValue = allDataGraphData.selectedPerformances[j].performanceValues[allDataGraphData.selectedPerformances[j].performanceValues.length - 1].value;
                
                actualData.push(lastYearValue);
                actualAverageData.push(averageValue);
            }
        }
        var graphTitle = allDataGraphData.selectedLabels[i];
        var chartCanvas = createChartCanvas(actualLabels, actualData, config.graph, graphTitle);
        createChart(chartCanvas, config.graph, graphTitle, actualLabels, actualData, {});

        var averageGraphTitle = allDataGraphData.selectedLabels[i] + ': Moyenne de tous les resultats des années selectionées';
        var chartCanvas = createChartCanvas(actualLabels, actualAverageData, config.graph, averageGraphTitle);
        createChart(chartCanvas, config.graph, averageGraphTitle, actualLabels, actualAverageData, {});
    }
}

function createChartCanvas(actualLabels, actualData, graph, graphTitle) {
    var chartsContainer = document.querySelector('.oak_graphs_configuration__chart_container');

    var chartCanvas = document.createElement('canvas');
    chartCanvas.className = 'oak_graph_canvas';
    chartCanvas.setAttribute('labels', JSON.stringify(actualLabels));
    chartCanvas.setAttribute('data', JSON.stringify(actualData));
    chartCanvas.setAttribute('graph', graph);
    chartCanvas.setAttribute('graph_title', graphTitle);
    chartCanvas.addEventListener('click', function() {
        choosingGraph = true;
        chosenGraphData.labels = JSON.parse(this.getAttribute('labels'));
        chosenGraphData.data = JSON.parse(this.getAttribute('data'));
        chosenGraphData.graph = this.getAttribute('graph');
        chosenGraphData.title = this.getAttribute('graph_title');
        openModal('Vous comptez choisir ce graphe pour paramétrer ?', true );
    });

    chartsContainer.append(chartCanvas);

    return chartCanvas;
}

function createChart(chartCanvas, graph, title, actualLabels, actualData, datasetProperties) {
    var datasets = [{
        label: title,
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: actualData
    }]
    for (var i = 0; i < datasetProperties.length; i++) {
        datasets[0][datasetProperties[i].propertyName] = datasetProperties[i].value;
    }
    
    var chartCreator = chartCanvas.getContext('2d');
    
    chartData = {
        type: graph,
        // The data for our dataset
        data: {
            labels: actualLabels,
            datasets
        },
        options: {
            responsive: true,
        }
    };
    var chart = new Chart(chartCreator, chartData);
}

var getKeys = function(obj){
    var keys = [];
    for(var key in obj){
       keys.push(key);
    }
    return keys;
}

function handleConfigurationElementsListeners() {
    var elements = document.querySelectorAll('.oak_graphs_configuration_element_container__single_element');
    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', function() {
            var chartsContainer = document.querySelector('.oak_graphs_configuration__chart_container');
            chartsContainer.innerHTML = '';
            if (containsClass(this, 'oak_graphs_configuration_element_container_single_element__considered')) {
                this.classList.remove('oak_graphs_configuration_element_container_single_element__considered');
            } else {
                this.classList.add('oak_graphs_configuration_element_container_single_element__considered');
            }
            generateChart({
                graph: selectedData.graph.graph_identifier,
                labels: selectedData.labels,
                values: selectedData.values
            });
        });
    }

    var performancesCheckboxes = document.querySelectorAll('.oak_performance_checkbox');
    for (var i = 0; i < performancesCheckboxes.length; i++) {
        performancesCheckboxes[i].addEventListener('change', function() {
            var chartsContainer = document.querySelector('.oak_graphs_configuration__chart_container');
            chartsContainer.innerHTML = '';
            generateChart({
                graph: selectedData.graph.graph_identifier,
                labels: selectedData.labels,
                values: selectedData.values
            });
        });
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

handleRefreshGraphButton();
function handleRefreshGraphButton() {
    var refreshGraphButton = document.querySelector('.refresh_graph_button');
    refreshGraphButton.addEventListener('click', function() {
        var graphParameters = getGraphParameters();

        var datasetProperties = graphParameters.datasetProperties;
        var labels = graphParameters.labels;
        var data = graphParameters = graphParameters.data;
        
        var selectedChartCanvas = document.querySelector('.oak_selected_graph');
        createChart(selectedChartCanvas, chosenGraphData.graph, chosenGraphData.title, labels, data, datasetProperties);
    });
}

function getGraphParameters() {
    var parametersInputs = document.querySelectorAll('.oak_single_parameter__input');
        var datasetProperties = [];
        for (var i = 0; i < parametersInputs.length; i++) {
            var value = parametersInputs[i].value;
            if ( parametersInputs[i].getAttribute('property_type') == 'array' ) {
                value = parametersInputs[i].value.split(',');
            }

            if (parametersInputs[i].getAttribute('property_nature') == 'dataset') {
                datasetProperties.push({
                    propertyName: parametersInputs[i].getAttribute('property_name'),
                    value
                });
            }
        }
        
        // Lets get the labels: the before last input:
        var labels = parametersInputs[parametersInputs.length - 2].value.split(',');
        var data = parametersInputs[parametersInputs.length - 1].value.split(',');

        return({
            datasetProperties,
            labels,
            data
        });
}

function createIdentifier() {
    var text = "";
    var possible = "abcdefghijklmnopqrstuvwxyz0123456789";
  
    for (var i = 0; i < 20; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));
    
    return text;
}

handleSaveGraphButton();
function handleSaveGraphButton() {
    var saveButton = document.querySelector('.oak_save_graph_button');
    saveButton.addEventListener('click', function() {

        setLoading();

        var graphParameters = getGraphParameters();

        var labels = graphParameters.labels;
        var data = graphParameters.data;
        var datasets = [{
            label: chosenGraphData.title,
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: data
        }]
        for (var i = 0; i < graphParameters.datasetProperties.length; i++) {
            datasets[0][graphParameters.datasetProperties[i].propertyName] = graphParameters.datasetProperties[i].value;
        }
        graphData = {
            type: chosenGraphData.graph,
            // The data for our dataset
            data: {
                labels: labels,
                datasets
            },
            options: {
                responsive: true,
            }
        };
        var title = '';
        for (var i = 0; i < graphParameters.datasetProperties.length; i++) {
            if (graphParameters.datasetProperties[i].propertyName == 'label' ) {
                title = graphParameters.datasetProperties[i].value;
            }
        }
        if (title == '') {
            title = chosenGraphData.title;
        }
        
        var graphDataInDatabase = {
            graph_designation: title,
            graph_identifier: createIdentifier(),
            graph_data: JSON.stringify(graphData)
        }
        
        jQuery(document).ready(function() {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'action': 'oak_save_graph',
                    'data': JSON.stringify(graphDataInDatabase)
                },
                success: function(data) {
                    doneLoading();
                    console.log(data);
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        });
    })
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

// For the confirm and cancel buttons
handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function() {
        if (choosingGraph) {
            closeModals();
            setLoading();
            document.querySelector('.oak_graphs_actual_config').classList.add('oak_hidden');
            document.querySelector('.oak_graphs_configuration__chart_container').classList.add('oak_hidden');
            document.querySelector('.oak_selected_graph_container').classList.remove('oak_hidden');
            var selectedChartCanvas = document.querySelector('.oak_selected_graph');

            var properties = [];
            switch(chosenGraphData.graph) {
                case 'doughnut' :
                    properties = [
                        { name: 'Couleurs', type: 'array', placeholder: 'Exemple: #FC644E,#FDA428,#42B273,#808080,#6A5ECA', propertyName: 'backgroundColor', value: [], propertyNature: 'dataset' },
                        { name: 'Couleurs des background au hover', type: 'array', placeholder: 'Exemple: #FC644E,#FDA428,#42B273,#808080,#6A5ECA', propertyName: 'hoverBackgroundColor', value: [], propertyNature: 'dataset' },
                        { name: 'Couleur de la bordure', type: 'normal', placeholder: 'Exemple: #FC644E', propertyName: 'borderColor', value: '', propertyNature: 'dataset' },
                        { name: 'Epaisseur de la bordure', type: 'normal', placeholder: 'Exemple: 2', propertyName: 'borderWidth', value: '', propertyNature: 'dataset' },
                        { name: 'Couleur de la bordure au hover', type: 'normal', placeholder: 'Exemple: #FC644E', propertyName: 'hoverBorderColor', value: '', propertyNature: 'dataset' },
                    ];
                case 'line' :
                    properties = [
                        { name: 'Couleur', type: 'array', placeholder: 'Exemple: #FC644E', propertyName: 'backgroundColor', value: '', propertyNature: 'dataset' },
                        { name: 'Couleur de la bordure', type: 'normal', placeholder: 'Exemple: #FC644E', propertyName: 'borderColor', value: '', propertyNature: 'dataset' },
                        { name: 'Titre', type: 'normal', placeholder: 'Titre', propertyName: 'label', value: '', propertyNature: 'dataset' },
                        { name: 'Tension de la ligne', type: 'normal', placeholder: 'Exemple: 0.4', propertyName: 'lineTension', value: '', propertyNature: 'dataset' },
                    ];
                break;
            }

            // To add labels and data to properties
            var labels = '';
            for (var i = 0; i < chosenGraphData.labels.length; i++) {
                var delimiter = ',';
                if (i == chosenGraphData.labels.length - 1) 
                    delimiter = '';

                labels += chosenGraphData.labels[i] + delimiter;
            }

            var data = '';
            for (var i = 0; i < chosenGraphData.data.length; i++) {
                var delimiter = ',';
                if (i == chosenGraphData.data.length - 1) 
                    delimiter = '';

                data += chosenGraphData.data[i] + delimiter;
            }

            var dataProperties = [
                { name: 'Labels', type: 'array', placeholder: 'Exemple: #FC644E,#FDA428,#42B273,#808080,#6A5ECA', propertyName: 'backgroundColor', value: labels, propertyNature: 'actualLabels' },
                { name: 'Données', type: 'array', placeholder: 'Exemple: #FC644E,#FDA428,#42B273,#808080,#6A5ECA', propertyName: 'hoverBackgroundColor', value: data, propertyNature: 'actualData' },
            ];
            properties.push(dataProperties[0]);
            properties.push(dataProperties[1]);
            
            var selectedGraphContainerConfiguration = document.querySelector('.oak_selected_graph_container__configuration');
            for( i = 0; i < properties.length; i++) {
                var singleParameter = document.createElement('div');
                singleParameter.className = 'oak_single_parameter';
                singleParameter.innerHTML = '<span class="oak_single_parameter__label">' + properties[i].name + ': </span>'
                + '<input type="text" value="' + properties[i].value  + '" property_nature="' + properties[i].propertyNature + '" property_type="' + properties[i].type + '" property_name="' + properties[i].propertyName + '" placeholder="' + properties[i].placeholder + '" class="oak_single_parameter__input">';

                selectedGraphContainerConfiguration.append(singleParameter);
            }
            createChart(selectedChartCanvas, chosenGraphData.graph, chosenGraphData.title, chosenGraphData.labels, chosenGraphData.data, {});
            doneLoading();
        }
    });

    var cancelButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function() {
        closeModals();
    });
}

function closeModals() {
    choosingGraph = false;
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