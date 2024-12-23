<?php
// Fetch data and preprocess
$id = $block['id'] ?? '';
$class = sanitize_title($block['name'] ?? '');
$gallery_section_group = get_field('gallery_section_group') ?? [];
$light_title = $gallery_section_group['light_title'] ?? '';
$bold_title = $gallery_section_group['bold_title'] ?? '';
$choose_products = $gallery_section_group['choose_products'] ?? [];
$buttons_repeater = $gallery_section_group['buttons_repeater'] ?? [];
?>

<section class="position-relative rounded-overlap-top <?php echo $class; ?>" id="<?php echo $id; ?>">
    <div class="container-fluid overflow-owl-slider">
        <div class="container py-md-5 py-4">
            <div class="row text-center justify-content-center mb-md-5 pb-3">
                <h2 class="h2"><?php echo $light_title; ?></h2>
                <div class="h1 mb-5"><?php echo $bold_title; ?></div>
            </div>
            <?php if (!empty($choose_products)) : ?>
                <div class="row">
                    <div class="owl-carousel owl-theme" data-responsive='{"0":{"items":1}}' data-loop="false" data-dots="true" data-items="3" data-padding="0" data-start="3" data-center="1">
                        <?php foreach ($choose_products as $gallery_item) : ?>
                            <div class="item">
                                <?php get_template_part('template-parts/content', 'product', ['post_id' => $gallery_item->ID ?? 0]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($buttons_repeater)) : ?>
                <div class="row py-5">
                    <div class="col-12 text-center">
                        <?php echo get_buttons($buttons_repeater); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>