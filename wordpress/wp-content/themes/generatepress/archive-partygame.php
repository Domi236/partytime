<?php
/**
 * Template Name: Custom Party Game Template
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0
 */


/** Todos:
 * 1) virus erstelle neue Aufgabe wann virus endet
 * 2) zähl Karten mit, wenn Anzahl an Karten erreicht oder alle durch, dann end game, erstelle neustart BTN
 * 3) Accordion für Activity erstellen
 * 4) Stylen
 */

session_start();
get_header(); ?>

<div id="primary">
    <main id="main">
<!--        <h1 class="headline">Party Time</h1>-->
        <form id="destroy-session" class="form activate-first-challenge" action="<?php echo the_permalink ();?>" method="post">
            <button id="resetBtn" type="submit" name="reset">Reset</button>
        </form>

        <?php
        if(isset($_POST['reset'])) :
            session_unset();
            session_destroy();
        endif;
        ?>
        <?php
        $_SESSION['step'] = isset($_SESSION['step']) ? $_SESSION['step'] : 'setup';
        $_SESSION['displayForm'] = isset($_SESSION['displayForm']) ? $_SESSION['displayForm'] : true;

        //$current_url = home_url($_SERVER['REQUEST_URI']);

        $allPosts = [
            'Crazy' => 'crazy', 'Crazy (ALK)' => 'crazy_alk',
            'HOT' => 'perverse',  'HOT (ALK)' => 'perverse_alk',
            'HOT 18+' => 'perverse_18',  'HOT 18+ (ALK)' => 'perverse_18_alk',  'Seducation' => 'seduction',  'Seducation (ALK)' => 'seduction_alk',
            'Activity' => 'activity',  'Activity 18+' => 'activity_18',
            'Storytime' => 'storytime', 'Storytime 18+' => 'storytime_18',
            'I Never Have' => 'i_never_have', 'I Never Have 18+' => 'i_never_have_18',
            'Truth or Dare' => 'truth_or_dare',  'Truth or Dare (ALK)' => 'truth_or_dare_alk',  'Truth or Dare 16+' => 'truth_or_dare_16', 'Truth or Dare 18+' => 'truth_or_dare_18', 'Truth or Dare EXTREM' => 'truth_or_dare_extrem',
            'Just Drinking' => 'just_drinking'
        ];

        if(isset($_POST['setup']) && $_SESSION['step'] === 'setup') {
            $_SESSION['displayHeadline'] = false;
            $_SESSION['displayForm'] = false;
            $_SESSION['step'] = 'play';
            $hashUser = random_int(0, 999) . random_int(0, 999) . random_int(0, 999);
            $hashPassword = random_int(0, 999) . random_int(0, 999) . random_int(0, 999);

            if ($_POST['username'] !== $hashUser &&
                $_POST['password'] !== $hashPassword) {
                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = $hashUser;

                $_SESSION['numberOfPlayers'] = $_POST['numberOfPlayers'];

                if($_SESSION['numberOfPlayers'] > 3) {
                    $_SESSION['4player'] = '4player';
                } else {
                    $_SESSION['4player'] = false;
                }

                if($_SESSION['numberOfPlayers'] > 3 && $_SESSION['numberOfPlayers'] % 2 === 0) {
                    $_SESSION['paar'] = 'paar';
                } else {
                    $_SESSION['paar'] = false;
                }

                foreach($allPosts as $post) {
                    if(isset($_POST['val-' . $post])) {
                        $_SESSION[$post] = $post;
                    } else {
                        $_SESSION[$post] = false;
                    }
                }

                for($p = 0; $p < 11; $p++) :
                    $player = 'player' . $p;
                    if(isset($_POST[$player])){
                        $_SESSION[$player] = $_POST[$player];
                    }
                endfor;

                /*if(isset($_POST['old_enough'])) {
	                $_SESSION['old_enough'] = true;
                }*/
                //echo 'You have entered valid use name and password';
            } else {
                $msg = 'please try again';
                return;
            }
        }

        if ($_SESSION['step'] === 'setup' && $_SESSION['displayForm']):
            ?>
            <div class="setting__container">
                <form id="form-setup" class="form-signin" role="form"
                      action="<?php echo the_permalink ();?>" method="post">
                    <input type="hidden" class="form-control"
                           name="username" value="username"
                           required></br>
                    <input type="hidden" class="form-control"
                           name="password" value="password" required>

                    <div class="setup__wrapper">
                        <div class="setup__container">
                            <h3 class="subline">Spieleranzahl</h3>
                            <select id="player-number" name="numberOfPlayers">
                                <?php
                                for($j = 2; $j < 11; $j++) :
                                    echo ' <option value="' . $j . '">' . $j . ' Player</option>';
                                endfor;
                                ?>
                            </select>
                            <?php
                            for($i = 1; $i < 11; $i++) :
                                echo '<p class="player-names"><input type="text" name="player' . $i . '" placeholder="player' . $i . '" value="player' . $i . '"></p>';
                            endfor;
                            ?>
                        </div>
                        <div class="setup__container">
                            <h3 class="subline">Einstellungen</h3>
                            <div class="setup__setting-wrapper">
                                <div class="setup__setting-container">
                                    <div id="categorie-filter">
                                        <label class="categorie__filter"><input id="no-limit" type="checkbox" name="no-limit" value="no-limit">ALL (NO LIMIT)<br><b style="color: red">ODER</b></label>
                                        <label class="categorie__filter"><input type="range" id="alkohol-limit" name="alkohol-limit" step="20" min="0" max="80" value="40"><span id="alkohol-limit-value">SAUFEN!</span></label>
                                        <label class="categorie__filter"><input type="range" id="perversions-limit" name="perversions-limit" step="20" min="0" max="80" value="40"><span id="perversions-limit-value">HOT!</span></label>
                                        <label class="categorie__filter"><input id="parent-ct-crazy"  type="checkbox" name="parent-val-crazy" value="parent-val-crazy">Crazy</label>
                                        <label class="categorie__filter"><input id="parent-ct-activity"  type="checkbox" name="parent-val-activity" value="parent-val-activity">Activity</label>
                                        <label class="categorie__filter"><input id="parent-ct-storytime"  type="checkbox" name="parent-val-storytime" value="parent-val-storytime">Storytime</label>
                                        <label class="categorie__filter"><input id="parent-ct-i_never_have"  type="checkbox" name="parent-val-i_never_have" value="parent-val-i_never_have">Ich hab noch nie...</label>
                                        <label class="categorie__filter"><input id="parent-ct-truth_or_dare"  type="checkbox" name="parent-val-truth_or_dare" value="parent-val-truth_or_dare">Truth or Dare</label>

