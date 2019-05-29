handleGraphsInitialization();
function handleGraphsInitialization() {
    var allGraphContainers = document.querySelectorAll('.oak_front_graph_container');

    for (var i = 0; i < allGraphContainers.length; i++) {
        var canvas = document.createElement('canvas');
        allGraphContainers[i].append(canvas);
        var chartCreator = canvas.getContext('2d');
        var data = JSON.parse(allGraphContainers[i].getAttribute('data'));

        var chart = new Chart(chartCreator, data);
    }
}