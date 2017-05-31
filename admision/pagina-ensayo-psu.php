<?php
    /*
    Template Name: Página Ensayo nacional PSU
    */
   
    //// acciones para recibir el POST del formulario
    $sending_form_valid = false;

    if( isset( $_POST['st_nonce'] ) ){
        $sending_form_valid = send_ensayo_form( $_POST );
    }

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

                    <div class="page-content">
                        <?php the_content(); ?>

                        <div class="island">
                            <?php
                                // boton principal
                                if( get_field('activar_boton') ){
                                    $link = '#';
                                    $atts = 'data-func="clickTo" data-target="#form-tab-btn"';

                                    if( get_field('tipo_boton') === 'externo' ){
                                        $link = ensure_url(get_field('url_link_externo'));
                                        $atts = '';
                                    }

                                    $texto = get_field('form_boton_text');

                                    echo '<a href="'. $link .'" class="button secundario tiny full-vertical-tablet-down" title="'. $texto .'" '. $atts .' >'. $texto .'</a>';
                                }
                                
                                $botones_adicionales = get_field('botones_adicionales');
                                if( !empty($botones_adicionales) ){
                                    foreach( $botones_adicionales as $boton ){
                                        $link = ensure_url( $boton['link'] );
                                        $external_class = '';

                                        if( is_external($link) ){
                                            $external_class = 'after-icon external';
                                            $external_att = 'rel="external nofollow"';
                                        }

                                        echo '<a href="'. $link .'" class="button seamless full-vertical-tablet-down '. $external_class .'" title="Ver enlace" '. $external_att .'>'. $boton['texto'] .'</a>';
                                    }
                                }
                            ?>
                        </div>
                    </div>

                    <?php

                        $galerias = get_field('galerias');
                        if( !empty($galerias) ) :
                            needs_script('ninjaSlider');
                    ?>

                    <h2 class="standalone-heading" >Galerías de fotos</h2>
                    <div class="parent">
                        <?php
                            $count = 0;
                            foreach( $galerias as $gal ){
                                echo '<div class="grid-4 grid-smalltablet-12">';
                                echo '<a href="#" class="gallery-access" title="Ver Galería" rel="nofollow" data-func="showGallery" data-pid="'. $post->ID .'" data-index="'. $count .'" >';
                                echo wp_get_attachment_image($gal['imagenes'][0]['imagen'], 'square');
                                echo '<span>'. $gal['titulo'] .'</span> ';
                                echo '</a>';
                                echo '</div>';

                                $count++;
                            }
                        ?>
                    </div>

                    <?php
                        endif;
                    ?>
                    <?php
                        if( $sending_form_valid === false ) :
                            $ocultar_tabs        = get_field('ocultar_tabs', $post->ID);

                            $ensayo = '';
                            $formulario = '';

                            foreach( $ocultar_tabs as $ocultar ) :
                                if( $ocultar === 'fechas_ensayo' ) {
                                    $ensayo = 'ocultar';
                                } else if ( $ocultar === 'formulario_de_inscripcion' ) {
                                    $formulario = 'ocultar';
                                }
                            endforeach;

                            $contenido_principal = get_field('contenido_principal', $post->ID);
                            $ensayo_active      = '';
                            $formulario_active   = '';

                            if( $contenido_principal === 'fechas_ensayo' ) {
                                $ensayo_active = 'active';
                            } else if( $contenido_principal === 'formulario_de_inscripcion' ) {
                                $formulario_active   = 'active';
                            }
                    ?>

                        <div class="tabs-holder">
                            <div class="tabs-controls">
                                <?php if( empty($ensayo) ) : ?>
                                    <button class="<?php echo $ensayo_active; ?>" title="Ver pestaña" data-func="tabControl" data-target="informacion">Fechas del ensayo</button>
                                <?php endif; ?>
                                
                                <?php
                                    if( get_field('tipo_boton') === 'interno' ){
                                        echo '<button id="form-tab-btn" class="'.$formulario_active.'" title="Ver pestaña" data-func="tabControl" data-target="formulario">Formulario de inscripción</button>';
                                    }
                                ?>
                                
                            </div>
                            <div class="tabs-box">
                                <div class="tab-item <?php echo $ensayo_active; ?>" data-tab-name="informacion" >
                                    <div class="white-section">
                                        <?php echo eventos("ensayo-psu"); ?>    
                                    </div>
                                </div>

                                <?php if( get_field('tipo_boton') === 'interno' ) : ?>
                                    <div class="tab-item <?php echo $formulario_active; ?>" data-tab-name="formulario" >
                                        <div class="white-section">
                                            <?php
                                                // para seguir el mismo modelo ya propuesto en el sitio
                                                // se van a seguir separando los formularios en partials
                                                
                                                get_template_part('partials/formulario', 'ensayo-psu');
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php
                        elseif(is_array($sending_form_valid)):
                    ?>

                        <div id="feedback" class="page-content">
                            <div class="complex-form-feedback">
                                <h2 class="feedback-title">¡Gracias!</h2>
                                <p class="feedback-subtitle">El formulario se ha enviado con éxito, los datos enviados son:</p>

                                <div class="feedback-body">
                                    <?php echo $sending_form_valid['feedback']; ?>
                                </div>
                            </div>
                        </div>

                    <?php
                        endif;
                    ?>
                </div>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>