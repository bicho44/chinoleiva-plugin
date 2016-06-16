<?php
/*
Title: Home Page Preferences
Post Type: page,post,portfolio_project
Description: Options to use the post at Home Page
Priority: high
Order: 3
Context: side
*/

piklist('field',
    array(
        'type' => 'radio'
    , 'scope' => 'post_meta' // Not used for settings sections
    , 'field' => 'imgd_slideshow'
    , 'value' => 'no' // Sets default to Option 2
    , 'label' => __('Home Page', 'imgd')
    , 'help' => __('Publish this post on the home Page', 'imgd')
    , 'attributes' => array(
        'class' => 'radio'
    )
    , 'position' => 'start'
    , 'choices' => array(
        'yes' => __('Yes', 'imgd')
        , 'no' => __('No', 'imgd')
    )
    ));

piklist('field', array(
    'type' => 'file'
    , 'field' => 'imgd_image_slideshow' // Use these field to match WordPress featured images.
    , 'scope' => 'post_meta'
    , 'label' => __('Imagen SlideShow', 'imgd')
    , 'help' => __('Ingrese la Imagen para el Slideshow', 'imgd')
    , 'conditions' => array(
            array(
                'field' => 'imgd_slideshow'
                ,'value' => 'yes'
            )
        )
    , 'options' => array(
            'title' => __('Image to be showed at Home Page', 'imgd')
        , 'modal_title' => __('Add Image', 'imgd')
        , 'button' => __('Add Image', 'imgd')
        , 'basic' => true
        ),
    'validate' => array(
        array(
            'type' => 'limit'
            ,'options' => array(
                'min' => 0
                ,'max' => 1
            )
        , 'message' => __('Limit 1 image', 'imgd')
        )
    )
));