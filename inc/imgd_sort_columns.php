<?php
/**
 * Funciones para ordenar columnas
 *
 *
 * User: bicho44
 * Date: 6/8/16
 * Time: 10:43 AM
 *
 * @todo Hay problemas con el ordenamiento que filtra y no ordena. Ver que onda más adelante
 *
 */

// Register the column
function destacado_column_register( $columns ) {
    $columns['imgd_destacado'] = __( 'Home', 'imgd' );

    return $columns;
}
add_filter( 'manage_edit-post_columns', 'destacado_column_register' );

// Display the column content
function destacado_column_display( $column_name, $post_id ) {
    if ( 'imgd_destacado' != $column_name )
        return;

    $destacado = '<span class="dashicons dashicons-no-alt cancel"></span>';

    $esdestacado = get_post_meta($post_id, 'imgd_destacado', true);

    if ($esdestacado=='1' || $esdestacado=='yes'  ) {
        If ($esdestacado =='1') update_post_meta($post_id, 'imgd_destacado', 'yes');

        $destacado = '<span class="dashicons dashicons-yes accept" ></span>';
    }

    echo $destacado;
}
add_action( 'manage_posts_custom_column', 'destacado_column_display', 10, 2 );

// Register the column as sortable
function destacado_column_register_sortable( $columns ) {
    $columns['imgd_destacado'] = 'imgd_destacado';

    return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'destacado_column_register_sortable' );

function destacado_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'imgd_destacado' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'imgd_destacado',
            'orderby' => 'meta_value_num'
        ) );
    }

    return $vars;
}
add_filter( 'request', 'destacado_column_orderby' );