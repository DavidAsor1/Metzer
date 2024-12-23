<?php
$id =  $block['id'];
$class =  sanitize_title($block['name']);
$contact_us_group = get_field('contact_us_group') ?? [];
$light_title = $contact_us_group['light_title'] ?? '';
$bold_title = $contact_us_group['bold_title'] ?? '';
$choose_form = $contact_us_group['choose_form'] ?? [];
$gradient_color_1 = $contact_us_group['gradient_color_1'] ?? '';
$gradient_color_2 = $contact_us_group['gradient_color_2'] ?? '';
$background = '';
if ($gradient_color_1 && $gradient_color_2) {
    $background = 'linear-gradient(to bottom, ' . $gradient_color_2 . ' 0%, ' . $gradient_color_1 . ' 50%, ' . $gradient_color_2 . ' 100%);';
}
?>

<section class="container-fluid position-relative py-5 <?= $class ?>" id="<?= $id ?>" style="background:<?= $background ?>">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-12">
                <h2 class="h2"><?= $light_title ?></h2>
                <div class="h1"><?= $bold_title ?></div>
            </div>
            <div class="col-md-7 col-12">
                <?php if (!empty($choose_form)) : ?>
                    <?= $choose_form; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</section>