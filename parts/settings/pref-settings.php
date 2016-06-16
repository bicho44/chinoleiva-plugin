<?php
/*
Title: Home Page Settings
Setting: chinoleiva_settings
Tab: Home
Order: 20
Default: True
Flow: Chino Leiva Settings
*/

/**
 * 1) Full Screen Slide Show
 * 2) SlideShow simple
 * 3) No Slide show
 * 3.1) Seleccionar categoría de catálogo
 * 4) Nada
 */

piklist('field', array(
	'type' => 'radio'
	,'field' => 'imgd_display_slideshow'
	,'label' => __('Activar Slide Show', 'imgd')
	,'value' => 'no'
	,'choices' => array(
		'fullscreen'    => __('A Toda Pantalla', 'imgd')
		,'hero'         => __('Slide Show simple', 'imgd')
		,'no'           => __('Sin SlideShow', 'imgd')
	)
));

