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
 * 1) virus/repeater erstelle neue Aufgabe wann virus endet
 * 2) zähl Karten mit, wenn Anzahl an Karten erreicht oder alle durch, dann end game, erstelle neustart BTN
 * 3) Accordion für Activity erstellen
 */

session_start();
get_header(); ?>

<div id="primary">
    <main id="main">
<!--        <h1 class="headline">Party Time</h1>-->
        <form id="destroy-session" class="form activate-first-challenge" action="<?php echo the_permalink ();?>" method="post">
            <button id="resetBtn" type="submit" name="reset">Einstellungen Zurücksetzen</button>
        </form>
        <div class="setup-icon__container">
            <button id="rule-btn" class="rule-btn" type="button" value="rule-btn">
                <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24"><g><rect fill="none" height="24" width="24"/></g><g><g/><g>
                            <path d="M21,5c-1.11-0.35-2.33-0.5-3.5-0.5c-1.95,0-4.05,0.4-5.5,1.5c-1.45-1.1-3.55-1.5-5.5-1.5S2.45,4.9,1,6v14.65 c0,0.25,0.25,0.5,0.5,0.5c0.1,0,0.15-0.05,0.25-0.05C3.1,20.45,5.05,20,6.5,20c1.95,0,4.05,0.4,5.5,1.5c1.35-0.85,3.8-1.5,5.5-1.5 c1.65,0,3.35,0.3,4.75,1.05c0.1,0.05,0.15,0.05,0.25,0.05c0.25,0,0.5-0.25,0.5-0.5V6C22.4,5.55,21.75,5.25,21,5z M21,18.5 c-1.1-0.35-2.3-0.5-3.5-0.5c-1.7,0-4.15,0.65-5.5,1.5V8c1.35-0.85,3.8-1.5,5.5-1.5c1.2,0,2.4,0.15,3.5,0.5V18.5z"/><g><path d="M17.5,10.5c0.88,0,1.73,0.09,2.5,0.26V9.24C19.21,9.09,18.36,9,17.5,9c-1.7,0-3.24,0.29-4.5,0.83v1.66 C14.13,10.85,15.7,10.5,17.5,10.5z"/><path d="M13,12.49v1.66c1.13-0.64,2.7-0.99,4.5-0.99c0.88,0,1.73,0.09,2.5,0.26V11.9c-0.79-0.15-1.64-0.24-2.5-0.24 C15.8,11.66,14.26,11.96,13,12.49z"/><path d="M17.5,14.33c-1.7,0-3.24,0.29-4.5,0.83v1.66c1.13-0.64,2.7-0.99,4.5-0.99c0.88,0,1.73,0.09,2.5,0.26v-1.52 C19.21,14.41,18.36,14.33,17.5,14.33z"/></g></g></g>
                </svg>
            </button>
            <form action="" method="post">
                <button class="re-new-btn" type="submit" name="reset" value="re-new-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <path d="M12 6v3l4-4-4-4v3c-4.42 0-8 3.58-8 8 0 1.57.46 3.03 1.24 4.26L6.7 14.8c-.45-.83-.7-1.79-.7-2.8 0-3.31 2.69-6 6-6zm6.76 1.74L17.3 9.2c.44.84.7 1.79.7 2.8 0 3.31-2.69 6-6 6v-3l-4 4 4 4v-3c4.42 0 8-3.58 8-8 0-1.57-.46-3.03-1.24-4.26z"/><path d="M0 0h24v24H0z" fill="none"/>
                    </svg>
                </button>
            </form>
        </div>

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

        $punishments = [
            'Die anderen Spieler überlegen sich eine wenn möglich unangenhme Frage für dich.',
            'Die anderen Spieler überlegen sich eine Pflichtaufgabe für dich.',
            'Das nächste mal wenn ein Spieler aufgefordert wird etwas zu tun oder auf eine Frage zu antworten, musst du stattdessen für ihn übernehmen.',
            'Du erhältst keine Strafe.'
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

	            if (isset($_POST['punishments-perverse'])) {
		            $_SESSION['punishments-perverse'] = 'Zieh dir ein Kleidungstück aus.';
		            array_push($punishments, $_SESSION['punishments-perverse']);
	            }

	            if (isset($_POST['punishments-drink-max'])) {
		            $_SESSION['punishments-drink-max'] = 'Trinke dein Glas leer.';
		            array_push($punishments, $_SESSION['punishments-drink-max']);
	            }

	            if (isset($_POST['punishments-drink-value']) && $_POST['punishments-drink-value'] > 0 ) {
		            $_SESSION['punishments-drink-value'] = 'Trinke ' . $_POST['punishments-drink-value'] . ' Schlücke.';
		            array_push($punishments, $_SESSION['punishments-drink-value']);
                } else {
		            $_SESSION['punishments-drink-value'] = false;
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

	            $_SESSION['punishments'] = $punishments;
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
                                echo '<p class="player-names"><input type="text" name="player' . $i . '" placeholder="Player' . $i . '"></p>';
                            endfor;
                            ?>
                        </div>
                        <div class="setup__container">
                            <h3 class="subline">Einstellungen</h3>
                            <div class="setup__setting-wrapper">
                                <div class="setup__setting-container">
                                    <div id="categorie-filter">
                                        <label class="categorie__filter"><input id="no-limit" type="checkbox" name="no-limit" value="no-limit">ALL (NO LIMIT)<br><b style="color: red">ODER</b></label>
                                        <label class="categorie__filter"><input type="range" id="alkohol-limit" name="alkohol-limit" step="20" min="0" max="80" value="40"><span class="range-text__container"><span id="alkohol-limit-value">SAUFEN!</span></span></label>
                                        <label class="categorie__filter"><input type="range" id="perversions-limit" name="perversions-limit" step="20" min="0" max="80" value="40"><span class="range-text__container"><span id="perversions-limit-value">HOT!</span></span></label>
                                        <label class="categorie__filter"><input id="parent-ct-crazy"  type="checkbox" name="parent-val-crazy" value="parent-val-crazy">Crazy</label>
                                        <label class="categorie__filter"><input id="parent-ct-activity"  type="checkbox" name="parent-val-activity" value="parent-val-activity">Activity</label>
                                        <label class="categorie__filter"><input id="parent-ct-storytime"  type="checkbox" name="parent-val-storytime" value="parent-val-storytime">Storytime</label>
                                        <label class="categorie__filter"><input id="parent-ct-i_never_have"  type="checkbox" name="parent-val-i_never_have" value="parent-val-i_never_have">Ich hab noch nie...</label>
                                        <label class="categorie__filter"><input id="parent-ct-truth_or_dare"  type="checkbox" name="parent-val-truth_or_dare" value="parent-val-truth_or_dare">Truth or Dare</label>
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
                        <div id="setup__container--rules-out-of-game" class="setup__container">
                            <h3 class="subline">Grundregeln</h3>
                            <div class="setup__setting-wrapper">
                                <div class="setup__setting-container">
                                    <p class="punishments__intro-text">Wenn sich ein Spieler weigert eine Aufgabe zu erfüllen oder eine Frage zu beantworten, tritt per Zufallsprinzip einer der folgenden Strafen in Kraft:</p>
                                    <ul class="punishments__container">
                                        <li id="punishments-perverse" class="punishments">Zieh dir ein Kleidungstück aus.
                                            <input id="punishments-perverse-check" type="checkbox" name="punishments-perverse" value="punishments-perverse" hidden checked>
                                        </li>
                                        <li id="punishments-drink" class="punishments">Trinke <span id="punishments-drink-value">2</span> Schlücke.
                                            <input id="punishments-drink-value-check" name="punishments-drink-value" value="2" hidden>
                                        </li>
                                        <li id="punishments-drink-max" class="punishments">Trinke dein Glas leer.
                                            <input id="punishments-drink-max-check" type="checkbox" name="punishments-drink-max" value="punishments-drink-max" hidden checked>
                                        </li>
                                        <li class="punishments">Die anderen Spieler überlegen sich eine wenn möglich unangenhme Frage für dich.</li>
                                        <li class="punishments">Die anderen Spieler überlegen sich eine Pflichtaufgabe für dich.</li>
                                        <li class="punishments">Das nächste mal wenn ein Spieler aufgefordert wird etwas zu tun oder auf eine Frage zu antworten, musst du stattdessen für ihn übernehmen.</li>
                                        <li class="punishments">Du erhältst keine Strafe.</li>
                                    </ul>
                                </div>
                            </div>
                            <button id="close-rules" type="button">OK</button>
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

//            var_dump($genre);

	        $args  = array(
		        'posts_per_page'    => -1,
		        'orderby'           => 'rand',
		        'post_type'         => $genre,
		        'post_status'       => 'publish',
		        'suppress_filters'  => true,
	        );
	        $postTypes = get_posts($args);

	        $crazy = 0;
	        $perverse = 0;
	        $activity = 0;
	        $storytime = 0;
	        $i_never_have = 0;
	        $truth_or_dare = 0;
	        $just_drinking = 0;

	        foreach ($postTypes as $postType) :
		        if($postType->post_type == 'crazy' || $postType->post_type == 'crazy_alk') {
			        $crazy++;
                } elseif ($postType->post_type == 'perverse' || $postType->post_type == 'perverse_alk' || $postType->post_type == 'perverse_18' ||
                    $postType->post_type == 'perverse_18_alk' || $postType->post_type == 'seduction' ||  $postType->post_type == 'seduction_alk') {
			        $perverse++;
                } elseif ($postType->post_type == 'activity' || $postType->post_type == 'activity_18') {
			        $activity++;
		        } elseif ($postType->post_type == 'storytime' || $postType->post_type == 'storytime_18') {
			        $storytime++;
		        } elseif ($postType->post_type == 'i_never_have' || $postType->post_type == 'i_never_have_18') {
			        $i_never_have++;
		        } elseif ($postType->post_type == 'truth_or_dare' || $postType->post_type == 'truth_or_dare_alk' ||
                    $postType->post_type == 'truth_or_dare_16' || $postType->post_type == 'truth_or_dare_18' || $postType->post_type == 'truth_or_dare_extrem') {
			        $truth_or_dare++;
		        } elseif ($postType->post_type == 'just_drinking') {
			        $just_drinking++;
		        }
	        endforeach;

	        echo $crazy . '$crazy<br>';
	        echo $perverse . '$perverse<br>';
	        echo $activity . '$activity<br>';
	        echo $storytime . '$storytime<br>';
	        echo $i_never_have . '$i_never_have<br>';
	        echo $truth_or_dare . '$truth_or_dare<br>';
	        echo $just_drinking . '$just_drinking<br>';

            $postNumber = [];

	        if($crazy < 30 && $crazy > 0) {
		        $crazy = 20;
		        array_push($postNumber, $crazy);
	        } else if ($crazy >= 30) {
		        $crazy = 30;
		        array_push($postNumber, $crazy);
	        }
	        if($perverse < 40 && $perverse > 0) {
		        $perverse = 30;
		        array_push($postNumber, $perverse);
	        } else if ($perverse >= 40) {
		        $perverse = 40;
		        array_push($postNumber, $perverse);
	        }
	        if($activity < 30 && $activity > 0) {
		        $activity = 20;
		        array_push($postNumber, $activity);
	        } else if ($activity >= 30) {
		        $activity = 30;
		        array_push($postNumber, $activity);
	        }
	        if($storytime < 30 && $storytime > 0) {
		        $storytime = 20;
		        array_push($postNumber, $storytime);
	        } else if ($storytime >= 30) {
		        $storytime = 30;
		        array_push($postNumber, $storytime);
	        }
	        if($i_never_have < 30 && $i_never_have > 0) {
		        $i_never_have = 20;
		        array_push($postNumber, $i_never_have);
	        } else if ($i_never_have >= 30) {
		        $i_never_have = 30;
		        array_push($postNumber, $i_never_have);
	        }
	        if($truth_or_dare < 40 && $truth_or_dare > 0) {
		        $truth_or_dare = 30;
		        array_push($postNumber, $truth_or_dare);
	        } else if ($truth_or_dare >= 40) {
	            $truth_or_dare = 40;
		        array_push($postNumber, $truth_or_dare);
	        }
	        if($just_drinking < 30 && $just_drinking > 0) {
		        $just_drinking = 20;
		        array_push($postNumber, $just_drinking);
	        } else if ($just_drinking >= 30) {
		        $just_drinking = 30;
		        array_push($postNumber, $just_drinking);
	        }
//
//            echo '<pre>';
////            var_dump($genre);
//            echo '</pre>';

	        $sum = 0;
	        $count = 0;
	        foreach ($postNumber as $val) {
		        if (is_int($val)) {
			        $sum += $val;
			        $count++;
		        }
	        }
	        $avgPostNumber = ($count>0 ? $sum/$count : 0);

//	        $args  = array(
//		        'posts_per_page'    => ($avgPostNumber * count($genre)),
//		        'orderby'           => 'rand',
//		        'post_type'         => $genre,
//		        'post_status'       => 'publish',
//		        'suppress_filters'  => true,
//	        );
//	        $posts = get_posts($args);

	        $posts = [];
            foreach ($genre as $postType) :
                $args = array(
                    'posts_per_page'    => $avgPostNumber,
                    'orderby'           => 'rand',
                    'post_type'         => $postType,
                    'post_status'       => 'publish',
                    'suppress_filters'  => true,
                );
	            $newPosts = get_posts($args);
                foreach ($newPosts as $newPost) :
	                array_push($posts, $newPost);
                endforeach;
            endforeach;

//            echo '<pre>';
//            var_dump($posts);
//            echo '</pre>';
	        shuffle($posts);

            foreach ($posts as $post) :
                echo '<div class="content__container-article">';
                echo '<div class="icon__container">
                          <button class="punishment-btn article-icons" type="button" value="punishment-btn">§</button>
                          <button class="game-descriptions-btn article-icons" type="button" value="game-descriptions-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                <path d="M0 0h24v24H0z" fill="none"/><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                            </svg>
                          </button>
                          <button class="rule-btn article-icons" type="button" value="rule-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24"><g><rect fill="none" height="24" width="24"/></g><g><g/><g>
                                <path d="M21,5c-1.11-0.35-2.33-0.5-3.5-0.5c-1.95,0-4.05,0.4-5.5,1.5c-1.45-1.1-3.55-1.5-5.5-1.5S2.45,4.9,1,6v14.65 c0,0.25,0.25,0.5,0.5,0.5c0.1,0,0.15-0.05,0.25-0.05C3.1,20.45,5.05,20,6.5,20c1.95,0,4.05,0.4,5.5,1.5c1.35-0.85,3.8-1.5,5.5-1.5 c1.65,0,3.35,0.3,4.75,1.05c0.1,0.05,0.15,0.05,0.25,0.05c0.25,0,0.5-0.25,0.5-0.5V6C22.4,5.55,21.75,5.25,21,5z M21,18.5 c-1.1-0.35-2.3-0.5-3.5-0.5c-1.7,0-4.15,0.65-5.5,1.5V8c1.35-0.85,3.8-1.5,5.5-1.5c1.2,0,2.4,0.15,3.5,0.5V18.5z"/><g><path d="M17.5,10.5c0.88,0,1.73,0.09,2.5,0.26V9.24C19.21,9.09,18.36,9,17.5,9c-1.7,0-3.24,0.29-4.5,0.83v1.66 C14.13,10.85,15.7,10.5,17.5,10.5z"/><path d="M13,12.49v1.66c1.13-0.64,2.7-0.99,4.5-0.99c0.88,0,1.73,0.09,2.5,0.26V11.9c-0.79-0.15-1.64-0.24-2.5-0.24 C15.8,11.66,14.26,11.96,13,12.49z"/><path d="M17.5,14.33c-1.7,0-3.24,0.29-4.5,0.83v1.66c1.13-0.64,2.7-0.99,4.5-0.99c0.88,0,1.73,0.09,2.5,0.26v-1.52 C19.21,14.41,18.36,14.33,17.5,14.33z"/></g></g></g>
                            </svg>
                          </button>
                          <form action="" method="post">
                                <button class="re-new-btn article-icons" type="submit" name="reset" value="re-new-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                        <path d="M12 6v3l4-4-4-4v3c-4.42 0-8 3.58-8 8 0 1.57.46 3.03 1.24 4.26L6.7 14.8c-.45-.83-.7-1.79-.7-2.8 0-3.31 2.69-6 6-6zm6.76 1.74L17.3 9.2c.44.84.7 1.79.7 2.8 0 3.31-2.69 6-6 6v-3l-4 4 4 4v-3c4.42 0 8-3.58 8-8 0-1.57-.46-3.03-1.24-4.26z"/><path d="M0 0h24v24H0z" fill="none"/>
                                    </svg>
                                </button>
                          </form>
                      </div>';
                echo '<span class="current-id">' . get_the_ID() . '</span>';
                the_post();
                echo '<span class="categorie">' . $post->post_type . '</span>';
                the_title( '<h1 class="headline__challenges">', '</h1>' );
                the_content();
                echo '</div>';
            endforeach;
            echo '<button id="continue" class="btn btn-lg btn-primary btn-block" type="button" name="continue">Continue</button>';
            ?>

            <div id="setup__container--rules" class="setup__container">
                <h3 class="subline">Grundregeln</h3>
                <div class="setup__setting-wrapper">
                    <div class="setup__setting-container">
                        <p class="punishments__intro-text">Wenn sich ein Spieler weigert eine Aufgabe zu erfüllen oder eine Frage zu beantworten, tritt per Zufallsprinzip einer der folgenden Strafen in Kraft:</p>
                        <ul class="punishments__container">
	                        <?php
                            if(isset($_SESSION['punishments-perverse'])) {
		                        echo '<li id="punishments-perverse" class="punishments">'. $_SESSION["punishments-perverse"] .'</li>';
	                        }
	                        if($_SESSION['punishments-drink-value'] !== false) {
		                        echo '<li id="punishments-drink" class="punishments">' . $_SESSION["punishments-drink-value"] .'</li>';
	                        }
	                        if(isset($_SESSION['punishments-drink-max'])) {
		                        echo '<li id="punishments-drink-max" class="punishments">Trinke dein Glas leer.</li>';
	                        } ?>
                            <li class="punishments">Die anderen Spieler überlegen sich eine wenn möglich unangenhme Frage für dich.</li>
                            <li class="punishments">Die anderen Spieler überlegen sich eine Pflichtaufgabe für dich.</li>
                            <li class="punishments">Das nächste mal wenn ein Spieler aufgefordert wird etwas zu tun oder auf eine Frage zu antworten, musst du stattdessen für ihn übernehmen.</li>
                            <li class="punishments">Du erhältst keine Strafe.</li>
                        </ul>
                    </div>
                </div>
                <button id="close-rules" type="button">OK</button>
            </div>
            <div id="display-punishment__container">
                <h3 class="subline">Strafe</h3>
                <div id="display-punishment">
                    <!--random punishment-->
                </div>
                <button id="close-punishment" type="button">OK</button>
            </div>
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
                <p id="datasheet__punishments">
		            <?php
		            for($i = 0; $i < count($_SESSION['punishments']); $i++) :
                        if($i === count($_SESSION['punishments']) -1) {
                            echo $_SESSION['punishments'][$i];
                        } else {
                            echo $_SESSION['punishments'][$i] . '| ';
                        }
		            endfor;
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
        const setupContainer = document.getElementsByClassName('setup__container');
        for(let i = 0; i < playerNames.length; i++) {
            if(i >= counter) {
                playerNames[i].style.display = 'none';
            } else {
                playerNames[i].style.display = 'block';
                let player = 'Player' + (i+1);
                playerNames[i].children[0].setAttribute('value', player);
            }
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
        var datasheetPunishments = document.getElementById('datasheet__punishments').textContent;
    }

    /** check perserve limit*/
    function checkHOTorNOT(limit) {
      const punishmentsPerverse = document.getElementById('punishments-perverse');
      const punishmentsPerverseCheck = document.getElementById('punishments-perverse');

      if ( limit == 0 )  {
        oldEnoughCheckValue.innerHTML = 'NEIN!';
        punishmentsPerverse.style.display = 'none';
        punishmentsPerverseCheck.checked = false;
      } else if ( limit == 20 )  {
        oldEnoughCheckValue.innerHTML = 'HAVE FUN!';
        punishmentsPerverseCheck.checked = false;
        punishmentsPerverse.style.display = 'none';
      } else if (limit == 40 )  {
        oldEnoughCheckValue.innerHTML = 'HOT!';
        punishmentsPerverseCheck.checked = true;
      } else if (limit == 60 )  {
        oldEnoughCheckValue.innerHTML = 'GET NACKED!';
        punishmentsPerverseCheck.checked = true;
      } else if ( limit == 80 )  {
        oldEnoughCheckValue.innerHTML = 'FUCK ME!';
        punishmentsPerverseCheck.checked = true;
      }

      if(limit > 20) {
        punishmentsPerverse.style.display = 'list-item';
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

    /** check alk limit*/
    function checkALKorNOT(limit) {
      const punishmentsDrinkMaxCheck = document.getElementById('punishments-drink-max-check');
      const punishmentsDrinkValue = document.getElementById('punishments-drink-value');
      const punishmentsDrink = document.getElementById('punishments-drink');
      const punishmentsDrinkMax = document.getElementById('punishments-drink-max');
      const punishmentsDrinkValueCheck = document.getElementById('punishments-drink-value-check');

      if ( limit == 0 )  {
        alkLimitCheckValue.innerHTML = 'NEIN!';
        punishmentsDrinkMaxCheck.checked = false;
        punishmentsDrinkValue.innerHTML = '0';
        punishmentsDrink.style.display = 'none';
        punishmentsDrinkMax.style.display = 'none';
        punishmentsDrinkValueCheck.value = punishmentsDrinkValue.textContent;

      } else if ( limit == 20 )  {
        alkLimitCheckValue.innerHTML = 'VORGLÜHEN!';
        punishmentsDrinkMaxCheck.checked = false;
        punishmentsDrinkValue.innerHTML = '1';
        punishmentsDrinkMax.style.display = 'none';
        punishmentsDrinkValueCheck.value = punishmentsDrinkValue.textContent;
      } else if ( limit == 40 )  {
        alkLimitCheckValue.innerHTML = 'SAUFEN!';
        punishmentsDrinkMaxCheck.checked = false;
        punishmentsDrinkValue.innerHTML = '2';
        punishmentsDrinkMax.style.display = 'none';
        punishmentsDrinkValueCheck.value = punishmentsDrinkValue.textContent;
      } else if ( limit == 60 )  {
        alkLimitCheckValue.innerHTML = 'GET DRUNK!';
        punishmentsDrinkMaxCheck.checked = true;
        punishmentsDrinkValue.innerHTML = '3';
        punishmentsDrinkMax.style.display = 'list-item';
        punishmentsDrinkValueCheck.value = punishmentsDrinkValue.textContent;
      } else if ( limit == 80 )  {
        alkLimitCheckValue.innerHTML = 'KAMPFTRINKEN!';
        punishmentsDrinkMaxCheck.checked = true;
        punishmentsDrinkValue.innerHTML = '4';
        punishmentsDrinkMax.style.display = 'list-item';
        punishmentsDrinkValueCheck.value = punishmentsDrinkValue.textContent;
      }

      if(limit > 0) {
        punishmentsDrink.style.display = 'list-item';
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
    }

    jQuery(document).ready(function($) {
      const categories = document.getElementsByClassName('categorie__filter');
      const categorieTags = document.getElementsByClassName( 'categorie-tags' );
      let setupContainerRules = document.getElementById('setup__container--rules');
      let setupContainerRulesOutofGame = document.getElementById('setup__container--rules-out-of-game');
      const closeRulesInGame = document.getElementById('close-rules');

      if(document.getElementById('datasheet__punishments')) {
        var datasheetPunishments = document.getElementById('datasheet__punishments').textContent;
      }
      let displayPunishmentContainer = document.getElementById('display-punishment__container');
      let displayPunishment = document.getElementById('display-punishment');


      let showRules = false;
      if(document.getElementById('rule-btn') !== null) {
        if(setupContainerRules == null) {
          setupContainerRules = setupContainerRulesOutofGame;
        }
        document.getElementById('rule-btn').addEventListener('click', () => {
          displayRules(showRules, setupContainerRules, closeRulesInGame)
        });
      }

      if(alkLimitCheck !== null) {
        let punishments = ['Die anderen Spieler überlegen sich eine wenn möglich unangenhme Frage für dich!',
          'Die anderen Spieler überlegen sich eine Pflichtaufgabe für dich!', 'Das nächste mal wenn ein Spieler aufgefordert wird etwas zu tun ' +
          'oder auf eine Frage zu antworten, musst du stattdessen für ihn übernehmen!', 'Du erhältst keine Strafe!' ];
        let limit = alkLimitCheck.value;
        checkHOTorNOT(limit);
        limit = oldEnoughCheck.value;
        checkALKorNOT(limit);
      }

      /** display dom elements, on specific url*/
        if(continueBtn !== null) { //window.location.href.includes( 'partygame' )
            $('.headline').css('display', 'none');
            $('#site-navigation').css('display', 'none');
            $('#masthead').css('display', 'none');
            $('#resetBtn').css('display', 'none');
            $('.setup-icon__container').css('display', 'none');

          setArticleIconEvents(articleIcons, showRules, setupContainerRules, closeRulesInGame, datasheetPunishments, displayPunishmentContainer, displayPunishment);
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
                console.log(contentContainerArticle[i].children[3])
                let newHeadline = contentContainerArticle[i].children[3].textContent.replace(new RegExp("[0-9]", "g"), "").replace('#', '');
                contentContainerArticle[i].children[3].innerHTML = newHeadline;

                if(contentContainerArticle[i].children[3].textContent == "") {
                  contentContainerArticle[i].children[3].style.marginTop = "50px";
                }

                let texte = contentContainerArticle[i].getElementsByTagName('p');
                for(let y = 0; y < texte.length; y++) {
                    let text = texte[y];
                    let newString = '';

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

    function setArticleIconEvents(articleIcons, showRules, setupContainerRules, closeRulesInGame, datasheetPunishments, displayPunishmentContainer, displayPunishment) {
      for(let i = 0; i < articleIcons.length; i++) {
        articleIcons[i].addEventListener('click', (ev) => {
          if(ev.target.value == 'punishment-btn') {
            showPunishments(datasheetPunishments, displayPunishmentContainer, displayPunishment, setupContainerRules);
          } else if (ev.target.value == 'game-descriptions-btn' ||
              ev.target.parentElement.value == 'game-descriptions-btn' ||
              ev.target.parentElement.parentElement.value == 'game-descriptions-btn' ) {
            showGameDescriptions();
          } else if (ev.target.value == 'rule-btn' ||
              ev.target.parentElement.value == 'rule-btn' ||
              ev.target.parentElement.parentElement.value == 'rule-btn'  ||
              ev.target.parentElement.parentElement.parentElement.value == 'rule-btn' ||
              ev.target.parentElement.parentElement.parentElement.parentElement.value == 'rule-btn' ) {
            displayRules(showRules, setupContainerRules, closeRulesInGame, displayPunishmentContainer);

          } else if (ev.target.value == 're-new-btn' ||
              ev.target.parentElement.value == 're-new-btn' ||
              ev.target.parentElement.parentElement.value == 're-new-btn' ) {
            goBackToStart();
          }
        })
      }
    }

    function showPunishments(datasheetPunishments, displayPunishmentContainer, displayPunishment, setupContainerRules) {
      let closePunishmentBtn = document.getElementById('close-punishment');
      let datasheetPunishmentsArray = datasheetPunishments.split('|');
      let randomPunishmentNumber = Math.floor(Math.random() * (datasheetPunishmentsArray.length+1));
      for(let i = 0; i < datasheetPunishmentsArray.length; i++) {
        if(i == randomPunishmentNumber) {
          displayPunishment.innerHTML = datasheetPunishmentsArray[i];
        }
      }
      displayPunishmentContainer.classList.add('show-punishment');
      setupContainerRules.classList.remove('show-rules');
      closePunishmentBtn.addEventListener('click', () => {
        displayPunishmentContainer.classList.remove('show-punishment');
      })
    }

    function displayRules(showRules, setupContainerRules, closeRulesInGame, displayPunishmentContainer) {
      if(!showRules) {
        showRules = true;
        displayPunishmentContainer.classList.remove('show-punishment');
        setupContainerRules.classList.add('show-rules');
        closeRulesInGame.style.display = 'block';

        closeRulesInGame.addEventListener('click', () => {
          showRules = false;
          setupContainerRules.classList.remove('show-rules');
          closeRulesInGame.style.display = 'none';
        })
      } else {
        showRules = false;
        setupContainerRules.classList.remove('show-rules');
        closeRulesInGame.style.display = 'none';
      }
    }

    function goBackToStart() {
      let ev = document.createEvent('MouseEvents');
      ev.initMouseEvent('click', true, true, window,
          0, 0, 0, 0, 0, false, false, false, false, 0, null);
      document.getElementById('reset-btn').dispatchEvent(ev);
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