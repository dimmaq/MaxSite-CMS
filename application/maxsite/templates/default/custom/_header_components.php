<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// компоненты шапки

if ($fn = get_component_fn('default_header_component1', 'logo-links.php')) require($fn);
if ($fn = get_component_fn('default_header_component2', 'menu.php')) require($fn);
if ($fn = get_component_fn('default_header_component3', 'image-slider.php')) require($fn);
