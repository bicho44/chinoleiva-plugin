<?php
/**
 * Listado de Funciones para incluir cosas en el plug-in
 * 
 * User: bicho44
 * Date: 6/2/16
 * Time: 8:06 PM
 */

$chinosettings = get_option('chinoleiva_settings');


if (!function_exists('imgd_has_slideshow_thumbnail')) {
	/**
	 * Verifica que haya imagen en el SlideShow
	 *
	 * @param null $post
	 * @return bool
	 */
	function imgd_has_slideshow_thumbnail($post = null)
	{
		return (bool)imgd_get_slideshow_thumbnail_id($post);
	}

}

if (!function_exists('imgd_get_slideshow_thumbnail_id')) {
	/**
	 * Retrieve SlideShow Image thumbnail ID.
	 *
	 * @since 2.9.0
	 * @since 4.4.0 `$post` can be a post ID or WP_Post object.
	 *
	 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global `$post`.
	 * @return string|int Post thumbnail ID or empty string.
	 */
	function imgd_get_slideshow_thumbnail_id($post = null)
	{
		$post = get_post($post);
		if (!$post) {
			return '';
		}
		return get_post_meta($post->ID, 'imgd_image_slideshow', true);
	}
}


/**
 * IMGD slideshow items
 * Obtain the posts who have images to the slide show
 *
 * @return object WP_Query
 */
function imgd_slideshow_items(){
    // Acá seleciono las Páginas que voy a mostrar en la Home
    /*$args = array('post_type' => array( 'post', 'page', 'portfolio_project'),
                  'meta_key' => 'imgd_slideshow',
                  'meta_value' => 'yes',
                  'post_status' => 'publish',
                  'post_per_pag' => -1,
    );*/
	
	$args = array('post_type' => array('post', 'page','portfolio_project'),
	              'post_status' => 'publish',
	              'post_per_page' => -1,
	              'order'=>'ASC',
	              'meta_query' => array(
		              array(
			              'key' => 'imgd_slideshow',
			              'value' => 'yes'
		              ),
	              ),
	);

	$loop = new WP_Query($args);

    return $loop;
}


function imgd_get_image_src($postID){

    $data = array();
    /* Obtengo el URL de la imagen principal */
    $post_thumbnail_id = imgd_get_slideshow_thumbnail_id($postID);
    $html = wp_get_attachment_image_src($post_thumbnail_id, 'full-cropped');

    $data['url']    = $html[0];
    $data['title']  = "";

    return $data;

}

function imgd_get_supersized_images(){

    $loop = imgd_slideshow_items();

    $images="NO HAY IMAGENES";

    if ($loop->have_posts()){

	    $images = "<script type=\"text/javascript\">\n";
	    $images .= "jQuery(function($){\n";

	    $images .= "$.supersized({\n";

	    $images .= "autoplay                :	1,\n";
	    $images .= "slide_interval          :   3000,\n";
	    $images .= "transition              :   1,\n" ;			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
	    $images .= "transition_speed		:	700,\n";		// Speed of transition


	    $images .= "\n\t\t slides               :  	[\n ";//{image : 'kazvan-1.jpg', title : 'Image Credit: Maria Kazvan'}

		$x = 0;

        while ($loop->have_posts()) : $loop->the_post();

            if (imgd_has_slideshow_thumbnail()){
                $data = imgd_get_image_src(get_the_ID());
	            //var_export($data);
	            if ($x!=0) $images .= ", \n";

                $images .= "{image : '".$data['url']."', 
                            title: '".get_the_title()."', 
                            url: '".get_the_permalink()."'} ";

	            $x++;
            }

        endwhile;

	    $images .= " \n]\n\n});";
	    $images .= "\n });";
	    $images .= "\n</script>";
    }

    echo $images;
}
//var_dump($chinosettings['imgd_display_slideshow']);

if (is_front_page() && ($chinosettings['imgd_display_slideshow'][0]==="fullscreen") ) {

	add_action('wp_head', 'imgd_get_supersized_images', 10);
	add_action('wp_enqueue_scripts', 'imgd_supersized_js');

}

/**
 * Enqueue the Admin CSS
 */
/*function imgd_setting_css()
{
    wp_register_style('imgd-settings-css', plugins_url( '../assets/css/abby_settings_admin.css', __FILE__ ));
    wp_enqueue_style('imgd-settings-css');
}
*/

/**
 * Enqueue full screen slider js
 */
function imgd_supersized_js(){
    imgd_supersized_css();
    // Scripts from Bootstrap
    wp_enqueue_script( 'supersized', IMGD_PLUGIN_PATH.'assets/js/vendor/supersized.min.js', array( 'jquery' ), '3.2.7', false );
	wp_enqueue_script( 'easing', IMGD_PLUGIN_PATH.'assets/js/vendor/jquery.easing.min.js', array( 'jquery' ), '3.2.7', false );
}

/**
 * Enqueue full screen slider css
 */
function imgd_supersized_css(){
    wp_register_style('imgd-supersized-css', plugins_url( '../assets/css/supersized.min.css', __FILE__ ), array('imgdigital-style'));
    wp_enqueue_style('imgd-supersized-css');
}