<!--                                        <label class="categorie__filter"><input id="old_enough" type="checkbox" name="old_enough" value="old_enough">18+</label>-->
<!--                                        <label class="categorie__filter"><input type="radio" name="filter" hidden value="all">All</label>-->
<!--                                        <label class="categorie__filter"><input type="radio" name="filter" hidden value="random">Random</label>-->
<!--										<label class="categorie__filter"><input type="radio" name="filter" hidden value="only_alk">Only Alk</label>-->
<!--                                        <label class="categorie__filter"><input type="radio" name="filter" hidden value="without_alk">Without Alk</label>-->
<!--                                        <label class="categorie__filter"><input type="radio" name="filter" hidden value="deep_talk">Deep Talk</label>-->
<!--                                        <label class="categorie__filter"><input type="radio" name="filter" hidden value="hot">Hot</label>-->
<!--                                        <label class="categorie__filter"><input type="radio" name="filter" hidden value="games">Games</label>-->
                                    </div>
                                </div>
                                <div class="categorie__wrapper">
		                            <?php foreach($allPosts as $key => $post) {
			                            echo  '
                                        <div class="categorie__container">
                                            <label for="ct-' . $post . '" class="container" hidden>' . $key . '
                                                <input id="ct-' . $post . '"  type="checkbox" class="categorie-tags" name="val-' . $post . '" value="' . $post . '">
                                                <span class="checkmark"></span>
                                            </label>
                                           <!-- <div class="categorie__description">' . $post . '</div> -->
                                        </div>
                                    ';
		                            } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="setup-btn" class="btn btn-lg btn-primary btn-block" type="submit" name="setup">Start Game</button>
                </form>
            </div>
        <?php
        endif;

        if ( $_SESSION['step'] === 'play'):
            $genre = [];
            foreach($allPosts as $post) {
                if($_SESSION[$post] !== false) {
                    $genre[] = $_SESSION[$post];
                }
            }

            $args  = array(
                'posts_per_page'    => -1,
                'orderby'           => 'rand',
                'post_type'         => $genre,
                'post_status'       => 'publish',
                'suppress_filters'  => true,
            );

            $posts = get_posts($args);

            foreach ($posts as $post) :
                echo '<div class="content__container-article">';
                    echo '<span class="current-id">' . get_the_ID() . '</span>';
                    the_post();
                    echo '<span class="categorie">' . $post->post_type . '</span>';
                    the_title( '<h1 class="headline__challenges">', '</h1>' );
                    the_content();
                echo '</div>';
            endforeach;
            echo '<button id="continue" class="btn btn-lg btn-primary btn-block" type="button" name="continue">Continue</button>';
            ?>
            <div id="datasheet">
                <p id="datasheet__players">
                    <?php
                    for($p = 0; $p < 11; $p++) :
                        $player = 'player' . $p;
                        if(!empty($_SESSION[$player])){
                            if($p === 10) {
                                echo $_SESSION[$player];
                            } else {
                                echo $_SESSION[$player] . ', ';
                            }
                        }
                    endfor;
                    ?>
                </p>
                <p id="datasheet__numberOfPlayers">
                    <?php echo $_SESSION['numberOfPlayers']; ?>
                </p>
                <p id="datasheet__tags">
                    <?php echo implode(", ", $genre); ?>
                </p>
                <p id="datasheet__schlagwörter">
                    <?php
                    echo $_SESSION['4player'] . ', ' . $_SESSION['paar'];
                    ?>
                </p>
                <!--<p id="datasheet__old-enough">
                    <?php
                    //echo $_SESSION['old_enough'];
                    ?>
                </p>-->
            </div>
        <?php

        endif;

        /*$is_page_refreshed = (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0');

        if($is_page_refreshed ) {
            echo 'This Page Is refreshed.';
        } else {
            echo 'This page is freshly visited. Not refreshed.';
        }*/

