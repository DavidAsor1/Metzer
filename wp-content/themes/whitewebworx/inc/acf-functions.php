<?php
function my_acf_block_render_callback($block, $content = '', $is_preview = false)
{

	if ($is_preview && ! empty($block['data'])) {
		echo '<img src="' . $block['data']['preview_image_help'] . '" width="300" height="145">';
		return;
	} else {
		$slug = str_replace('acf/', '', $block['name']);
		$file = "/template-parts/block/block-{$slug}.php";
		if (file_exists(get_theme_file_path($file))) {
			include(get_theme_file_path($file));
		} else {
			pre("template not exists:" . $file);
		}
	}
}

add_action('acf/init', 'my_acf_init');

function my_acf_init()
{
	if (!function_exists('acf_register_block')) return;

	$blocks = [
		'banner_section' => [
			'title' => 'Banner Section',
			'description' => 'A custom Banner Section block.',
			'icon' => 'admin-comments',
			'keywords' => ['Banner', 'image and text', 'hero banner section', 'Hero Block Top Banner Section'],
			'preview' => 'block-banner.png'
		],
		'gallery_section' => [
			'title' => 'Gallery Section',
			'description' => 'A custom Gallery Section block.',
			'icon' => 'images-alt2',
			'keywords' => ['Gallery', 'images', 'photo gallery section'],
			'preview' => 'block-gallery.png'
		],
		'projects_section' => [
			'title' => 'Projects Section',
			'description' => 'A custom Projects Section block.',
			'icon' => 'portfolio',
			'keywords' => ['Projects', 'portfolio', 'project showcase section'],
			'preview' => 'block-projects.png'
		],
		'crops_section' => [
			'title' => 'Crops Section',
			'description' => 'A custom Crops Section block.',
			'icon' => 'portfolio',
			'keywords' => ['Crops', 'crops showcase', 'crops section'],
			'preview' => 'block-crops.png'
		],
		'solutions_section' => [
			'title' => 'Solutions Section',
			'description' => 'A custom Solutions Section block.',
			'icon' => 'portfolio',
			'keywords' => ['Solutions', 'solutions showcase', 'solutions section'],
			'preview' => 'block-solutions.png'
		],
		'sustainable_agriculture_insights' => [
			'title' => 'Sustainable Agriculture Insights',
			'description' => 'A custom Sustainable Agriculture Insights block.',
			'icon' => 'portfolio',
			'keywords' => ['Sustainable Agriculture Insights', 'sustainable agriculture insights showcase', 'sustainable agriculture insights section'],
			'preview' => 'block-sustainable-agriculture-insights.png'
		],
		'strip' => [
			'title' => 'Strip',
			'description' => 'A custom Strip block.',
			'icon' => 'portfolio',
			'keywords' => ['Strip', 'strip showcase', 'strip section'],
			'preview' => 'block-strip.png'
		],
		'events_section' => [
			'title' => 'Events Section',
			'description' => 'A custom Events Section block.',
			'icon' => 'portfolio',
			'keywords' => ['Events', 'events showcase', 'events section'],
			'preview' => 'block-events.png'
		],
		'contact_us_section' => [
			'title' => 'Contact Us Section',
			'description' => 'A custom Contact Us Section block.',
			'icon' => 'portfolio',
			'keywords' => ['Contact Us', 'contact us showcase', 'contact us section'],
			'preview' => 'block-contact-us.png'
		],
	];

	foreach ($blocks as $name => $block) {
		acf_register_block([
			'name' => $name,
			'title' => __($block['title']),
			'description' => __($block['description']),
			'render_callback' => 'my_acf_block_render_callback',
			'category' => 'formatting',
			'icon' => $block['icon'],
			'keywords' => $block['keywords'],
			'example' => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'preview_image_help' => get_template_directory_uri() . '/assets/images/blocks/' . $block['preview']
					]
				]
			]
		]);
	}
}

