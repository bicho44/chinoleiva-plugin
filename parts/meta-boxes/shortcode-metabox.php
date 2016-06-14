<?php
/*
Title: Page Attributes
Post Type: page
Description: Option to put a revolution slider shorcode. Remember to use the page Template "Page with slider" in the Page options MetaBox. If yo dont do this the slider do not gone a shown
Order: 10
Collapse: false
Context: side

Template: page-con-sliders

Extend: pageparentdiv
Extend Method: after
*/


piklist('field', array(
    'type' => 'text'
    ,'field' => 'imgd_revolution_shortcode'
    ,'label' => __('Revolution ShortCode', 'imgd')
    ,'description' => __('Please enter the Revolution shortcode','imgd')
    ,'attributes' => array(
        'placeholder' => 'home'
        )
));