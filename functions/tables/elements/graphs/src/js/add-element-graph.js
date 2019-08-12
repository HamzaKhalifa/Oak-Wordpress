initializeGraph();
function initializeGraph() {
    if (DATA.revisions.length > 0) {
        refreshGraph();
    }
}

handleDesignationChange();
function handleDesignationChange() {
    var designationInput = document.querySelector('.graph_designation_input');
    designationInput.oninput = function() {
        var data =  JSON.parse(document.querySelector('.graph_data_input').value);
        if (data.data.datasets) {
            data.data.datasets[0].label = designationInput.value;
            document.querySelector('.graph_data_input').value = JSON.stringify(data);
        } 
    }
}


var lastDrawn = '';
handleGraphProperties(document.querySelector('.graph_data_input').value, []);
function handleGraphProperties(graphData, trace) {
    if (typeof(graphData) != 'object') {
        graphData = JSON.parse(graphData);
    }

    var graphDataKeys = getKeys(graphData);

    var elementContainer = document.querySelector('.oak_add_element_container');
    var normalTextFieldContent = document.querySelector('.oak_text_field_container').innerHTML;
    for (var i = 0; i < graphDataKeys.length; i++) {
        if (typeof(graphData[graphDataKeys[i]]) != 'object') {
            justEndedAnObject = false;
            var newHorizontalContainer = document.createElement('div');
            newHorizontalContainer.className = 'oak_add_element_container__horizontal_container';
            elementContainer.append(newHorizontalContainer);

            var newTextField = document.createElement('div');
            newTextField.className = 'oak_text_field_container';
            newTextField.innerHTML = normalTextFieldContent;
            newHorizontalContainer.append(newTextField);

            lastDrawn = 'field';
            newTextFieldInput = newTextField.querySelector('input');
            newTextFieldInput.value = graphData[graphDataKeys[i]];
            newTextField.querySelector('.text_field_description').innerHTML = graphDataKeys[i];
            newTextField.querySelector('.oak_text_field_placeholder').innerHTML = graphDataKeys[i];
            var comma = trace.toString() == '' ? '' : ',';
            newTextFieldInput.setAttribute('trace', trace.toString() + comma + graphDataKeys[i]);
            newTextFieldInput.oninput = function() {
                var data =  JSON.parse(document.querySelector('.graph_data_input').value);
                trace = this.getAttribute('trace').split(',');
                var path = '';
                for(var t = 0; t < trace.length; t++) {
                    if (trace[t] != '') {
                        var delimiter = '.';
                        if (t == trace.length - 1) 
                            delimiter = '';

                        path += trace[t] + delimiter;
                    }
                }

                var endValue = this.value;
                if (endValue == 'true')
                    endValue = true;
                if (endValue == 'false')
                    endValue = false;

                _.set(data, path, endValue);
                document.querySelector('.graph_data_input').value = JSON.stringify(data);
            }
        } else if(typeof(graphData[graphDataKeys[i]]) == 'object') {
            // Lets add the property object name: 
            if ( graphDataKeys[i] != '0' ) {
                var objectPropertyName = document.createElement('h2');
                elementContainer.append(objectPropertyName);
                objectPropertyName.innerHTML = graphDataKeys[i];
            }

            // call the recursive function
            trace.push(graphDataKeys[i]);
            handleGraphProperties(graphData[graphDataKeys[i]], trace);
        }

    }
    trace.pop();
    
    if ( lastDrawn != 'endOfObject' ) {
        var endOfObjectDiv = document.createElement('div');
        endOfObjectDiv.className = 'oak_end_of_graph_data_object_div';
        elementContainer.append(endOfObjectDiv);
        lastDrawn = 'endOfObject';
    }

    textFieldsAnimations();
}


var getKeys = function(obj){
    var keys = [];
    for(var key in obj){
       keys.push(key);
    }
    return keys;
}

handleRefreshGraphButton();
function handleRefreshGraphButton() {
    var refreshButton = document.querySelector('.oak_add_element_refresh_graph_button');
    refreshButton.addEventListener('click', function() {
        refreshGraph();
    })
}

function refreshGraph() {
    if (DATA.revisions.length > 0) {

        var data =  JSON.parse(document.querySelector('.graph_data_input').value);
        var links = document.querySelector('.graph_links_input').value;

        var chartCanvas = document.querySelector('.add_element_graph_canvas');
        ctx = chartCanvas.getContext('2d');
        
        var linksArray = [];
        if ( links != null ) {
            linksArray = links.split(';');
        }
        if (linksArray) {
            chartCanvas.onclick = function(evt) {
                var activePoints = chart.getElementsAtEvent(evt);
                if (activePoints[0]) {
                    var linkIndex = activePoints[0]._index;
                    var url = linksArray[linkIndex];
                    if (url){
                        if (validURL(url))
                            window.location.replace(url); 
                        else {
                            var elements = document.querySelectorAll('.' + url);
                            if (elements) {
                                for (var n = 0; n < elements.length; n++) {
                                    if (classExists(elements[n], 'oak_hidden')) 
                                        elements[n].classList.remove('oak_hidden');
                                    else
                                        elements[n].classList.add('oak_hidden');
                                }
                            }
                        }
                    }
                }
                // => activePoints is an array of points on the canvas that are at the same position as the click event.
            };
        }

        if (data.data.datasets[0].backgroundColor) {
            data.data.datasets[0].backgroundColor = data.data.datasets[0].backgroundColor.split(',')
        }
        
        var chart = new Chart(ctx, data);
    }
}
