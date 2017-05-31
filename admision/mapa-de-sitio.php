<?php
    /*
    Template Name: Mapa del Sitio
    */

    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container">            
            <section class="page-body parent">
                <h1 class="single-page-title">
                    <?php the_title(); ?>
                </h1>

                <div class="grid-9 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                    <?php
                        the_post_thumbnail('regular-big', array(
                            'class' => 'elastic-img cover'
                        ));
                    ?>

                    <div class="page-content font-bigger">
                    <?php the_content(); ?>
                    </div>
                </div>
                <aside class="regular-sidebar grid-3 no-gutter-right hide-on-vertical-tablet-down">
                    <section class="content-box">
                        <h2 class="content-box-title corporativo dark">
                            <span class="tag full">¿Necesitas Ayuda?</span>
                        </h2>
                        <div class="content-box-body">
                            <?php echo get_help_links('ayuda'); ?>
                        </div>
                    </section>
                </aside>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>