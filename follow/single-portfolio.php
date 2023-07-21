<?php
get_header();
?>

<article class="content px-3 py-5 p-md-5">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
    ?>
            <img class="mr-3 img-fluid post-thumb d-none d-md-flex"
             src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="image">
            <?php
                echo awosome_get_terms($post->ID, 'field');
                echo"||";
                echo awosome_get_terms($post->ID, 'software');
            ?>

            <?php
                if( current_user_can('manage_options')) {
                    echo '|| '; edit_post_link();
                }
            ?>
            
            <h2><?php the_title(); ?></h2>
            <?php the_content();
        }
    } else {
        echo '<p>No posts found.</p>';
    }
    ?>
</article>

<?php
get_footer();
?>
