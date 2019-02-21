<?php
/*
Template Name: Portfolio
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
                <?php the_content(); ?>
            </main><!-- #main -->
        </div><!-- #primary -->

        <div class="text-column">
            <button id="portfolio-posts-btn"> Load Posts</button>
            <div class="my-container" id="portfolio-posts-container"></div>
        </div>

    </div><!-- .wrap -->
<?php get_footer();
