<?php
require get_stylesheet_directory() . '/includes/acf/acf-option-pages.php';
require get_stylesheet_directory() . '/includes/acf/acf-helper-deprecated.php';
require get_stylesheet_directory() . '/includes/acf/acf-helper-text.php';
require get_stylesheet_directory() . '/includes/acf/acf-helper-image.php';
if (!function_exists('bfi_thumb')) {
    require get_stylesheet_directory() . '/includes/acf/BFI_Thumb.php';
}