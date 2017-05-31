<?php
    $tabs_info = get_field('tabs');

    if( !empty($tabs_info) ) :
?>

<div class="tabs-holder bg-blanco">
    <?php
        $buttons = '';
        $tabs_contents = '';
        $count = 0;
        foreach( $tabs_info as $tab ){
            $active = $count === 0 ? 'active' : '';

            $buttons .= '<button class="'. $active .'" data-func="tabControl" data-target="'. sanitize_title($tab['titulo']) .'">'. $tab['titulo'] .'</button>';
            
            $tabs_contents .= generate_tab_content( $tab, !!$active );

            $count++;
        }
    ?>

    <div class="tabs-controls">
        <?php echo $buttons; ?>
    </div>
    <div class="tabs-box">
        <?php echo $tabs_contents; ?>
    </div>
</div>

<?php endif; ?>