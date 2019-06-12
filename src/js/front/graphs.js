handleGraphsInitialization();
function handleGraphsInitialization() {
    var allGraphContainers = document.querySelectorAll('.oak_front_graph_container');

    for (var i = 0; i < allGraphContainers.length; i++) {
        var canvas = document.createElement('canvas');
        allGraphContainers[i].append(canvas);
        var chartCreator = canvas.getContext('2d');
        var graphIdentifier = allGraphContainers[i].getAttribute('graph-identifier');
        for (var j = 0; j < GRAPHS_DATA.graphs.length; j++) {
            if (GRAPHS_DATA.graphs[j].graph_identifier == graphIdentifier) {
                var data = JSON.parse(GRAPHS_DATA.graphs[j].graph_data);
                var links = GRAPHS_DATA.graphs[j].graph_links;
                linksArray = links.split(';');
                console.log('links array', linksArray);
                if (linksArray) {
                    canvas.onclick = function(evt){
                        var activePoints = chart.getElementsAtEvent(evt);
                        if (activePoints[0]) {
                            var linkIndex = activePoints[0]._index;
                            var url = linksArray[linkIndex];
                            if (url){
                                window.open(url);
                            }
                        }
                        // => activePoints is an array of points on the canvas that are at the same position as the click event.
                    };
                }

                var chart = new Chart(chartCreator, data);
            }
        }


        // var data = JSON.parse(allGraphContainers[i].getAttribute('data'));
        // var links = allGraphContainers[i].getAttribute('links');
        // console.log(links);

        // var chart = new Chart(chartCreator, data);
    }
}