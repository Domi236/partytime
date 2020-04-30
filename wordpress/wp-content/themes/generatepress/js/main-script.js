
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

/**get current Player count*/
function getCurrentPlayerCount(counter) {
    const setupContainer = document.getElementsByClassName('setup__container');
    for(let i = 0; i < playerNames.length; i++) {
        if(i >= counter) {
            playerNames[i].style.display = 'none';
        } else {
            playerNames[i].style.display = 'block';
        }
        console.log(playerNames.length)
        if(counter > 4) {
            for(let y = 0; y < setupContainer.length; y++) {
                if(y === 0) {
                    setupContainer[y].style.overflow = 'scroll';
                }
            }
        } else {
            for(let y = 0; y < setupContainer.length; y++) {
                if(y === 0) {
                    setupContainer[y].style.overflow = 'hidden';
                }
            }
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
const headlineChallenges = document.getElementsByClassName('headline__challenges');
const container = document.getElementById('main');
const oldEnoughCheck = document.getElementById('perversions-limit');
const oldEnoughCheckValue = document.getElementById('perversions-limit-value');
const alkLimitCheck = document.getElementById('alkohol-limit');
const alkLimitCheckValue = document.getElementById('alkohol-limit-value');
const articleIcons = document.getElementsByClassName('article-icons');

const activity = ['Pantomime', 'Erklären', 'Zeichnen'];

/**datasheet*/
if( document.getElementById('datasheet__players') !== null) {
    var datasheetPlayers = document.getElementById('datasheet__players').textContent;
    var datasheetNumberOfPlayers = document.getElementById('datasheet__numberOfPlayers').textContent;
    var datasheetTags = document.getElementById('datasheet__tags').textContent;
    var datasheetSchlagwörter = document.getElementById('datasheet__schlagwörter').textContent;
    //var datasheetOldEnough = document.getElementById('datasheet__old-enough').textContent;
}

/** set choosen punishments*/
function setPunishments() {
    const punishmentList = document.getElementsByClassName('punishments');
    let punishments = [];
    for(let i = 0; i < punishmentList.length; i++) {
        if(punishmentList[i].style.display !== 'none') {
            punishments.push(punishmentList[i].textContent);
        }
    }
    sessionStorage.punishments = punishments;
}

/** check perserve limit*/
function checkHOTorNOT(limit, punishments) {
    console.log(punishments)

    if ( limit == 0 )  {
        oldEnoughCheckValue.innerHTML = 'NEIN!';
        document.getElementById('punishments-perverse').style.display = 'none';
    } else if ( limit == 20 )  {
        oldEnoughCheckValue.innerHTML = 'HAVE FUN!';
        document.getElementById('punishments-perverse').style.display = 'none';
    } else if (limit == 40 )  {
        oldEnoughCheckValue.innerHTML = 'HOT!';
    } else if (limit == 60 )  {
        oldEnoughCheckValue.innerHTML = 'GET NACKED!';
    } else if ( limit == 80 )  {
        oldEnoughCheckValue.innerHTML = 'FUCK ME!';
    }

    if(limit > 20) {
        document.getElementById('punishments-perverse').style.display = 'list-item';
        // punishments.push('Zieh dir ein Kleidungstück aus!');
        document.getElementById('ct-perverse').checked = true;
        document.getElementById('ct-seduction').checked = true;
    } else {
        document.getElementById('ct-perverse').checked = false;
        document.getElementById('ct-seduction').checked = false;
    }

    if(limit > 20 && alkLimitCheck.value > 0) {
        document.getElementById('ct-perverse_alk').checked = true;
        document.getElementById('ct-seduction_alk').checked = true;
    } else {
        document.getElementById('ct-perverse_alk').checked = false;
        document.getElementById('ct-seduction_alk').checked = false;
    }

    limit > 40 ? document.getElementById('ct-perverse_18').checked = true : document.getElementById('ct-perverse_18').checked = false;
    limit > 40 && alkLimitCheck.value > 0 ? document.getElementById('ct-perverse_18_alk').checked = true : document.getElementById('ct-perverse_18_alk').checked = false;
    sessionStorage.oldEnough = limit;
    setPunishments();
}

/** check alk limit*/
function checkALKorNOT(limit, punishments) {
    console.log(punishments)
    let punishmentsDink = "Trinke <span id='punishments-drink-value'></span> Schlücke!";
    console.log(punishmentsDink, punishments)
    if ( limit == 0 )  {
        alkLimitCheckValue.innerHTML = 'NEIN!';
        document.getElementById('punishments-drink').style.display = 'none';
        document.getElementById('punishments-drink-max').style.display = 'none';
    } else if ( limit == 20 )  {
        alkLimitCheckValue.innerHTML = 'VORGLÜHEN!';
        document.getElementById('punishments-drink-value').innerHTML = '1';
        document.getElementById('punishments-drink-max').style.display = 'none';
    } else if ( limit == 40 )  {
        alkLimitCheckValue.innerHTML = 'SAUFEN!';
        document.getElementById('punishments-drink-value').innerHTML = '2';
        document.getElementById('punishments-drink-max').style.display = 'none';
    } else if ( limit == 60 )  {
        alkLimitCheckValue.innerHTML = 'GET DRUNK!';
        document.getElementById('punishments-drink-value').innerHTML = '3';
        document.getElementById('punishments-drink-max').style.display = 'list-item';
    } else if ( limit == 80 )  {
        alkLimitCheckValue.innerHTML = 'KAMPFTRINKEN!';
        document.getElementById('punishments-drink-value').innerHTML = '4';
        document.getElementById('punishments-drink-max').style.display = 'list-item';
    }

    if(limit > 0) {
        document.getElementById('punishments-drink').style.display = 'list-item';
        document.getElementById('ct-just_drinking').checked = true;
    } else {
        document.getElementById('ct-just_drinking').checked = false;
    }

    if(limit > 0 && oldEnoughCheck.value > 20) {
        document.getElementById('ct-perverse_alk').checked = true;
        document.getElementById('ct-seduction_alk').checked = true;
    } else {
        document.getElementById('ct-perverse_alk').checked = false;
        document.getElementById('ct-seduction_alk').checked = false;
    }

    limit > 0 && oldEnoughCheck.value > 40 ? document.getElementById('ct-perverse_18_alk').checked = true : document.getElementById('ct-perverse_18_alk').checked = false;
    sessionStorage.alkLimit = limit;
    setPunishments();
}

jQuery(document).ready(function($) {
    const categories = document.getElementsByClassName('categorie__filter');
    const categorieTags = document.getElementsByClassName( 'categorie-tags' );

    let showRules = false;
    if(document.getElementById('rule-btn') !== null) {
        document.getElementById('rule-btn').addEventListener('click', () => {
            if(!showRules) {
                showRules = true;
                $('.setup__container:last-child').addClass('show-rules');
                $('#close-rules').css('display', 'block');

                document.getElementById('close-rules').addEventListener('click', () => {
                    showRules = false;
                    $('.setup__container:last-child').removeClass('show-rules');
                    $('#close-rules').css('display', 'none');
                })
            } else {
                showRules = false;
                $('.setup__container:last-child').removeClass('show-rules');
                $('#close-rules').css('display', 'none');
            }
        })
    }

    if(alkLimitCheck !== null) {
        let punishments = ['Die anderen Spieler überlegen sich eine wenn möglich unangenhme Frage für dich!',
            'Die anderen Spieler überlegen sich eine Pflichtaufgabe für dich!', 'Das nächste mal wenn ein Spieler aufgefordert wird etwas zu tun ' +
            'oder auf eine Frage zu antworten, musst du stattdessen für ihn übernehmen!', 'Du erhältst keine Strafe!' ];
        let limit = alkLimitCheck.value;
        checkHOTorNOT(limit, punishments);
        limit = oldEnoughCheck.value;
        checkALKorNOT(limit, punishments);
    }

    /** display dom elements, on specific url*/
    if(continueBtn !== null && window.location.href.includes( 'partygame' )) {
        $('.headline').css('display', 'none');
        $('#site-navigation').css('display', 'none');
        $('#masthead').css('display', 'none');
        //$('#resetBtn').css({'position': 'fixed','top': '0', 'right': '0' });
        $('#resetBtn').css('display', 'none');
        $('.setup-icon__container').css('display', 'none');

        setArticleIconEvents(articleIcons);
    }

    /**change perversions-limit categories*/
    if(oldEnoughCheck !== null) {
        oldEnoughCheck.addEventListener('change', (ev) => {

            let limit = ev.target.value;
            checkHOTorNOT(limit);
        })
    }
    /**change alk-limit categories*/
    if(alkLimitCheck !== null) {
        alkLimitCheck.addEventListener('change', (ev) => {

            let limit = ev.target.value;
            checkALKorNOT(limit);
        })
    }

    /**category filter -> check categories by choosen parent categories and range limits*/
    if(categories !== null ) {
        for ( let n = 0; n < categories.length; n++ ) {
            categories[n].addEventListener( 'click', ( ev ) => {
                sessionStorage.oldEnough = oldEnoughCheck.value;
                sessionStorage.alkLimit = alkLimitCheck.value;

                let categoryArray = [
                    'crazy', 'crazy_alk',
                    'perverse', 'perverse_alk', 'perverse_18', 'perverse_18_alk', 'seduction', 'seduction_alk',
                    'activity', 'activity_18', 'storytime', 'storytime_18', 'i_never_have', 'i_never_have_18',
                    'truth_or_dare', 'truth_or_dare_alk', 'truth_or_dare_16', 'truth_or_dare_18', 'truth_or_dare_extrem', 'just_drinking'];

                if ( ev.target.value === 'no-limit' ) {
                    checkChoosenCategories( categorieTags, categoryArray );
                    oldEnoughCheck.value = 80;
                    alkLimitCheck.value = 80;
                    for ( let s = 0; s < categories.length; s++ ) {
                        categories[s].children[0].checked = true;
                        categories[s].style.pointerEvents = 'none';
                        categories[s].style.color = 'grey';
                    }
                } else {
                    if ( ev.target.value === 'parent-val-crazy' ) {
                        categoryArray = ['crazy']
                        if ( sessionStorage.alkLimit > 0) {
                            let newContent = ['crazy_alk'];
                            for ( let i = 0; i < newContent.length; i++ ) {
                                categoryArray.push( newContent[i] );
                            }
                        }
                        checkChoosenCategories( categorieTags, categoryArray );
                        categories[n].style.color = 'grey';
                        categories[n].style.pointerEvents = 'none';
                        alkLimitCheck.style.pointerEvents = 'none';
                        oldEnoughCheck.style.pointerEvents = 'none';
                    } else if ( ev.target.value === 'parent-val-activity' ) {
                        categoryArray = ['activity']
                        if ( sessionStorage.oldEnough > 0) {
                            let newContent = ['activity_18'];
                            for ( let i = 0; i < newContent.length; i++ ) {
                                categoryArray.push( newContent[i] );
                            }
                        }
                        checkChoosenCategories( categorieTags, categoryArray );
                        categories[n].style.pointerEvents = 'none';
                        alkLimitCheck.style.pointerEvents = 'none';
                        oldEnoughCheck.style.pointerEvents = 'none';
                        categories[n].style.color = 'grey';
                    } else if ( ev.target.value === 'parent-val-storytime' ) {
                        categoryArray = ['storytime']
                        if ( sessionStorage.oldEnough > 0) {
                            let newContent = ['storytime_18'];
                            for ( let i = 0; i < newContent.length; i++ ) {
                                categoryArray.push( newContent[i] );
                            }
                        }
                        checkChoosenCategories( categorieTags, categoryArray );
                        categories[n].style.color = 'grey';
                        categories[n].style.pointerEvents = 'none';
                        alkLimitCheck.style.pointerEvents = 'none';
                        oldEnoughCheck.style.pointerEvents = 'none';
                    } else if ( ev.target.value === 'parent-val-i_never_have' ) {
                        categoryArray = ['i_never_have']
                        if ( sessionStorage.oldEnough > 0) {
                            let newContent = ['i_never_have_18'];
                            for ( let i = 0; i < newContent.length; i++ ) {
                                categoryArray.push( newContent[i] );
                            }
                        }
                        checkChoosenCategories( categorieTags, categoryArray );
                        categories[n].style.color = 'grey';
                        categories[n].style.pointerEvents = 'none';
                        alkLimitCheck.style.pointerEvents = 'none';
                        oldEnoughCheck.style.pointerEvents = 'none';
                    } else if ( ev.target.value === 'parent-val-truth_or_dare' ) {
                        categoryArray = ['truth_or_dare']
                        if ( sessionStorage.oldEnough > 0) {
                            let newContent = ['truth_or_dare_16'];
                            for ( let i = 0; i < newContent.length; i++ ) {
                                categoryArray.push( newContent[i] );
                            }
                        }
                        if ( sessionStorage.oldEnough > 20) {
                            let newContent = ['truth_or_dare_18'];
                            for ( let i = 0; i < newContent.length; i++ ) {
                                categoryArray.push( newContent[i] );
                            }
                        }
                        if ( sessionStorage.oldEnough > 40) {
                            let newContent = ['truth_or_dare_extrem'];
                            for ( let i = 0; i < newContent.length; i++ ) {
                                categoryArray.push( newContent[i] );
                            }
                        }
                        if ( sessionStorage.alkLimit > 0) {
                            let newContent = ['truth_or_dare_alk'];
                            for ( let i = 0; i < newContent.length; i++ ) {
                                categoryArray.push( newContent[i] );
                            }
                        }
                        checkChoosenCategories( categorieTags, categoryArray );
                        categories[n].style.pointerEvents = 'none';
                        alkLimitCheck.style.pointerEvents = 'none';
                        oldEnoughCheck.style.pointerEvents = 'none';
                        categories[n].style.color = 'grey';
                    }
                }
            })
        }
    }
});

/**check Choosen Categories from filter*/
function checkChoosenCategories(categorieTags, categoryArray) {
    for(let i = 0; i < categorieTags.length; i++) {
        if(categoryArray.includes(categorieTags[i].value)) {
            categorieTags[i].checked = true;
        }
    }
}

/** display first challenge*/
window.addEventListener('load', function() {
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


/** get random players*/
function getRandomPlayers() {
    let newPlayers = '';
    let randomPlayer = '';
    let randomPlayerNUmber = Math.floor(Math.random() * datasheetNumberOfPlayers);
    let players = sessionStorage.players;
    console.log(sessionStorage.players)
    players.forEach((player, index, players) => {
        if(index === randomPlayerNUmber) {
            newPlayers = players.filter(currentPlayers => currentPlayers !== player);
            randomPlayer = players.filter(newPlayer => newPlayer == player);
            sessionStorage.players = newPlayers;
            while (randomPlayerNUmber <= index) {
                randomPlayerNUmber = Math.floor(Math.random() * newPlayers.length);
            }
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

/** change random player*/
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

/** change Background and player*/
function changeBackgroundAndPlayer() {
    for(let i = 0; i < contentContainerArticle.length; i++) {
        if(contentContainerArticle[i].classList.contains('active')) {
            let truth = contentContainerArticle[i].getElementsByClassName('truth');
            for(let y = 0; y < truth.length; y++) {
                truth[y].addEventListener('click', () => {
                    contentContainerArticle[i].children[6].style.display = 'none';
                    contentContainerArticle[i].children[5].style.display = 'block';
                })
            }

            let dare = contentContainerArticle[i].getElementsByClassName('dare');
            for(let y = 0; y < dare.length; y++) {
                dare[y].addEventListener('click', () => {
                    contentContainerArticle[i].children[5].style.display = 'none';
                    contentContainerArticle[i].children[6].style.display = 'block';
                })
            }

            if(contentContainerArticle[i].children[2].textContent.includes('VIRUS')) {
                console.log('virus')
            }

            let texte = contentContainerArticle[i].getElementsByTagName('p');
            for(let y = 0; y < texte.length; y++) {
                let text = texte[y];
                let newString = ''; //wichtig (muss bleiben)

                if(text.textContent.includes('#Activity#')) {
                    let newText = text.textContent.replace('#Activity#', getRandomActivity());
                    text.innerHTML = newText;
                }

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

            if(contentContainerArticle[i].children[2].textContent === 'perverse' || contentContainerArticle[i].children[2].textContent === 'perverse_alk'
                || contentContainerArticle[i].children[2].textContent === 'perverse_18' || contentContainerArticle[i].children[2].textContent === 'perverse_18_alk'
                ||  contentContainerArticle[i].children[2].textContent === 'seduction'||  contentContainerArticle[i].children[2].textContent === 'seduction_alk'
                ||  contentContainerArticle[i].children[2].textContent === 'truth_or_dare_16' || contentContainerArticle[i].children[2].textContent === 'truth_or_dare_18'
                ||  contentContainerArticle[i].children[2].textContent === 'truth_or_dare_extrem') {
                container.style.background = 'rgba(255, 0, 0, 0.4)';
            } else if (contentContainerArticle[i].children[2].textContent === 'crazy' || contentContainerArticle[i].children[2].textContent === 'crazy_alk'
                || contentContainerArticle[i].children[2].textContent === 'truth_or_dare_alk' || contentContainerArticle[i].children[2].textContent === 'truth_or_dare') {
                container.style.background = 'rgba(255, 255, 126, 0.4)';
            } else if (contentContainerArticle[i].children[2].textContent === 'common' || contentContainerArticle[ i].children[2].textContent === 'just_drinking' ) {
                container.style.background = 'lightblue';
            } else if (contentContainerArticle[i].children[2].textContent === 'activity' || contentContainerArticle[i].children[2].textContent === 'activity_18') {
                container.style.background = 'rgba(0, 255, 0, 0.4)';
            } else if (contentContainerArticle[i].children[2].textContent === 'storytime' || contentContainerArticle[i].children[2].textContent === 'storytime_18') {
                container.style.background = 'rgba(190, 144, 212, 0.4)';
            } else if (contentContainerArticle[i].children[2].textContent === 'i_never_have'|| contentContainerArticle[i].children[2].textContent === 'i_never_have_18') {
                container.style.background = 'rgba(245, 171, 53, 0.4)';
            }
        }
    }
    if( document.getElementById('datasheet__players') !== null) {
        let players = datasheetPlayers.split(', ');
        sessionStorage.players = players;
    }
}

/** get random Activity*/
function getRandomActivity() {
    let players = sessionStorage.players.toString().split(',');
    let randomPlayerNUmber = Math.floor(Math.random() * (players.length -1));
    let randomPlayer = '';
    let replacement = '';
    players.forEach((player, index, players) => {
        if(index === randomPlayerNUmber) {
            randomPlayer = players.filter(newPlayer => newPlayer === player);
        }
    });

    let currentActivityNumber = Math.floor(Math.random() * activity.length);
    activity.forEach((el, index) => {
        if(index === currentActivityNumber) {
            replacement = 'Aktivität: ' + el + ', Spieler: ' + randomPlayer;
        }
    })
    console.log(currentActivityNumber)
    return replacement;
}

if(setupBtn !== null ) {
    setupBtn.addEventListener('click', () => {
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

function setArticleIconEvents(articleIcons) {
    for(let i = 0; i < articleIcons.length; i++) {
        articleIcons[i].addEventListener('click', (ev) => {
            console.log(ev.target);
            // console.log(ev.target.value);
            if(ev.target.value == 'punishment-btn') {
                showPunishments();
            } else if (ev.target.value == 'game-descriptions-btn' ||
                ev.target.parentElement.value == 'game-descriptions-btn' ||
                ev.target.parentElement.parentElement.value == 'game-descriptions-btn' ) {
                showGameDescriptions();
            } else if (ev.target.value == 'rule-btn' ||
                ev.target.parentElement.value == 'rule-btn' ||
                ev.target.parentElement.parentElement.value == 'rule-btn'  ||
                ev.target.parentElement.parentElement.parentElement.value == 'rule-btn' ) {
                $('.setup__container:last-child').addClass('show-rules');
            } else if (ev.target.value == 're-new-btn' ||
                ev.target.parentElement.value == 're-new-btn' ||
                ev.target.parentElement.parentElement.value == 're-new-btn' ) {
                goBackToStart();
            }
        })
    }
}

function showPunishments() {
    console.log('showPunishments');
}

function showGameDescriptions() {
    console.log('showGameDescriptions');
}

function goBackToStart() {
    let ev = document.createEvent('MouseEvents');
    ev.initMouseEvent('click', true, true, window,
        0, 0, 0, 0, 0, false, false, false, false, 0, null);
    document.getElementById('reset-btn').dispatchEvent(ev);
}

/*let postIDs = [];
if(typeof(Storage) !== "undefined") {
    if(sessionStorage.currentPostID !== '') {
        postIDs = sessionStorage.currentPostID;
    } */