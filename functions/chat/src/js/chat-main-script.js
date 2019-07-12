(function() {
    Notification.requestPermission().then(function(result) {
        console.log(result);
    });

    var authentificationForm = document.querySelector('.oak_chat_menu__authentication');
    var loaderContainer = document.querySelector('.oak_chat_loader_container');
    var authenticatedView = document.querySelector('.oak_chat_authenticated');
    var loadingMessage = document.querySelector('.oak_chat_loader_container__loading_message');
    var otherMessageView = null;
    var fileMessageView = null;
    var imageMessageView = null;
    var chatBoxView = null;
    var singleUserChatButtonView = null;
    var firstTimeCheckingChatNotifications = true;

    currentUser = {
        id: '',
        username: '',
        email: '',
    }
    
    getChatViews();
    function getChatViews() {
        var chatBoxExample = document.querySelector('.oak_single_chat_box');

        var otherMessageExample = chatBoxExample.querySelector('.oak_single_chat_box__message_container');
        otherMessageView = otherMessageExample.innerHTML;
        otherMessageExample.remove();

        var fileMessageExample = chatBoxExample.querySelector('.file_message_container');
        fileMessageView = fileMessageExample.innerHTML;
        fileMessageExample.remove();

        var imageMessageExample = chatBoxExample.querySelector('.image_message_container');
        imageMessageView = imageMessageExample.innerHTML;
        imageMessageExample.remove();


        var myMessageExample = chatBoxExample.querySelector('.my_message_style');
        myMessageExample.remove();

        chatBoxView = chatBoxExample.innerHTML;
        chatBoxExample.remove();

        var singleUserChatButton = document.querySelector('.oak_chat_menu__single_user_view');
        singleUserChatButtonView = singleUserChatButton.innerHTML;
        singleUserChatButton.remove();

    }

    // Check if authenticated: 
    handleAuthentificationView();
    function handleAuthentificationView() {
        var alreadyAuthenticatedView = document.querySelector('.oak_chat_authenticated');
        if ( OAK_MAIN_CHAT_DATA.authenticated == 'false' ) {
            authentificationForm.classList.remove('oak_hidden');
            alreadyAuthenticatedView.classList.add('oak_hidden');
        } else {
            authentificationForm.classList.add('oak_hidden');
            alreadyAuthenticatedView.classList.remove('oak_hidden');
        }
    }

    handleAuthentificationFormListener();
    function handleAuthentificationFormListener() {
        var errorMessageSpan = document.querySelector('.oak_chat_authentication__error_message');

        authentificationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var email = document.querySelector('.oak_chat_email').value;
            var password = document.querySelector('.oak_chat_password').value;
            var username = document.querySelector('.oak_chat_username').value;
            if (email == '') {
                errorMessageSpan.innerHTML = 'Le nom d\'utilisateur ne doit pas être vide';
                return
            } else if(password == '' ) {
                errorMessageSpan.innerHTML = 'Le mot de passe ne doit pas être vide';
                return;
            } else if(username == '' ) {
                errorMessageSpan.innerHTML = 'Le nom d\'utilisateur ne doit pas être vide';
                return;
            } else {
                errorMessageSpan.innerHTML = '';
            }

            authentificationForm.classList.add('oak_hidden');
            loaderContainer.classList.remove('oak_hidden');
            loadingMessage.innerHTML = 'Authentification en cours...'

            firebase.auth().createUserWithEmailAndPassword(email, password).catch(function(error) {
                var errorCode = error.code;
                var errorMessage = error.message;

                if (errorCode == 'auth/email-already-in-use') {
                    firebase.auth().signInWithEmailAndPassword(email, password).catch(function(error) {
                        var errorCode = error.code;
                        var errorMessage = error.message;

                        loaderContainer.classList.add('oak_hidden');
                        authentificationForm.classList.remove('oak_hidden');
                        errorMessageSpan.innerHTML = errorMessage
                    }).then(function(data) {
                        if (data) {
                            writeUserData(data.user.uid, username, email)
                        }
                    });
                } else {
                    loaderContainer.classList.add('oak_hidden');
                    authentificationForm.classList.remove('oak_hidden');
                    errorMessageSpan.innerHTML = errorMessage
                }
            }).then(function(data) {
                if (data) {
                    writeUserData(data.user.uid, username, email)
                }
            });
            // Here we try to authenticate using firebase: 
        })
    }

    handleOnAuthStateChanged()
    function handleOnAuthStateChanged() {
        firebase.auth().onAuthStateChanged(function(user) {
            if (user) {
                // User is signed in.
                var email = user.email;
                var emailVerified = user.emailVerified;
                var photoURL = user.photoURL;
                var isAnonymous = user.isAnonymous;
                var uid = user.uid;
                var username = firebase.database().ref('users/' + uid + '/username').on('value', function(snapshot){
                    currentUser.username = snapshot.val();
                    document.querySelector('.oak_chat_menu__current_connected_user').innerHTML = snapshot.val();
                })
                var providerData = user.providerData;
                currentUser = {
                    email,
                    username, 
                    id: uid
                }

                // loaderContainer.classList.add('oak_hidden');
                authenticatedView.classList.remove('oak_hidden');
                authentificationForm.classList.add('oak_hidden');
                loadingMessage.innerHTML = 'Chargement de la liste...';

                sendAjaxRequest('true', 'modify_authenticated', function(data) {
                });

                handleSystemBarChatNotifications();
                handleUsersList();
            } else {
                // User is signed out.
                currentUser = {};
                document.querySelector('.oak_chat_menu_button__notification').classList.add('oak_hidden');
                loaderContainer.classList.add('oak_hidden');
                authenticatedView.classList.add('oak_hidden');
                authentificationForm.classList.remove('oak_hidden');

                sendAjaxRequest('false', 'modify_authenticated', function(data) {
                })

                // Fermer toutes les fenêtres de chat au sign out: 
                var allChatBoxes = document.querySelectorAll('.oak_single_chat_box');
                for(var i = 0; i < allChatBoxes.length; i++) {
                    allChatBoxes[i].remove();
                }
            }
        });
    }

    function notify(numberOfNotifications) {
        if (!currentUser.id)
            return;

        // Let's check if the browser supports notifications
        if (!("Notification" in window)) {
            alert("This browser does not support system notifications");
            // This is not how you would really do things if they aren't supported. :)
        }

        // Let's check whether notification permissions have already been granted
        else if (Notification.permission === "granted") {
            // If it's okay let's create a notification
            var audio = new Audio(OAK_MAIN_CHAT_DATA.notificationSound);
            audio.play();
            var notification = new Notification("Vous avez " + numberOfNotifications + " message(s) non lu(s)");
        }

        // Otherwise, we need to ask the user for permission
        else if (Notification.permission !== 'denied') {
            Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
                if (permission === "granted") {
                    var notification = new Notification("Hi there!");
                }
            });
        }

        // Finally, if the user has denied notifications and you 
        // want to be respectful there is no need to bother them any more.
    }

    function handleSystemBarChatNotifications() {
        firebase.database().ref('users/' + currentUser.id + '/chat').on('value', function(snapshot) {
            if (!currentUser.id) {
                return;
            }

            var numberOfNotifications = 0;
            var chatteUsersIds = getKeys(snapshot.val());
            for(var i = 0; i < chatteUsersIds.length; i++) {
                var sentMessagesIds = getKeys(snapshot.val()[chatteUsersIds[i]]);
                for (var j = 0; j < sentMessagesIds.length; j++) {
                    var messageData = snapshot.val()[chatteUsersIds[i]][sentMessagesIds[j]];
                    if (!messageData.me && !messageData.seen) {
                        numberOfNotifications++;
                    }
                }
            }

            var systemBarNotifications = document.querySelector('.oak_chat_menu_button__notification');
            var currentNotificationsNumber = parseInt(systemBarNotifications.innerHTML);

            if (currentNotificationsNumber < numberOfNotifications) {
                if (!firstTimeCheckingChatNotifications)
                    notify(numberOfNotifications);
            }
            firstTimeCheckingChatNotifications = false;

            systemBarNotifications.innerHTML = numberOfNotifications;

            if (numberOfNotifications > 0) {
                systemBarNotifications.classList.remove('oak_hidden');
            } else {
                systemBarNotifications.classList.add('oak_hidden');
            }
        });
    }

    handleSignOutButton();
    function handleSignOutButton() {
        var signOutButton = document.querySelector('.oak_chat_sign_out_button');
        signOutButton.addEventListener('click', function() {
            loaderContainer.classList.remove('oak_hidden');
            loadingMessage.innerHTML = 'Déconnexion...';
            authenticatedView.classList.add('oak_hidden');
            firebase.auth().signOut();
        })
    }

    function writeUserData(userId, name, email) {
        firebase.database().ref('users/' + userId + '/email').set(email);
        firebase.database().ref('users/' + userId + '/username').set(name);
    }

    // handleUsersList();
    function handleUsersList() {
        firebase.database().ref('users').on('value', function(snapshot) {
            var userIds = getKeys(snapshot.val());
            // delete all already existing user chat buttons: 
            var allChatButtons = document.querySelectorAll('.oak_chat_menu__single_user_view');
            for (var i = 0; i < allChatButtons.length; i++) {
                allChatButtons[i].remove();
            }

            for (var i = 0; i < userIds.length; i++) {
                var userData = snapshot.val()[userIds[i]];

                var newSingleUserChatButton = document.createElement('div');
                newSingleUserChatButton.classList.add('oak_chat_menu__single_user_view');
                newSingleUserChatButton.innerHTML = singleUserChatButtonView;
                newSingleUserChatButton.id = userIds[i];
                newSingleUserChatButton.setAttribute('username', userData.username);
                newSingleUserChatButton.setAttribute('email', userData.email);
                newSingleUserChatButton.querySelector('.oak_chat_menu_single_user__name').innerHTML = userData.username + ' (' + userData.email + ')';

                var numberOfUnreadMessages = 0;
                var userId = userIds[i];
                firebase.database().ref('users/' + currentUser.id + '/chat/' + userIds[i]).on('value', function(messagesSnapshot) {
                    var messagesIds = getKeys( messagesSnapshot.val() );
                    for (var m = 0; m < messagesIds.length; m++) {
                        if (messagesSnapshot.val()[messagesIds[m]].seen == false && messagesSnapshot.val()[messagesIds[m]].me == false) {
                            numberOfUnreadMessages++;
                        }
                    }

                    var notificationContainer = newSingleUserChatButton.querySelector('.oak_chat_menu_single_user_view__notification');
                    newSingleUserChatButton.querySelector('.oak_chat_menu_single_user_view__notification').innerHTML = numberOfUnreadMessages;
                    if ( numberOfUnreadMessages > 0 ) {
                        notificationContainer.classList.remove('oak_hidden');
                    } else {
                        notificationContainer.classList.add('oak_hidden');
                    }
                });
                
                authenticatedView.append(newSingleUserChatButton);
            }

            loaderContainer.classList.add('oak_hidden');
            handleChatButtons();
        });
    }

    function setMessagesSeen(seenById, messagesOfWhoId) {
        firebase.database().ref('users/' + seenById + '/chat/' + messagesOfWhoId).once('value', function(messagesSnapshot) {
            var snapshot = messagesSnapshot.val();
            var messagesIds = getKeys(snapshot);
            for (var m = 0; m < messagesIds.length; m++) {
                if (!snapshot[messagesIds[m]].me) {
                    firebase.database().ref('users/' + seenById + '/chat/' + messagesOfWhoId + '/' + messagesIds[m] + '/seen').set(true);
                    firebase.database().ref('users/' + messagesOfWhoId + '/chat/' + seenById + '/' + messagesIds[m] + '/seen').set(true);
                }
            }
        });
    }

    function handleChatButtons() {
        var chatBoxesContainer = document.querySelector('.oak_chat_boxes_container');

        var usersChatButtons = document.querySelectorAll('.oak_chat_menu__single_user_view');
        for(var i = 0; i < usersChatButtons.length; i++) {
            usersChatButtons[i].addEventListener('click', function() {
                // Get all chat boxes to check if chat box for clicked user isn't already shown: 
                var allChatBoxes = document.querySelectorAll('.oak_single_chat_box');
                var theId = this.id;
                setMessagesSeen(currentUser.id, theId);

                for (var m = 0; m < allChatBoxes.length; m++) {
                    if (allChatBoxes[m].id == this.id) {
                        return;
                    }
                }

                var newChatBox = document.createElement('div');
                newChatBox.className = 'oak_single_chat_box';
                newChatBox.innerHTML = chatBoxView;
                newChatBox.id = theId
                newChatBox.querySelector('.oak_single_chat_box_bar__name').innerHTML = this.getAttribute('username');

                var inputField = newChatBox.querySelector('.oak_single_chat_box_message_textarea');
                inputField.addEventListener('focus', function(e) {
                    setMessagesSeen(currentUser.id, theId);
                })

                chatBoxesContainer.append(newChatBox);
                handleChatBoxButtons(newChatBox);
            });
        }

        function handleChatBoxButtons(chatBox) {
            handleOffButton();
            function handleOffButton() {
                chatBox.querySelector('.chat_box_off_button').addEventListener('click', function() {
                    chatBox.remove();
                });
            }

            handleMakeChatBoxBiggerOrSmallerButton();
            function handleMakeChatBoxBiggerOrSmallerButton() {
                var makeBiggerOrSmallerButton = chatBox.querySelector('.chat_box_make_bigger_or_smaller_button');
                makeBiggerOrSmallerButton.addEventListener('click', function() {
                    if (classExists(chatBox, 'chat_box_bigger')) {
                        chatBox.classList.remove('chat_box_bigger')
                    } else {
                        chatBox.classList.add('chat_box_bigger');
                    }
                })
            }

            handleSendMessageForm();
            function handleSendMessageForm() {
                chatBox.querySelector('.oak_single_chat_box_message_form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (chatBox.querySelector('.oak_single_chat_box_message_textarea').value != '')
                        sendMessage('text');
                    if (chatBox.querySelector('.oak_single_chat_box_message_form__files_button').value != '')
                        sendMessage('file');
                    if (chatBox.querySelector('.oak_single_chat_box_message_form__images_button').value != '')
                        sendMessage('image');
                })
            }

            function sendMessage(type) {
                var messageTextArea = chatBox.querySelector('.oak_single_chat_box_message_textarea');
                var fileInput = chatBox.querySelector('.oak_single_chat_box_message_form__files_button');
                var imageInput = chatBox.querySelector('.oak_single_chat_box_message_form__images_button');
                var message = '';
                var data = '';
                if (type == 'text')
                    message = messageTextArea.value;
                else if (type == 'file') {
                    data = fileInput.getAttribute('data');
                    // message = fileInput.value;
                    message = fileInput.files.item(0).name
                } else if (type == 'image') {
                    data = imageInput.getAttribute('data');
                    // message = imageInput.value;
                    message = imageInput.files.item(0).name
                }
                     
                var messageObject = {
                    sentIn: new Date().toString(),
                    message,
                    seen: false,
                    me: true,
                    type,
                    data
                }

                var messageKey = firebase.database().ref('users/' + currentUser.id + '/chat/' + chatBox.id).push(messageObject).key;
                if ( chatBox.id != currentUser.id ) {
                    messageObject.me = false;
                    firebase.database().ref('users/' + chatBox.id + '/chat/' + currentUser.id + '/' + messageKey).set(messageObject);
                }

                if (type == 'file') 
                    fileInput.value = '';
                else if (type == 'text')
                    messageTextArea.value = '';
                else if(type == 'image')
                    imageInput.value = '';
                
            }

            handleChatBoxInputFieldKeyPress();
            function handleChatBoxInputFieldKeyPress() {
                var inputField = chatBox.querySelector('.oak_single_chat_box_message_textarea');
                inputField.addEventListener('keypress', function(e){
                    if(e.which == 13 && !e.shiftKey) {
                        // jQuery(this).closest("form");
                        forceSubmitFormWithVirtualButton(chatBox.querySelector('.oak_single_chat_box_message_form'));
                        // chatBox.querySelector('.oak_single_chat_box_message_form').trigger('submit');
                        e.preventDefault();
                        return false;
                    }
                });
            }

            function forceSubmitFormWithVirtualButton(form) {
                //get the form element's document to create the input control with
                //(this way will work across windows in IE8)
                var button = form.ownerDocument.createElement('input');
                //make sure it can't be seen/disrupts layout (even momentarily)
                button.style.display = 'none';
                //make it such that it will invoke submit if clicked
                button.type = 'submit';
                //append it and click it
                form.appendChild(button).click();
                //if it was prevented, make sure we don't get a build up of buttons
                form.removeChild(button);
            }

            handleFileAndImageButtons();
            function handleFileAndImageButtons() {
                var fileButton = chatBox.querySelector('.oak_single_chat_box_message_form__files_button');
                var imageButton = chatBox.querySelector('.oak_single_chat_box_message_form__images_button');

                fileInputChange(fileButton);
                fileInputChange(imageButton);
            }

            function fileInputChange(input) {
                input.addEventListener('change', function(e) {
                    readURL(this, function(result) {
                        var fileIdentifier = createIdentifier();
                        input.setAttribute('data', result);
                    })
                })
            }

            handleChatListener();
            function handleChatListener() {
                firebase.database().ref('users/' + currentUser.id + '/chat/' + chatBox.id).on('value', function(snapshot) {
                    var allMessagesIds = getKeys(snapshot.val());

                    var seenText = chatBox.querySelector('.oak_chat_box_seen_or_not');
                    var seen = true;
                    var allAlreadyExistingMessages = chatBox.querySelectorAll('.oak_single_chat_box__message_container');
                    for (var i = 0; i < allMessagesIds.length; i++) {
                        var messageAlreadyPushed = false;
                        for (var j = 0; j < allAlreadyExistingMessages.length; j++) {
                            if (allAlreadyExistingMessages[j].id == allMessagesIds[i]) {
                                messageAlreadyPushed = true;
                            }
                        }

                        var messageData = snapshot.val()[allMessagesIds[i]];
                        if (!messageData.seen) {
                            seen = false;
                        }

                        if (!messageAlreadyPushed) {
                            var message = document.createElement('div');
                            message.className = 'oak_single_chat_box__message_container';
                            message.id = allMessagesIds[i];

                            var chatBoxMessagesContainer = chatBox.querySelector('.oak_single_chat_box__messages_container');
                            chatBoxMessagesContainer.append(message);

                            console.log('message data', messageData);

                            if (messageData.type == 'text') {
                                message.innerHTML = otherMessageView;
                                message.querySelector('.oak_message_text_style').innerHTML = messageData.message;
                            } else if (messageData.type == 'file') {
                                message.innerHTML = fileMessageView;
                                message.classList.add('file_message_container');
                                var fileDownloadButton = message.querySelector('.oak_message_container__file_input');
                                var fileName = message.querySelector('.oak_message_container__file_name');
                                fileDownloadButton.setAttribute('href', messageData.data);
                                // fileDownloadButton.addEventListener('click', function() {

                                // });
                                fileName.innerHTML = messageData.message;
                            } else if (messageData.type == 'image') {
                                message.innerHTML = imageMessageView;
                                message.classList.add('image_message_container');
                                var messageImage = message.querySelector('.oak_message_container__image');
                                messageImage.setAttribute('src', messageData.data);
                            }
                            
                            if (messageData.me) {
                                message.classList.add('my_message_style');
                            }

                            message.scrollIntoView();
                        }
                    }

                    seenText.innerHTML = seen ? 'Vu' : 'Non vu';
                });
            }
        }
    }

    function readURL(input, callback) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                callback(e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function createIdentifier() {
        var text = "";
        var possible = "abcdefghijklmnopqrstuvwxyz0123456789";
    
        for (var i = 0; i < 20; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        
        return text;
    }

    function classExists(element, className) {
        for (var i = 0; i < element.classList.length; i++) {
            if (element.classList[i] == className) 
                return true
        }

        return false;
    }

    function sendAjaxRequest(data, functionName, callback) {
        jQuery(document).ready(function() {
            jQuery.ajax({
                type: 'POST',
                url: OAK_MAIN_CHAT_DATA.ajaxUrl,
                data: {
                    'data': data,
                    'action': functionName
                },
                success: function(data) {
                    // console.log(data);
                    callback(data);
                },
                error: function(error) {
                    // console.log(error);
                    callback(error);
                }
            });
        });
    }

    var getKeys = function(obj){
        var keys = [];
        for(var key in obj){
        keys.push(key);
        }
        return keys;
    }
})();