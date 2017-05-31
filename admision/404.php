<?php get_header(); ?>

<main id="main-content" class="main-content" role="main">
    <section class="page-holder">
        <div class="container">            
            <section class="page-body parent">
                <h1 class="single-page-title">Error 404</h1>
                <div class="parent">
                    <div class="grid-9 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                        <div class="page-content">
                            <h2>Página no encontrada</h2>
                            <p>Lo sentimos, la página que buscas fue modificada, borrada o no existe.</p>
                            <p>
                                <strong>
                                    Te invitamos a continuar tu navegación conociendo nuestras carreras o contactándote con nuestros canales de ayuda.
                                </strong>
                            </p>
                        </div>
                    </div>
                    <aside class="regular-sidebar grid-3 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                        <section class="content-box">
                            <h2 class="content-box-title corporativo dark">
                                <span class="tag full">¿Necesitas Ayuda?</span>
                            </h2>
                            <div class="content-box-body">
                                <?php echo get_help_links('ayuda'); ?>
                            </div>
                        </section>
                    </aside>
                </div>

                <?php get_template_part('partials/busqueda-carreras', 'seccion'); ?>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>