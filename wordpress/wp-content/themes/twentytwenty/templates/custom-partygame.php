<?php
/**
 * Template Name: Custom Party Game Template
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0
 */

session_start();
get_header(); ?>

    <div id="primary">
        <main id="main">
            <h1 class="headline">Party Time</h1>
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
                'crazy', 'crazy_alk',
                'perverse', 'perverse_alk', 'perverse_18', 'perverse_18_alk', 'seduction', 'seduction_alk',
                'activity', 'activity_18', 'storytime', 'i_never_have',
                'truth_or_dare', 'truth_or_dare_alk', 'just_drinking'
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
                                <h3 class="subline">Choose Players</h3>
                                <select id="player-number" name="numberOfPlayers">
                                    <?php
                                    for($j = 2; $j < 11; $j++) :
                                        echo ' <option value="' . $j . '">' . $j . ' Player</option>';
                                    endfor;
                                    ?>
                                </select>
                                <?php
                                for($i = 1; $i < 11; $i++) :
                                    echo '<p class="player-names"><input type="text" name="player' . $i . '" placeholder="player' . $i . '" size="4"></p>';
                                endfor;
                                ?>
                            </div>
                            <div class="setup__container">
                                <h3 class="subline">Choose Content</h3>
                                <div class="categorie__wrapper">
                                    <?php foreach($allPosts as $post) {
                                        echo  '
                                        <div class="categorie__container">
                                            <label for="ct-' . $post . '" class="container">' . $post . '
                                                <input id="ct-' . $post . '"  type="checkbox" name="val-' . $post . '" value="' . $post . '">
                                                <span class="checkmark"></span>
                                            </label>
                                           <!-- <div class="categorie__description">' . $post . '</div> -->
                                        </div>
                                    ';
                                    } ?>
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
                    get_template_part( 'template-parts/custom-posts', get_post_type() );
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
                </div>
            <?php

            endif;

            /*$is_page_refreshed = (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0');

            if($is_page_refreshed ) {
                echo 'This Page Is refreshed.';
            } else {
                echo 'This page is freshly visited. Not refreshed.';
            }*/

            echo '<pre>';
            //var_dump($allPosts);
            print_r($_SESSION);
            //var_dump(get_children());
            echo '</pre>';
            ?>
        </main>
    </div>

