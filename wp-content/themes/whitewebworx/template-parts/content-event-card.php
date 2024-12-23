<?php

/**
 * The template part for displaying content of event.
 *
 * @package Whitewebworx
 */

$post_id = $args['post_id'] ?? 0;

$single_event_group = get_field('single_event_group', $post_id);
$categories = get_the_terms($post_id, 'event_category');
$tags = get_the_terms($post_id, 'event_tag');
$post_title = get_the_title($post_id);

$excerpt = $single_event_group['short_description'] ?? '';
$event_date_time = $single_event_group['event_date_time'] ?? '';


?>
<div class="card event-card shadow">
    <div class="row">
        <div class="col-md-4 col-12">
            <?= get_the_post_thumbnail($post_id, 'medium', ['class' => 'img-fluid event-thumbnail h-100']); ?>
        </div>
        <div class="col d-flex flex-column p-0">
            <div class="p-3">
                <?php if (!empty($categories)) : ?>
                    <?php foreach ($categories as $category) :
                        $category_group = get_field('event_category_group', $category);
                        $icon = $category_group['icon'] ?? [];
                    ?>
                        <div class="d-flex align-items-center gap-2 bg-gery px-3 py-2 rounded w-fit-content my-3">
                            <div class="icon-wrap">
                                <?= load_image($icon, 'img-fluid event-category-icon', 1); ?>
                            </div>
                            <span class="product-category"><?= $category->name; ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($post_title) : ?><h5 class="h5"><?= $post_title; ?></h5> <?php endif; ?>
                <?php if ($excerpt) : ?>
                    <p class="card-text text-muted mb-5 pb-3">
                        <?php
                        $trimmed_excerpt = wp_trim_words($excerpt, 20, '...');
                        echo $trimmed_excerpt;
                        ?>
                    </p>
                <?php endif; ?>

                <div class="event-date-time"><?= format_acf_datetime($event_date_time); ?></div>
                <?php if (!empty($tags)) : ?>
                    <div class="tags">
                        <span><?= __('Platform', DEFAULT_TEXT_DOMAIN); ?>: </span>
                        <span class="">
                            <?= implode(', ', wp_list_pluck($tags, 'name')); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php
                $events_group = get_setting_field('events_group') ?? [];
                $buttons = $events_group['event_register_button'] ?? [];
                $link = get_permalink($post_id);
                $buttons[0]['button_link_url'] = $link;

                ?>

                <div class="mt-auto d-flex justify-content-end">
                    <?= get_buttons($buttons); ?>
                </div>
            </div>
        </div>
    </div>
</div>