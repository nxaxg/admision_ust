<section class="index-section">
    <div class="container full-container">
        <?php
            needs_script('ninjaSlider_solo');
            $slider = get_field('slider_principal', 'option');
            $items = [];
            $bullets = [];

            $count = 0;
            foreach( $slider as $item ){
                $figure = '<figure class="slide '. ($count === 0 ? 'current' : '') .'" data-index="'. $count .'">';
                $figure .= wp_get_attachment_image($item['imagen_desktop'], 'regular-biggest', false, ['class' => 'hide-on-vertical-tablet-down']);
                $figure .= wp_get_attachment_image($item['imagen_mobile'], 'regular-bigger', false, ['class' => 'only-on-vertical-tablet-down']);
                $figure .= '<figcaption>';
                $figure .= apply_filters('the_content', $item['texto']);
                $figure .= '</figcaption>';
                $figure .= '</figure>';

                $items[] = $figure;

                $bullets[] = '<button class="bullet '. ($count === 0 ? 'current' : '') .'" data-target="'. $count .'"></button>';

                $count++;
            }
        ?>

        <section class="index-slider-holder" data-role="index-slider-module">
            <div class="index-slider" data-role="slider"><?php echo implode('', $items); ?></div>
            <div class="index-slider-bullets" data-role="bullets"><?php echo implode('', $bullets); ?></div>
        </section>
    </div>
</section>

<?php
    if( !empty($seccion_mensaje = get_field('seccion_mensaje', 'option')) ) :
        $seccion_mensaje = $seccion_mensaje[0];
        if( $seccion_mensaje['texto'] ) :
?>

<section class="index-section">
    <section class="message-section bg-primario dark">
        <div class="container">
            <h3 class="text">
                <?php
                    echo $seccion_mensaje['texto'];

                    if( $seccion_mensaje['texto_boton'] && $seccion_mensaje['link_boton'] ){
                        $external_class = '';

                        if( is_external( $seccion_mensaje['link_boton'] ) ){
                            $external_class = 'after-icon external';
                        }

                        echo ' <a href="'. ensure_url($seccion_mensaje['link_boton']) .'" class="button secundario small wide full-vertical-tablet-down '. $external_class .'" title="Ver enlace">'. $seccion_mensaje['texto_boton'] .'</a>';
                    }
                ?>
                
            </h3>
        </div>
    </section>
</section>

<?php
        endif;
    endif;
?>

<section class="section-showroom">
    <div class="container">
        <div class="showroom">
            <div class="info-box">
                <h2>Vive Santo Tomás</h2>
                <p><?php echo get_field('introduccion','options'); ?></p>
 
                <div class="parent">
                    <?php
                            // se usa esto para separar el menu por columnas
                        $items = wp_get_nav_menu_items( 'accesos_vive_santotomas' );
                        $total_items = count($items);
                        $col_items_num = ceil( $total_items / 2 );

                        for( $i = 0; $i < 2; $i++ ){
                            $col_items = array_slice($items,  $i * $col_items_num, $col_items_num );

                            echo '<div class="grid-6 grid-smalltablet-12 no-gutter-smalltabet">';
                            echo '<ul class="regular-list regular-big-text">';

                            foreach( $col_items as $item ){
                                echo '<li>';
                                echo '<a class="link-dark" href="'. $item->url .'" title="Ver '. $item->title .'">'. $item->title .'</a>';
                                echo '</li>';
                            }

                            echo '</ul>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
            <div class="image-box">
                <?php
                    $imagen = get_field('imagen_vive_santo_tomas', 'option');

                    if( !empty($imagen) ){
                        echo wp_get_attachment_image($imagen, 'regular-medium', false, ['class' => 'elastic-img cover']);
                    }
                    else {
                        echo '<img src="http://placehold.it/591x354" class="elastic-img cover">';
                    }
                ?>
            </div>
        </div>
    </div>
</section>



<section class="index-section">
    <section class="bg-blanco">
        <div class="container centered-text">
            <div class="index-cta-holder">
                <h2 class="cta-title">¿QUÉ QUIERES ESTUDIAR? Conoce nuestras carreras</h2>
            </div>
        </div>
        <?php
            // en vista de que este ya es un template_part
            // la inclusion se debe hacer con un include comun
            include('busqueda-carreras-seccion.php');
        ?>
    </section>
</section>















