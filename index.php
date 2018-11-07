<?php 
    get_header();
?>

<?php include get_template_directory() . '/template-parts/contact.php'; ?>

<?php 
if ( have_posts() ) : 
    while ( have_posts() ) :
        the_post(); ?>
        <article class="post">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <?php the_content(); ?>
         </article>
         <?php
    endwhile;
    else : 
        echo('<p>There are no posts</p>');
endif;
?>

<?php 
    get_footer();
?>