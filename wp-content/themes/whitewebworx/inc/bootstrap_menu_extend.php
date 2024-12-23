<?php
class Bootstrap_NavWalker extends Walker_Nav_Menu
{
    private $parent_classes = []; // Array to hold parent classes

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth > 0) ? 'dropdown-submenu' : '';
        $style_class = in_array('mega-menu-style-2', $this->parent_classes) ? 'mega-menu-style-2' : (in_array('mega-menu-style', $this->parent_classes) ? 'mega-menu-style' : 'regular-style');

        if ($depth === 0 /*&& in_array('mega-menu-style-2', $this->parent_classes)*/) {
            $output .= "\n$indent<div class=\"wrapped\">\n";
        }
        $output .= "\n$indent<ul class=\"dropdown-menu $submenu $style_class depth_$depth\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
        if ($depth === 0 /*&& in_array('mega-menu-style-2', $this->parent_classes)*/) {
            $output .= "$indent</div>\n";
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        if ($depth === 0) {
            $this->parent_classes = empty($item->classes) ? array() : (array) $item->classes;
        }

        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item menu-item-' . $item->ID;

        if ($args->has_children) {
            $classes[] = 'dropdown';
        }

        // Adding the regular-style class if specific mega menu styles are absent
        if (!in_array('mega-menu-style-2', $classes) && !in_array('mega-menu-style', $classes)) {
            $classes[] = 'regular-style';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $shortcode = ($depth === 0) ? get_field('shortcode', $item->ID) : '';

        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';

        if ($args->has_children && $depth === 0) {
            $atts['class'] = 'nav-link dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
        } else {
            $atts['class'] = 'nav-link';
        }

        $icon_html = $this->get_icon_html($item);

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        if (!empty($shortcode)) {
            $item_output .= do_shortcode($shortcode);
        } else {
            $item_output .= $icon_html . $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        }
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    private function get_icon_html($item)
    {
        $icon = get_field('menu_item_icon', $item->ID);
        if ($icon) {
            return '<img src="' . esc_url($icon['url']) . '" alt="' . esc_attr($item->title) . ' Icon" class="menu-icon">';
        }
    }

    public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args = null, &$output = '')
    {
        if (!$element) {
            return;
        }

        $id_field = $this->db_fields['id'];
        if (isset($args[0]) && is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);
        }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}
