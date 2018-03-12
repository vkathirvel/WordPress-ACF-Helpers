<?php
if (!function_exists('owAcfImageAssignFullInSizesArray')) {

    function owAcfImageAssignFullInSizesArray($imageArray)
    {
        $newImageArray = $imageArray;
        if ($imageArray and isset($imageArray['url'])) {
            $newImageArray['sizes']['full']        = $newImageArray['url'];
            $newImageArray['sizes']['full-width']  = (int) $newImageArray['width'];
            $newImageArray['sizes']['full-height'] = (int) $newImageArray['height'];
        }
        return $newImageArray;
    }
}

if (!function_exists('owAcfImageBfiThumbResize')) {

    function owAcfImageBfiThumbResize($imageArray, $bfiThumbOptions = array())
    {
        $newImageArray = $imageArray;
        if ($imageArray and isset($imageArray['url'])) {
            if (function_exists('bfi_thumb')) {
                $bfiThumbImageArray                       = bfi_thumb($newImageArray['url'], $bfiThumbOptions, false);
                $newImageArray['sizes']['resized']        = $bfiThumbImageArray[0];
                $newImageArray['sizes']['resized-width']  = (int) $bfiThumbImageArray[1];
                $newImageArray['sizes']['resized-height'] = (int) $bfiThumbImageArray[2];
            }
        }
        return $newImageArray;
    }
}

if (!function_exists('owAcfImageHtml')) {

    function owAcfImageHtml($imageArray, $imageAttributes = array())
    {
        $imageHtml = false;
        if ($imageArray and isset($imageArray['url'])) {
            $imageArray   = owAcfImageAssignFullInSizesArray($imageArray);
            $resizedImage = false;
            if (isset($imageAttributes['bfi_thumb_options'])) {
                $imageArray   = owAcfImageBfiThumbResize($imageArray, $imageAttributes['bfi_thumb_options']);
                $resizedImage = true;
            }
            $layeredImageArgs = false;
            if (isset($imageAttributes['layered_image_options']) and is_array($imageAttributes['layered_image_options'])) {
                $layeredImageArgs         = $imageAttributes['layered_image_options'];
                $layeredImageArgsDefaults = array(
                    'container_div_attributes'   => array('class' => 'layered-image-container'),
                    'image_div_attributes'       => array('class' => 'layered-image-image'),
                    'bootstrap_container'        => false,
                    'caption_element'            => 'div',
                    'caption_div_attributes'     => array('class' => 'layered-image-caption'),
                    'description_element'        => 'div',
                    'description_div_attributes' => array('class' => 'layered-image-description'),
                );
                $layeredImageArgs = array_merge($layeredImageArgsDefaults, $layeredImageArgs);
            }
            $imageArrayAttributes = array();
            if ($imageArray['url']) {
                $imageArrayAttributes['src'] = $imageArray['url'];
            }
            if ($imageArray['width']) {
                $imageArrayAttributes['width'] = $imageArray['width'];
            }
            if ($imageArray['height']) {
                $imageArrayAttributes['height'] = $imageArray['height'];
            }
            if (isset($imageAttributes['image_size'])) {
                $imageArrayAttributes['src']    = $imageArray['sizes'][$imageAttributes['image_size']];
                $imageArrayAttributes['width']  = $imageArray['sizes'][$imageAttributes['image_size'] . '-width'];
                $imageArrayAttributes['height'] = $imageArray['sizes'][$imageAttributes['image_size'] . '-height'];
            }
            $resizedSrcsetLine = '';
            if ($resizedImage) {
                $resizedSrcsetLine = $imageArray['sizes']['resized'] . ' ' . $imageArray['sizes']['resized-width'] . 'w, ';
            }
            if (isset($imageAttributes['srcset_images'])) {
                if ($imageAttributes['srcset_images']) {
                    $imageArrayAttributes['srcset'] = $resizedSrcsetLine;
                    $imageArrayAttributes['srcset'] .= esc_attr(wp_get_attachment_image_srcset($imageArray['ID']));
                }
            }
            if ($imageArray['title']) {
                $imageArrayAttributes['title'] = $imageArray['title'];
            } elseif ($imageArray['alt']) {
                $imageArrayAttributes['title'] = $imageArray['alt'];
            }
            if ($imageArray['alt']) {
                $imageArrayAttributes['alt'] = $imageArray['alt'];
            } elseif ($imageArray['title']) {
                $imageArrayAttributes['alt'] = $imageArray['title'];
            }
            if (isset($imageAttributes['bfi_thumb_options'])) {
                unset($imageAttributes['bfi_thumb_options']);
            }
            if (isset($imageAttributes['layered_image_options'])) {
                unset($imageAttributes['layered_image_options']);
            }
            if (isset($imageAttributes['image_size'])) {
                unset($imageAttributes['image_size']);
            }
            if (isset($imageAttributes['srcset_images'])) {
                unset($imageAttributes['srcset_images']);
            }
            $imageAttributes = array_merge($imageArrayAttributes, $imageAttributes);
            $imageHtml       = '';
            $imageHtml .= '<img';
            foreach ($imageAttributes as $imageAttributeKey => $imageAttributeValue) {
                $imageHtml .= ' ' . $imageAttributeKey . '="' . $imageAttributeValue . '"';
            }
            $imageHtml .= '>';
            if ($layeredImageArgs) {
                $layeredImageHtml = '';
                $layeredImageHtml .= '<div';
                foreach ($layeredImageArgs['container_div_attributes'] as $containerDivAttributeKey => $containerDivAttributeValue) {
                    $layeredImageHtml .= ' ' . $containerDivAttributeKey . '="' . $containerDivAttributeValue . '"';
                }
                $layeredImageHtml .= '>';
                $layeredImageHtml .= '<div';
                foreach ($layeredImageArgs['image_div_attributes'] as $imageDivAttributeKey => $imageDivAttributeValue) {
                    $layeredImageHtml .= ' ' . $imageDivAttributeKey . '="' . $imageDivAttributeValue . '"';
                }
                $layeredImageHtml .= '>';
                $layeredImageHtml .= $imageHtml;
                $layeredImageHtml .= '</div>';
                if ($layeredImageArgs['bootstrap_container']) {
                    $layeredImageHtml .= '<div class="container">';
                }
                if ($imageArray['caption']) {
                    $layeredImageHtml .= '<' . $layeredImageArgs['caption_element'];
                    foreach ($layeredImageArgs['caption_div_attributes'] as $captionDivAttributeKey => $captionDivAttributeValue) {
                        $layeredImageHtml .= ' ' . $captionDivAttributeKey . '="' . $captionDivAttributeValue . '"';
                    }
                    $layeredImageHtml .= '>';
                    $layeredImageHtml .= $imageArray['caption'];
                    $layeredImageHtml .= '</' . $layeredImageArgs['caption_element'] . '>';
                }
                if ($imageArray['description']) {
                    $layeredImageHtml .= '<' . $layeredImageArgs['description_element'];
                    foreach ($layeredImageArgs['description_div_attributes'] as $descriptionDivAttributeKey => $descriptionDivAttributeValue) {
                        $layeredImageHtml .= ' ' . $descriptionDivAttributeKey . '="' . $descriptionDivAttributeValue . '"';
                    }
                    $layeredImageHtml .= '>';
                    $layeredImageHtml .= $imageArray['description'];
                    $layeredImageHtml .= '</' . $layeredImageArgs['description_element'] . '>';
                }
                if ($layeredImageArgs['bootstrap_container']) {
                    $layeredImageHtml .= '</div>';
                }
                $layeredImageHtml .= '</div>';
                $imageHtml = $layeredImageHtml;
            }
        }
        return $imageHtml;
    }
}

