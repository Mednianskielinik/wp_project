<?php
/*
Template Name: Add Posts
*/
?>

<?php

get_header();
?>

    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php
                while (have_posts()) : the_post();

                    get_template_part('template-parts/page/content', 'page');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;

                endwhile; // End of the loop.
                ?>
                <div class="text-column">
                    <?php the_content(); ?>
                </div>
                <?php if (current_user_can('administrator')) : ?>
                    <div class="admin-quick-add">
                        <h3>Add Post</h3>
                        <input type="text" name="title" placeholder="Title">
                        <textarea name="content" placeholder="Content"></textarea>
                        <button id="quick-add-button" type="button">Create New Post</button>
                    </div>
                <?php endif; ?>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .wrap -->


<?php get_footer();
