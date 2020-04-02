<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
			<?php
            //player names
            $_COOKIE['players'] = isset($_POST['players']) ? $_POST['players'] : array();

            //number of players
            $_COOKIE['numberOfPlayers'] = isset($_POST['numberOfPlayers']) ? $_POST['numberOfPlayers'] : 0;

            //current challenge ID
            $_COOKIE['currentChallengeID'] = isset($_POST['currentChallengeID']) ? $_POST['currentChallengeID'] : '';

            //current challenge
            $_COOKIE['currentChallenge'] = isset($_POST['currentChallenge']) ? $_POST['currentChallenge'] : 0;

            //max challenges
            $_COOKIE['maxChallenges'] = isset($_POST['maxChallenges']) ? $_POST['maxChallenges'] : 50;

            //categories
            $_COOKIE['categories'] = isset($_POST['categories']) ? $_POST['categories'] : array('crazy' => true, 'mime' => false, 'perverse' => true, 'explain' => true, 'draw' => false, 'common' => true);

            //tags
            $_COOKIE['tags'] = isset($_POST['tags']) ? $_POST['tags'] : array('virus' => true, 'paar' => false, '4player' => false);

            echo '<pre>';
                var_dump( $_COOKIE['players'] );
                echo $_COOKIE['numberOfPlayers'];
                echo $_COOKIE['currentChallengeID'];
                echo $_COOKIE['currentChallenge'];
                echo $_COOKIE['maxChallenges'];
                var_dump( $_COOKIE['categories'] );
                var_dump( $_COOKIE['tags'] );
            echo '</pre>';
            print_r($_COOKIE);


            $current_url = home_url($_SERVER['REQUEST_URI']);
            echo $current_url;
            ?>
            <!-- first step -->
            <form class="form" method="POST" action="<?php $current_url ?>">
                <h3 class="subline">Choose Number of Players</h3>
                <select name="numberOfPlayers">
                    <option value="0">nothing choosen</option>
                    <option value="2"></option>
                    <option value="3"></option>
                    <option value="4"></option>
                    <option value="5"></option>
                    <option value="6"></option>
                    <option value="7"></option>
                    <option value="8"></option>
                    <option value="9"></option>
                    <option value="10"></option>
                </select>
                <?php
                for($i = 0; $i < 4; $i++) { //$_SESSION['numberOfPlayers'];
                    echo '<p><span>Player ' .  ( $i + 1 ) . ' </span><input type="text" name="players" value="player' . $i . '" size="4"></p>';
                }
                ?>
                <h3 class="subline">Additional Content</h3>
                <label class="container">Crazy
                    <input name="crazy" value="crazy" type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Hot
                    <input name="hot" value="hot"  type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Explain
                    <input name="explain" value="explain" type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Mime
                    <input name="mime" value="mime" type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Draw
                    <input name="draw" value="draw" type="checkbox">
                    <span class="checkmark"></span>
                </label>

                <button class="submit" type="submit" name="first">Continue</button
            </form>

            <?php
            if(isset($_POST['submit'])){
                if(isset($_POST['numberOfPlayers'])){
                    $_COOKIE['numberOfPlayers'] = $_POST['numberOfPlayers'];
                }
                if(isset($_POST['players'])){
                    $_COOKIE['players'] = $_POST['players'];
                }

                if(isset($_POST['categories'])) {
                    $_COOKIE['categories'] = $_POST['categories'];
                }

                if($_COOKIE['numberOfPlayers'] > 3) {
                    $_COOKIE['tags'] = $_COOKIE['4player'][true];
                }
                if($_COOKIE['numberOfPlayers'] % 2 === 0) {
                    $_COOKIE['tags'] = $_COOKIE['paar'][true];
                }

            }
            ?>

            <?php
            foreach($_POST as $key => $value)
                $_COOKIE[$key] = $value;


            $args  = array(
                'posts_per_page'  => 100,
                'order'           => 'rand',
                'post_type'       => array('crazy' , 'mime', 'perverse', 'explain', 'draw', 'common'),
                'post_status'     => 'publish',
                'suppress_filters' => true,
            );

            $posts = get_posts($args);
            foreach ($posts as $post) :
                //get_the_title();
                the_post();
                get_template_part( 'content', 'page' );
            endforeach; ?>
            <?php

            echo '<pre>';
            print_r($_COOKIE);
            //var_dump(get_children());
            echo '</pre>';
            do_action( 'generate_after_main_content' );
            ?>
		</main><!-- #main -->
	</div><!-- #primary -->

get_footer();
