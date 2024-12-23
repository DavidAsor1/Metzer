<?php
// Fetch data and preprocess
$id = $block['id'] ?? '';
$class = sanitize_title($block['name'] ?? '');
$events_section_group = get_field('events_section_group') ?? [];
$light_title = $events_section_group['light_title'] ?? '';
$bold_title = $events_section_group['bold_title'] ?? '';

$choose_events = $events_section_group['choose_events'] ?? [];
$buttons_repeater = $events_section_group['buttons_repeater'] ?? [];
$background_image = $events_section_group['background_image'] ?? '';

?>

<section class="container-fluid position-relative p-0 overflow-owl-slider <?= $class ?>" id="<?= $id ?>">
    <div class="position-relative py-5">
        <div class="container">
            <div class="row text-start justify-content-start mb-5 pb-3">
                <h2 class="h2"><?= $light_title; ?></h2>
                <div class="h1"><?= $bold_title; ?></div>
                <?php if (!empty($choose_events)) : ?>
                    <div class="row">
                        <div class="mb-5">
                            <?= get_owl_navigation_arrows('events'); ?>
                        </div>
                        <div class="owl-carousel owl-theme owl-first-bigger" data-responsive='{"0":{"items":1}}' <?= !wp_is_mobile() ? 'data-auto-width="1"' : ''; ?> data-loop="false" data-dots="false" data-padding="" data-items="2" data-arrows="events">
                            <?php foreach ($choose_events as $key => $event_item) :
                                $is_first = $key === 0;
                            ?>
                                <div class="item">
                                    <?php get_template_part('template-parts/content', 'event-card', ['post_id' => $event_item->ID]); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="container py-5">
                    <?php if (!empty($buttons_repeater)) : ?>
                        <div class="row">
                            <div class="col-12 text-center">
                                <?php echo get_buttons($buttons_repeater); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</section>