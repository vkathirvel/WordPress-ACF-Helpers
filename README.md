# WordPress ACF Helpers

```
$args = array(
    'field_name' => 'test', // Required. All ACF fields will start with this value and followed by an underscore and value.
    //'post_id' => FALSE, // Optional. Used to get the image of a specific post_id. post_id is not used when get_sub_field is set to TRUE.
    //'get_sub_field' => FALSE, // Optional. Used when accessing repeater subfields.
    //'image_array' => FALSE, // Optional. Provide an ACF image array to override the automagic get_field('field_name_image').
    //'link' => FALSE, // Optional. Provide a text link to override the automagic get_field('field_name_link').
    //'image_attributes' => array(), // Optional. Provide an array as key value pairs to merge over the automagic get_field('field_name_image_attributes'). e.g. array('id' => 'someid', 'class' => 'someclass').
    //'link_attributes' => array(), // Optional. Provide an array as key value pairs to merge over the automagic get_field('field_name_link_attributes'). e.g. array('id' => 'someid', 'class' => 'someclass').
    //'div_attributes' => array(), // Optional. Provide an array as key value pairs to merge over the automagic get_field('field_name_div_attributes'). e.g. array('id' => 'someid', 'class' => 'someclass').
);
```

```
$args['image_attributes']['bfi_thumb_options'] = array('width' => 600);
```

```
$args['image_attributes']['image_size'] = 'medium';
```

```
$args['image_attributes']['srcset_images'] = TRUE;
```

```
$args['image_attributes']['width'] = 700;
$args['image_attributes']['height'] = 300;
```

```
$args = array(
    'repeater_field_name' => 'some_repeater',
    //'repeater_container_element' => 'ul', // Optional. 'ul' by default.
    //'repeater_container_attributes' => array(), // Optional. Provide an array as key value pairs. e.g. array('id' => 'someid', 'class' => 'someclass')
    //'repeater_item_element' => 'li', // Optional. 'li' by default.
    //'repeater_item_attributes' => array(), // Optional. Provide an array as key value pairs. e.g. array('id' => 'someid', 'class' => 'someclass')
    'field_name' => 'test', // Required. All ACF fields will start with this value and followed by an underscore and value.
    //'post_id' => FALSE, // Optional. Used to get the image of a specific post_id. post_id is not used when get_sub_field is set to TRUE.
    'get_sub_field' => TRUE, // Required. Used when accessing repeater subfields.
    //'image_array' => FALSE, // Optional. Provide an ACF image array to override the automagic get_field('field_name_image').
    //'link' => FALSE, // Optional. Provide a text link to override the automagic get_field('field_name_link').
    //'image_attributes' => array(), // Optional. Provide an array as key value pairs to merge over the automagic get_field('field_name_image_attributes'). e.g. array('id' => 'someid', 'class' => 'someclass').
    //'link_attributes' => array(), // Optional. Provide an array as key value pairs to merge over the automagic get_field('field_name_link_attributes'). e.g. array('id' => 'someid', 'class' => 'someclass').
    //'div_attributes' => array(), // Optional. Provide an array as key value pairs to merge over the automagic get_field('field_name_div_attributes'). e.g. array('id' => 'someid', 'class' => 'someclass').
);
```

```
$args['image_attributes']['layered_image_options'] = array(
    'container_div_attributes' => array('class' => 'layered-image-container'),
    'image_div_attributes' => array('class' => 'layered-image-image'),
    'bootstrap_container' => FALSE,
    'caption_element' => 'div',
    'caption_div_attributes' => array('class' => 'layered-image-caption'),
    'description_element' => 'div',
    'description_div_attributes' => array('class' => 'layered-image-description'),
);
```

```
echo owAcfGetImageCta($args);
```

```
echo owAcfGetCtasFromRepeater($args);
```
