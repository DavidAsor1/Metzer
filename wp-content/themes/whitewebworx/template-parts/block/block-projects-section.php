<?php
$id =  $block['id'];
$class =  sanitize_title($block['name']);
$projects_section_group = get_field('projects_section_group');
$light_title = $projects_section_group['light_title'] ?? '';
$bold_title = $projects_section_group['bold_title'] ?? '';
$sub_title = $projects_section_group['sub_title'] ?? '';

$projects_types = $projects_section_group['projects_types'] ?? [];
$buttons_repeater = $projects_section_group['buttons_repeater'] ?? [];
$choose_projects = $projects_section_group['choose_projects'] ?? [];
$arrow_image = $projects_section_group['arrow_image'] ?? [];

$gradient_color_1 = $projects_section_group['gradient_color_1'] ?? '';
$gradient_color_2 = $projects_section_group['gradient_color_2'] ?? '';
$background = '';
if ($gradient_color_1 && $gradient_color_2) {
    $background = 'background: linear-gradient(180deg, ' . $gradient_color_1 . ', ' . $gradient_color_2 . ');';
}
?>
<div class="rounded-overlap-top blue position-relative" style="<?= $background ?>"></div>
<section class="container-fluid py-5 overflow-owl-slider <?= $class ?>" id="<?= $id ?>" style="<?= $background ?>">
    <div class="container">
        <div class="row">

            <div class="content text-center">
                <h2 class="h2"><?php echo $light_title; ?></h2>
                <div class="position-relative w-fit mx-auto">
                    <?php
                    $bold_title_parts = explode(' ', $bold_title, 2);
                    $first_word = $bold_title_parts[0] ?? '';
                    $rest_of_title = $bold_title_parts[1] ?? '';
                    ?>
                    <div class="h1 position-relative z-index-1">
                        <span class="position-relative">
                            <?php echo $first_word; ?>
                            <?= load_image($arrow_image, 'position-absolute arrow-image-360'); ?>
                        </span>
                        <?php echo ' ' . $rest_of_title; ?>
                    </div>
                </div>
                <h4 class="h4 mb-md-4 mt-3"><?php echo $sub_title; ?></h4>
            </div>

            <?php if (!empty($projects_types)) : ?>
                <div class="projects-types d-flex flex-md-row flex-column justify-content-center mb-4 py-md-5 py-3 mb-5 gap-md-0 gap-4">
                    <?php foreach ($projects_types as $key => $project_type) :
                        $project_type_title = $project_type['project_type_title'] ?? '';
                        $project_type_icon = $project_type['project_type_icon'] ?? [];
                    ?>
                        <div class="project-type text-center d-flex flex-md-column h-100 justify-content-center gap-md-0 gap-2">
                            <div class="project-type__image mb-md-3">
                                <?= load_image($project_type_icon); ?>
                            </div>
                            <div class="project-type__title mt-auto">
                                <?= $project_type_title ?>
                            </div>
                        </div>
                        <?php
                        if ($key !== count($projects_types) - 1) : ?>
                            <img class="dots-seperator position-relative d-md-block d-none" src="<?= get_template_directory_uri() . '/assets/images/seperator-dots-projects.svg'; ?>" alt="dots">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($choose_projects)) : ?>
                <div class="projects-container d-flex">
                    <div class="<?= wp_is_mobile() ? 'owl-carousel owl-theme' : 'd-flex' ?>" data-dots="true" data-items="1" data-padding="0">
                        <?php foreach ($choose_projects as $key => $project) : ?>
                            <?php
                            $title   = get_the_title($project->ID);
                            $projects_fields_group = get_field('projects_fields_group', $project->ID);
                            $short_description = $projects_fields_group['short_description'] ?? '';
                            $content = apply_filters('the_content', $short_description);
                            $image_url = get_the_post_thumbnail_url($project->ID, 'large');
                            $show = $key === 0 || wp_is_mobile();
                            ?>

                            <div class="project-item mb-3 position-relative pe-3">
                                <img
                                    src="<?php echo esc_url($image_url); ?>"
                                    class="cursor-pointer object-fit-cover h-100 w-100 project-image"
                                    alt="<?php echo esc_attr($title); ?>"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseWidthExample-<?php echo $project->ID; ?>"
                                    aria-expanded="<?php echo $show ? 'true' : 'false'; ?>"
                                    aria-controls="collapseWidthExample-<?php echo $project->ID; ?>" />
                                <div class="collapse collapse-horizontal position-absolute top-0 start-0 h-100 <?php echo $show ? 'show' : ''; ?>" id="collapseWidthExample-<?php echo $project->ID; ?>">
                                    <div class="card card-body h-100 bg-dark">
                                        <div class="card-content-wrap d-flex flex-grow-1 flex-column mt-3">
                                            <h3 class="mb-3"><?php echo esc_html($title); ?></h3>
                                            <div class="font-family-secondary font-weight-ligher"><?php echo $content; ?></div>
                                            <?php
                                            $hectares_term    = get_the_terms($project->ID, 'hectares');
                                            $locations_term   = get_the_terms($project->ID, 'locations');
                                            $connected_crops  = get_field('connected_crops', $project->ID);
                                            $project_settings = get_setting_field('tax_group') ?? [];

                                            $hectares_term_names  = wp_list_pluck($hectares_term, 'name') ?? [];
                                            $locations_term_names = wp_list_pluck($locations_term, 'name') ?? [];
                                            $crops_names          = wp_list_pluck($connected_crops, 'post_title') ?? [];

                                            $hectares_title = $project_settings['hectares_group']['title'] ?? '';
                                            $crop_title     = $project_settings['crop_group']['title'] ?? '';
                                            $location_title = $project_settings['location_group']['title'] ?? '';
                                            $hectares_icon  = $project_settings['hectares_group']['hectares_icon'] ?? [];
                                            $location_icon  = $project_settings['location_group']['location_icon'] ?? [];
                                            $crop_icon      = $project_settings['crop_group']['crop_icon'] ?? [];

                                            $project_settings_buttons_repeater = $project_settings['buttons_repeater'] ?? [];
                                            $project_link = get_permalink($project->ID);
                                            $project_settings_buttons_repeater[0]['button_link_url'] = $project_link;

                                            $info_items = [
                                                [
                                                    'title' => $location_title,
                                                    'value' => implode(', ', $locations_term_names),
                                                    'icon' => $location_icon
                                                ],
                                                [
                                                    'title' => $hectares_title,
                                                    'value' => implode(', ', $hectares_term_names) . ' ' . __('ha', DEFAULT_TEXT_DOMAIN),
                                                    'icon' => $hectares_icon
                                                ],
                                                [
                                                    'title' => $crop_title,
                                                    'value' => implode(', ', $crops_names),
                                                    'icon' => $crop_icon
                                                ]
                                            ];
                                            ?>
                                            <div class="d-flex font-family-secondary mt-md-5 flex-md-row flex-column">
                                                <?php foreach ($info_items as $key => $info_item) : ?>
                                                    <div class="d-flex flex-md-row flex-column">
                                                        <div class="icon-wrap d-flex gap-2 align-items-start">
                                                            <?= load_image($info_item['icon'], 'project-tax-icon'); ?>
                                                            <div class="item d-md-block d-flex align-items-center flex-grow-1">
                                                                <div class="col-md-12 col-6 info-item__title font-weight-ligher"><?= $info_item['title']; ?></div>
                                                                <div class="col-md-12 col-6 info-item__value w-100 fw-200"><?= $info_item['value']; ?></div>
                                                            </div>
                                                        </div>
                                                        <?php if ($key !== count($info_items) - 1) : ?>
                                                            <div class="border-right-dots-seperator ms-3 me-4"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if ($key !== count($info_items) - 1) : ?>
                                                        <div class="border-bottom-dots-seperator my-2 d-md-none"></div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="d-md-none thumbnail-wrap mt-3">
                                                <img src="<?php echo esc_url($image_url); ?>" class="object-fit-cover h-100 w-100" alt="<?php echo esc_attr($title); ?>" />
                                            </div>
                                            <div class=" view-project-button mt-auto text-end">
                                                <?= get_buttons($project_settings_buttons_repeater); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($buttons_repeater)) : ?>
                <div class="row mt-4">
                    <div class="col-12 text-end project-buttons-wrap">
                        <?= get_buttons($buttons_repeater); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>