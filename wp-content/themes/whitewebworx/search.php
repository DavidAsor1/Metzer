<?php get_header(); ?>


<?php if (have_posts()) : ?>

    <h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'your-text-domain'), '<span>' . get_search_query() . '</span>'); ?></h1>

    <?php
    while (have_posts()) : the_post(); ?>

        <?php
        get_template_part('template-parts/content', 'search');
        ?>

    <?php endwhile;
    ?>

    <?php
    the_posts_pagination(array(
        'prev_text'          => __('Previous page', 'your-text-domain'),
        'next_text'          => __('Next page', 'your-text-domain'),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'your-text-domain') . ' </span>',
    ));
    ?>

<?php

else :
    get_template_part('template-parts/content', 'none');
endif;
?>


<?php get_footer(); ?>