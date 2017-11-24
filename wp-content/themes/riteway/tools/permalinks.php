<?php

header('Content-type:text/plain');
require_once( dirname( __FILE__ ) . '/../../../../wp-load.php' );

$posts = new WP_Query('post_type=any&posts_per_page=-1&post_status=publish&orderby=type');
$posts = $posts->posts;

foreach ($posts as $post) {
    switch ($post->post_type) {
        case 'revision':
        case 'nav_menu_item':
            break;
        case 'page':
            $permalink = get_page_link($post->ID);
            break;
        case 'post':
            $permalink = get_permalink($post->ID);
            break;
        case 'attachment':
            $permalink = get_attachment_link($post->ID);
            break;
        default:
            $permalink = get_post_permalink($post->ID);
            break;
    }
    echo "\n{$post->post_type}\t\t{$permalink}\t\t{$post->post_title}";
}

