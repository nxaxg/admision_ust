<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?> data-path="<?php bloginfo('template_directory'); ?>/">
    <?php
        // codigo de GTM
        echo get_field('codigo_gtm', 'options');
        do_action('print_conversion_code');
    ?>
