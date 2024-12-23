<?php
$languages = apply_filters('wpml_active_languages', NULL, 'skip_missing=0');
$current_lang = apply_filters('wpml_current_language', NULL);
$header_group = get_setting_field('header_group') ?? [];
$wpml_language_country_filter =  $header_group['wpml_language_country_filter'] ?? [];
$select_languages = $wpml_language_country_filter['select_languages'] ?? [];
$pre_selected_lang = [];

$filtered_lang = array_filter($wpml_language_country_filter, function ($lang) use ($current_lang) {
    return isset($lang['select_language']) && $lang['select_language'] === $current_lang;
})[0] ?? [];

$pre_selected_lang = $filtered_lang['select_languages'] ?? [];
$pre_selected_lang = array_map('strtoupper', $pre_selected_lang);
$icon_src = get_theme_file_uri('/assets/images/search-icon.svg');
?>

<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="text-center country-filter-popup-title"><?= $header_group['country_filter_popup_title'] ?? '' ?></div>
        </div>
        <div class="col-12 mb-3 text-center">
            <input style="background-image: url(<?= esc_url($icon_src) ?>);" type="text" id="lang-search" placeholder="<?= __('United States', DEFAULT_TEXT_DOMAIN) ?>" class="form-control search-input-icon" style="max-width: 400px; margin: 0 auto;" data-pre-selected='<?= json_encode($pre_selected_lang); ?>'>
        </div>
        <div class="col-12 px-4">
            <div class="select-your-language font-family-secondary mb-3">
                <?= __('Select your language', DEFAULT_TEXT_DOMAIN); ?>
            </div>
            <div id="language-list">
                <?php foreach ($languages as $lang_code => $language): ?>
                    <?php
                    $show_initially = in_array(strtoupper($lang_code), $pre_selected_lang) || in_array('All', $pre_selected_lang) || true;
                    ?>
                    <div class="form-check mb-2" style="<?php echo $show_initially ? '' : 'display: none;'; ?>">
                        <input
                            class="form-check-input custom-radio"
                            type="radio"
                            name="language"
                            id="lang-<?php echo esc_attr($lang_code); ?>"
                            value="<?php echo esc_attr($lang_code); ?>"
                            <?php echo $show_initially ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="lang-<?php echo esc_attr($lang_code); ?>">
                            <?php echo esc_html($language['native_name']) . ' (' . strtoupper($lang_code) . ')'; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center">
                <div class="btn btn-primary">
                    <?= __('Select', DEFAULT_TEXT_DOMAIN); ?>
                </div>
            </div>
        </div>
    </div>
</div>