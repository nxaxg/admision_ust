<?php
    /*
    Template Name: Portadilla de Área
    Template post type: area_ust
    */

    get_header();
    the_post();
    

    $pertenencia = get_field('pertenencia_area');
    $pertenencia_slug = $pertenencia->slug;

?>

<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="bg-blanco">
        <div class="container container--special"> 
            <section class="page-header page-header--special">
                <?php
                    the_post_thumbnail('regular-biggest', array(
                        'class' => 'elastic-img cover'
                    ));
                ?>

                <div class="page-header-caption page-header-caption--special">
                    <p>Santo Tomás</p>
                    <h1><?php the_title(); ?></h1>
                </div>
            </section>
            <div class="special-excerpt">
                <p><?php the_field('bajada_area'); ?></p>
            </div>
        </div>
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

    <div class="bg-corporativo--special">
        <div class="container">
            <?php
                
                $careers = new WP_Query(array(
                    'posts_per_page' => -1,
                    'post_type' => 'carrera',
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                        'taxonomy' => 'areas_general',
                        'field' => 'slug',
                        'terms' => $pertenencia_slug
                        )
                    )
                ));

                if($careers->have_posts()):
                    while($careers->have_posts()):
                        $careers->the_post();

                        $inst = wp_get_post_terms( $post->ID, 'institucion' );
                        $instname = '';
                        if( !empty($inst) ){
                            $inst = $inst[0];
                            $instname = $inst->name;
                        }

                        $jornadas = get_field('jornada', $post->ID);
                        $jornada = strtolower(implode(' ', $jornadas)); 

                        if($instname=='Universidad Santo Tomás'){
                            $printuniv .= '<li>';
                            $printuniv .=   '<a href="'.get_permalink($post).'" class="sede-link '.$jornada.'">';
                            $printuniv .=       $post->post_title;
                            $printuniv .=   '</a>';
                            $printuniv .= '</li>';
                        }     
                        if($instname=='Instituto Profesional'){
                            $printinst .= '<li>';
                            $printinst .=   '<a href="'.get_permalink($post).'" class="sede-link '.$jornada.'">';
                            $printinst .=       $post->post_title;
                            $printinst .=   '</a>';
                            $printinst .= '</li>';
                        }  
                        if($instname=='Centro de Formación Técnica'){
                            $printctf .= '<li>';
                            $printctf .=   '<a href="'.get_permalink($post).'" class="sede-link '.$jornada.'">';
                            $printctf .=       $post->post_title;
                            $printctf .=   '</a>';
                            $printctf .= '</li>';
                        }                    
                    endwhile;
                endif;

                wp_reset_query();
            ?>
            <h2 class="special-title">Carreras</h2>
            <div class="special-career-holder--special">
                <div class="special-career-holder bordered-columns" data-equalize="children" data-mq="vertical-tablet-down">
                    <?php
                    if($printuniv): ?>
                    <div class="grid-4 grid-smalltablet-12">
                        <h4 class="special-info-subtitle">Carreras Universitarias</h4>
                        <ul class="regular-list">
                            <?php echo $printuniv; ?>
                        </ul>
                    </div>
                    <?php
                    endif;
                    
                    if($printinst): ?>
                    <div class="grid-4 grid-smalltablet-12">
                        <h4 class="special-info-subtitle">Carreras de Instituto Profesional</h4>
                        <ul class="regular-list">
                            <?php echo $printinst; ?>
                        </ul>
                    </div>
                    <?php
                    endif;

                    if($printctf): ?>
                    <div class="grid-4 grid-smalltablet-12">
                        <h4 class="special-info-subtitle">Carreras Centro de Formación Técnica</h4>
                        <ul class="regular-list">
                            <?php echo $printctf; ?>
                        </ul>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
            <p class="special-par">
                * Santo Tomás sólo se obliga a otorgar servicios educacionales en los términos indicados en el respectivo contrato y se reserva el derecho a modificar la malla curricular y la oferta académica.
            </p>
        </div>
    </div>

    <section class="collapsed-form formulario-pasos hide-on-vertical-tablet-down" data-override-eq="true" >
        <div class="container full-container" data-gtm-tag="cotizacion-home">
            <?php
                // prefijo para el formulario
                $GLOBALS['cotizacion_prefix'] = 'body';
                get_template_part('partials/formulario-cotizacion');
            ?>
        </div>
    </section>

    <section class="index-section bg-blanco">
        <div class="container">
            <h2 class="double-line-title">
                <span>¿Necesitas Ayuda?</span>
            </h2>

            <div class="expanded-help-holder">
                <?php echo get_help_links('ayuda'); ?>
            </div>

        </div>
    </section>

    <section class="bg-blanco">
        <div class="container">
            <?php
                $drivers = get_field('drivers_area');
                if( !empty($drivers) ) :
            ?>
            <div class="index-drivers parent" data-equalize="children" data-mq="tablet-down">
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
        </div>
    </section>

    <section class="bg-blanco top-border--green">
        <div class="container">
            <h2 class="special-title">
                Te invitamos a conocer todas las áreas de Santo Tomás
            </h2>
            <div class="island">
                <div method="post" id="areaselect" class="complex-form">
                    <div class="form-controls-holder form-control form-control--centered">
                        <div class="input-group inline-group">
                            <select class="regular-input select inline-input" id="area-select" name="area-select">
                                <option selected disabled="disabled">Areas Santo Tomás</option>
                                <?php
                                    $areasust = get_page_by_path('areas-ust');

                                    $areas_args = array(
                                        'post_type' => 'page',
                                        'posts_per_page' => '-1',
                                        'post_parent' => $areasust->ID,
                                        'order' => 'ASC',
                                        'orderby' => 'title'
                                    );

                                    $areas = new WP_Query($areas_args);

                                    if($areas->have_posts()):
                                        while($areas->have_posts()):
                                            $areas->the_post();
                                            echo '<option value="'.get_permalink($post).'">'.$post->post_title.'</option>';
                                        endwhile;
                                    endif;
                                    wp_reset_query();
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-controls-holder form-control form-control--centered">
                        <div class="island">
                            <button id="page-area" class="button secundario small wide full-vertical-tablet-down">Ir al área</button>
                        </div>
                    </div>
                </div>
                <script>
                    jQuery(function () {
                        // remove the below comment in case you need chnage on document ready
                        // location.href=jQuery("#selectbox").val(); 
                        jQuery("#page-area").click(function () {
                            location.href = jQuery("#area-select").val();
                        })
                    });
                </script>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>