initializeGameView();
function initializeGameView() {
    var gameMainView = document.createElement('div');
    gameMainView.className = 'oak_loading_game_container oak_hidden';
    document.querySelector('body').append(gameMainView);
    gameMainView.innerHTML = '<img class="oak_loading_game_character" src="' + LOADING_GAME_DATA.characterIdlAnimationImage[0] + '" alt="">'
    + '<div class="oak_loading_game_bar_container">'
    + '<div class="oak_loading_game_bar">'
    + '<div class="oak_loading_game_bar_fill"></div>'
    + '</div>'
    + '<span class="oak_loading_game_bar_text_message">Loading</span>'
    + '</div>'  
}

function startGame() {
    var gameContainer = document.querySelector('.oak_loading_game_container');
    gameContainer.classList.remove('oak_hidden');

    startPeriodicalThreatSummon();
}

function startPeriodicalThreatSummon() {
    var canSummon = true;
    var gameContainer = document.querySelector('.oak_loading_game_container');

    window.addEventListener('focus', function() {
        canSummon = true;
    });
    window.addEventListener('blur', function() {
        canSummon = false;
    })
    
    setInterval(function() {
        if (!canSummon)
            return;
            
        var boulder = document.createElement('img');
        boulder.setAttribute('src', LOADING_GAME_DATA.boulderImage);
        boulder.className = 'oak_loading_game_boulder';
        gameContainer.append(boulder);
        boulder.style.top = Math.floor((Math.random() * window.innerHeight - 30) + 10) + 'px';
        
        var speed = Math.floor((Math.random() * 5) + 1);
        var spawnRightOrLeft = Math.floor((Math.random() * 10) + 0);
        if (spawnRightOrLeft > 5) {
            boulder.style.left = '0%';
            speed = -speed;
        }

        // To move the boulder
        setInterval(function() {
            var newLeftPosition = parseInt(parseInt(getComputedStyle(boulder).getPropertyValue('left'))) - speed;
            boulder.style.left = newLeftPosition + 'px';

            // To detect Collision
            var width = parseInt(getComputedStyle(boulder).getPropertyValue('width'));
            var height = parseInt(getComputedStyle(boulder).getPropertyValue('height'));
            var top = parseInt(getComputedStyle(boulder).getPropertyValue('top'));
            var left = parseInt(getComputedStyle(boulder).getPropertyValue('left'));

            var fireBeams = document.querySelectorAll('.oak_loading_game_firebeam');
            for (var i = 0; i < fireBeams.length; i++) {
                var firebeamWidth = parseInt(getComputedStyle(fireBeams[i]).getPropertyValue('width'));
                var firebeamHeight = parseInt(getComputedStyle(fireBeams[i]).getPropertyValue('height'));
                var firebeamTop = parseInt(getComputedStyle(fireBeams[i]).getPropertyValue('top'));
                var firebeamLeft = parseInt(getComputedStyle(fireBeams[i]).getPropertyValue('left'));

                if ( firebeamTop + firebeamHeight >= top && firebeamTop <= top + height
                    && firebeamLeft + firebeamWidth >= left && firebeamLeft <= left + width  ) {
                        fireBeams[i].remove();
                        // We are gonna summon the explosion
                        var explosion = document.createElement('img');
                        gameContainer.append(explosion);
                        explosion.className = 'oak_loading_game__explosion';
                        explosion.style.top = top - parseInt(getComputedStyle(boulder).getPropertyValue('height')) / 2 + 'px'  
                        explosion.style.left = left - parseInt(getComputedStyle(boulder).getPropertyValue('width')) / 2 + 'px'  
                        handleAnimation(explosion, LOADING_GAME_DATA.explosionImages, true);
                        boulder.remove();
                }
            }

            // To destroy the boulder when it leaves
            if (left >= parseInt(window.innerWidth) || left <= -width ) {
                boulder.remove();
            }
        }, 0.01);


        // To destroy the boulder
        // setTimeout(function() {
        //     boulder.remove();
        // }, 15000);
    }, 2000);
}

function endGame() {
    var gameContainer = document.querySelector('.oak_loading_game_container');
    gameContainer.classList.add('oak_hidden');
}

