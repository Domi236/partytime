
		<div class="entry-content" itemprop="text">



			<?php
			//the_content();

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
            var_dump( $_COOKIE['players'] );
            echo $_COOKIE['numberOfPlayers'];
            echo $_COOKIE['currentChallengeID'];
            echo $_COOKIE['currentChallenge'];
            echo $_COOKIE['maxChallenges'];
            var_dump( $_COOKIE['categories'] );
            var_dump( $_COOKIE['tags'] );
            echo '</pre>';
            print_r($_COOKIE);


			?>
		</div><!-- .entry-content -->