if (!function_exists('owAcfImageHtmlWithLink')) {

    function owAcfImageHtmlWithLink($imageArray, $link = false, $imageAttributes = array(), $linkAttributes = array())
    {
        $imageHtmlWithLink = false;
        $imageHtml         = owAcfImageHtml($imageArray, $imageAttributes);
        if ($imageHtml) {
            $imageHtmlWithLink = '';
            if ($link) {
                $imageArrayLinkAttributes = array();
                if ($imageArray['title']) {
                    $imageArrayLinkAttributes['title'] = $imageArray['title'];
                }
                $linkAttributes         = array_merge($imageArrayLinkAttributes, $linkAttributes);
                $linkAttributes['href'] = trim($link);
                $imageHtmlWithLink .= '<a';
                foreach ($linkAttributes as $linkAttributeKey => $linkAttributeValue) {
                    $imageHtmlWithLink .= ' ' . $linkAttributeKey . '="' . $linkAttributeValue . '"';
                }
                $imageHtmlWithLink .= '>';
            }
            $imageHtmlWithLink .= $imageHtml;
            if ($link) {
                $imageHtmlWithLink .= '</a>';
            }
        }
        return $imageHtmlWithLink;
    }
}

if (!function_exists('owAcfImageHtmlWithLinkInDiv')) {

    function owAcfImageHtmlWithLinkInDiv($imageArray, $link = false, $imageAttributes = array(), $linkAttributes = array(), $divAttributes = array())
    {
        $imageHtmlWithLinkInDiv = false;
        $imageHtmlWithLink      = owAcfImageHtmlWithLink($imageArray, $link, $imageAttributes, $linkAttributes);
        if ($imageHtmlWithLink) {
            $imageHtmlWithLinkInDiv = '';
            $imageHtmlWithLinkInDiv .= '<div';
            foreach ($divAttributes as $divAttributeKey => $divAttributeValue) {
                $imageHtmlWithLinkInDiv .= ' ' . $divAttributeKey . '="' . $divAttributeValue . '"';
            }
            $imageHtmlWithLinkInDiv .= '>';
            $imageHtmlWithLinkInDiv .= $imageHtmlWithLink;
            $imageHtmlWithLinkInDiv .= '</div>';
        }
        return $imageHtmlWithLinkInDiv;
    }
}

