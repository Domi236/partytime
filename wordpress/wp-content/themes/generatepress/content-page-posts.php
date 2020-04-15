
<?php
/*echo '<pre>';
var_dump($posts);
echo '</pre>';*/

echo '<span class="categorie">' . $post->post_type . '</span>';
the_title( '<h1 class="headline__challenges">', '</h1>' );
if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
    the_excerpt();
} else {
    the_content( __( 'Continue reading', 'twentytwenty' ) );
}
?>