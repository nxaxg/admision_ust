<?php
    /*
    Template Name: Preguntas frecuentes
    */

    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <section class="page-holder">
        <div class="container">            
            <section class="page-body parent">
                <h1 class="single-page-title"><?php the_title(); ?></h1>
                <div class="parent">
                    <div class="grid-9 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                        <div class="faq-holder bg-blanco">
                        <?php
                            $preguntas = get_field('preguntas');
                            if( !empty($preguntas) ) : foreach($preguntas as $pregunta) :
                        ?>
                            <article class="faq">
                                <h2 class="faq-title" data-func="deployParent" data-parent=".faq" ><?php echo $pregunta['pregunta']; ?></h2>
                                <div class="faq-body">
                                    <div class="page-content">
                                        <?php echo apply_filters('the_content', $pregunta['respuesta']); ?>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; endif; ?>
                    </div>
                    </div>
                    <aside class="regular-sidebar grid-3 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                        <?php get_sidebar('interes'); ?>
                    </aside>
                </div>

                <?php get_template_part('partials/busqueda-carreras', 'seccion'); ?>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>