<?php
if (!function_exists('owAcfBxSliderHtml')) {

    function owAcfBxSliderHtml($galleryArray, $ulAttributes = array(), $liAttributes = array())
    {
        return owAcfBxSliderHtmlFromGallery($galleryArray, $ulAttributes, $liAttributes);
    }
}

if (!function_exists('owAcfBxSliderHtmlInDiv')) {

    function owAcfBxSliderHtmlInDiv($galleryArray, $divAttributes = array(), $ulAttributes = array(), $liAttributes = array())
    {
        return owAcfBxSliderHtmlFromGalleryInDiv($galleryArray, $divAttributes, $ulAttributes, $liAttributes);
    }
}

if (!function_exists('owAcfGetBxSliderHtmlFromImageLinkRepeater')) {

    function owAcfGetBxSliderHtmlFromImageLinkRepeater($args = array())
    {
        $argsDefaults = array(
            'repeater_container_attributes' => array('class' => 'bxslider'),
        );
        $args         = array_merge($argsDefaults, $args);
        $bxSliderHtml = false;
        $bxSliderHtml = owAcfGetCtasFromRepeater($args);
        return $bxSliderHtml;
    }
}

if (!function_exists('owAcfBxSliderHtmlFromGallery')) {

    function owAcfBxSliderHtmlFromGallery($args = array())
    {
        $argsDefaults = array(
            'gallery_array'    => array(),
            'check_single'     => false,
            'image_attributes' => array(),
            'ul_attributes'    => array('class' => 'bxslider'),
            'li_attributes'    => array(),
        );
        $args         = array_merge($argsDefaults, $args);
        $bxSliderHtml = false;
        if (count($args['gallery_array']) > 0) {
            if ($args['check_single'] and (count($args['gallery_array']) == 1)) {
                $args['ul_attributes']['class'] = str_replace('bxslider', '', $args['ul_attributes']['class']);
            }
            $bxSliderHtml = '';
            $bxSliderHtml .= '<ul';
            foreach ($args['ul_attributes'] as $ulAttributeKey => $ulAttributeValue) {
                $bxSliderHtml .= ' ' . $ulAttributeKey . '="' . $ulAttributeValue . '"';
            }
            $bxSliderHtml .= '>';
            foreach ($args['gallery_array'] as $galleryImage) {
                $bxSliderHtml .= '<li';
                foreach ($args['li_attributes'] as $liAttributeKey => $liAttributeValue) {
                    $bxSliderHtml .= ' ' . $liAttributeKey . '="' . $liAttributeValue . '"';
                }
                $bxSliderHtml .= '>';
                $bxSliderHtml .= owAcfImageHtml($galleryImage, $args['image_attributes']);
                $bxSliderHtml .= '</li>';
            }
            $bxSliderHtml .= '</ul>';
        }
        return $bxSliderHtml;
    }
}

if (!function_exists('owAcfBxSliderHtmlPagerFromGallery')) {

    function owAcfBxSliderHtmlPagerFromGallery($args = array())
    {
        $argsDefaults = array(
            'gallery_array'    => array(),
            'image_attributes' => array(),
            'ul_attributes'    => array('id' => 'bx-pager'),
            'li_attributes'    => array(),
            'a_attributes'     => array(),
        );
        $args              = array_merge($argsDefaults, $args);
        $bxSliderHtmlPager = false;
        if (count($args['gallery_array']) > 0) {
            $bxSliderHtmlPager = '';
            $bxSliderHtmlPager .= '<ul';
            foreach ($args['ul_attributes'] as $ulAttributeKey => $ulAttributeValue) {
                $bxSliderHtmlPager .= ' ' . $ulAttributeKey . '="' . $ulAttributeValue . '"';
            }
            $bxSliderHtmlPager .= '>';
            $i = 0;
            foreach ($args['gallery_array'] as $galleryImage) {
                $bxSliderHtmlPager .= '<li';
                foreach ($args['li_attributes'] as $liAttributeKey => $liAttributeValue) {
                    $bxSliderHtmlPager .= ' ' . $liAttributeKey . '="' . $liAttributeValue . '"';
                }
                $bxSliderHtmlPager .= '>';
                $bxSliderHtmlPager .= '<a href="" ';
                $bxSliderHtmlPager .= 'data-slide-index="' . $i . '"';
                $i++;
                foreach ($args['a_attributes'] as $aAttributeKey => $aAttributeValue) {
                    $bxSliderHtmlPager .= ' ' . $aAttributeKey . '="' . $aAttributeValue . '"';
                }
                $bxSliderHtmlPager .= '>';
                $bxSliderHtmlPager .= owAcfImageHtml($galleryImage, $args['image_attributes']);
                $bxSliderHtmlPager .= '</a>';
                $bxSliderHtmlPager .= '</li>';
            }
            $bxSliderHtmlPager .= '</ul>';
        }
        return $bxSliderHtmlPager;
    }
}
