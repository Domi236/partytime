
/**logik for displaying players with number of players */
const numberOfPlayers = document.getElementById('player-number');
const playerNames = document.getElementsByClassName('player-names');
let counter = 2;

if(playerNames !== null ) {
    getCurrentPlayerCount(counter);
}

if(numberOfPlayers !== null) {
    numberOfPlayers.addEventListener('click', function() {
        counter = numberOfPlayers.value;
        getCurrentPlayerCount(counter);
    })
}

function getCurrentPlayerCount(counter) {
    for(let i = 0; i < playerNames.length; i++) {
        if(i >= counter) {
            playerNames[i].style.display = 'none';
        } else {
            playerNames[i].style.display = 'block';
        }
    }
}

/**swipe to next challenge*/
const continueBtn = document.getElementById('continue');
const resetBtn = document.getElementById('resetBtn');
const destroySessionForm = document.getElementById('destroy-session');
const formSetup = document.getElementById('form-setup');
const setupBtn = document.getElementById('setup-btn');
//let currentID = document.getElementsByClassName('current-id');
const contentContainerArticle = document.getElementsByClassName('content__container-article');
const container = document.getElementById('main');

/**datasheet*/
if( document.getElementById('datasheet__players') !== null) {
    var datasheetPlayers = document.getElementById('datasheet__players').textContent;
    var datasheetNumberOfPlayers = document.getElementById('datasheet__numberOfPlayers').textContent;
    var datasheetTags = document.getElementById('datasheet__tags').textContent;
    var datasheetSchlagwörter = document.getElementById('datasheet__schlagwörter').textContent;
}

jQuery(document).ready(function($) {
    if(continueBtn !== null ) {
        $('.headline').css('display', 'none');
    }
});

window.addEventListener('load', function() {
    console.log(2123323)
    for (let i = 0; i < contentContainerArticle.length; i++) {
        if (i === 0) {
            contentContainerArticle[i].classList.add('active');
        }
    }
    if( document.getElementById('datasheet__players') !== null) {
        let players = datasheetPlayers.split(', ');
        players.pop();
        sessionStorage.players = players;
    }
    changeBackgroundAndPlayer();
})


function getRandomPlayers() {
    let newPlayers = '';
    let randomPlayer = '';
    let randomPlayerNUmber = Math.floor(Math.random() * datasheetNumberOfPlayers);
    let players = sessionStorage.players;
    console.log(sessionStorage.players)
    players.forEach((player, index, players) => {
        if(index === randomPlayerNUmber) {
            console.log(randomPlayerNUmber+ ' randomPlayerNUmber')
            newPlayers = players.filter(currentPlayers => currentPlayers !== player);
            randomPlayer = players.filter(newPlayer => newPlayer == player);
            sessionStorage.players = newPlayers;
            while (randomPlayerNUmber <= index) {
                randomPlayerNUmber = Math.floor(Math.random() * newPlayers.length);
                console.log(randomPlayerNUmber+ ' randomPlayerNUmber')
            }
            console.log(sessionStorage.players+ ' sessionStorage.players')
            console.log(randomPlayerNUmber+ ' randomPlayerNUmber')

        }
    });
    return randomPlayer;
}

if(continueBtn !== null ) {
    continueBtn.addEventListener('click', function() {
        clickCounter();
        sessionStorage.displayFirstChallengeClass = 'activate-first-challenge';
        destroySessionForm.classList.remove(sessionStorage.displayFirstChallengeClass);
        changeBackgroundAndPlayer();
    })
}

function changeRandomPlayer(text, newString) {
    let newPlayers = '';
    let randomPlayer = '';
    let players = sessionStorage.players.toString().split(',');
    players.pop();
    let randomPlayerNUmber = Math.floor(Math.random() * players.length);

    players.forEach((player, index, players) => {
        if(index === randomPlayerNUmber) {
            newPlayers = players.filter(currentPlayers => currentPlayers !== player);
            randomPlayer = players.filter(newPlayer => newPlayer === player);
            sessionStorage.players = newPlayers;
        }
    });
    newString = text.textContent.replace('#Spieler#', randomPlayer); ///#Spieler#/g
    text.innerHTML = newString;
}

function changeBackgroundAndPlayer() {
    for(let i = 0; i < contentContainerArticle.length; i++) {
        if(contentContainerArticle[i].classList.contains('active')) {
            let texte = contentContainerArticle[i].getElementsByTagName('p');
            for(let y = 0; y < texte.length; y++) {
                let text = texte[y];
                let newString = ''; //wichtig (muss bleiben)

                if(text.textContent.includes('#Spieler#')) {
                    changeRandomPlayer(text, newString);
                }
                if(text.textContent.includes('#Spieler#')) {
                    changeRandomPlayer(text, newString);
                }
                if(text.textContent.includes('#Spieler#')) {
                    changeRandomPlayer(text, newString);
                }

                let defaultPlayers = datasheetPlayers.split(', ');
                defaultPlayers.pop();
                sessionStorage.players = defaultPlayers;
            }

            if(contentContainerArticle[i].children[1].textContent === 'perverse') {
                container.style.background = 'rgba(255, 0, 0, 0.4)';
            } else if (contentContainerArticle[i].children[1].textContent === 'crazy') {
                container.style.background = 'rgba(255, 255, 126, 0.4)';
            } else if (contentContainerArticle[i].children[1].textContent === 'common') {
                container.style.background = 'lightblue';
            } else if (contentContainerArticle[i].children[1].textContent === 'draw') {
                container.style.background = 'rgba(0, 255, 0, 0.4)';
            } else if (contentContainerArticle[i].children[1].textContent === 'explain') {
                container.style.background = 'rgba(190, 144, 212, 0.4)';
            } else if (contentContainerArticle[i].children[1].textContent === 'mime') {
                container.style.background = 'rgba(245, 171, 53, 0.4)';
            }
        }
    }
    if( document.getElementById('datasheet__players') !== null) {
        let players = datasheetPlayers.split(', ');
        sessionStorage.players = players;
    }
}

if(setupBtn !== null ) {
    setupBtn.addEventListener('click', function() {
        sessionStorage.displaySetup = 'none';
        formSetup.style.display = sessionStorage.displaySetup;
    })
}


if(resetBtn !== null) {
    resetBtn.addEventListener('click', function() {
        sessionStorage.clickcount = 0;
        sessionStorage.displaySetup = 'block';
        sessionStorage.displayFirstChallengeClass = '';
        //sessionStorage.currentPostID = '';
    })
}

function clickCounter() {
    if(typeof(Storage) !== "undefined") {
        if (sessionStorage.clickcount && sessionStorage.clickcount <= contentContainerArticle.length - 2) {
            sessionStorage.clickcount = Number(sessionStorage.clickcount)+1;
        } else {
            sessionStorage.clickcount = 0;
        }
        for(let b = 0; b < contentContainerArticle.length; b++ ) {
            contentContainerArticle[b].classList.remove('active');
        }
        for(let a = 0; a < contentContainerArticle.length; a++ ) {
            if(a === Number(sessionStorage.getItem("clickcount"))) {
                contentContainerArticle[a].classList.add('active');
            }
        }
    }
}


/*let postIDs = [];
if(typeof(Storage) !== "undefined") {
	if(sessionStorage.currentPostID !== '') {
		postIDs = sessionStorage.currentPostID;
	} */
