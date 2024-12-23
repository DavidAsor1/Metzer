<?php
function get_buttons($buttons)
{
	if (!empty($buttons)) {

		$button_count = "btn-one";
		if (count($buttons) > 1) {
			$button_count = "btn-multi flex-column flex-xl-row";
		}

		$return = '';
		$return .= '<div class="section-btns ' . $button_count . '">';
		foreach ($buttons as $key => $value) {
			//pre($buttons); 
			$name = isset($value['button_name']) ? $value['button_name'] : '';
			$url = isset($value['button_link_url']) ? $value['button_link_url'] : '';
			$buttoncolor = isset($value['select_button_color']) ? $value['select_button_color'] : '';
			$buttonTarget = isset($value['select_button_target']) ? $value['select_button_target'] : '';
			$icon = getIcon($buttoncolor);
			$return .= '<a aria-label="' . $name . '" href="' . $url . '" class="btn btn-' . $buttoncolor . ' fw-regular" target="' . $buttonTarget . '">' . $name . '<i class="fas ' . $icon . '"></i></a>';
		}
		$return .= '</div>';
		return $return;
	}
}

function getIcon($name)
{
	switch ($name) {
		case 'primary':
			return '';
		case 'secondary':
			return ' fa-regular fa-chevron-right';
		case 'tertiary':
			return ' fa-regular fa-chevron-right';
		case 'success':
			return ' fa-check';
		case 'danger':
			return ' fa-exclamation-triangle';
		case 'warning':
			return ' fa-exclamation-circle';
		case 'info':
			return ' fa-info-circle';
		case 'light':
			return ' fa-lightbulb';
		case 'dark':
			return ' fa-moon';
		default:
			return '';
	}
}
