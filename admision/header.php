<?php require_once( "meta-header.php" ); ?>
<header id="main-header" class="main-header">
    <section class="hide-on-vertical-tablet-down bg-corporativo">
        <div class="container">
            <div class="top-bar-menu" data-name="sitios-santo-tomas">
                <?php
                    if( $sitios_santo_tomas = get_field('sitios_santo_tomas', 'options') ){
                        echo '<div class="top-bar-menu-items-holder columns-list" data-area-name="desktop-sitios" >';

                        echo '<ul id="sitios-list" class="top-bar-menu-list" data-mutable="vertical-tablet-down" data-desktop-area="desktop-sitios" data-mobile-area="mobile-sitios" >';

                        foreach( $sitios_santo_tomas as $sitio ){
                            echo '<li><a href="'. ensure_url( $sitio['url_sitio'] ) .'" title="Ver sitio" rel="external nofollow">'. $sitio['nombre_sitio'] .'</a></li>';
                        }

                        echo '</ul>';

                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </section>
    <section id="menu-top" class="menu-top bg-corporativo dark hide-on-vertical-tablet-down" >
        <div class="container">
            <div class="grid-3 no-gutter-left">
                <button id="topbartoggle" class="top-bar-toggle" data-func="toggleTarget" data-target='[data-name="sitios-santo-tomas"], #topbartoggle'>Sitios Santo Tomás</button>
            </div>
            <div class="grid-9 no-gutter-right righted-text" data-area-name="menu-socials-desktop">
                <a class="menu-top-link icon email" href="<?php echo get_link_by_slug('contacto'); ?>" title="Contáctanos">Contáctanos</a>
                <a class="menu-top-link icon chat" href="<?php echo get_link_by_slug('te-llamamos'); ?>" title="¿Tienes dudas? Te llamamos">¿Tienes dudas? Te llamamos</a>
                <a class="menu-top-link icon phone" href="tel:6004444444" title="Llámanos">600 444 4444</a>

                <?php $perfiles = get_social_links(); ?>
                <a href="<?php echo ensure_url( $perfiles['facebook'] ); ?>" target="_blank" rel="help external" title="Ver Perfil de facebook" class="social-square-link facebook" data-mutable="vertical-tablet-down" data-desktop-area="menu-socials-desktop" data-mobile-area="menu-socials-mobile" data-order="1" data-track data-gtm-event="facebook" data-gtm-eventcategory="conversemos-fb" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-facebook" >Facebook</a>
                <a href="<?php echo ensure_url( $perfiles['twitter'] ); ?>" target="_blank" rel="help external" title="Ver Perfil de twitter" class="social-square-link twitter" data-mutable="vertical-tablet-down" data-desktop-area="menu-socials-desktop" data-mobile-area="menu-socials-mobile" data-order="2" data-track data-gtm-event="twitter" data-gtm-eventcategory="conversemos-tw" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-twitter"  >Twitter</a>
                <a href="<?php echo ensure_url( $perfiles['youtube'] ); ?>" target="_blank" rel="help external" title="Ver Perfil de youtube" class="social-square-link youtube" data-mutable="vertical-tablet-down" data-desktop-area="menu-socials-desktop" data-mobile-area="menu-socials-mobile" data-order="3" data-track data-gtm-event="youtube" data-gtm-eventcategory="conversemos-yt" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-youtube" >Youtube</a>
                <a href="<?php echo ensure_url( $perfiles['instagram'] ); ?>" target="_blank" rel="help external" title="Ver Perfil de instagram" class="social-square-link instagram" data-mutable="vertical-tablet-down" data-desktop-area="menu-socials-desktop" data-mobile-area="menu-socials-mobile" data-order="4" data-track data-gtm-event="instagram" data-gtm-eventcategory="conversemos-it" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-instagram" >Instagram</a>
            </div>
        </div>
    </section>
    <section class="header-body" >
        <button class="mobile-deployer nav-deployer" title="Mostrar menú principal" data-func="deployMainNav" >
            <span></span>
        </button>

        <div class="container">
            <nav id="secondary-nav" class="secondary-nav righted-text hide-on-vertical-tablet-down" data-area-name="menu-sec-desktop">
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'secundario',
                        'menu_class' => 'secondary-nav-items',
                        'items_wrap' => '<ul id="%1$s" class="%2$s" data-mutable="vertical-tablet-down" data-desktop-area="menu-sec-desktop" data-mobile-area="menu-sec-mobile" data-order="1" >%3$s</ul>'
                    ));
                ?>
            </nav>
 
            <?php
                $home_type = get_field('version_inicio', 'option');
            ?>

            <a id="logo-holder" class="logo-holder <?php echo $home_type; ?>" href="<?php echo home_url(); ?>" title="Ir a la página de inicio" rel="index">
                <?php
                    if( $home_type === 'admision' ){
                        $logo_general = '<img class="elastic-img cover hide-on-vertical-tablet-down hide-on-fixed" src="'. get_bloginfo('template_directory') .'/images/logos/logo-admision.svg" width="223" height="100">';

                        $logos = get_field('logotipos_admision', 'options');
                        if( !empty($logos) && !empty($logos[0]['logo_general']) ){
                            $logo_general = wp_get_attachment_image($logos[0]['logo_general'], 'full', false, ['class' => 'elastic-img cover hide-on-vertical-tablet-down hide-on-fixed editorial']);
                        }

                        echo $logo_general;
                    }
                    else {
                        echo '<img class="elastic-img cover hide-on-vertical-tablet-down hide-on-tablet-only hide-on-fixed" src="'. get_bloginfo('template_directory') .'/images/logos/logo-ust.svg" width="86" height="99">';
                        echo '<span class="text-logo">Admisión</span>';

                        echo '<img class="elastic-img cover logo-down-tablet" src="'. get_bloginfo('template_directory') .'/images/logos/logo-st-badge.svg" width="40" height="40" >';
                    }
                ?>

                <!-- <img class="elastic-img cover logo-down-tablet" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-st-badge.svg" width="40" height="40" > -->
                <img class="elastic-img cover logo-down" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-ust-horizontal.svg" width="195" height="39" >
            </a>

            <nav id="main-nav" class="main-nav">
                <ul class="main-nav-items" >
                    <?php
                        $home_type = get_field('version_inicio', 'option');

                        wp_nav_menu(array(
                            'theme_location' => 'principal_' . $home_type,
                            'menu_class' => 'main-nav-items',
                            'items_wrap' => '%3$s'
                        ));
                    ?>
                    <li><button class="show-main-form-btn <?php echo $home_type; ?> hide-on-vertical-tablet-down" title="Ver fomulario de cotización" data-func="deployHeaderForm">Consulta tu arancel Aquí</button></li>
                </ul>
                

                <div class="only-on-vertical-tablet-down" data-area-name="menu-sec-mobile"></div>

                <div class="mobile-help-holder only-on-vertical-tablet-down">
                    <?php echo get_help_links(); ?>
                </div>
                
                <div class="mobile-social-nav only-on-vertical-tablet-down" data-area-name="menu-socials-mobile"></div>
            </nav>
        </div>

        <div class="mobile-main-form-holder">
            <button id="mobile-form-deployer" class="show-main-form-btn only-on-vertical-tablet-down" title="Ver fomulario de cotización" data-func="deployHeaderForm">Consulta tu arancel Aquí</button>

            <div class="mobile-main-form-box bg-blanco collapsed-form" data-role="header-form" data-override-eq="true">
                <div class="container full-container" data-gtm-tag="cotizacion">
                    <?php
                        // prefijo para el formulario
                        $GLOBALS['cotizacion_prefix'] = 'header';
                        get_template_part('partials/formulario-cotizacion');
                    ?>
                </div>
            </div>
        </div>
    </section>
</header>