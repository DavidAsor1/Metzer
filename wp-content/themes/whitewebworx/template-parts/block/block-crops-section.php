<?php
// Fetch data and preprocess
$id = $block['id'] ?? '';
$class = sanitize_title($block['name'] ?? '');
$crops_section_group = get_field('crops_section_group') ?? [];
$light_title = $crops_section_group['light_title'] ?? '';
$bold_title = $crops_section_group['bold_title'] ?? '';
$sub_title = $crops_section_group['sub_title'] ?? '';
$content = $crops_section_group['content'] ?? '';

$choose_crops = $crops_section_group['choose_crops'] ?? [];
$buttons_repeater = $crops_section_group['buttons_repeater'] ?? [];
$background_image = $crops_section_group['background_image'] ?? '';


?>

<section class="container-fluid position-relative p-0 overflow-owl-slider <?= $class ?>" id="<?= $id ?>">
    <div class="position-relative py-5 <?= $class; ?>" id="<?= $id; ?>">
        <div class="container">
            <div class="row text-md-start text-center justify-content-start mb-md-5 mb-3 pb-3">
                <h2 class="h2"><?= $light_title; ?></h2>
                <div class="h1"><?= $bold_title; ?></div>
                <?php if ($sub_title): ?><h5 class="h5"><?= $sub_title; ?></h5> <?php endif; ?>
                <?php if ($content): ?><div class="content mb-5"><?= $content; ?></div><?php endif; ?>
                <?php if (!empty($choose_crops)) : ?>
                    <div class="row">
                        <div class="mb-5 d-md-block d-none">
                            <?= get_owl_navigation_arrows('crops'); ?>
                        </div>
                        <div class="owl-carousel owl-theme" data-responsive='{"0":{"dots":1}}' data-auto-width="1" data-loop="false" data-dots="false" data-padding="90" data-items="2" data-arrows="crops" data-margin="90">
                            <?php foreach ($choose_crops as $crop_item) :
                                $crop_ID = $crop_item->ID;
                                $title = strtolower(str_replace(' ', '-', $crop_item->post_title));
                                $permalink = get_the_permalink($crop_ID);
                                $thumbnail_id = get_post_thumbnail_id($crop_ID);
                            ?>
                                <div class="item">
                                    <a href="<?= $permalink; ?>">
                                        <?= load_image($thumbnail_id, $title, 1) ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($buttons_repeater)) : ?>
                    <div class="row pt-5 mt-md-3">
                        <div class="col-12 text-center">
                            <?php echo get_buttons($buttons_repeater); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
</section>