<?php
if (!function_exists('owAcfGetHeading')) {
    function owAcfGetHeading($pageType = 'single', $postId = NULL)
    {
        if (is_null($postId)) {
            $heading = get_the_title();
            $customHeading = get_field('heading_' . $pageType);
        } else {
            $heading = get_the_title($postId);
            $customHeading = get_field('heading_' . $pageType, $postId);
        }
        if ($customHeading AND ! is_null($customHeading)) {
            $heading = $customHeading;
        }
        return $heading;
    }
}

if (!function_exists('owAcfTheHeading')) {
    function owAcfTheHeading($pageType = 'single', $postId = NULL)
    {
        return owAcfGetHeading($pageType, $postId);
    }
}

if (!function_exists('owAcfGetTextLink')) {

    function owAcfGetTextLink($args = array())
    {
        $argsDefaults = array(
            'field_name' => FALSE,
            'post_id' => FALSE,
            'get_sub_field' => FALSE,
        );
        $args = array_merge($argsDefaults, $args);
        $argsDefaults = array();
        $textLink = FALSE;
        if ($args['field_name']) {
            if ($args['get_sub_field']) {
                $argsDefaults['text'] = get_sub_field($args['field_name'] . '_text');
                $argsDefaults['link'] = get_sub_field($args['field_name'] . '_link');
            } else {
                $argsDefaults['text'] = get_field($args['field_name'] . '_text', $args['post_id']);
                $argsDefaults['link'] = get_field($args['field_name'] . '_link', $args['post_id']);
            }
            $args = array_merge($argsDefaults, $args);
            $getLinkAttributes = get_field($args['field_name'] . '_link_attributes', $args['post_id']);
            if ($getLinkAttributes) {
                $getLinkAttributesArray = array();
                $getLinkAttributes = explode(';', trim($getLinkAttributes));
                foreach ($getLinkAttributes as $getLinkAttribute) {
                    $getLinkAttribute = explode('|', trim($getLinkAttribute));
                    $getLinkAttributesArray[$getLinkAttribute[0]] = trim($getLinkAttribute[1]);
                }
                $args['link_attributes'] = array_merge($getLinkAttributesArray, $args['link_attributes']);
            }
            $textLink = $args;
        }
    }
}