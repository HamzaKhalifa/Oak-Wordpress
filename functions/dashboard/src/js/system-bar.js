(function() {
    handleChatMenuButton();
    function handleChatMenuButton() {
        var chatMenuButton = document.querySelector('.oak_chat_menu_button');
        chatMenuButton.addEventListener('click', function() {
            var chatMenu = document.querySelector('.oak_chat_menu');
            var chatMenuWidth = window.innerWidth * 20 / 100;
            var chatMenuWidth = parseInt(window.getComputedStyle(chatMenu).getPropertyValue('width')) + parseInt(window.getComputedStyle(chatMenu).getPropertyValue('padding')) * 2;
            var body = document.querySelector('body');
            var chatBoxesContainer = document.querySelector('.oak_chat_boxes_container');
            if (classExists(chatMenu, 'oak_chat_menu_hidden')) {
                chatMenu.classList.remove('oak_chat_menu_hidden');
                body.style.width = parseInt(window.getComputedStyle(body).getPropertyValue('width')) - chatMenuWidth + 'px';
                console.log('right', chatMenuWidth);
                chatBoxesContainer.style.right = chatMenuWidth + 'px';
            } else {
                chatMenu.classList.add('oak_chat_menu_hidden');
                body.style.width = parseInt(window.getComputedStyle(body).getPropertyValue('width')) + chatMenuWidth + 'px';
                chatBoxesContainer.style.right = '0px';
                console.log('right', chatMenuWidth);
            }
        })
    }

    handleWindowResizeListener();
    function handleWindowResizeListener() {
        window.onresize = function(event) {
            var chatMenu = document.querySelector('.oak_chat_menu'); 
            if (!classExists(chatMenu, 'oak_chat_menu_hidden')) {
                var chatMenuWidth = window.innerWidth * 20 / 100;
                var bodyAndChatBoxesWidth = window.innerWidth - chatMenuWidth - parseInt(window.getComputedStyle(chatMenu).getPropertyValue('padding')) * 2;
                chatMenu.style.width = chatMenuWidth + 'px';
                document.querySelector('body').style.width = bodyAndChatBoxesWidth + 'px';
                console.log('right', chatMenuWidth);
                chatMenuWidth += 20;
                document.querySelector('.oak_chat_boxes_container').style.right = chatMenuWidth  + 'px';
            }
            

        }
    }

    function classExists(element, className) {
        for (var i = 0; i < element.classList.length; i++) {
            if (element.classList[i] == className) 
                return true
        }

        return false;
    }
})();