<?php
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

                    <?php
                        // el contenido cambia en funcion de la existencia de tabs
                        $has_tabs = get_field('tabs_open');
                        if( $has_tabs && !!$post->post_content ){
                            echo '<div class="page-content font-bigger">';
                            the_content();
                            echo '</div>';

                            get_template_part('partials/page-tabs');
                        }

                        elseif( !!$post->post_content ){
                            echo '<div class="page-content">';
                            the_content();
                            echo '</div>';
                        }

                        $habilitar_areas = get_field('habilitar_areas_ust');

                        if($habilitar_areas){
                            echo get_despliegue_areas();
                        }
                    ?>
                </div>
            </section>
        </div>
    </section>
</main>

<a href="#" class="tag full icon link"></a>

<?php get_footer(); ?>