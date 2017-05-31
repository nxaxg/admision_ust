<section class="content-box">
    <h2 class="content-box-title primario light">
        <span class="tag full">Suscribete a nuestro Newsletter</span>
    </h2>
    <div class="content-box-body">
       <form action="<?php echo get_permalink(); ?>exito/" class="regular-form content-box__form" method="post" data-validation="generic" autocomplete="off" >
           <div class="parent form-set">
               <label for="newsletter-nombre" class="regular-label required">Nombre:</label>
                <input class="regular-input" type="text" id="newsletter-nombre" name="newsletter-nombre" maxlength="20" required placeholder="Ingresa tu(s) nombre(s)" data-ws="name.first" tabindex="1" data-custom-validation="onlyString">
           </div>
           <div class="parent form-set">
               <label for="newsletter-email" class="regular-label required">Correo electrónico:</label>
                <input class="regular-input" type="email" id="newsletter-email" name="newsletter-email" required placeholder="Ingresa tu mail" data-ws="email" tabindex="2">
           </div>
           <div class="island">
                <input class="button secundario wide full-vertical-tablet-down" type="submit" value="Suscribir" tabindex="3">
                <input type="hidden" name="ws-form-name" value="newsletter" >
            </div>
            <?php wp_nonce_field('enviar_formulario', 'st_nonce'); ?>
       </form>
    </div>
</section>

<section class="content-box">
    <h2 class="content-box-title primario light">
        <span class="tag full">Información de interés</span>
    </h2>
    <div class="content-box-body">
        <?php
            wp_nav_menu(array(
                'theme_location' => 'interes_general',
                'menu_class' => 'regular-list',
                'items_wrap' => '<ul id="%1$s" class="%2$s" >%3$s</ul>'
            ));
        ?>
    </div>
</section>