if (!function_exists('owAcfImageCta')) {

    function owAcfImageCta($args = array())
    {
        $argsDefaults = array(
            'image_array'      => false,
            'link'             => false,
            'image_attributes' => array(),
            'link_attributes'  => array(),
            'div_attributes'   => array(),
        );
        $args     = array_merge($argsDefaults, $args);
        $imageCta = false;
        if (count($args['div_attributes']) > 0) {
            $imageCta = owAcfImageHtmlWithLinkInDiv($args['image_array'], $args['link'], $args['image_attributes'], $args['link_attributes'], $args['div_attributes']);
        } else {
            $imageCta = owAcfImageHtmlWithLink($args['image_array'], $args['link'], $args['image_attributes'], $args['link_attributes']);
        }
        return $imageCta;
    }
}

if (!function_exists('owAcfCtaOverlay')) {

    function owAcfCtaOverlay($args = array())
    {
        $argsDefaults = array(
            'heading'             => false,
            'description'         => false,
            'cta_text'            => false,
            'cta_link'            => false,
            'bootstrap_container' => false,
        );
        $args       = array_merge($argsDefaults, $args);
        $ctaOverlay = '';
        if ($args['heading'] or $args['description'] or $args['cta_text']) {
            $ctaOverlay .= '<div class="image-cta-overlay-overlay hidden-xs hidden-sm">';
            if ($args['bootstrap_container']) {
                $ctaOverlay .= '<div class="container">';
            }
            $ctaOverlay .= '<div class="image-cta-overlay-overlay-container">';
            if ($args['heading']) {
                $ctaOverlay .= '<div class="image-cta-overlay-overlay-heading">';
                $ctaOverlay .= $args['heading'];
                $ctaOverlay .= '</div>';
            }
            if ($args['description']) {
                $ctaOverlay .= '<div class="image-cta-overlay-overlay-description">';
                $ctaOverlay .= $args['description'];
                $ctaOverlay .= '</div>';
            }
            if ($args['cta_text']) {
                $ctaOverlay .= '<div class="image-cta-overlay-overlay-cta">';
                if ($args['cta_link']) {
                    $ctaOverlay .= '<a href="' . $args['cta_link'] . '" title="' . $args['cta_text'] . '" class="image-cta-overlay-overlay-cta-link">';
                }
                $ctaOverlay .= '<span class="image-cta-overlay-overlay-cta-text">' . $args['cta_text'] . '</span>';
                if ($args['cta_link']) {
                    $ctaOverlay .= '</a>';
                }
                $ctaOverlay .= '</div>';
            }
            $ctaOverlay .= '</div>';
            if ($args['bootstrap_container']) {
                $ctaOverlay .= '</div>';
            }
            $ctaOverlay .= '</div>';
        }
        return $ctaOverlay;
    }
}

