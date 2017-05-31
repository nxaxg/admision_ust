<?php
    /*
    Template Name: Sello Santo Tomás
    */

    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container">            
            <section class="page-body parent">
                <aside class="regular-sidebar grid-3 no-gutter-left hide-on-vertical-tablet-down">
                    <?php get_sidebar(); ?>
                </aside>
                <div class="grid-9 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                    <h1 class="single-page-title">
                        <?php the_title(); ?>
                    </h1>

                    <?php
                        the_post_thumbnail('regular-big', array(
                            'class' => 'elastic-img cover'
                        ));
                    ?>

                    <section class="sello-content" >
                        <div class="sello-controls parent">
                            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet">
                                <button class="sello-btn bg-neutral" data-func="selloControl" data-id="valoramos">Valoramos</button>
                            </div>
                            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet">
                                <button class="sello-btn bg-primario" data-func="selloControl" data-id="exigimos">Exigimos</button>
                            </div>
                            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet">
                                <button class="sello-btn bg-corporativo" data-func="selloControl" data-id="apoyamos">Apoyamos</button>
                            </div>
                        </div>

                        <?php
                            $imagenes = get_field('imagenes');
                        ?>
                    
                        <div class="sello-items parent" data-role="sello-items">
                            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet" >
                                <figure class="sello-item">
                                    <?php echo wp_get_attachment_image( $imagenes[0]['imagen'], 'regular', false, array('class' => 'elastic-img cover') ); ?>
                                    <figcaption class="valoramos exigimos apoyamos">
                                        <p data-valoramos="Tu vocación y superación" data-exigimos="Tu compromiso y responsabilidad" data-apoyamos="Tu esfuerzo y perseverancia con Becas y Financiamiento" ></p>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet" >
                                <figure class="sello-item">
                                    <?php echo wp_get_attachment_image( $imagenes[1]['imagen'], 'regular', false, array('class' => 'elastic-img cover') ); ?>
                                    <figcaption class="valoramos exigimos apoyamos">
                                        <p data-valoramos="Tu esfuerzo y perseverancia" data-exigimos="Tu esfuerzo personal" data-apoyamos="Tus ganas de estudiar a través del Centro de Aprendizaje" ></p>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet" >
                                <figure class="sello-item">
                                    <?php echo wp_get_attachment_image( $imagenes[2]['imagen'], 'regular', false, array('class' => 'elastic-img cover') ); ?>
                                    <figcaption class="valoramos exigimos apoyamos">
                                        <p data-valoramos="Tu confianza y ganas de seguir creciendo" data-exigimos="Tu Dedicación y trabajo bien hecho" data-apoyamos="Tu desarrollo personal a través de una formación valórica" ></p>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet" >
                                <figure class="sello-item">
                                    <?php echo wp_get_attachment_image( $imagenes[3]['imagen'], 'regular', false, array('class' => 'elastic-img cover') ); ?>
                                    <figcaption class="apoyamos">
                                        <p data-apoyamos="Tu necesidades y vida estudiantil en la Dirección de Asuntos estudiantiles" ></p>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet" >
                                <figure class="sello-item">
                                    <?php echo wp_get_attachment_image( $imagenes[4]['imagen'], 'regular', false, array('class' => 'elastic-img cover') ); ?>
                                    <figcaption class="valoramos exigimos apoyamos">
                                        <p data-valoramos="TÚ PUEDES" data-exigimos="TÚ PUEDES" data-apoyamos="Tu inserción laboral por medio de CREA Empleo y el Círculo de Egresados" ></p>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet" >
                                <figure class="sello-item">
                                    <?php echo wp_get_attachment_image( $imagenes[5]['imagen'], 'regular', false, array('class' => 'elastic-img cover') ); ?>
                                    <figcaption class="apoyamos">
                                        <p data-apoyamos="TÚ PUEDES" ></p>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>