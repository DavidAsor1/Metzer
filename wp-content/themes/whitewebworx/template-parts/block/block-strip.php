<?php
$id =  $block['id'];
$class =  sanitize_title($block['name']);
$strip_group = get_field('strip_group');
$image = $strip_group['image'] ?? [];
$text_area = $strip_group['text_area'] ?? '';
$buttons_repeater = $strip_group['buttons_repeater'] ?? [];
$background_color = $strip_group['background_color'] ?? '';
$bg_style = $background_color != '' ? 'style="background-color: ' . $background_color . ';"' : '';
?>

<section class="container-fluid position-relative bg-dark <?= $class ?>" id="<?= $id ?>" <?= $bg_style ?>>
    <div class="container py-5">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-5 col-12 mb-md-0 mb-4 pb-md-0 pb-2">
                <div class="strip-image">
                    <?= load_image($image, 'img-fluid w-100', 1); ?>
                </div>
            </div>
            <div class="col-md-7 col-12 mb-md-0 mb-4 pb-md-0 pb-3">
                <div class="strip-text">
                    <?= $text_area; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="strip-buttons text-end">
                <?= get_buttons($buttons_repeater); ?>
            </div>
        </div>
    </div>
</section>