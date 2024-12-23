<?php
$id =  $block['id'];
$class =  sanitize_title($block['name']);
$acf_data_group = get_field('sustainable_agriculture_insights_group') ?? [];
$light_title = $acf_data_group['light_title'] ?? '';
$bold_title = $acf_data_group['bold_title'] ?? '';
$buttons_repeater = $acf_data_group['buttons_repeater'] ?? [];
$main_image = $acf_data_group['main_image'] ?? [];
$main_image_background = $acf_data_group['main_image_background'] ?? [];
$content_repeater = $acf_data_group['content_repeater'] ?? [];
$gradient_color_1 = $acf_data_group['gradient_color_1'] ?? '';
$gradient_color_2 = $acf_data_group['gradient_color_2'] ?? '';
$buttons_repeater = $acf_data_group['buttons_repeater'] ?? [];

// Split the content_repeater into two parts
$first_half = array_slice($content_repeater, 0, 2);
$second_half = array_slice($content_repeater, 2, 2);
?>

<section class="container-fluid position-relative py-5 <?= $class ?>" id="<?= $id ?>" style="background: linear-gradient(to bottom, <?= $gradient_color_1 ?> 0%, <?= $gradient_color_2 ?> 50%, <?= $gradient_color_1 ?> 100%);">
    <div class="container py-5">
        <div class="row text-center mb-5">
            <h2 class="h2"><?= $light_title ?></h2>
            <div class="h1"><?= $bold_title ?></div>
        </div>
        <div class="row align-items-center">
            <div class="col-4 half-1">
                <?php if (!empty($first_half)) : ?>
                    <?php foreach ($first_half as $item) : ?>
                        <?php
                        $icon = $item['icon'] ?? '';
                        $title = $item['title'] ?? '';
                        $content = $item['content'] ?? '';
                        ?>
                        <div class="content-item position-relative mt-5 pt-4">
                            <div class="d-flex align-items-center gap-2">
                                <?php if ($icon): ?>
                                    <div class="rounded-circle bg-dark p-2">
                                        <?= load_image($icon, 'img-fluid', 1) ?>
                                    </div>
                                <?php endif; ?>
                                <div class="d-flex align-items-center">
                                    <h3 class="content-title"> <?= $title ?> </h3>
                                    <hr class="water-drop-line">
                                </div>
                            </div>
                            <p class="content-description mt-3"> <?= $content ?> </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if (!empty($main_image)): ?>
                <div class="col-4">
                    <div class="main-image text-center position-relative">
                        <?= load_image($main_image_background, 'img-fluid center-floating position-absolute water-seed-drop-background w-100', 1) ?>
                        <?= load_image($main_image, 'img-fluid water-seed-drop w-100', 1) ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-4 half-2">
                <?php if (!empty($second_half)) : ?>
                    <?php foreach ($second_half as $item) : ?>
                        <?php
                        $icon = $item['icon'] ?? '';
                        $title = $item['title'] ?? '';
                        $content = $item['content'] ?? '';
                        ?>
                        <div class="content-item position-relative mt-5 pt-4">
                            <div class="d-flex align-items-center gap-2">
                                <?php if ($icon): ?>
                                    <div class="rounded-circle bg-dark p-2">
                                        <?= load_image($icon, 'img-fluid', 1) ?>
                                    </div>
                                <?php endif; ?>
                                <div class="d-flex align-items-center">
                                    <hr class="water-drop-line">
                                    <h3 class="content-title"> <?= $title ?> </h3>
                                </div>
                            </div>
                            <p class="content-description mt-3"> <?= $content ?> </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="col-12 text-center">
                <?= get_buttons($buttons_repeater); ?>
            </div>
        </div>
    </div>
</section>