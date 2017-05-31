<section class="index-section">
    <div class="container full-container" data-equalize="target" data-mq="vertical-tablet-down" data-eq-target=".content-box-body">
        <?php
            $events = [];
            $today = date('Ymd');
            $calQuery = new WP_Query([
                'post_type' => 'calendario',
                'posts_per_page' => 2,
                'meta_key' => 'fecha_inicio',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',

                'meta_query' => array(
                    array(
                        'key'     => 'fecha_inicio',
                        'value'   => $today,
                        'compare' => '>='
                    )
                )
            ]); 

            if( $calQuery->have_posts() ){
                while( $calQuery->have_posts() ){
                    $calQuery->the_post();
                    $events[] = generate_calendar_module( $calQuery->post );
                }
            }
            wp_reset_query();

            $col_class = 'grid-6 no-gutter-left';
            if( empty($events) ){
                $col_class = 'grid-12 no-gutter';
            }
        ?>

        <div class="<?php echo $col_class; ?> grid-smalltablet-12  no-gutter-smalltablet">
            <div class="content-box">
                <h2 class="content-box-title primario light">
                    <a class="tag full icon link" href="<?php echo 'link conoce más' ?>" rel="section" title="Ver calendario">Conoce más sobre...</a>
                </h2>
                <div class="content-box-body parent">
                    <?php
                        // se usa esto para separar el menu por columnas
                        $items = wp_get_nav_menu_items( 'conocemas' );
                        $total_items = count($items);
                        $col_items_num = ceil( $total_items / 2 );

                        for( $i = 0; $i < 2; $i++ ){
                            $col_items = array_slice($items,  $i * $col_items_num, $col_items_num );

                            echo '<div class="grid-6 grid-smalltablet-12 no-gutter-smalltabet">';
                            echo '<ul class="regular-list two-child regular-text">';

                            foreach( $col_items as $item ){
                                echo '<li>';
                                echo '<a href="'. $item->url .'" title="Ver '. $item->title .'">'. $item->title .'</a>';
                                echo '</li>';
                            }

                            echo '</ul>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <?php
            if( !empty($events) ) :
            // if( !empty($events) ) :
        ?>
        <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
            <div class="content-box">
                <h2 class="content-box-title neutral">
                    <a class="tag full icon calendar" href="<?php echo get_post_type_archive_link('calendario'); ?>" rel="section" title="Ver calendario">Calendario</a>
                </h2>
                <div class="content-box-body parent">
                    <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                        <?php echo array_shift($events); ?>
                    </div>
                    <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                        <?php echo array_shift($events); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
            endif;
        ?>
    </div>
</section>