handleCharacterMovement();
function handleCharacterMovement() {
    var character = document.querySelector('.oak_loading_game_character');
    var stepPerFrame = 1;
    var keysValues = [
        {
            name: 'ArrowRight',
            pressed: false,
            stylePropertyName: 'left',
            changeValue: stepPerFrame, 
            add: true,
            movement: true,
        },
        {
            name: 'ArrowLeft',
            pressed: false,
            stylePropertyName: 'left',
            changeValue: stepPerFrame, 
            add: false,
            movement: true,
        },
        {
            name: 'ArrowDown',
            pressed: false,
            stylePropertyName: 'top',
            changeValue: stepPerFrame, 
            add: true,
            movement: true,
        },
        {
            name: 'ArrowUp',
            pressed: false,
            stylePropertyName: 'top',
            changeValue: stepPerFrame, 
            add: false,
            movement: true,
        },
    ]

    document.addEventListener('keydown', function(e) {
        const keyName = event.key;
        
        if ( keyName == 'ArrowRight' ) 
            character.classList.remove('oak_loading_game_object_changed_direction');
        else if (keyName == 'ArrowLeft')
            character.classList.add('oak_loading_game_object_changed_direction');
            
        if ( keyName == 'Shift' ) {
            fireBeam();
        }

        for (var i = 0; i < keysValues.length; i++) {
            if (keysValues[i].name == keyName) {
                keysValues[i].pressed = true;
            }
        }
    });
    document.addEventListener('keyup', function(e) {
        const keyName = event.key;
        
        for (var i = 0; i < keysValues.length; i++) {
            if (keysValues[i].name == keyName) {
                keysValues[i].pressed = false;
            }
        }
    });

    (function() {
        setInterval(function() {
            for(var i = 0; i < keysValues.length; i++) {
                if (keysValues[i].pressed) {
                    var styleValue = parseInt(getComputedStyle(character).getPropertyValue(keysValues[i]['stylePropertyName']));
                    if (keysValues[i]['add'] == true) {
                        styleValue += keysValues[i]['changeValue']
                    } else {
                        styleValue -= keysValues[i]['changeValue']
                    }
    
                    character.style[keysValues[i]['stylePropertyName']] = styleValue + 'px';
                }
            }
        }, .0000001);
    })();
}

handleAnimation(document.querySelector('.oak_loading_game_character'), LOADING_GAME_DATA.characterIdlAnimationImage, false);
function handleAnimation(element, animationImages, destroyAfterFinish) {
    var currentImage = 0;
    setInterval(function() {
        currentImage++;
        if (currentImage == animationImages.length ) {
            currentImage = 0;
            if (destroyAfterFinish === true) 
                element.remove();
        }
        element.setAttribute('src', animationImages[currentImage]);
    }, 50);
}

function fireBeam() {
    var character = document.querySelector('.oak_loading_game_character');
    
    var characterPosition = getObjectPosition(character);
    var beam = document.createElement('img');
    beam.setAttribute('src', LOADING_GAME_DATA.fireBeamImage);
    var beamDirection = classExists(character, 'oak_loading_game_object_changed_direction') ? -1 : 1;
    if (beamDirection == -1) {
        beam.classList.add('oak_loading_game_object_changed_direction');
    }
    beam.style.top = characterPosition.top + 50 + 'px';
    beam.style.left = characterPosition.left + 60 + 'px';
    beam.classList.add('oak_loading_game_firebeam');

    document.querySelector('.oak_loading_game_container').append(beam);
    setInterval(function() {
        beam.style.left = parseInt(beam.style.left) + 7 * beamDirection + 'px';
    }, 0.01);
    setTimeout(() => {
        beam.remove();
    }, 4000);
    
}

function getObjectPosition(object) {
    return {
        top: parseInt(getComputedStyle(object).getPropertyValue('top')),
        left: parseInt(getComputedStyle(object).getPropertyValue('left'))
    }
}

function setLoadingPercentage(percentage, message) {
    var barFill = document.querySelector('.oak_loading_game_bar_fill');
    if (percentage == '100%') {
        setTimeout(function() {
            endGame();
            barFill.style.width = '0%';
        }, 2000)
    }

    if (message) {
        var messageSpan = document.querySelector('.oak_loading_game_bar_text_message');
        messageSpan.innerHTML = message;
    }

    barFill.style.width = percentage;
}

function classExists(element, className) {
    for (var i = 0; i < element.classList.length; i++) {
        if (element.classList[i] == className) 
            return true
    }

    return false;
}