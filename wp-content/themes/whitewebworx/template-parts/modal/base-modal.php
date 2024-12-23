<?php

/**
 * Template Part: Bootstrap Modal
 *
 * Usage: Pass dynamic content or file path via get_template_part() arguments.
 */

// Get modal content file or custom content
$modal_file = isset($args['file']) ? $args['file'] : '';
$modal_id   = isset($args['id']) ? $args['id'] : 'defaultModal';
?>

<!-- Bootstrap Modal -->
<div class="modal fade" id="<?php echo esc_attr($modal_id); ?>" tabindex="-1" aria-labelledby="<?php echo esc_attr($modal_id); ?>Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header pb-0 border-none">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0">
        <?php
        $file_path = get_template_directory() . '/template-parts/modal/' . $modal_file . '.php';
        if ($modal_file && file_exists($file_path)) {
          get_template_part('template-parts/modal/' . $modal_file);
        } else {
          echo '<p>No content available for this modal.</p>';
        }
        ?>
      </div>
    </div>
  </div>
</div>