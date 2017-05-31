<?php
needs_script('funciones_cotizacion');
global $idaCRM;
$zonas_options = $idaCRM->selector_zonasadmision();
?>
<form class="regular-form" action="<?php echo get_permalink(); ?>#feedback" method="post" data-validation="generic" >
    <h2 class="regular-form-title" >Inscripción al ensayo</h2>
    <div class="parent form-set">
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <label for="ensayo" class="regular-label required">Sede donde quiero rendir ensayo PSU </label>
            <select class="regular-input select" id="ensayo" name="cotizacion-sede-ensayo" required data-role="dynamic-select" >
                <?php echo $zonas_options; ?>
            </select>
        </div>
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">    
            <label for="ensayo" class="regular-label required">Cuando rendir ensayo PSU </label>
            <select class="regular-input select" id="ensayo" name="cotizacion-sede-ensayo" required data-role="dynamic-select" >
                <?php echo $idaCRM->selector_evento("ensayo-psu"); ?>
            </select>
        </div>
    </div>


    <div class="parent form-set">
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <label for="rut" class="regular-label required">RUT</label>
            <input class="regular-input" type="text" id="rut" name="contacto-rut" required placeholder="Ingresa tu RUT" data-custom-validation="validateRut">

            <label for="nombre" class="regular-label required">Nombres(s)</label>
            <input class="regular-input" type="text" id="nombre" name="contacto-nombre" required placeholder="Ingresa tu nombre" data-custom-validation="onlyString">

            <label for="apellido-paterno" class="regular-label required">Apellido paterno</label>
            <input class="regular-input" type="text" id="apellido-paterno" name="contacto-apellido-paterno" required placeholder="Ingresa tu apellido paterno" data-custom-validation="onlyString">

            <label for="apellido-materno" class="regular-label required">Apellido materno</label>
            <input class="regular-input" type="text" id="apellido-materno" name="contacto-apellido-materno" required placeholder="Ingresa tu apellido materno" data-custom-validation="onlyString">
        </div>
        <div class="grid-6 grid-mobile-4 no-gutter-right no-gutter-mobile">
            <div class="input-group inline-group">
                <label for="celular" class="regular-label required">Celular</label>
                <select class="regular-input select inline-input" id="celular-codigo" name="contacto-celular-codigo" required >
                    <option value="">--</option>
                    <option value="9">9</option>
                </select>

                <input class="regular-input inline-input" type="text" id="celular-numero" name="contacto-celular-numero" required data-custom-validation="onlyNumbers">
            </div>

            <div class="input-group inline-group">
                <label for="telefono" class="regular-label required">Teléfono</label>
                <select class="regular-input select inline-input" id="telefono-codigo" name="contacto-telefono-codigo" required >
                    <option value="">--</option>
                    <?php
                    $codigos = get_phone_codes();

                    foreach ($codigos as $code) {
                        echo '<option value="' . $code . '">' . $code . '</option>';
                    }
                    ?>
                </select>

                <input class="regular-input inline-input" type="text" id="telefono-numero" name="contacto-telefono-numero" required data-custom-validation="onlyNumbers">
            </div>

            <label for="email" class="regular-label required">Mail</label>
            <input class="regular-input" type="email" id="email" name="contacto-email" required placeholder="Ingresa tu email">

            <label for="email-conf" class="regular-label required">Confirmar mail</label>
            <input class="regular-input" type="email" id="email-conf" name="contacto-email-confirm" required placeholder="Confirma tu email" data-custom-validation="equalToEmail" data-sample="email" data-func="preventPaste" data-events="paste">
        </div>
    </div>

    <div class="parent form-set">
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <label for="region" class="regular-label required">Región</label>
            <select class="regular-input select" id="region" name="cotizacion-region" required data-name="selector-region">
                <?php echo $idaCRM->selector_region(); ?>
            </select>

            <label for="comuna" class="regular-label required">Comuna</label>
            <select class="regular-input select" id="comuna" name="cotizacion-comuna" required data-name="selector-comuna">
                <option value="" >Selecciona una Comuna</option>
            </select>

            <label for="colegio" class="regular-label required">Colegio</label>
            <select class="regular-input select" id="colegio" name="cotizacion-colegio" required data-name="selector-colegio">
                <option value="" >Selecciona un Colegio</option>
            </select>
        </div>
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <label for="ano-cursado" class="regular-label required">¿Qué año cursas?</label>
            <select class="regular-input select" id="ano-cursado" name="cotizacion-ano-cursado" required data-name="selector-curso" data-func="inputControl" data-events="change.st" data-group="situacion-type">
                <option value="" >Selecciona una año</option>
                <option value="1º" >Primero Medio</option>
                <option value="2º" >Segundo Medio</option>
                <option value="3º" >Tercero Medio</option>
                <option value="4º" >Cuarto Medio</option>
                <option value="egresado" >Egresado</option>
            </select>

            <div class="changing-inputs" data-role="situacion-type" data-name="egresado">
                <label for="ano-egreso" class="regular-label required">Año de egreso</label>
                <select class="regular-input select" id="ano-egreso" name="cotizacion-ano-egreso" data-name="selector-egreso">
                    <option value="" >Selecciona una año de egreso</option>
                    <?php
                    $year = date('Y', strtotime('-1 year'));
                    for ($i = 0; $i < 3; $i++) {
                        echo '<option value="' . ($year - $i) . '" >' . ($year - $i) . '</option>';

                        // la ultima opcion debe ser un rango menos al ultimo año
                        if ($i === 2) {
                            echo '<option value="antes del ' . ($year - $i) . '" >Antes del ' . ($year - $i) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-set">
        <div class="combos">
            <div class="career-combo deployed added" data-count="1">
                <h3 class="career-combo-title">
                    Carrera 1
                    <button class="career-combo-btn expand" data-func="deployCareerCombo" ></button>
                </h3>
                <div class="career-combo-fields">
                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">¿Dónde quieres estudiar?</label>
                            <select class="regular-input select" name="combo-carreras[0][sede]" required data-name="selector-sede">
                                <?php echo $zonas_options; ?>
                            </select>
                        </div>
                        <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                            <label class="regular-label required">Jornada</label>
                            <select class="regular-input select" name="combo-carreras[0][jornada]" required data-name="selector-jornada">
                                <option value="">Selecciona una jornada</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">Carrera</label>
                            <select class="regular-input select" name="combo-carreras[0][carrera]" required data-name="selector-carrera">
                                <option value="">Selecciona una carrera</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="career-combo" data-count="2">
                <h3 class="career-combo-title">
                    Carrera 2 <span>(opcional)</span>
                    <button class="career-combo-btn close gtm_desplegar_carrera" data-func="addRemoveCareerCombo"></button>
                    <button class="career-combo-btn expand" data-func="deployCareerCombo"></button>
                </h3>

                <div class="career-combo-fields">
                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">¿Dónde quieres estudiar?</label>
                            <select class="regular-input select" name="combo-carreras[1][sede]" data-name="selector-sede">
                                <?php echo $zonas_options; ?>
                            </select>
                        </div>
                        <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                            <label class="regular-label required">Jornada</label>
                            <select class="regular-input select" name="combo-carreras[1][jornada]" data-name="selector-jornada">
                                <option value="">Selecciona una jornada</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">Carrera</label>
                            <select class="regular-input select" name="combo-carreras[1][carrera]" data-name="selector-carrera">
                                <option value="">Selecciona una carrera</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="career-combo" data-count="3">
                <h3 class="career-combo-title">
                    Carrera 3 <span>(opcional)</span>
                    <button class="career-combo-btn close gtm_desplegar_carrera" data-func="addRemoveCareerCombo"></button>
                    <button class="career-combo-btn expand" data-func="deployCareerCombo"></button>
                </h3>

                <div class="career-combo-fields">
                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">¿Dónde quieres estudiar?</label>
                            <select class="regular-input select" name="combo-carreras[2][sede]" data-name="selector-sede">
                                <?php echo $zonas_options; ?>
                            </select>
                        </div>
                        <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                            <label class="regular-label required">Jornada</label>
                            <select class="regular-input select" name="combo-carreras[2][jornada]" data-name="selector-jornada">
                                <option value="">Selecciona una jornada</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">Carrera</label>
                            <select class="regular-input select" name="combo-carreras[2][carrera]" data-name="selector-carrera">
                                <option value="">Selecciona una carrera</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
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
