<?php
    /*
    Template Name: Archivo de carreras
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
                        if( !!$post->post_content ){
                            echo '<div class="page-content">';
                            the_content();
                            echo '</div>';
                        }

                        $key = 'programas_especiales_continuidad';
                        $value = get_field('programas_especiales_continuidad');
                        if ( ! $value || $value !== true ) {
                            $key = 'jornada';
                            $value = get_field('tipo_jornada');
                        }

                        echo '<div class="career-search-items-holder always-visible loaded" >';
                        echo generate_careers_search_list([
                            'show_icons' => false,
                            'tax_search' => false,
                            'meta_query' => [[
                                'key' => $key,
                                'value' => $value,
                                'compare' => 'LIKE'
                            ]]
                        ]);
                        echo '</div>';
                    ?>
                </div>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>