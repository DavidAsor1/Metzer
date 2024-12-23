<?php

/**
 * The template part for displaying content of product.
 *
 * @package Whitewebworx
 */

// pre($args);
$post_id = $args['post_id'] ?? 0;
$product_data = get_field('product_data', $post_id);
$post_title = get_the_title($post_id);
$product_title = $product_data['product_title'] ?? '';
$permalink = get_permalink($post_id);
?>
<div class="card">
    <div class="card-body p-0 d-flex flex-column">
        <div class="product-thumbnail-wrap bg-grey mb-2 d-flex justify-content-center align-items-center">
            <?= get_the_post_thumbnail($post_id, 'medium', ['class' => 'img-fluid product-thumbnail']); ?>
        </div>
        <div class="d-flex flex-column text-start">
            <a href="<?= $permalink; ?>">
                <h5 class="card-title"><?= $post_title; ?></h5>
            </a>
            <a href="<?= $permalink; ?>">
                <h6 class="card-subtitle text-muted"><?= $product_title; ?></h6>
            </a>
        </div>
    </div>
</div>