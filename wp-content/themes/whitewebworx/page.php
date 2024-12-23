<?php get_header(); ?>

<div role="main" id="main-container" class="main-container">
	<?php 
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
    ?>

</div>

<?php get_footer(); ?>