if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title'     => 'Website General Settings',
		'menu_title'    => 'Website Settings',
		'menu_slug'     => 'website-general-settings',
		'capability'    => 'edit_posts',
		'redirect'        => false
	));
}

function clearWebsiteSettingCache()
{
	$cache_key = 'website_setting_key';
	delete_transient($cache_key);
}

add_action('acf/save_post', 'clearWebsiteSettingCache');

function my_acf_populate_tax_options($field)
{
	$taxonomies = get_taxonomies_definitions();

	$choices = array();
	foreach ($taxonomies as $tax) {
		$choices[$tax['slug']] = $tax['name'];
	}

	$field['choices'] = $choices;

	return $field;
}

add_filter('acf/load_field/name=all_tax_options', 'my_acf_populate_tax_options');

/**
 * Populate ACF Select Field with WPML Languages
 */
function acf_populate_select_language_choices($field)
{
	$field['choices'] = [];

	if (function_exists('icl_get_languages')) {
		$languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
		if (!empty($languages)) {
			foreach ($languages as $lang) {
				$field['choices'][$lang['language_code']] = $lang['native_name'];
			}
		}
	}

	return $field;
}
add_filter('acf/load_field/name=select_language', 'acf_populate_select_language_choices');
add_filter('acf/load_field/name=select_languages', 'acf_populate_select_language_choices');


function acf_populate_select_countries_choices($field)
{
	$field['choices'] = [];

	$countries = get_countries_array();
	foreach ($countries as $code => $name) {
		$field['choices'][$code] = $name;
	}

	return $field;
}
add_filter('acf/load_field/name=select_countries', 'acf_populate_select_countries_choices');

function format_acf_datetime($acf_datetime)
{
	if (empty($acf_datetime)) {
		return '';
	}

	$date = DateTime::createFromFormat('d/m/Y h:i a', $acf_datetime);

	if (!$date) {
		return 'Invalid date format';
	}

	return $date->format('F j, Y | g A T');
}

