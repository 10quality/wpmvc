<?php
/**
 * CORE wordpress functions.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\WPPluginCore
 * @version 1.0
 */

 if ( ! function_exists( 'resize_image' ) ) {
    /**
     * Resizes image and returns URL path.
     * @since 1.0
     *
     * @param string  $url    Image URL path
     * @param int     $width  Width wanted.
     * @param int     $height Height wanted.
     * @param boolean $crop   Flag that indicates if resulting image should crop
     *
     * @return string URL
     */
    function resize_image( $url, $width, $height, $crop = true )
    {
    	$image = wp_get_image_editor( $url );

    	if( is_wp_error( $image ) ) return;

    	$image_name = explode( '/', $url );
    	$image_name = explode( '.', $image_name[count( $image_name ) - 1] );
    	$image_extension = strtolower( $image_name[count( $image_name ) - 1] );
    	$image_name = $image_name[0];

    	$upload_dir = wp_upload_dir();

    	$filename = sprintf(
    		'/%s-%sx%s.%s',
    		$image_name,
    		$width,
    		$height,
    		$image_extension
    	);

    	$image->resize( $width, $height, $crop );
    	$image->save( $upload_dir['path'] . $filename );

    	return $upload_dir['url'] . $filename;
    }
 }
