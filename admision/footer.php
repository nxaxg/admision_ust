    <section class="full-section standalone bg-complementario only-on-vertical-tablet-down">
        <button class="go-to-top-btn" data-func="goToTop">
            Ir arriba
        </button>
    </section>                        
    
    <footer id="main-footer" class="main-footer bg-primario">
        <section class="main-footer-section primary-section">
            <div class="container">
                <div class="grid-2 no-gutter-left grid-smalltablet-12 no-gutter-smalltablet">
                    <div class="footer-logo-holder">
                        <img class="elastic-img cover hide-on-vertical-tablet-down" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-ust.svg" alt="Logotipo Santo Tomás">

                        <img class="elastic-img cover only-on-vertical-tablet-down" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-ust-horizontal.svg" alt="Logotipo Santo Tomás">
                    </div>
                </div>
                <div class="grid-10 no-gutter-right hide-on-vertical-tablet-down">
                    <div class="grid-3 no-gutter-left">
                        <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer_principal',
                                'menu_class' => 'footer-nav-items',
                                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                            ));
                        ?>
                    </div>
                    <div class="grid-3">
                        <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer_secundario',
                                'menu_class' => 'footer-subnav-items',
                                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                            ));
                        ?>
                    </div>
                    <div class="grid-3">
                        <div class="footer-help">
                            <?php echo get_help_links(); ?>
                        </div>
                    </div>
                    <div class="grid-3 no-gutter-right">
                        <h3 class="footer-title">Redes Sociales</h3>
                        
                        <?php $perfiles = get_social_links(); ?>
                        <a href="<?php echo ensure_url( $perfiles['facebook'] ); ?>" rel="help external" title="Ver Perfil de facebook" class="footer-social-square-link facebook" target="_blank" data-track data-gtm-event="facebook" data-gtm-eventcategory="conversemos-fb" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-facebook">Facebook</a>
                        <a href="<?php echo ensure_url( $perfiles['twitter'] ); ?>" rel="help external" title="Ver Perfil de twitter" class="footer-social-square-link twitter" target="_blank" data-track data-gtm-event="twitter" data-gtm-eventcategory="conversemos-tw" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-twitter" >Twitter</a>
                        <a href="<?php echo ensure_url( $perfiles['youtube'] ); ?>" rel="help external" title="Ver Perfil de youtube" class="footer-social-square-link youtube" target="_blank" data-track data-gtm-event="youtube" data-gtm-eventcategory="conversemos-yt" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-youtube">Youtube</a>
                        <a href="<?php echo ensure_url( $perfiles['instagram'] ); ?>"  rel="help external" title="Ver Perfil de instagram" class="footer-social-square-link instagram" target="_blank" data-track data-gtm-event="instagram" data-gtm-eventcategory="conversemos-it" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-instagram">Instagram</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="main-footer-section secondary-section">
            <div class="container">
                <div class="footer-logos centered-text hide-on-vertical-tablet-down">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/comision-nacional-acreditacion.svg" alt="Logotipo Santo Tomás">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/acreditacion-universidad.svg" alt="Logotipo Santo Tomás">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/acreditacion-ip.svg" alt="Logotipo Santo Tomás">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/acreditacion-cft.svg" alt="Logotipo Santo Tomás">
                </div>
                <div class="footer-logos centered-text only-on-vertical-tablet-down">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/acreditacion-universidad-plus.svg" alt="Logotipo Santo Tomás">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/acreditacion-ip-plus.svg" alt="Logotipo Santo Tomás">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/acreditacion-cft-plus.svg" alt="Logotipo Santo Tomás">
                </div>
            </div>
        </section>
        <section class="main-footer-section bottom-section">
            <div class="container centered-text">
                <p class="footer-disclaimer">Derechos reservados Santo Tomás. Casa Central AV. Ejército 146, Barrio Universitario, Santiago.</p>
            </div>
        </section>
    </footer>
    <?php wp_footer(); ?>
    </body>
</html>