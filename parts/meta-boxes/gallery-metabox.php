<?php
/*
Title: Image Gallery
Post Type: page,post,events,tvvideo,faculty,classes
Description: Metabox to load all the pictures in the gallery. Just upload all the pictures and the magic occur in the theme
Priority: high
Order: 3
*/

piklist('field', array(
    'type' => 'file'
,'field' => 'imgd_gallery_images' // Use this field to match WordPress featured image field name.
,'scope' => 'post_meta'
,'options' => array(
        'title' => __('Set image(s) for the gallery', 'imgd')
    ,'button' => __('Load Gallery Images', 'imgd')
    )
));