/**
 * Retrieve Image thumbnail ID.
 *
 * @since 2.9.0
 * @since 4.4.0 `$post` can be a post ID or WP_Post object.
 *
 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global `$post`.
 * @param string $meta Meta data a buscar
 * @return string|int Meta ID or empty string.
 */
function imgd_get_meta_id( $post = null, $meta = 'imgd_image_slideshow' ) {

    $post = get_post( $post );
    if ( ! $post ) {
        return '';
    }

    return get_post_meta( $post->ID, $meta , true );
}

/**
 * Get Image Home Page
 * Returns an IMAGE URL if exist.
 *
 * @param $post
 * @param string $meta Post Meta for the IMAG
 * @param string $thumbsize
 * @param string $posttype
 * @return false|string
 */
function get_imgd_imagen_home($post, $meta='imgd_slideshow', $thumbsize='thumbnail', $posttype=""){

    $imageID=array();
    $path = "";

    if ($meta=='') $meta='imgd_slideshow';
    if ($thumbsize=='') $meta='thumbnail';

    $post = get_post( $post );

    if ( ! $post ) {
        return '';
    }

    $imageID = get_post_meta( $post->ID, $meta, true );

    //piklist::pre($imageID);

    if (!empty($imageID)){
        return wp_get_attachment_url($imageID, $thumbsize);

    } else {

        if($posttype!="") {
            $imageID = get_post_meta($post->ID, $posttype);
            if (!empty($imageID))
                return thumb($imageID[0]['path']);
        }

        if (has_post_thumbnail($post->ID)) {
            return get_the_post_thumbnail_url($post->ID, $thumbsize);

        }
    }
}

/**
 * Get Promo Title
 * Retrive the Promotional Title if is in use. If not return the Post Title.
 *
 * @param $post The Post
 * @return mixed|string Title Promotional or Post Title
 */
function get_promo_title($post){

    $post = get_post( $post );

    if ( ! $post ) {
        return '';
    }

    $title = get_post_meta( $post->ID, 'imgd_destacado_title', true );

    if (empty($title)){
        $title = get_the_title($post->ID);
    }

    return $title;

}

// check if the options are different from the saved
/**
 * @todo Make it work because right now is bogus
 */
function imgd_set_thumbanils_sizes(){
    $thw = 320;
    $thh = 240;
    $flw = 800;
    $flh = 600;

    $settings = get_option('abbylee_settings');

    $gr = $settings['gallery_group'];

    $thw = $gr['imgd_image_thumb_w'];
    $thh = $gr['imgd_image_thumb_w'];
    $flw = $gr['imgd_image_big_w'];
    $flh = $gr['imgd_image_big_h'];

    add_image_size('full-gallery', $flw, $flh, true);
    add_image_size('thumb-gallery', $thw, $thh, true);
}

add_image_size('full-gallery', 800, 600, true);
add_image_size('thumb-gallery', 150, 150, true);


function imgd_check_gallery($postid, $metadata = 'imgd_gallery_images' ){

    //$post = get_post( $post );

    if ( ! $postid ) {
        return '';
    }

    $image_ids = get_post_meta($postid, $metadata);

    if (!$image_ids) return false;

    return $image_ids;
}

function imgd_get_images_from_gallery($image_ids=array()){

    if (empty($image_ids))
        return '';

    $data = '<div  id="gallery-page" class="gallery">' ;
    foreach ($image_ids as $image)
    {
        $myupload = get_post($image);
        $title = $myupload->post_title;
        $description = $myupload->post_content;
        $caption = $myupload->post_excerpt;


        $data .= '<dl class="gallery-item">
			<dt class="gallery-icon">';

        $big = wp_get_attachment_image_src( $image, 'full-gallery' );

        $data .= '<a href="'.$big[0].'" >';

        $data .= wp_get_attachment_image( $image, 'thumb-gallery' );

        //$data .= '<img src="' . wp_get_attachment_url($image) . '" alt="'.$title.'" />';
        /*<a href="http://wp.loc/wp-content/uploads/2016/05/IMG_9356.jpg">
                <img src="http://wp.loc/wp-content/uploads/2016/05/IMG_9356-169x300.jpg"
        class="attachment-medium size-medium" alt="IMG_9356"
        srcset="http://wp.loc/wp-content/uploads/2016/05/IMG_9356-169x300.jpg 169w, 
        http://wp.loc/wp-content/uploads/2016/05/IMG_9356-768x1367.jpg 768w, 
        http://wp.loc/wp-content/uploads/2016/05/IMG_9356-575x1024.jpg 575w, 
        http://wp.loc/wp-content/uploads/2016/05/IMG_9356-253x450.jpg 253w, 
        http://wp.loc/wp-content/uploads/2016/05/IMG_9356-197x350.jpg 197w"
        sizes="(max-width: 169px) 100vw, 169px" height="300" width="169">
        </a>*/
        $data .='</a>';
        $data .= '	</dt>
        </dl>';

    }
    $data .= '<br style="clear: both">
		</div>';

    return $data;
}

add_filter('get_the_archive_title', function ($title) {
    return preg_replace('/^\w+: /', '', $title);
});