<?php
/*
Title: Home Page Preferences
Post Type: page,post,events,tvvideo,faculty,classes
Description: Options to use the post at Home Page
Priority: high
Order: 3
Context: side
*/

piklist('field',
    array(
        'type' => 'radio'
    , 'scope' => 'post_meta' // Not used for settings sections
    , 'field' => 'imgd_destacado'
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
    'type' => 'number'
    , 'scope' => 'post_meta'
    , 'field' => 'imgd_destacado_order'
    , 'value' => 1
    , 'label' => __('Post Order', 'imgd')
    , 'help' => __('Set the order where the post must be showed in the home page, the number must be 1 to 5 ', 'imgd')
    , 'conditions' => array(
            array(
                'field' => 'imgd_destacado'
                , 'value' => 'yes'
            )
        )
    , 'attributes' => array(
            'class' => 'small-text'
        )
));

piklist('field', array(
    'type' => 'text'
    , 'scope' => 'post_meta'
    , 'field' => 'imgd_destacado_title'
    , 'value' => ''
    , 'label' => __('Promotional Title (optional)', 'imgd')
    , 'help' => __('This is optional, and will be used as the title in the Home Page, if is empty, the Home will use the Post Title', 'imgd')
    , 'conditions' => array(
            array(
                'field' => 'imgd_destacado'
                ,'value' => 'yes'
            )
        )
    , 'attributes' => array(
            'class' => 'regular-text'
        )
));

piklist('field', array(
    'type' => 'file'
    , 'field' => 'imgd_destacado_image' // Use these field to match WordPress featured images.
    , 'scope' => 'post_meta'
    , 'label' => __('Promotional Image (optional)', 'imgd')
    , 'help' => __('Set the promotional Image to be used in the Home Page insted of the Feature Image.', 'imgd')
    , 'conditions' => array(
            array(
                'field' => 'imgd_destacado'
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