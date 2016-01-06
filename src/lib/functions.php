<?php
/**
 * CORE wordpress functions.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\WPPluginCore
 * @version 1.2
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

if ( ! function_exists( 'theme_basename' ) ) {
    /**
     * Returens basename / relative path of a theme file.
     * @since 1.2
     *
     * @param string $file File path.
     *
     * @return string
     */
    function theme_basename( $file )
    {
        return trim( preg_replace(
            '#^' . preg_quote( wp_normalize_path( get_template_directory() ), '#' ) . '/#',
            '',
            wp_normalize_path( $file )
        ) , '/');
    }
}

if ( ! function_exists( 'theme_url' ) ) {
    /**
     * Returns the url based on the relative path and file passed by.
     * @since 1.2
     *
     * @param string $path  Relative path.
     * @param string $theme Theme file.
     *
     * @return string
     */
    function theme_url( $path, $theme )
    {
        $path = wp_normalize_path( $path );
        $url = get_template_directory_uri();

        if ( !empty($theme) && is_string($theme) ) {
            $folder = dirname(theme_basename($theme));
            if ( '.' != $folder )
                $url .= '/' . ltrim($folder, '/');
        }

        if ( $path && is_string( $path ) )
            $url .= '/' . ltrim($path, '/');

        return $url;
    }
}

if ( ! function_exists( 'asset_url' ) ) {
    /**
     * Returns url of asset located in a theme or plugin.
     * @since 1.1
     *
     * @param string  $path Asset relative path.
     * @param string  $file File location path.
     *
     * @return string URL
     */
    function asset_url( $path, $file )
    {
        $url = home_url( '/' );
        if ( preg_match( '/plugins/', $file ) )
            $url = plugins_url( $path , $file );
        if ( preg_match( '/themes/', $file ) )
            $url = theme_url( $path , $file );
        return $url;
    }
}
