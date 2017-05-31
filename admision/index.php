<?php get_header(); ?>

<main id="main-content" class="main-content" role="main">
    <?php
        get_template_part('partials/index', get_field('version_inicio', 'option'));
    ?>

    <section class="content-section mix-content-box">
        <?php
            get_template_part('partials/seccion-acceso-calendario');
            get_template_part('partials/home','noticias');
        ?>
    </section>

    <?php
        $testi = get_field('testimonio_destacado', 'option')[0];
        if( !empty($testi) ):
    ?>
    <section class="index-section">
        <div class="container full-container">
            <article class="experiencia-destacada" >
                <div class="thumbnail">
                    <?php
                        if( $video = get_field('video', $testi) ) {
                            echo apply_filters('the_content', $video);
                        }
                        else {
                            echo get_the_post_thumbnail($testi, 'regular-small');
                        }
                    ?>
                </div>
                <div class="info">
                    <div class="info-text">
                        <div class="quote"><?php echo get_field('cita', $testi); ?></div>
                        <div class="author">
                            <?php $author = get_field('info_autor', $testi)[0]; ?>
                            <p class="name" ><?php echo $author['nombre']; ?></p>
                            <p class="desc" ><?php echo $author['descripcion']; ?></p>
                            <p class="place" ><?php echo $author['institucion']; ?></p>
                        </div>
                    </div>

                    <div class="see-more">
                        <a href="<?php echo get_link_by_slug('experiencia-santo-tomas'); ?>" title="Ver más testimonios" rel="section">Ver más testimonios</a>
                    </div>
                </div>

            </article>
        </div>
    </section>
    <?php endif; ?>

    <section class="index-section bg-blanco">
        <div class="container">
            <h2 class="double-line-title">
                <span>¿Necesitas Ayuda?</span>
            </h2>

            <div class="expanded-help-holder">
                <?php echo get_help_links('ayuda'); ?>
            </div>

            <?php
                $drivers = get_field('drivers_destacados', 'option');
                if( !empty($drivers) ) :
            ?>
            <div class="index-drivers parent" data-equalize="children" data-mq="vertical-tablet-down">
                <?php
                    foreach( $drivers as $d ) :
                        $color = get_field('color', $d);
                        $driver_contents = get_field('contenido', $d);
                ?>
                    <article class="simple-access driver" style="background: <?php echo $color; ?>;">
                    <?php echo $driver_contents; ?>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if( $home_type === 'admision' ) : ?>
            <section class="index-cta-holder hide-on-vertical-tablet-down">
                <h2 class="cta-title">¿Quieres ser parte de Santo Tomás?</h2>
                <button class="index-cta-btn" title="Ver fomulario de cotización" data-func="scrollToTarget" data-target="#body-formulario-cotizacion" >Postula y cotiza</button>
            </section>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