//        echo '<pre>';
        //var_dump($allPosts);
//        print_r($_SESSION);
        //var_dump(get_children());
//        echo '</pre>';
        ?>
    </main>
</div>

<script>

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
    const headlineChallenges = document.getElementsByClassName('headline__challenges');
    const container = document.getElementById('main');
    const oldEnoughCheck = document.getElementById('perversions-limit');
    const oldEnoughCheckValue = document.getElementById('perversions-limit-value');
    const alkLimitCheck = document.getElementById('alkohol-limit');
    const alkLimitCheckValue = document.getElementById('alkohol-limit-value');

    const activity = ['Pantomime', 'Erklären', 'Zeichnen'];

    /**datasheet*/
    if( document.getElementById('datasheet__players') !== null) {
        var datasheetPlayers = document.getElementById('datasheet__players').textContent;
        var datasheetNumberOfPlayers = document.getElementById('datasheet__numberOfPlayers').textContent;
        var datasheetTags = document.getElementById('datasheet__tags').textContent;
        var datasheetSchlagwörter = document.getElementById('datasheet__schlagwörter').textContent;
        //var datasheetOldEnough = document.getElementById('datasheet__old-enough').textContent;
    }

    function checkHOTorNOT(limit) {
      if ( limit == 0 )  {
        oldEnoughCheckValue.innerHTML = 'NEIN!';
      } else if ( limit == 20 )  {
        oldEnoughCheckValue.innerHTML = 'HAVE FUN!';
      } else if (limit == 40 )  {
        oldEnoughCheckValue.innerHTML = 'HOT!';
      } else if (limit == 60 )  {
        oldEnoughCheckValue.innerHTML = 'GET NACKED!';
      } else if ( limit == 80 )  {
        oldEnoughCheckValue.innerHTML = 'FUCK ME!';
      }

      if(limit > 20) {
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
    }

    function checkALKorNOT(limit) {
      if ( limit == 0 )  {
        alkLimitCheckValue.innerHTML = 'NEIN!';
      } else if ( limit == 20 )  {
        alkLimitCheckValue.innerHTML = 'VORGLÜHEN!';
      } else if ( limit == 40 )  {
        alkLimitCheckValue.innerHTML = 'SAUFEN!';
      } else if ( limit == 60 )  {
        alkLimitCheckValue.innerHTML = 'GET DRUNK!';
      } else if ( limit == 80 )  {
        alkLimitCheckValue.innerHTML = 'KAMPFTRINKEN!';
      }

      limit > 0 ? document.getElementById('ct-just_drinking').checked = true : document.getElementById('ct-just_drinking').checked = false;

      if(limit > 0 && oldEnoughCheck.value > 20) {
        document.getElementById('ct-perverse_alk').checked = true;
        document.getElementById('ct-seduction_alk').checked = true;
      } else {
        document.getElementById('ct-perverse_alk').checked = false;
        document.getElementById('ct-seduction_alk').checked = false;
      }

      limit > 0 && oldEnoughCheck.value > 40 ? document.getElementById('ct-perverse_18_alk').checked = true : document.getElementById('ct-perverse_18_alk').checked = false;
      sessionStorage.alkLimit = limit;
    }

    jQuery(document).ready(function($) {
      const categories = document.getElementsByClassName('categorie__filter');
      const categorieTags = document.getElementsByClassName( 'categorie-tags' );

      if(alkLimitCheck !== null) {
        let limit = alkLimitCheck.value;
        checkHOTorNOT(limit);
        limit = oldEnoughCheck.value;
        checkALKorNOT(limit);
      }

        if(continueBtn !== null && window.location.href.includes( 'partygame' )) {
            $('.headline').css('display', 'none');
            $('#site-navigation').css('display', 'none');
            $('#masthead').css('display', 'none');
            $('#resetBtn').css({'position': 'fixed','top': '0', 'right': '0' });
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

        /**category filter*/
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
                    contentContainerArticle[i].children[5].style.display = 'none';
                    contentContainerArticle[i].children[4].style.display = 'block';
                  })
                }

                let dare = contentContainerArticle[i].getElementsByClassName('dare');
                for(let y = 0; y < dare.length; y++) {
                  dare[y].addEventListener('click', () => {
                    contentContainerArticle[i].children[4].style.display = 'none';
                    contentContainerArticle[i].children[5].style.display = 'block';
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

                if(contentContainerArticle[i].children[1].textContent === 'perverse' || contentContainerArticle[i].children[1].textContent === 'perverse_alk'
                || contentContainerArticle[i].children[1].textContent === 'perverse_18' || contentContainerArticle[i].children[1].textContent === 'perverse_18_alk'
                ||  contentContainerArticle[i].children[1].textContent === 'seduction'||  contentContainerArticle[i].children[1].textContent === 'seduction_alk') {
                    container.style.background = 'rgba(255, 0, 0, 0.4)';
                } else if (contentContainerArticle[i].children[1].textContent === 'crazy' || contentContainerArticle[i].children[1].textContent === 'crazy_alk'
                || contentContainerArticle[i].children[1].textContent === 'truth_or_dare_alk' || contentContainerArticle[i].children[1].textContent === 'truth_or_dare'
                || contentContainerArticle[i].children[1].textContent === 'truth_or_dare_18') {
                    container.style.background = 'rgba(255, 255, 126, 0.4)';
                } else if (contentContainerArticle[i].children[1].textContent === 'common' || contentContainerArticle[ i].children[1].textContent === 'just_drinking' ) {
                    container.style.background = 'lightblue';
                } else if (contentContainerArticle[i].children[1].textContent === 'activity' || contentContainerArticle[i].children[1].textContent === 'activity_18') {
                    container.style.background = 'rgba(0, 255, 0, 0.4)';
                } else if (contentContainerArticle[i].children[1].textContent === 'storytime') {
                    container.style.background = 'rgba(190, 144, 212, 0.4)';
                } else if (contentContainerArticle[i].children[1].textContent === 'i_never_have') {
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


    /*let postIDs = [];
    if(typeof(Storage) !== "undefined") {
        if(sessionStorage.currentPostID !== '') {
            postIDs = sessionStorage.currentPostID;
        } */

</script>

<!---->
<!--if ( ev.target.value === 'random' ) {-->
<!--//getRandomCategories(categorieTags, categoryArray);-->
<!--}-->
<!--else if ( ev.target.value === 'all' ) {-->
<!--checkChoosenCategories( categorieTags, categoryArray );-->
<!--}-->
<!--else {-->
<!--if ( ev.target.value === 'only_alk' ) {-->
<!--categoryArray = [-->
<!--'crazy_alk',-->
<!--'i_never_have',-->
<!--'truth_or_dare_alk',-->
<!--'perverse_alk',-->
<!--'just_drinking',-->
<!--'seduction_alk']-->
<!--if ( sessionStorage.oldEnough ) {-->
<!--let newContent = ['perverse_18_alk'];-->
<!--for ( let i = 0; i < newContent.length; i++ ) {-->
<!--categoryArray.push( newContent[i] );-->
<!--}-->
<!--}-->
<!--checkChoosenCategories( categorieTags, categoryArray );-->
<!--}-->
<!--else if ( ev.target.value === 'without_alk' ) {-->
<!--categoryArray = ['crazy', 'activity', 'storytime', 'i_never_have', 'truth_or_dare'];-->
<!--if ( sessionStorage.oldEnough ) {-->
<!--let newContent = ['perverse_18', 'activity_18', 'truth_or_dare_18'];-->
<!--for ( let i = 0; i < newContent.length; i++ ) {-->
<!--categoryArray.push( newContent[i] );-->
<!--}-->
<!--}-->
<!--checkChoosenCategories( categorieTags, categoryArray );-->
<!--}-->
<!--else if ( ev.target.value === 'deep_talk' ) {-->
<!--categoryArray = ['storytime', 'i_never_have'];-->
<!--checkChoosenCategories( categorieTags, categoryArray );-->
<!---->
<!--}-->
<!--else if ( ev.target.value === 'hot' ) {-->
<!--let categoryArray = ['perverse', 'perverse_alk', 'seduction', 'seduction_alk']-->
<!--if ( sessionStorage.oldEnough ) {-->
<!--let newContent = ['perverse_18', 'perverse_18_alk', 'activity_18', 'truth_or_dare_18'];-->
<!--for ( let i = 0; i < newContent.length; i++ ) {-->
<!--categoryArray.push( newContent[i] );-->
<!--}-->
<!--}-->
<!--checkChoosenCategories( categorieTags, categoryArray );-->
<!--}-->
<!--else if ( ev.target.value === 'games' ) {-->
<!--let categoryArray = ['storytime', 'i_never_have', 'activity', 'truth_or_dare', 'truth_or_dare_alk']-->
<!--if ( sessionStorage.oldEnough ) {-->
<!--let newContent = ['activity_18', 'truth_or_dare_18'];-->
<!--for ( let i = 0; i < newContent.length; i++ ) {-->
<!--categoryArray.push( newContent[i] );-->
<!--}-->
<!--}-->
<!--checkChoosenCategories( categorieTags, categoryArray );-->
<!--}-->
<!--}-->