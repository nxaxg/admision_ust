<section class="content-box">
    <h2 class="content-box-title primario light">
        <span class="tag full">Información de interés</span>
    </h2>
    <div class="content-box-body">
        <?php
            wp_nav_menu(array(
                'theme_location' => 'interes_general',
                'menu_class' => 'regular-list',
                'items_wrap' => '<ul id="%1$s" class="%2$s" >%3$s</ul>'
            ));
        ?>
    </div>
</section>

<section class="content-box">
    <h2 class="content-box-title corporativo dark">
        <span class="tag full">¿Necesitas Ayuda?</span>
    </h2>
    <div class="content-box-body">
        <?php echo get_help_links('ayuda'); ?>
    </div>
</section>