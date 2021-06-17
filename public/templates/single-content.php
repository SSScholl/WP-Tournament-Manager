<?php

/**
 * The template for displaying all single job posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package 
 */

$meta = get_post_custom($post->ID);


?>
<div class="wrap-job">
    <?php

    /**
     * now-hiring-single-content hook
     */
    do_action('tourney-manager-single-content', $meta);

    ?>
</div>