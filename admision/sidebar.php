<nav id="page-navigation" class="page-navigation" >
    <?php 
        $ancestor_id = get_super_parent( $post );

        echo '<a class="ancestor" href="'. get_permalink($ancestor_id) .'" title="Ir a '. get_the_title($ancestor_id) .'" rel="section" >'. get_the_title($ancestor_id) .'</a>';

        echo get_page_navigation( $ancestor_id ); 
    ?>
</nav>

<?php
    $drivers = get_field('drivers_sidebar');
    if( !empty($drivers) ){
        foreach( $drivers as $driver_id ){
            $color = get_field('color', $driver_id);
            $driver_contents = get_field('contenido', $driver_id);

            echo '<article class="simple-access sidebar driver" style="background: '. $color .';">';
            echo $driver_contents;
            echo '</article>';
        }
    }
?>