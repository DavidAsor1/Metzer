    <footer class="container-fluid bg-dark py-3 px-md-0 px-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-auto col-12 mb-md-0 mb-3">
                    <a class="navbar-brand" href="<?= home_url(); ?>">
                        <?= load_image(get_setting_field('main_website_logo_footer') ?? 0, 'img-fluid mb-1', 1); ?>
                    </a>
                </div>
                <div class="col-md-8 col-12">
                    <div class="footer-menu">
                        <?php
                        if (wp_is_mobile()):
                            $menu_items = wp_get_nav_menu_items('footer');

                            if ($menu_items) :
                                $first_part = array_slice($menu_items, 0, count($menu_items) - 2);
                                $second_part = array_slice($menu_items, -2);

                                echo '<ul id="menu-footer" class="d-flex align-items-center p-0">';
                                echo '<div class="d-flex flex-wrap">';
                                for ($i = 0; $i < count($first_part); $i += 3) {
                                    echo '<div class="d-flex justify-content-between w-100 mb-2">';
                                    for ($j = $i; $j < $i + 3 && $j < count($first_part); $j++) {
                                        $item = $first_part[$j];
                                        echo '<li><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
                                    }
                                    echo '</div>';
                                }
                                echo '</div>';
                                echo '</ul>';


                            endif;
                        else :
                            wp_nav_menu(array(
                                'theme_location' => 'footer',
                                'container'      => false,
                                'menu_class'     => 'd-flex gap-3 align-items-center mb-0 px-2',
                                'fallback_cb'    => '__return_false',
                                'depth'          => 1,
                            ));
                        endif;
                        ?>

                    </div>
                </div>
                <div class="ms-auto col-md-2 col-12">
                    <div class="footer-social d-flex justify-content-between align-items-center mt-md-0 mt-3">
                        <?php if (wp_is_mobile()): ?>
                            <?php
                            echo '<ul id="menu-footer" class="d-flex align-items-center p-0 mb-0 gap-3">';
                            foreach ($second_part as $key => $item) {
                                echo '<li><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
                                echo $key == 0 ? "|" : "";
                            }
                            echo '</ul>';
                            ?>
                        <?php endif; ?>
                        <?= get_social_icons(); ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <?= get_modal('wpml-modal-content', 'wpml-change-language-modal'); ?>
    <?php wp_footer(); ?>

    </body>

    </html>