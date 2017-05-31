<?php
/*Template name: Carrera v2*/
/*Template post type: carrera*/

    get_header();
    the_post();

    $thisid = $post->ID;

    $institucion = wp_get_post_terms( $post->ID, 'institucion' );
    $institucion_name = '';
    if( !empty($institucion) ){
        $institucion = $institucion[0];
        $institucion_name = $institucion->name;
    }

    $type = 'universidad';
    if( $institucion->slug !== 'universidad-santo-tomas' ){
        $type = 'ipcft';
    }

    $malla = get_field('malla_curricular');

    $sedes = wp_get_post_terms( $post->ID, 'sede' );
    $areas = wp_get_post_terms( $post->ID, 'areas_general' );

    $area = $areas[0];
    $area_slug = $area->slug;

    $facultad = wp_get_post_terms( $post->ID, 'facultades_escuelas' );
    $facultad_name = '';
    if( empty($facultad) || is_wp_error($facultad) ){
        $facultad = wp_get_post_terms($post->ID, 'areas');
    }


    $color = '#333333';

    if( !empty($facultad) ){
        $facultad = $facultad[0];
        $facultad_name = $facultad->name;
        $color = get_field('color_asociado', $facultad->taxonomy . '_' . $facultad->term_id);
    }
?>

<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container">
            <section class="page-header">
                <div class="parent" data-equalize="children" data-mq="vertical-tablet-down" style="background: <?php echo $color; ?>;">
                    <div class="grid-5 grid-smalltablet-12 no-gutter">
                        <div data-area-name="mobile-page-thumb" ></div>

                        <div class="page-intro-holder">
                            <h1 class="page-title"><?php the_title(); ?></h1>
                            <h2 class="page-subtitle" ><?php echo $facultad_name; ?></h2>
                            <p class="page-intro-text" ><?php echo $institucion_name; ?></p>

                            <div class="island">
                                <a href="#" class="button secundario full-phablet-down" rel="help section" title="Postula aquí" data-func="deployHeaderForm">Postula y cotiza aquí</a>
                            </div>
                        </div>
                    </div>
                    <div class="grid-7 no-gutter hide-on-vertical-tablet-down" data-area-name="desktop-page-thumb">
                        <?php
                            the_post_thumbnail('regular-big', array(
                                'class' => 'elastic-img cover',
                                'data-mutable' => 'vertical-tablet-down',
                                'data-desktop-area' => 'desktop-page-thumb',
                                'data-mobile-area' => 'mobile-page-thumb',
                                'data-order' => '1'
                            ));
                        ?>
                    </div>
                </div>
                <div class="career-meta-holder parent" data-equalize="children" data-mq="vertical-tablet-down">
                    <?php
                        $sec_class = 'big';
                        $grado = get_field('grado');
                        if( !$grado ){ $sec_class = 'bigger'; }
                    ?>
                    <div class="career-meta <?php echo $sec_class; ?> title">
                        <h3>Título</h3>
                        <p><?php the_field('titulo'); ?></p>
                    </div>

                    <?php if( $grado ) : ?>
                    <div class="career-meta big degree">
                        <h3>
                            <?php
                                if( $facultad->taxonomy === 'facultades_escuelas' ){
                                    echo 'Grado';
                                } else {
                                    echo 'Salida intermedia';
                                }
                            ?>
                        </h3>
                        <p><?php echo $grado; ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="career-meta small duration">
                        <h3>Duración</h3>
                        <p><?php the_field('duracion'); ?></p>
                    </div>
                    <div class="career-meta small type">
                        <h3>Jornada</h3>
                        <p><?php the_field('jornada'); ?></p>
                    </div>
                </div>
            </section>
            
            <section class="page-body parent">
                <div class="grid-9 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                    <div class="page-content font-bigger">
                        <h2 class="career-subtitle">¿Por qué estudiar <strong style="color: <?php echo $color; ?>;" ><?php the_title(); ?></strong>?</h2>
                        <?php the_field('por_que_estudiar'); ?>
                        <?php
                            if(!empty($malla)){
                                $printmalla  =  '<div class="island">';
                                $printmalla .=      '<a href="'.$malla['url'].'" class="button secundario download" download>';
                                $printmalla .=          'Descargar malla curricular';
                                $printmalla .=      '</a>';
                                $printmalla .=  '</div>';
                                echo $printmalla;
                            }
                        ?>
                    </div>
                    
                    <?php $informacion = get_field('informacion_especifica')[0];
                    $habilitar_malla_virtual = get_field('habilitar_malla_virtual');
                    if($habilitar_malla_virtual):
                    ?>

                    <div class="special-info-holder collapsection">
                        <div class="special-info full">
                            <h3 class="special-info-collapse to-collapse"><span id="collapse-btn">+ Mostrar</span> Malla curricular</h3>
                            <div class="special-info-body body-collapse special-info-body--no-padd">
                                <?php get_template_part('partials/carrera-malla-dinamica'); ?>
                            </div>
                        </div>
                    </div>

                    <?php
                    endif;
                    ?>
                    

                    <div class="special-info-holder always-visible">
                        <div class="special-info">
                            <h3 class="special-info-title to-deployable" data-func="deployParent" data-parent=".special-info" data-mq="vertical-tablet-down">Objetivos</h3>
                            <div class="special-info-body">
                                <?php 
                                    echo apply_filters('the_content', $informacion['objetivos']); 
                                ?>
                            </div>
                        </div>
                        <div class="special-info">
                            <h3 class="special-info-title to-deployable" data-func="deployParent" data-parent=".special-info" data-mq="vertical-tablet-down">Campo ocupacional</h3>
                            <div class="special-info-body">
                                <?php 
                                    echo apply_filters('the_content', $informacion['campo_ocupacional']); 
                                ?>
                            </div>
                        </div>
                        <div class="special-info">
                            <h3 class="special-info-title to-deployable" data-func="deployParent" data-parent=".special-info" data-mq="vertical-tablet-down">Perfil de egreso</h3>
                            <div class="special-info-body">
                                <?php 
                                    echo apply_filters('the_content', $informacion['perfil_egreso']);
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="special-info-holder">
                        <div class="special-info full">
                            <h3 class="special-info-title to-deployable" data-func="deployParent" data-parent=".special-info" data-mq="vertical-tablet-down">Sedes y jornadas</h3>
                            <div class="special-info-body bordered-columns">

                                <?php $sedes_ordenadas = separar_sedes_carrera( $post->ID ); ?>
                                <div class="grid-4 grid-smalltablet-12">
                                    <h4 class="special-info-subtitle">Zona Norte</h4>
                                    <?php 
                                        echo generate_sedes_list( $sedes_ordenadas['zona_norte'] );
                                    ?>
                                </div>
                                <div class="grid-4 grid-smalltablet-12">
                                    <h4 class="special-info-subtitle">Zona Centro</h4>
                                    <?php 
                                        echo generate_sedes_list( $sedes_ordenadas['zona_centro'] );
                                    ?>
                                </div>
                                <div class="grid-4 grid-smalltablet-12">
                                    <h4 class="special-info-subtitle">Zona Sur</h4>
                                    <?php 
                                        echo generate_sedes_list( $sedes_ordenadas['zona_sur'] );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        $general_disclaimer = get_field('texto_legal_carreras', 'options');
                        if( $general_disclaimer ){
                            echo '<div class="career-disclaimer">';
                            echo apply_filters('the_content', $general_disclaimer);
                            echo '</div>';
                        }

                        $career_disclaimer = get_field('disclaimer_carrera');
                        if( $career_disclaimer ){
                            echo '<div class="career-disclaimer">';
                            echo apply_filters('the_content', $career_disclaimer);
                            echo '</div>';
                        }
                    ?>
                </div>
                <aside class="regular-sidebar grid-3 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                    <?php get_sidebar('carreras-v2'); ?>
                </aside>
            </section>

            <?php
                $recommend = new WP_Query(array(
                    'posts_per_page' => 4,
                    'post_type' => 'carrera',
                    'orderby' => 'rand',
                    'post__not_in' => array($thisid),
                    'tax_query' => array(
                            array(
                            'taxonomy' => 'areas_general',
                            'field' => 'slug',
                            'terms' => $area_slug
                            )
                        )
                    ));

                if($recommend->have_posts()):
            ?>
            <section class="page-body">
                <div class="page-content page-content--no-overflow">
                    <h2 class="page-content__title page-content__title--min">
                        Te podría interesar
                    </h2>
                    <div class="row" data-equalize="children" data-mq="vertical-tablet-down">
                            <?php
                                while($recommend->have_posts()):
                                    $recommend->the_post();

                                    $inst = wp_get_post_terms( $post->ID, 'institucion' );
                                    $instname = '';
                                    if( !empty($inst) ){
                                        $inst = $inst[0];
                                        $instname = $inst->name;
                                    }
                                    
                                    $jornadas = get_field('jornada', $post->ID);
                                    
                                    $jornada = strtolower(implode(' ', $jornadas));

                                    
                                    $printrecom .=      '<article class="grid-3 grid-smalltablet-12 special-gutter carrera-maybe">';
                                    $printrecom .=          '<figure class="carrera-maybe__figure">';
                                    $printrecom .=              '<a href="'.get_permalink($post).'" class="simple-link" target="_blank">';
                                    $printrecom .=                  get_the_post_thumbnail( $post, 'regular-medium', ['class' => 'elastic-img cover'] );
                                    $printrecom .=              '</a>';
                                    $printrecom .=          '</figure>';
                                    $printrecom .=          '<div class="carrera-maybe__body">';
                                    $printrecom .=              '<p>'.$instname.'</p>';
                                    $printrecom .=              '<h3 class="sede-link '.$jornada.' carrera-maybe__titulo">';
                                    $printrecom .=                  '<a href="'.get_permalink($post).'" class="simple-link" target="_blank">';
                                    $printrecom .=                      $post->post_title;
                                    $printrecom .=                  '</a>';
                                    $printrecom .=              '</h3>';
                                    $printrecom .=          '</div>';
                                    $printrecom .=      '</article>';

                                endwhile;
                            echo $printrecom;
                            ?>
                    </div>
                </div>
            </section>

            <?php
                endif;
                wp_reset_query();
            ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>