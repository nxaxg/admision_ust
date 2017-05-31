<?php
needs_script('funciones_cotizacion');
global $idaCRM;
?>
<form class="regular-form" action="<?php echo get_permalink(); ?>#feedback" method="post" data-validation="generic" >
    <div class="parent form-set">
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <label for="ensayo" class="regular-label required">Sede donde quiero asistir</label>
            <select class="regular-input select" id="ensayo" name="cotizacion-sede-ensayo" required data-role="dynamic-select" >
                <?php echo $idaCRM->selector_zonasadmision(); ?>
            </select>
        </div>
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">    
            <label for="ensayo" class="regular-label required">Fecha en que quiero asistir</label>
            <select class="regular-input select" id="ensayo" name="cotizacion-sede-ensayo" required data-role="dynamic-select" >
                <?php echo $idaCRM->selector_evento("actividades-para-orientadores"); ?>
            </select>
        </div>
    </div>     
    <div class="parent form-set">
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <label for="rut" class="regular-label required">RUT</label>
            <input class="regular-input" type="text" id="rut" name="rut" required placeholder="Ingresa tu RUT" data-custom-validation="validateRut">

            <label for="nombre" class="regular-label required">Nombres(s)</label>
            <input class="regular-input" type="text" id="nombre" name="nombre" required placeholder="Ingresa tu nombre" data-custom-validation="onlyString">

            <label for="apellido-paterno" class="regular-label required">Apellido paterno</label>
            <input class="regular-input" type="text" id="apellido-paterno" name="apellido-paterno" required placeholder="Ingresa tu apellido paterno" data-custom-validation="onlyString">

            <label for="apellido-materno" class="regular-label required">Apellido materno</label>
            <input class="regular-input" type="text" id="apellido-materno" name="apellido-materno" required placeholder="Ingresa tu apellido materno" data-custom-validation="onlyString">
        </div>
        <div class="grid-6 grid-mobile-4 no-gutter-right no-gutter-mobile">
            <div class="input-group inline-group">
                <label for="celular" class="regular-label required">Celular</label>
                <select class="regular-input select inline-input" id="celular-codigo" name="celular-codigo" required tabindex="4">
                    <option value="">--</option>
                    <option value="9">9</option>
                </select>

                <input class="regular-input inline-input" type="text" id="celular-numero" name="celular-numero" required data-custom-validation="onlyNumbers">
            </div>

            <div class="input-group inline-group">
                <label for="telefono" class="regular-label required">Teléfono</label>
                <select class="regular-input select inline-input" id="telefono-codigo" name="telefono-codigo" required tabindex="4">
                    <option value="">--</option>
                    <?php
                    $codigos = get_phone_codes();
                    foreach ($codigos as $code) {
                        echo '<option value="' . $code . '">' . $code . '</option>';
                    }
                    ?>
                </select>

                <input class="regular-input inline-input" type="text" id="telefono-numero" name="telefono-numero" required data-custom-validation="onlyNumbers">
            </div>

            <label for="email" class="regular-label required">Mail</label>
            <input class="regular-input" type="email" id="email" name="email" required placeholder="Ingresa tu email">

            <label for="email-conf" class="regular-label required">Confirmar mail</label>
            <input class="regular-input" type="email" id="email-conf" name="email-conf" required placeholder="Confirma tu email" data-custom-validation="equalToEmail" data-sample="email" data-func="preventPaste" data-events="paste">
        </div>
    </div>

    <div class="parent form-set">
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <label for="region" class="regular-label required">Región del establecimiento</label>
            <select class="regular-input select" id="region" name="region" required data-name="selector-region">
                <?php echo $idaCRM->selector_region(); ?>
            </select>

            <label for="comuna" class="regular-label required">Comuna del establecimiento</label>
            <select class="regular-input select" id="comuna" name="comuna" required data-name="selector-comuna">
                <option value="" >Selecciona una Comuna</option>
            </select>
        </div>
        <div class="grid-6 grid-mobile-4 no-gutter-right no-gutter-mobile">
            <label for="establecimiento" class="regular-label required">Nombre del establecimiento</label>
            <select class="regular-input select" id="colegio" name="colegio" required data-name="selector-colegio">
                <option value="" >Selecciona un establecimiento</option>
            </select>

            <label for="colegio-cargo" class="regular-label required">Cargo contacto Colegio</label>
            <select class="regular-input select" id="colegio-cargo" name="cargo" required >
                <option value="">Selecciona una cargo</option>
                <option value="Orientador">Orientador</option>
                <option value="Psicólogo">Psicólogo</option>
                <option value="Profesor jefe">Profesor jefe</option>
                <option value="Profesor">Profesor</option>
                <option value="Director">Director</option>

            </select>
        </div>
    </div>

    <div class="island">
        <p class="regular-form-helper">*Campos requeridos</p>
    </div>
    <div class="island">
        <input class="button secundario small wide full-vertical-tablet-down" type="submit" value="Enviar formulario" >
        <!-- <input type="hidden" name="ws-form-name" value="tellamamos" > -->
    </div>

    <?php wp_nonce_field('enviar_formulario', 'st_nonce'); ?>
</form>