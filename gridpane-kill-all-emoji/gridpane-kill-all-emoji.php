<?php

function kill_emojis_kill_them_with_fire() {

    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

    add_filter( 'tiny_mce_plugins', 'kill_emojis_in_tinymce' );
    add_filter( 'wp_resource_hints', 'kill_emojis_in_dns_prefetch', 10, 2 );
    
}
add_action( 'init', 'kill_emojis_kill_them_with_fire' );


function kill_emojis_in_tinymce( $plugins ) {

    if ( is_array( $plugins ) ) {

        return array_diff( $plugins, array( 'wpemoji' ) );

    } else {

        return array();

    }

}

function kill_emojis_in_dns_prefetch( $urls, $relation_type ) {

    if ( 'dns-prefetch' == $relation_type ) {
 
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }

    return $urls;

}