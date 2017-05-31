<form class="regular-form" action="<?php echo get_permalink(); ?>exito/" method="post" data-validation="generic" autocomplete="off" >
    <div class="parent">

        <div class="island">
            <p class="regular-form-helper">Los campos con (*) son obligatorios</p>
        </div>
    
        <div class="parent form-set">
            <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                <label for="contacto-rut" class="regular-label required">RUT</label>
                <input class="regular-input" type="text" id="contacto-rut" name="contacto-rut" maxlength="10" required placeholder="Ingresa tu RUT" data-name="input-rut" tabindex="1" data-custom-validation="validateRut">
            </div>
        </div>

        <?php $codigos = get_phone_codes(); ?>

        <div class="parent form-set">
            <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet input-column">
                <label for="contacto-nombre" class="regular-label required">Nombre(s)</label>
                <input class="regular-input" type="text" id="contacto-nombre" name="contacto-nombre" maxlength="20" required placeholder="Ingresa tu(s) nombre(s)" data-ws="name.first" tabindex="2" data-custom-validation="onlyString">
            </div>
            <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet input-column">
                <label for="contacto-apellido-paterno" class="regular-label required">Apellido paterno</label>
                <input class="regular-input" type="text" id="contacto-apellido-paterno" name="contacto-apellido-paterno" maxlength="20" required placeholder="Ingresa tu apellido paterno"  data-ws="name.last" tabindex="3" data-custom-validation="onlyString">
            </div>

            <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet input-column">
                <div class="input-group inline-group">
                    <label for="contacto-celular" class="regular-label required">Celular</label>
                    <select class="regular-input select inline-input" id="contacto-celular-codigo" name="contacto-celular-codigo" required tabindex="4">
                        <option value="">Elige</option>
                        <option value="9">9</option>
                    </select>

                    <input class="regular-input inline-input" type="text" id="contacto-celular-numero" maxlength="8" name="contacto-celular-numero" required data-ws="mobilePhone.number" tabindex="5" data-custom-validation="onlyNumbers">
                </div>
            </div>
            <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet input-column">
                <div class="input-group inline-group">
                    <label for="contacto-telefono" class="regular-label">Teléfono</label>
                    <select class="regular-input select inline-input" id="contacto-telefono-codigo" name="contacto-telefono-codigo" tabindex="6">
                        <option value="">Elige</option>
                        <?php
                        foreach ($codigos as $code) {
                            echo '<option value="' . $code . '">' . $code . '</option>';
                        }
                        ?>
                    </select>

                    <input class="regular-input inline-input required" type="text" id="contacto-telefono-numero" name="contacto-telefono-numero" maxlength="8" data-ws="phone.number" tabindex="7" data-custom-validation="onlyNumbers">
                </div>
            </div>

            <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet input-column">
                <label for="contacto-email" class="regular-label required">Mail(s)</label>
                <input class="regular-input" type="email" id="contacto-email" name="contacto-email" required placeholder="Ingresa tu mail" data-ws="email" tabindex="8">
            </div>
            <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet input-column">
                <label for="contacto-email-confirmacion" class="regular-label required">Confirmar mail</label>
                <input class="regular-input" type="email" id="contacto-email-confirmacion" name="contacto-email-confirmacion" required placeholder="Confirma tu mail" tabindex="9" data-custom-validation="equalToEmail" data-sample="contacto-email" data-func="preventPaste" data-events="paste">
            </div>
        </div>

        <label for="contacto-mensaje" class="regular-label required">Mensaje</label>
        <textarea class="regular-input" id="contacto-mensaje" name="contacto-mensaje" required placeholder="Ingresa tu mensaje" tabindex="10"></textarea>
    </div>


    <div class="island">
        <p class="regular-form-helper">*Campos requeridos</p>
    </div>
    <div class="island">
        <input class="button secundario small wide full-vertical-tablet-down" type="submit" value="Enviar" tabindex="11">
        <input type="hidden" name="ws-form-name" value="contacto" >
    </div>

    <?php wp_nonce_field('enviar_formulario', 'st_nonce'); ?>
</form>
