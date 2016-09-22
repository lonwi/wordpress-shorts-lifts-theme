<?php
/* URI shortcuts
================================================== */
define( 'THEME_ASSETS', get_template_directory_uri() . '/assets/', false );
define( 'THEME_INCLUDES', get_template_directory_uri() . '/includes/', false );
define( 'TEMPLATE_PATH', get_template_directory_uri(), false );
define( 'TEMPLATE_DIR', get_template_directory(), false );
define( 'GETTEXT_DOMAIN', 'shorts' );
$placeholdersmall = wp_get_attachment_image_src( 213, 'post-thumbnail');
define( 'IMAGE_PLACEHOLDER_SMALL', $placeholdersmall[0]);
$placeholderbig = wp_get_attachment_image_src( 213, 'post-thumbnails-big');
define( 'IMAGE_PLACEHOLDER_LARGE', $placeholderbig[0]);

add_action( 'init', 'exclude_from_search' );
function exclude_from_search() {
  global $wp_post_types;
  $wp_post_types['attachment']->exclude_from_search = true;
}


/* Functions
================================================== */
require_once dirname( __FILE__ ) . '/includes/functions/functions-template.php';
require_once dirname( __FILE__ ) . '/includes/functions/functions-setup.php';

require_once dirname( __FILE__ ) . '/includes/functions/functions-hooks.php';
require_once dirname( __FILE__ ) . '/includes/functions/functions-shortcodes.php';
require_once dirname( __FILE__ ) . '/includes/functions/functions-woocommerce.php';
require_once dirname( __FILE__ ) . '/includes/functions/functions-search.php';
require_once dirname( __FILE__ ) . '/includes/functions/functions-slider.php';
