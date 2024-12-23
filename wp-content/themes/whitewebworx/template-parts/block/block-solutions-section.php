<?php
$id =  $block['id'];
$class =  sanitize_title($block['name']);
$solutions_section_group = get_field('solutions_section_group') ?? [];
$light_title = $solutions_section_group['light_title'] ?? '';
$bold_title = $solutions_section_group['bold_title'] ?? '';
$choose_solutions = $solutions_section_group['choose_solutions'] ?? [];
$buttons_repeater = $solutions_section_group['buttons_repeater'] ?? [];
$background_image = $solutions_section_group['background_image'] ?? '';
?>

<section class="container-fluid position-relative <?= $class ?>" id="<?= $id ?>">
    <div class="solutions-container row bg-dark">
        <div class="col-6">
            <div class="slider-1">
                <h2 class="h2"><?= $light_title ?></h2>
                <div class="h1"><?= $bold_title ?></div>
                <?php if (!empty($choose_solutions)) : ?>
                    <div class="owl-carousel owl-theme owl-skip" data-padding="" data-items="1">
                        <?php
                        foreach ($choose_solutions as $key => $solution) :
                            $solution_title = $solution->post_title ?? '';
                            $solution_id =  $solution->ID ?? '';
                            $solutions_fields_group = get_field('solutions_fields_group', $solution_id) ?? [];
                            $title = $solutions_fields_group['title'] ?? '';
                            $short_description = apply_filters('the_content', $solutions_fields_group['short_description'] ?? '');
                        ?>
                            <div class="item mt-5 mb-4 pt-5">
                                <div class="current-slide-number">
                                    <?= $key + 1; ?>
                                </div>
                                <div class="content">
                                    <h3 class="mb-2 bolder"><?= $solution_title ?> :</h3>
                                    <h3 class="mb-2"><?= $title ?></h3>
                                    <div class="font-family-secondary"><?= $short_description ?></div>
                                    <a href="#" class="btn btn-primary"><?= __('Learn more', DEFAULT_TEXT_DOMAIN); ?></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="d-flex total-slider-items">
                        <div class="d-flex align-items-center">
                            <span class="current">1</span> / <span class="total"><?= count($choose_solutions); ?></span>
                        </div>
                        <hr class="w-100 mx-2">
                        <?= get_owl_navigation_arrows("solution") ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="text-end pb-3">
                <?= get_buttons($buttons_repeater); ?>
            </div>
        </div>
        <div class="slider-2 col-6 p-0">
            <?php if (!empty($choose_solutions)) : ?>
                <div class="owl-carousel owl-theme owl-skip" data-padding="" data-items="1">
                    <?php foreach ($choose_solutions as $solution) : ?>
                        <div class="item">
                            <?php
                            $solution_id =  $solution->ID ?? '';
                            $thumbnail_id = get_post_thumbnail_id($solution_id);
                            echo load_image($thumbnail_id, 'img-fluid w-100 h-100', 1);
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>