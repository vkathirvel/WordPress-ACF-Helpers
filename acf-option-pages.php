<?php
if (function_exists('acf_add_options_sub_page')) {
    acf_add_options_page();
    acf_add_options_sub_page('Global');
    acf_add_options_sub_page('Header');
    acf_add_options_sub_page('Footer');
    acf_add_options_sub_page('Blog');
}