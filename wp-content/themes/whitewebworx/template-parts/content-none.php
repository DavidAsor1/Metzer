<?php

/**
 * The template part for displaying a message that posts cannot be found.
 *
 * @package Whitewebworx
 */
?>
<div class="container mt-5">
    <section class="no-results not-found">
        <header class="page-header">
            <h1 class="page-title"><?= esc_html__('Nothing Found', 'your-text-domain'); ?></h1>
        </header>

        <div class="page-content">
            <?php if (is_search()) : ?>
                <p><?= esc_html__('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'your-text-domain'); ?></p>
                <?php get_search_form(); ?>
            <?php else : ?>
                <p><?= esc_html__('It seems we can’t find what you’re looking for. Perhaps searching can help.', 'your-text-domain'); ?></p>
                <?php get_search_form(); ?>
            <?php endif; ?>
        </div>
    </section>
</div>