if (!function_exists('owAcfGetImageCta')) {

    function owAcfGetImageCta($args = array())
    {
        $argsDefaults = array(
            'field_name'       => false,
            'post_id'          => false,
            'get_sub_field'    => false,
            'image_attributes' => array(),
            'link_attributes'  => array(),
            'div_attributes'   => array(),
        );
        $args         = array_merge($argsDefaults, $args);
        $argsDefaults = array();
        $imageCta     = false;
        if ($args['field_name']) {
            if ($args['get_sub_field']) {
                $argsDefaults['image_array'] = get_sub_field($args['field_name'] . '_image');
                $argsDefaults['link']        = get_sub_field($args['field_name'] . '_link');
                $getImageAttributes          = get_sub_field($args['field_name'] . '_image_attributes');
                $getLinkAttributes           = get_sub_field($args['field_name'] . '_link_attributes');
                $getDivAttributes            = get_sub_field($args['field_name'] . '_div_attributes');
            } else {
                $argsDefaults['image_array'] = get_field($args['field_name'] . '_image', $args['post_id']);
                $argsDefaults['link']        = get_field($args['field_name'] . '_link', $args['post_id']);
                $getImageAttributes          = get_field($args['field_name'] . '_image_attributes', $args['post_id']);
                $getLinkAttributes           = get_field($args['field_name'] . '_link_attributes', $args['post_id']);
                $getDivAttributes            = get_field($args['field_name'] . '_div_attributes', $args['post_id']);
            }
            $args = array_merge($argsDefaults, $args);
            if ($getImageAttributes) {
                $getImageAttributesArray = array();
                $getImageAttributes      = explode(';', trim($getImageAttributes));
                foreach ($getImageAttributes as $getImageAttribute) {
                    $getImageAttribute                              = explode('|', trim($getImageAttribute));
                    $getImageAttributesArray[$getImageAttribute[0]] = trim($getImageAttribute[1]);
                }
                $args['image_attributes'] = array_merge($getImageAttributesArray, $args['image_attributes']);
            }
            if ($getLinkAttributes) {
                $getLinkAttributesArray = array();
                $getLinkAttributes      = explode(';', trim($getLinkAttributes));
                foreach ($getLinkAttributes as $getLinkAttribute) {
                    $getLinkAttribute                             = explode('|', trim($getLinkAttribute));
                    $getLinkAttributesArray[$getLinkAttribute[0]] = trim($getLinkAttribute[1]);
                }
                $args['link_attributes'] = array_merge($getLinkAttributesArray, $args['link_attributes']);
            }
            if ($getDivAttributes) {
                $getDivAttributesArray = array();
                $getDivAttributes      = explode(';', trim($getDivAttributes));
                foreach ($getDivAttributes as $getDivAttribute) {
                    $getDivAttribute                            = explode('|', trim($getDivAttribute));
                    $getDivAttributesArray[$getDivAttribute[0]] = trim($getDivAttribute[1]);
                }
                $args['div_attributes'] = array_merge($getDivAttributesArray, $args['div_attributes']);
            }
            $imageCta = owAcfImageCta($args);
            if ($imageCta) {
                $ctaOverlay             = false;
                $ctaOverlayArgsDefaults = false;
                if ($args['get_sub_field']) {
                    $ctaOverlay = get_sub_field($args['field_name'] . '_overlay');
                    if ($ctaOverlay) {
                        $ctaOverlayArgsDefaults                        = array();
                        $ctaOverlayArgsDefaults['heading']             = get_sub_field($args['field_name'] . '_overlay_heading');
                        $ctaOverlayArgsDefaults['description']         = get_sub_field($args['field_name'] . '_overlay_description');
                        $ctaOverlayArgsDefaults['cta_text']            = get_sub_field($args['field_name'] . '_overlay_cta_text');
                        $ctaOverlayArgsDefaults['cta_link']            = get_sub_field($args['field_name'] . '_overlay_cta_link');
                        $ctaOverlayArgsDefaults['bootstrap_container'] = get_sub_field($args['field_name'] . '_overlay_bootstrap_container');
                    }
                } else {
                    $ctaOverlay = get_field($args['field_name'] . '_overlay', $args['post_id']);
                    if ($ctaOverlay) {
                        $ctaOverlayArgsDefaults                        = array();
                        $ctaOverlayArgsDefaults['heading']             = get_field($args['field_name'] . '_overlay_heading', $args['post_id']);
                        $ctaOverlayArgsDefaults['description']         = get_field($args['field_name'] . '_overlay_description', $args['post_id']);
                        $ctaOverlayArgsDefaults['cta_text']            = get_field($args['field_name'] . '_overlay_cta_text', $args['post_id']);
                        $ctaOverlayArgsDefaults['cta_link']            = get_field($args['field_name'] . '_overlay_cta_link', $args['post_id']);
                        $ctaOverlayArgsDefaults['bootstrap_container'] = get_field($args['field_name'] . '_overlay_bootstrap_container', $args['post_id']);
                    }
                }
                if ($ctaOverlay and is_array($ctaOverlayArgsDefaults)) {
                    $imageCtaWithOverlay = '<div class="image-cta-overlay-container">';
                    $imageCtaWithOverlay .= owAcfCtaOverlay($ctaOverlayArgsDefaults);
                    $imageCtaWithOverlay .= '<div class="image-cta-overlay-image">' . $imageCta . '</div>';
                    $imageCtaWithOverlay .= '</div>';
                    $imageCta = $imageCtaWithOverlay;
                }
            }
        }
        return $imageCta;
    }
}