function get_countries_array()
{
	return [
		"All" => "All",
		"AF" => "Afghanistan",
		"AL" => "Albania",
		"DZ" => "Algeria",
		"AS" => "American Samoa",
		"AD" => "Andorra",
		"AO" => "Angola",
		"AI" => "Anguilla",
		"AQ" => "Antarctica",
		"AG" => "Antigua and Barbuda",
		"AR" => "Argentina",
		"AM" => "Armenia",
		"AW" => "Aruba",
		"AU" => "Australia",
		"AT" => "Austria",
		"AZ" => "Azerbaijan",
		"BS" => "Bahamas",
		"BH" => "Bahrain",
		"BD" => "Bangladesh",
		"BB" => "Barbados",
		"BY" => "Belarus",
		"BE" => "Belgium",
		"BZ" => "Belize",
		"BJ" => "Benin",
		"BM" => "Bermuda",
		"BT" => "Bhutan",
		"BO" => "Bolivia",
		"BA" => "Bosnia and Herzegovina",
		"BW" => "Botswana",
		"BV" => "Bouvet Island",
		"BR" => "Brazil",
		"BQ" => "British Antarctic Territory",
		"IO" => "British Indian Ocean Territory",
		"VG" => "British Virgin Islands",
		"BN" => "Brunei",
		"BG" => "Bulgaria",
		"BF" => "Burkina Faso",
		"BI" => "Burundi",
		"KH" => "Cambodia",
		"CM" => "Cameroon",
		"CA" => "Canada",
		"CT" => "Canton and Enderbury Islands",
		"CV" => "Cape Verde",
		"KY" => "Cayman Islands",
		"CF" => "Central African Republic",
		"TD" => "Chad",
		"CL" => "Chile",
		"CN" => "China",
		"CX" => "Christmas Island",
		"CC" => "Cocos [Keeling] Islands",
		"CO" => "Colombia",
		"KM" => "Comoros",
		"CG" => "Congo - Brazzaville",
		"CD" => "Congo - Kinshasa",
		"CK" => "Cook Islands",
		"CR" => "Costa Rica",
		"HR" => "Croatia",
		"CU" => "Cuba",
		"CY" => "Cyprus",
		"CZ" => "Czech Republic",
		"CI" => "Côte d’Ivoire",
		"DK" => "Denmark",
		"DJ" => "Djibouti",
		"DM" => "Dominica",
		"DO" => "Dominican Republic",
		"NQ" => "Dronning Maud Land",
		"DD" => "East Germany",
		"EC" => "Ecuador",
		"EG" => "Egypt",
		"SV" => "El Salvador",
		"GQ" => "Equatorial Guinea",
		"ER" => "Eritrea",
		"EE" => "Estonia",
		"ET" => "Ethiopia",
		"FK" => "Falkland Islands",
		"FO" => "Faroe Islands",
		"FJ" => "Fiji",
		"FI" => "Finland",
		"FR" => "France",
		"GF" => "French Guiana",
		"PF" => "French Polynesia",
		"TF" => "French Southern Territories",
		"FQ" => "French Southern and Antarctic Territories",
		"GA" => "Gabon",
		"GM" => "Gambia",
		"GE" => "Georgia",
		"DE" => "Germany",
		"GH" => "Ghana",
		"GI" => "Gibraltar",
		"GR" => "Greece",
		"GL" => "Greenland",
		"GD" => "Grenada",
		"GP" => "Guadeloupe",
		"GU" => "Guam",
		"GT" => "Guatemala",
		"GG" => "Guernsey",
		"GN" => "Guinea",
		"GW" => "Guinea-Bissau",
		"GY" => "Guyana",
		"HT" => "Haiti",
		"HM" => "Heard Island and McDonald Islands",
		"HN" => "Honduras",
		"HK" => "Hong Kong SAR China",
		"HU" => "Hungary",
		"IS" => "Iceland",
		"IN" => "India",
		"ID" => "Indonesia",
		"IR" => "Iran",
		"IQ" => "Iraq",
		"IE" => "Ireland",
		"IM" => "Isle of Man",
		"IL" => "Israel",
		"IT" => "Italy",
		"JM" => "Jamaica",
		"JP" => "Japan",
		"JE" => "Jersey",
		"JT" => "Johnston Island",
		"JO" => "Jordan",
		"KZ" => "Kazakhstan",
		"KE" => "Kenya",
		"KI" => "Kiribati",
		"KW" => "Kuwait",
		"KG" => "Kyrgyzstan",
		"LA" => "Laos",
		"LV" => "Latvia",
		"LB" => "Lebanon",
		"LS" => "Lesotho",
		"LR" => "Liberia",
		"LY" => "Libya",
		"LI" => "Liechtenstein",
		"LT" => "Lithuania",
		"LU" => "Luxembourg",
		"MO" => "Macau SAR China",
		"MK" => "Macedonia",
		"MG" => "Madagascar",
		"MW" => "Malawi",
		"MY" => "Malaysia",
		"MV" => "Maldives",
		"ML" => "Mali",
		"MT" => "Malta",
		"MH" => "Marshall Islands",
		"MQ" => "Martinique",
		"MR" => "Mauritania",
		"MU" => "Mauritius",
		"YT" => "Mayotte",
		"FX" => "Metropolitan France",
		"MX" => "Mexico",
		"FM" => "Micronesia",
		"MI" => "Midway Islands",
		"MD" => "Moldova",
		"MC" => "Monaco",
		"MN" => "Mongolia",
		"ME" => "Montenegro",
		"MS" => "Montserrat",
		"MA" => "Morocco",
		"MZ" => "Mozambique",
		"MM" => "Myanmar [Burma]",
		"NA" => "Namibia",
		"NR" => "Nauru",
		"NP" => "Nepal",
		"NL" => "Netherlands",
		"AN" => "Netherlands Antilles",
		"NT" => "Neutral Zone",
		"NC" => "New Caledonia",
		"NZ" => "New Zealand",
		"NI" => "Nicaragua",
		"NE" => "Niger",
		"NG" => "Nigeria",
		"NU" => "Niue",
		"NF" => "Norfolk Island",
		"KP" => "North Korea",
		"VD" => "North Vietnam",
		"MP" => "Northern Mariana Islands",
		"NO" => "Norway",
		"OM" => "Oman",
		"PC" => "Pacific Islands Trust Territory",
		"PK" => "Pakistan",
		"PW" => "Palau",
		"PS" => "Palestinian Territories",
		"PA" => "Panama",
		"PZ" => "Panama Canal Zone",
		"PG" => "Papua New Guinea",
		"PY" => "Paraguay",
		"YD" => "People's Democratic Republic of Yemen",
		"PE" => "Peru",
		"PH" => "Philippines",
		"PN" => "Pitcairn Islands",
		"PL" => "Poland",
		"PT" => "Portugal",
		"PR" => "Puerto Rico",
		"QA" => "Qatar",
		"RO" => "Romania",
		"RU" => "Russia",
		"RW" => "Rwanda",
		"RE" => "Réunion",
		"BL" => "Saint Barthélemy",
		"SH" => "Saint Helena",
		"KN" => "Saint Kitts and Nevis",
		"LC" => "Saint Lucia",
		"MF" => "Saint Martin",
		"PM" => "Saint Pierre and Miquelon",
		"VC" => "Saint Vincent and the Grenadines",
		"WS" => "Samoa",
		"SM" => "San Marino",
		"SA" => "Saudi Arabia",
		"SN" => "Senegal",
		"RS" => "Serbia",
		"CS" => "Serbia and Montenegro",
		"SC" => "Seychelles",
		"SL" => "Sierra Leone",
		"SG" => "Singapore",
		"SK" => "Slovakia",
		"SI" => "Slovenia",
		"SB" => "Solomon Islands",
		"SO" => "Somalia",
		"ZA" => "South Africa",
		"GS" => "South Georgia and the South Sandwich Islands",
		"KR" => "South Korea",
		"ES" => "Spain",
		"LK" => "Sri Lanka",
		"SD" => "Sudan",
		"SR" => "Suriname",
		"SJ" => "Svalbard and Jan Mayen",
		"SZ" => "Swaziland",
		"SE" => "Sweden",
		"CH" => "Switzerland",
		"SY" => "Syria",
		"ST" => "São Tomé and Príncipe",
		"TW" => "Taiwan",
		"TJ" => "Tajikistan",
		"TZ" => "Tanzania",
		"TH" => "Thailand",
		"TL" => "Timor-Leste",
		"TG" => "Togo",
		"TK" => "Tokelau",
		"TO" => "Tonga",
		"TT" => "Trinidad and Tobago",
		"TN" => "Tunisia",
		"TR" => "Turkey",
		"TM" => "Turkmenistan",
		"TC" => "Turks and Caicos Islands",
		"TV" => "Tuvalu",
		"UM" => "U.S. Minor Outlying Islands",
		"PU" => "U.S. Miscellaneous Pacific Islands",
		"VI" => "U.S. Virgin Islands",
		"UG" => "Uganda",
		"UA" => "Ukraine",
		"SU" => "Union of Soviet Socialist Republics",
		"AE" => "United Arab Emirates",
		"GB" => "United Kingdom",
		"US" => "United States",
		"ZZ" => "Unknown or Invalid Region",
		"UY" => "Uruguay",
		"UZ" => "Uzbekistan",
		"VU" => "Vanuatu",
		"VA" => "Vatican City",
		"VE" => "Venezuela",
		"VN" => "Vietnam",
		"WK" => "Wake Island",
		"WF" => "Wallis and Futuna",
		"EH" => "Western Sahara",
		"YE" => "Yemen",
		"ZM" => "Zambia",
		"ZW" => "Zimbabwe",
		"AX" => "Åland Islands",
	];
}
