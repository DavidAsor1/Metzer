<?php
$id =  $block['id'];
$class =  sanitize_title($block['name']);
$banner_section_group = get_field('banner_section_group');
$gallery_group = $banner_section_group['gallery_group'];
$light_title = $banner_section_group['light_title'] ?? '';
$bold_title = $banner_section_group['bold_title'] ?? '';
$buttons_repeater = $banner_section_group['buttons_repeater'] ?? [];
?>

<section class="container-fluid position-relative p-0 <?= $class ?>" id="<?= $id ?>">
    <div class="position-absolute center-floating w-100">
        <div class="container">
            <div class="row">
                <div class="content text-center">
                    <h2 class="h2 color-white"><?= $light_title ?></h2>
                    <h1 class="h1 color-white mb-4"><?= $bold_title ?></h1>
                    <?= get_buttons($buttons_repeater) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="owl-carousel owl-theme" data-loop="true" data-dots="false" data-items="1">
        <?php if ($banner_section_group) : ?>
            <?php foreach ($gallery_group as $gallery_item) : ?>
                <div class="item">
                    <?php
                    $type = $gallery_item['choose_type'] ?? '';

                    switch ($type):
                        case 'image':
                            $image = $gallery_item['image'] ?? '';
                            $mobile_image = $gallery_item['image_mobile'] ?? [];
                            if (wp_is_mobile() && $mobile_image) {
                                $image = $mobile_image;
                            }
                            if ($image) :
                    ?>
                                <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>" class="img-fluid w-100 h-100 position-absolute object-fit-cover">
                                <?php endif;
                            break;
                        case 'video':
                            $video_url = $gallery_item['link'] ?? '';
                            $video_mobile_url = $gallery_item['mobile_link'] ?? '';
                            if (wp_is_mobile() && $video_mobile_url) {
                                $video_url = $video_mobile_url;
                            }
                            if ($video_url) :
                                $video_type = get_video_type($video_url);
                                if ($video_type === 'vimeo') :
                                    $video_url = add_query_arg('controls', '0', $video_url);
                                ?>
                                    <iframe src="<?= esc_url($video_url); ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen class="img-fluid w-100 h-100 position-absolute"></iframe>
                                <?php else : ?>
                                    <video loop muted class="img-fluid w-100 h-100 position-absolute">
                                        <source src="<?= esc_url($video_url); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                    <?php endif;
                            endif;
                            break;
                        default:
                            break;
                    endswitch; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>