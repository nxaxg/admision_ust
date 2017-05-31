<form class="regular-form" action="<?php echo get_permalink(); ?>exito/" method="post" data-validation="generic" autocomplete:="off" >
    <div class="parent">

        <div class="island">
            <p class="regular-form-helper">Los campos con (*) son obligatorios</p>
        </div>

        <div class="parent form-set">
            <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                <label for="contacto-rut" class="regular-label required">RUT</label>
                <input class="regular-input" type="text" id="contacto-rut" name="contacto-rut" maxlength="10" required placeholder="Ingresa tu RUT" tabindex="1" data-custom-validation="validateRut" data-name="input-rut" >
            </div>
        </div>

        <div class="parent form-set">
            <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                <label for="contacto-nombre" class="regular-label required">Nombre(s)</label>
                <input class="regular-input" type="text" id="contacto-nombre" name="contacto-nombre" maxlength="20" required placeholder="Ingresa tu(s) nombre(s)" tabindex="2"  data-ws="name.first" data-custom-validation="onlyString">
            </div>
        </div>

        <?php $codigos = get_phone_codes(); ?>

        <div class="parent form-set">
            <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                <label for="contacto-apellido-paterno" class="regular-label required">Apellido paterno</label>
                <input class="regular-input" type="text" id="contacto-apellido-paterno" name="contacto-apellido-paterno" maxlength="15" required placeholder="Ingresa tu apellido paterno" tabindex="3"  data-ws="name.last" data-custom-validation="onlyString">

                <div class="input-group inline-group">
                    <label for="contacto-celular" class="regular-label required">Celular</label>
                    <select class="regular-input select inline-input" id="contacto-celular-codigo" name="contacto-celular-codigo" required tabindex="5"  >
                        <option value="">Elige</option>
                        <option value="9">9</option>
                    </select>

                    <input class="regular-input inline-input" type="text" id="contacto-celular-numero" name="contacto-celular-numero" maxlength="8" required placeholder="Escribe tu celular" tabindex="6" data-custom-validation="onlyNumbers" data-ws="mobilePhone.number">
                </div>

                <label for="contacto-email" class="regular-label required">Mail</label>
                <input class="regular-input" type="email" id="contacto-email" name="contacto-email" required placeholder="Ingresa tu mail" tabindex="9" data-ws="email">
            </div>
            <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                <label for="contacto-apellido-materno" class="regular-label">Apellido materno</label>
                <input class="regular-input required" type="text" id="contacto-apellido-materno" name="contacto-apellido-materno" maxlength="15" placeholder="Ingresa tu apellido materno" tabindex="4" data-custom-validation="onlyString">

                <div class="input-group inline-group">
                    <label for="contacto-telefono" class="regular-label">Teléfono</label>
                    <select class="regular-input select inline-input" id="contacto-telefono-codigo" name="contacto-telefono-codigo" tabindex="7" >
                        <option value="">Elige</option>
                        <?php
                            foreach( $codigos as $code ){
                                echo '<option value="'. $code .'">'. $code .'</option>';
                            }
                        ?>
                    </select>

                    <input class="regular-input inline-input" type="text" id="contacto-telefono-numero" name="contacto-telefono-numero" maxlength="8" placeholder="Escribe tu teléfono" tabindex="8" data-custom-validation="onlyNumbers" data-ws="phone.number">
                </div>
            </div>
        </div>
    </div>


    <div class="island">
        <p class="regular-form-helper">*Campos requeridos</p>
    </div>
    <div class="island">
        <input class="button secundario small wide full-vertical-tablet-down" type="submit" value="Solicitar llamada" tabindex="10" >
        <input type="hidden" name="ws-form-name" value="tellamamos" >
    </div>

    <?php wp_nonce_field('enviar_formulario', 'st_nonce'); ?>
</form>
