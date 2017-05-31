<?php
    $section_config = get_field('admision_config', 'option')[0];
?>
<section class="admision-intro-section">
    <?php
        echo wp_get_attachment_image( $section_config['imagen_portada'], 'full-header-small', false, array('class' => 'full-header-img'));
    ?>
    <section class="admision-intro-info">
        <div class="container full-container">
            <div class="admision-intro">
                <?php echo apply_filters('the_content', $section_config['texto_portada']); ?>
            </div>
        </div>
    </section>
</section>

<?php
    // en vista de que este ya es un template_part
    // la inclusion se debe hacer con un include comun
    include('busqueda-carreras-seccion.php');
?>

<section class="collapsed-form formulario-pasos hide-on-vertical-tablet-down" data-override-eq="true" >
    <div class="container full-container" data-gtm-tag="cotizacion-home">
        <?php
            // prefijo para el formulario
            $GLOBALS['cotizacion_prefix'] = 'body';
            include('formulario-cotizacion.php');
        ?>
    </div>
</section>
<?php
/**
// Comentado temporalmente

<section class="index-section ensayo">
    <div class="container">
        <div class="grid-9 grid-smalltablet-12 centered parent">
            <div class="grid-4 grid-mobile-4 grid-smalltablet-5 no-gutter-left no-gutter-mobile">
                <?php
                    $img_ensayo_id = get_field('imagen_ensayo','options');
                    if( $img_ensayo_id ) {
                        echo $img_ensayo = wp_get_attachment_image( $img_ensayo_id, 'regular-ensayo-medium', '', ['class' => 'elastic-img cover'] );
                    }
                ?>
            </div>
            <div class="container-content-section grid-8 grid-mobile-4 grid-smalltablet-7 no-gutter-mobile no-gutter-right">
                <?php
                    $titulo_seccion = get_field('titulo_seccion','options');
                    $link_boton     = get_field('link_boton','options');
                    $texto_boton    = get_field('texto_boton','options');

                    if( !empty( $titulo_seccion ) ){
                        echo $titulo_seccion;
                    }

                    if( !empty( $link_boton ) ) {
                        echo '<a href="'.ensure_url( $link_boton ).'" class="button secundario small wide">'.$texto_boton.'</a>';
                    }
                ?>
            </div>
        </div>
    </div>
</section>

*/
?>