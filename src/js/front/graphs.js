handleGraphsInitialization();
function handleGraphsInitialization() {
    var allGraphContainers = document.querySelectorAll('.oak_front_graph_container');

    for (var i = 0; i < allGraphContainers.length; i++) {
        var canvas = document.createElement('canvas');

        allGraphContainers[i].innerHTML = '';
        allGraphContainers[i].append(canvas);
        var chartCreator = canvas.getContext('2d');

        var graphIdentifier = allGraphContainers[i].getAttribute('graph-identifier');
        for (var j = 0; j < GRAPHS_DATA.graphs.length; j++) {
            if (GRAPHS_DATA.graphs[j].graph_identifier == graphIdentifier) {
                var data = JSON.parse(GRAPHS_DATA.graphs[j].graph_data);
                var links = GRAPHS_DATA.graphs[j].graph_links;
                var linksArray = [];
                if ( links != null ) {
                    linksArray = links.split(';');
                }
                // Lets hide all elements ID: 
                for (m = 0; m < linksArray.length; m++) {
                    if (!validURL(linksArray[m]) && linksArray[m] != '') {
                        var elements = document.querySelectorAll('.' + linksArray[m]);
                        if (elements) {
                            for (var n = 0; n < elements.length; n++) {
                                elements[n].classList.add('oak_hidden');
                            }
                        }
                    }
                }
                if (linksArray) {
                    canvas.onclick = function(evt) {
                        var activePoints = chart.getElementsAtEvent(evt);
                        if (activePoints[0]) {
                            hideAllHideableWidgets(linksArray);
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
                
                data.options.legend = JSON.parse(GRAPHS_DATA.graphs[j].graph_legend_configuration);
                
                if (data.data.datasets[0].backgroundColor) {
                    // data.data.datasets[0].backgroundColor = data.data.datasets[0].backgroundColor.split(',')
                }
                var chart = new Chart(chartCreator, data);

                // Make canvas full width: 
                parent = canvas.parentNode;
                do {
                    parent.style.height = '100%';
                    parent = parent.parentNode;
                } while(parent.tagName != 'SECTION')
            }
        }
    }
}

function hideAllHideableWidgets(ids) {
    for(var i = 0; i < ids.length; i++) {
        var elements = document.querySelectorAll('.' + ids[i]);
        for (var j = 0; j < elements.length; j++) {
            if (!classExists(elements[j], 'oak_hidden')) {
                elements[j].classList.add('oak_hidden');
            }
        }
    }
}

function validURL(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
      '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
      '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
      '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
      '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
      '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
    return !!pattern.test(str);
}

function classExists(element, className) {
    for (var i = 0; i < element.classList.length; i++) {
        if (element.classList[i] == className) 
            return true
    }

    return false;
}