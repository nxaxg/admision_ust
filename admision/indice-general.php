<?php
    /*
    Template Name: Índice General
    */

    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container"> 
            <section class="page-header">
                <?php
                    the_post_thumbnail('regular-biggest', array(
                        'class' => 'elastic-img cover'
                    ));
                ?>

                <div class="page-header-caption">
                    <h1><?php the_title(); ?></h1>
                    <p><?php the_field('introduccion'); ?></p>
                </div>
            </section>
        </div>

        <?php
            if( get_field('has_search') ){
                get_template_part('partials/busqueda-carreras', 'seccion');
            }
        ?>

        <div class="container">
            <section class="page-body parent" data-masonry-grid data-equalize="target" data-mq="vertical-tablet-down" data-eq-target=".masonry-item">
                <?php
                    // los accesos en este tipo de portadillar son adminsitrables desde un campo flexible ACF
                    // El tipo de acceso cambia en base al layout de cada row de este campo
                    $accesos = get_field('accesos');
                    if( !empty($accesos) ){
                        foreach($accesos as $acceso){
                            $access_contents = '';
                            $color = false;

                            if( $acceso['acf_fc_layout'] === 'pagina_hija' ){
                                $type_class = 'pagina';
                                $hija_id = $acceso['pagina'][0];
                                $title = get_the_title( $hija_id );
                                $permalink = get_permalink( $hija_id );

                                $access_contents .= '<a href="'. $permalink .'" title="Ver '. $title .'" rel="subsection">';

                                $access_contents .= get_the_post_thumbnail( $hija_id, 'regular', array(
                                    'class' => 'elastic-img cover'
                                ));

                                $access_contents .= '<h2>';
                                $access_contents .= $title;
                                $access_contents .= '</h2>';
                                $access_contents .= '</a>';
                            }
                            else {
                                $type_class = 'driver';
                                $driver_id = $acceso['driver'][0];
                                $color = get_field('color', $driver_id);
                                $access_contents .= get_field('contenido', $driver_id);
                            }

                            ?>

                            <article class="masonry-item simple-access <?php echo $type_class; ?>" <?php echo $color ? 'style="background: '. $color .';"' : ''; ?> >
                                <?php echo $access_contents; ?>
                            </article>

                            <?php
                        }
                    }
                ?>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>