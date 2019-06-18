handleFrameObjectsButtons();
function handleFrameObjectsButtons() {
    var frameObjectsButtons = document.querySelectorAll('.oak_sidebar_frame_objects_container_single_frame__scroll_to_content_button');
    var allImages = document.querySelectorAll('img');
    for (var i = 0; i < frameObjectsButtons.length; i++) {
        var identifier = createIdentifier();
        frameObjectsButtons[i].setAttribute('id', identifier);

        // Remove it in case it is not shown/used in the page: 
        var value = frameObjectsButtons[i].getAttribute('value');
        if (value == '' || value == 'true' || value == 'false') {
            frameObjectsButtons[i].classList.add('oak_hidden');
        } else {
            var allElementsThatContainValue = jQuery('*:contains("' + value + '")'); 
            if (allElementsThatContainValue.length == 0) {
                // Now search for images before hiding: 
                var imageExists = false;
                for(var j = 0; j < allImages.length; j++) {
                    if (allImages[j].getAttribute('src') == value) 
                        imageExists = true;
                }
                if (!imageExists)
                    frameObjectsButtons[i].classList.add('oak_hidden');
            }
        }

        jQuery('#' + identifier).click(function() {
            var value = this.getAttribute('value');
            
            var allElementsThatContainValue = jQuery('*:contains("' + value + '")'); 
            if (allElementsThatContainValue.length == 0) {
                for(var j = 0; j < allImages.length; j++) {
                    if (allImages[j].getAttribute('src') == value) 
                        theElement = allImages[j];
                }
            } else 
                var theElement = allElementsThatContainValue[allElementsThatContainValue.length - 2];
            
            theElement.scrollIntoView();
            theElement.classList.add('oak_sidebar_element_highlighted');
            setTimeout(function() {
                theElement.classList.remove('oak_sidebar_element_highlighted');
            }, 1000);
        });
    }
}

function createIdentifier() {
    var text = "";
    var possible = "abcdefghijklmnopqrstuvwxyz0123456789";
  
    for (var i = 0; i < 20; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
} 