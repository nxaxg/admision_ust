<?php 

$sede = get_queried_object();
$field_loc = 'sede_'. $sede->term_id;

get_header();

?>
 
<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container"> 
            <section class="page-header">
                <?php
                    $thumb = wp_get_attachment_image( get_field('imagen_cabecera', $field_loc), 'regular-biggest',false, array('class' => 'elastic-img cover'));

                    if( !$thumb ){
                        $thumb = '<img src="http://placehold.it/1200x450" class="elastic-img cover" >';
                    }

                    echo $thumb;
                ?>

                <div class="page-header-caption">
                    <h1><?php echo $sede->name; ?></h1>
                </div>
            </section>
        </div>

        <div class="container">
            <section class="grid-9 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                <div class="page-content">
                    <h2>Información de contacto</h2>

                    <?php
                        $img_cont = get_field('imagen_contenido', $field_loc);
                        if( !empty($img_cont) ){
                            echo wp_get_attachment_image( $img_cont, 'regular', false, array(
                                'class' => 'elastic-img alignright'
                            ));
                        }

                        echo '<h3 class="content-heading">Dirección</h3>';
                        echo '<ul>';

                        $direccion_1    = get_field('direccion_exacta', $field_loc);
                        $direccion_mapa = get_field('direccion_mapa', $field_loc);
                        $html_link_map  = '';
                        $map_link       = '';
                        if( !empty($direccion_1) ){
                            if( !empty($direccion_mapa) ) {
                                $map_link      = 'https://maps.google.com/?q='. urlencode( $direccion_mapa );
                                $html_link_map = '<a class="external" href="'. $map_link .'" title="Ver mapa de google" rel="external nofollow" target="_blank" >Ver mapa</a>';
                            }
                            echo '<li>'. $direccion_1 . ' ' . $html_link_map . '</li>';
                        }

                        $direccion_2      = get_field('direccion_exacta_2', $field_loc);
                        $direccion_2_mapa = get_field('direccion_exacta_2', $field_loc);
                        $html_link_map_2  = '';
                        $map_link_2       = '';
                        if( !empty($direccion_2) ){
                            if( !empty($direccion_2_mapa) ) {
                                $map_link_2      = 'https://maps.google.com/?q='. urlencode( $direccion_2_mapa );
                                $html_link_map_2 = '<a class="external" href="'. $map_link_2 .'" title="Ver mapa de google" rel="external nofollow" target="_blank" >Ver mapa</a>';

                            }
                            echo '<li>'. $direccion_2 . ' ' . $html_link_map_2 . '</li>';
                        }

                        echo '</ul>';

                        $puntos = get_field('puntos_matricula', $field_loc);
                        if( !empty($puntos) ){
                            echo '<h3 class="content-heading">Puntos de matrícula</h3>';
                            
                            echo '<ul>';
                            foreach( $puntos as $p ){
                                echo '<li>'. $p['punto'] .'</li>';
                            }
                            echo '</ul>';
                        }

                        $horarios = get_field('horarios', $field_loc);
                        if( !empty($horarios) ){
                            echo '<h3 class="content-heading">Horarios de atención</h3>';
                            echo '<div class="paragraph-group">'. $horarios .'</div>';
                        }

                        $links = get_field('links_interes', $field_loc);
                        if( !empty($links) ){
                            echo '<h3 class="content-heading">Te podría interesar</h3>';
                            
                            echo '<ul>';
                            foreach( $links as $link ){
                                $url = ensure_url($link['url']);
                                $external = is_external( $url ) ? 'class="external" rel="external nofollow"' : '';
                                echo '<li><a href="'. $url .'" title="Ver enlace" '. $external .' >'. $link['texto'] .'</a></li>';
                            }
                            echo '</ul>';
                        }
                    ?>

                </div>

                <div class="special-info-holder">
                    <div class="special-info always-visible full">
                        <h3 class="special-info-title">Carreras de la sede</h3>
                        <div class="special-info-body bordered-columns">
                            <div class="grid-4 grid-smalltablet-12">
                                <h4 class="special-info-subtitle">Universidad</h4>
                                <?php echo list_careers_by_sede( $sede->slug, 'universidad-santo-tomas' ); ?>
                            </div>
                            <div class="grid-4 grid-smalltablet-12">
                                <h4 class="special-info-subtitle">Instituto Profesional</h4>
                                <?php echo list_careers_by_sede( $sede->slug, 'instituto-profesional' ); ?>
                            </div>
                            <div class="grid-4 grid-smalltablet-12">
                                <h4 class="special-info-subtitle">Centro de formación Técnica</h4>
                                <?php echo list_careers_by_sede( $sede->slug, 'centro-de-formacion-tecnica' ); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="career-disclaimer">
                    - Santo Tomás sólo se obliga a otorgar servicios educacionales en los términos indicados en el respectivo contrato y se reserva el derecho a modificar la malla curricular y la oferta académica.
                </p>
                <p class="career-disclaimer">
                    - Con el objeto de resguardar el adecuado cumplimiento de la Ley 20.422, para aquellas personas que presenten alguna condición de discapacidad, el plazo de postulación para Admisión 2016 se extiende hasta el 15 de enero 2016.                
                </p>
                <p class="career-disclaimer">
                    - La Institución se reserva el derecho de realizar entrevistas o de solicitar constataciones especializadas a los postulantes a ﬁn de conocer el grado de desarrollo de las habilidades, capacidades y destrezas de éstos, con el propósito de relacionarlas con el perﬁl de ingreso y egreso, además de los requerimientos propios de la carrera.
                </p>

            </section>
            <aside class="regular-sidebar grid-3 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                <nav id="page-navigation" class="page-navigation group-nav" >
                    <?php 
                        $zona = get_sede_zone( (int)$sede->term_id );
                        echo '<span class="ancestor" >Sedes '. $zona .'</span>';

                        $zona_field = 'sedes_'. str_replace(' ', '_', strtolower( $zona ));
                        $sedes_zona = get_field($zona_field, 'options');

                        usort( $sedes_zona, 'order_by_posicion' );

                        foreach( $sedes_zona as $s ){
                            $term = get_term_by('id', $s, 'sede');

                            $current = is_tax( 'sede', $term->slug ) ? 'class="current"' : '';

                            echo '<a '. $current .' href="'. get_term_link( $term ) .'" title="Ir a '. $term->name .'" rel="section">'. $term->name .'</a>';
                        }
                    ?>

                    <a class="see-more" href="/sedes/" rel="section">Ver más sedes</a>
                </nav>
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
    </section>
</main>

<?php get_footer(); ?>