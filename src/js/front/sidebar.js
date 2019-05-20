handleFrameObjectsButtons();
function handleFrameObjectsButtons() {
    var frameObjectsButtons = document.querySelectorAll('.oak_sidebar_frame_objects_container_single_frame__scroll_to_content_button');
    for (var i = 0; i < frameObjectsButtons.length; i++) {
        var identifier = createIdentifier();
        frameObjectsButtons[i].setAttribute('id', identifier);

        jQuery('#' + identifier).click(function() {
            var value = this.getAttribute('value');
            
            var allElementsThatContainValue = jQuery('*:contains("' + value + '")'); 
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