<?php

    $requisitos = get_field('requisitos');
    if( !empty( $requisitos ) ) :
?>

<section class="special-info-holder always-visible">
    <div class="special-info full">
        <h3 class="special-info-title">Requisitos admisión regular</h3>
        <div class="special-info-body">
            <ol class="pretty-ol">
                <?php
                    foreach( $requisitos as $r ){
                        echo '<li>'. $r['requisito'] .'</li>';
                    }
                ?>
            </ol>
        </div>
    </div>
</section>

<?php endif; ?>

<section class="content-box">
    <h2 class="content-box-title primario light">
        <span class="tag full icon link">Conoce más sobre...</span>
    </h2>
    <div class="content-box-body">
        <?php
            wp_nav_menu(array(
                'theme_location' => 'conoce_mas_carreras',
                'menu_class' => 'regular-list',
                'items_wrap' => '<ul id="%1$s" class="%2$s" >%3$s</ul>'
            ));
        ?>
    </div>
</section>


<section class="content-box">
    <h2 class="content-box-title corporativo dark">
        <span class="tag full">¿Necesitas Ayuda?</span>
    </h2>
    <div class="content-box-body">
        <?php echo get_help_links(); ?>
    </div>
</section>



<?php 
    echo generate_actions_box( $post, false, false, 'por_que_estudiar' );
?>