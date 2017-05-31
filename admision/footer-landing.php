    <footer class="main-footer bg-primario">
        <section class="main-footer-section auxiliar-section centered-text">
            <?php
                $links = get_field('links_externos');
                if( !empty($links) ){
                    foreach( $links as $link ){
                        echo '<a class="landing-site-link" href="'. ensure_url($link['url']) .'" title="Visitar Sitio" rel="external nofollow" style="border-color: '. $link['color'] .';" >'. $link['texto'] .'</a>';
                    }
                }
            ?>
        </section>
        <section class="main-footer-section secondary-section">
            <div class="container">
                <div class="footer-logos centered-text hide-on-vertical-tablet-down">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-ust.svg" alt="Logotipo Santo Tomás">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/comision-nacional-acreditacion.svg" alt="Logotipo Santo Tomás">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/acreditacion-universidad.svg" alt="Logotipo Santo Tomás">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/acreditacion-ip.svg" alt="Logotipo Santo Tomás">
                    <img class="elastic-img" src="<?php bloginfo('template_directory'); ?>/images/logos/acreditacion-cft.svg" alt="Logotipo Santo Tomás">
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