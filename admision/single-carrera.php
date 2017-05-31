<?php
    get_header();
    the_post();

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


    $sedes = wp_get_post_terms( $post->ID, 'sede' );
    $areas = wp_get_post_terms( $post->ID, 'areas_general' );


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
                <div class="parent" data-equalize="children" data-mq="vertical-tablet-down">
                    <div class="grid-5 grid-smalltablet-12 no-gutter" style="background: <?php echo $color; ?>;" >
                        <div data-area-name="mobile-page-thumb" ></div>

                        <div class="page-intro-holder">
                            <h1 class="page-title"><?php the_title(); ?></h1>
                            <h2 class="page-subtitle" ><?php echo $facultad_name; ?></h2>
                            <p class="page-intro-text" ><?php echo $institucion_name; ?></p>

                            <div class="island">
                                <a href="#" class="button blanco info full-phablet-down" rel="help section" title="Postula aquí" data-func="deployHeaderForm">Postula aquí</a>
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
                        <h2 class="career-subtitle">¿Por qué estudiar <strong style="color: <?php echo $color; ?>;" ><?php the_title(); ?></strong> en Santo Tomás?</h2>
                        <?php the_field('por_que_estudiar'); ?>
                    </div>

                    <?php
                        $certificaciones = get_field('certificaciones');
                        if( !empty($certificaciones) ) :
                    ?>

                    <div class="special-info-holder">
                        <div class="special-info full">
                            <h3 class="special-info-title to-deployable" data-func="deployParent" data-parent=".special-info" data-mq="vertical-tablet-down">Certificaciones y convenios</h3>
                            <div class="special-info-body bordered-rows">
                                <?php foreach( $certificaciones as $cert ) : ?>
                                <div class="parent">
                                    <?php
                                        // si hay logotipo se hace en 2 columans
                                        // si no en una sola
                                        if( !empty($cert['logotipo']) ){
                                            echo '<div class="grid-9 grid-smalltablet-8 grid-mobile-4" >';
                                            echo apply_filters('the_content', $cert['texto']);
                                            echo '</div>';

                                            echo '<div class="grid-3 grid-smalltablet-4 grid-mobile-4" >';
                                            echo '<img class="elastic-img cover" src="'. $cert['logotipo']['url'] .'" >';
                                            echo '</div>';
                                        }
                                        else {
                                            echo '<div>';
                                            echo apply_filters('the_content', $cert['texto']);
                                            echo '</div>';
                                        }
                                    ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <?php endif; ?>
                    
                    <?php $informacion = get_field('informacion_especifica')[0]; ?>

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
                    <?php get_sidebar('carreras'); ?>
                </aside>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>