if (!function_exists('owAcfGetCtasFromRepeater')) {

    function owAcfGetCtasFromRepeater($args = array())
    {
        $argsDefaults = array(
            'repeater_field_name'           => false,
            'field_name'                    => false,
            'post_id'                       => false,
            'repeater_container_element'    => 'ul',
            'repeater_container_attributes' => array(),
            'repeater_item_element'         => 'li',
            'repeater_item_attributes'      => array(),
            'get_sub_field'                 => true,
        );
        $args                   = array_merge($argsDefaults, $args);
        $ctasFromRepeaterReturn = false;
        $ctasFromRepeater       = '';
        if ($args['repeater_field_name'] and $args['field_name'] and get_field($args['repeater_field_name'], $args['post_id'])) {
            $ctasFromRepeater .= '<' . $args['repeater_container_element'];
            foreach ($args['repeater_container_attributes'] as $repeaterContainerAttributeKey => $repeaterContainerAttributeValue) {
                $ctasFromRepeater .= ' ' . $repeaterContainerAttributeKey . '="' . $repeaterContainerAttributeValue . '"';
            }
            $ctasFromRepeater .= '>';
            while (has_sub_field($args['repeater_field_name'], $args['post_id'])) {
                $owAcfGetImageCta = owAcfGetImageCta($args);
                if ($owAcfGetImageCta) {
                    $ctasFromRepeaterReturn = true;
                    $ctasFromRepeater .= '<' . $args['repeater_item_element'];
                    foreach ($args['repeater_item_attributes'] as $repeaterItemAttributeKey => $repeaterItemAttributeValue) {
                        $ctasFromRepeater .= ' ' . $repeaterItemAttributeKey . '="' . $repeaterItemAttributeValue . '"';
                    }
                    $ctasFromRepeater .= '>';
                    $ctasFromRepeater .= $owAcfGetImageCta;
                    $ctasFromRepeater .= '</' . $args['repeater_item_element'] . '>';
                }
            }
            $ctasFromRepeater .= '</' . $args['repeater_container_element'] . '>';
        }
        if ($ctasFromRepeaterReturn) {
            return $ctasFromRepeater;
        }
        return $ctasFromRepeaterReturn;
    }
}

if (!function_exists('owAcfSliderFromGallery')) {

    function owAcfSliderFromGallery($args = array())
    {
        $argsDefaults = array(
            'gallery_array'               => array(),
            'image_link'                  => 'self',
            'image_link_attributes'       => array(),
            'image_attributes'            => array(),
            'slider_container_element'    => 'ul',
            'slider_container_attributes' => array(),
            'slider_item_element'         => 'li',
            'slider_item_attributes'      => array(),
        );
        $args       = array_merge($argsDefaults, $args);
        $sliderHtml = false;
        if (count($args['gallery_array']) > 0) {
            $sliderHtml = '';
            $sliderHtml .= '<' . $args['slider_container_element'];
            foreach ($args['slider_container_attributes'] as $silderContainerAttributeKey => $silderContainerAttributeValue) {
                $sliderHtml .= ' ' . $silderContainerAttributeKey . '="' . $silderContainerAttributeValue . '"';
            }
            $sliderHtml .= '>';
            foreach ($args['gallery_array'] as $galleryImage) {
                $sliderHtml .= '<' . $args['slider_item_element'];
                foreach ($args['slider_item_attributes'] as $silderItemAttributeKey => $silderItemAttributeValue) {
                    $sliderHtml .= ' ' . $silderItemAttributeKey . '="' . $silderItemAttributeValue . '"';
                }
                $sliderHtml .= '>';
                $imageLink = false;
                if ($args['image_link'] == 'self') {
                    $imageLinkImageArray = $galleryImage;
                    if (isset($args['image_link_attributes']['bfi_thumb_options'])) {
                        $imageLinkImageArray = owAcfImageBfiThumbResize($imageLinkImageArray, $args['image_link_attributes']['bfi_thumb_options']);
                        unset($args['image_link_attributes']['bfi_thumb_options']);
                    }
                    $imageLink = $imageLinkImageArray['url'];
                } elseif ($args['image_link']) {
                    $imageLink = $args['image_link'];
                }
                $sliderHtml .= owAcfImageHtmlWithLink($galleryImage, $imageLink, $args['image_attributes'], $args['image_link_attributes']);
                $sliderHtml .= '</' . $args['slider_item_element'] . '>';
            }
            $sliderHtml .= '</' . $args['slider_container_element'] . '>';
        }
        return $sliderHtml;
    }
}
