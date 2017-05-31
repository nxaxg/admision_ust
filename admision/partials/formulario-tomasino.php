<?php
needs_script('funciones_cotizacion');
global $idaCRM;
?>
<form class="regular-form" action="<?php echo get_permalink(); ?>#feedback" method="post" data-validation="generic" >

    <div class="island">
        <p class="regular-form-helper">Los campos con (*) son obligatorios</p>
    </div>

    <div class="parent form-set">
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <label for="ensayo" class="regular-label required">Evento al cual quiero asistir</label>
            <select class="regular-input select" id="ensayo" name="id_evento_crm" required  data-role="dynamic-select" data-func="appendInputHidden" data-events="change">
                <?php echo $idaCRM->selector_evento("tomasino-por-un-dia"); ?>
            </select>
        </div>
    </div>

    <div class="form-set">
        <label class="regular-label">Tipo de inscripción</label>
        <div class="inline-options-box">
            <label class="radio-label">
                <input type="radio" name="tipo-inscripcion" value="colegio" checked data-func="inputControl" data-events="change.st" data-group="inscripcion-type">
                <span>Colegio</span>
            </label>
            <label class="radio-label">
                <input type="radio" name="tipo-inscripcion" value="individual" data-func="inputControl" data-events="change.st" data-group="inscripcion-type">
                <span>Individual</span>
            </label>
        </div>
    </div>

    <div class="parent form-set">
        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <label for="rut" class="regular-label required">RUT</label>
            <input class="regular-input" type="text" id="rut" name="rut" maxlength="10" required placeholder="Ingresa tu RUT" data-name="input-rut" data-custom-validation="validateRut">

            <label for="nombre" class="regular-label required">Nombres(s)</label>
            <input class="regular-input" type="text" id="nombre" name="nombre" maxlength="20" required data-error-message="Campo obligatorio, solo letras"  placeholder="Ingresa tu nombre" data-custom-validation="onlyString">

            <label for="apellido-paterno" class="regular-label required">Apellido paterno</label>
            <input class="regular-input" type="text" id="apellido-paterno" name="apellido-paterno" maxlength="15" required data-error-message="Campo obligatorio, solo letras"  placeholder="Ingresa tu apellido paterno" data-custom-validation="onlyString">

            <label for="apellido-materno" class="regular-label">Apellido materno</label>
            <input class="regular-input required" type="text" id="apellido-materno" name="apellido-materno" maxlength="15" data-error-message="Campo obligatorio, solo letras" placeholder="Ingresa tu apellido materno" data-custom-validation="onlyString">
        </div>

        <div class="grid-6 grid-mobile-4 no-gutter-right no-gutter-mobile">
            <div class="input-group inline-group">
                <label for="celular" class="regular-label required">Celular</label>
                <select class="regular-input select inline-input" id="celular-codigo" name="celular-codigo" required  required data-error-message="Obligatorio" >
                    <option value="">--</option>
                    <option value="9">9</option>
                </select>

                <input class="regular-input inline-input" type="text" id="celular-numero" name="celular-numero" maxlength="8" required data-error-message="Obligatorio, solo números"  data-custom-validation="onlyNumbers">
            </div>

            <div class="input-group inline-group">
                <label for="telefono" class="regular-label required">Teléfono</label>
                <select class="regular-input select inline-input" id="telefono-codigo" name="telefono-codigo" required  required data-error-message="Obligatorio">
                    <option value="">--</option>
                    <?php
                    $codigos = get_phone_codes();

                    foreach ($codigos as $code) {
                        echo '<option value="' . $code . '">' . $code . '</option>';
                    }
                    ?>
                </select>

                <input class="regular-input inline-input" type="text" id="telefono-numero" name="telefono-numero" maxlength="8" required  data-error-message="Obligatorio, solo números" data-custom-validation="onlyNumbers">
            </div>

            <label for="email" class="regular-label required">Mail</label>
            <input class="regular-input" type="email" id="email" name="email" required  data-error-message="Campo obligatorio, formato email" placeholder="Ingresa tu email">

            <label for="email-conf" class="regular-label required">Confirmar mail</label>
            <input class="regular-input" type="email" id="email-conf" name="email-confirm" required  data-error-message="Campo obligatorio, formato email" placeholder="Confirma tu email" data-custom-validation="equalToEmail" data-sample="email" data-func="preventPaste" data-events="paste">
        </div>
    </div>

    <div class="parent form-set">

        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <label for="region" class="regular-label required">Región</label>
            <select class="regular-input select" id="region" name="region" required data-name="selector-region" >
                <?php echo $idaCRM->selector_region(); ?>
            </select>

            <label for="comuna" class="regular-label required">Comuna</label>
            <select class="regular-input select" id="comuna" name="comuna" required data-name="selector-comuna">
                <option value="" >Selecciona una Comuna</option>
            </select>

            <label for="colegio" class="regular-label required">Colegio</label>
            <select class="regular-input select" id="colegio" name="colegio" required data-name="selector-colegio">
                <option value="" >Selecciona un Colegio</option>
            </select>
        </div>

        <div class="grid-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
            <div class="changing-inputs" data-role="inscripcion-type" data-name="individual">
                <label for="ano-cursado" class="regular-label required">¿Qué año cursas?</label>
                <select class="regular-input select" id="ano-cursado" name="ano-cursado" data-name="selector-curso" data-func="inputControl" data-events="change.st" data-group="situacion-type" >
                    <option value="" >Selecciona una año</option>
                    <option value="1º" >Primero Medio</option>
                    <option value="2º" >Segundo Medio</option>
                    <option value="3º" >Tercero Medio</option>
                    <option value="4º" >Cuarto Medio</option>
                    <option value="egresado" >Egresado</option>
                </select>

                <div class="changing-inputs" data-role="situacion-type" data-name="egresado"  style="margin-top:20px;">
                    <label for="ano-egreso" class="regular-label required">Año de egreso</label>
                    <select class="regular-input select" id="ano-egreso" name="ano-egreso" data-name="selector-egreso">
                        <option value="" >Selecciona una año de egreso</option>
                        <?php
                        $year = date('Y', strtotime('-1 year'));
                        for ($i = 0; $i <=10; $i++) {
                            echo '<option value="' . ($year - $i) . '" >' . ($year - $i) . '</option>';

                            // la ultima opcion debe ser un rango menos al ultimo año
                            if ($i === 9) {
                                echo '<option value="antes del ' . ($year-$i) . '" >Antes del ' . ($year - $i) . '</option>';
                            }
                            // Año actual
                            if ($i === 10) {
                                echo '<option value="antes del ' . ($year) . '" >Antes del ' . ($year) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="changing-inputs active" data-role="inscripcion-type" data-name="colegio">
                <label for="colegio-cargo" class="regular-label required">Cargo contacto Colegio</label>
                <select class="regular-input select" id="colegio-cargo" name="cargo" required >
                    <option value="">Selecciona una cargo</option>
                    <option value="Director">Director</option>
                    <option value="Orientador">Orientador</option>
                    <option value="Profesor">Profesor</option>
                    <option value="Profesor jefe">Profesor jefe</option>
                    <option value="Psicólogo">Psicólogo</option>
                    <option value="Otro">Otro</option>
                </select>

                <label for="numero-cuartos" class="regular-label required">Número cursos de 4º Medios del colegio</label>
                <input class="regular-input" type="text" id="numero-cuartos" name="numero-cuartos" required  data-error-message="Máximo dos dígitos" placeholder="Ingresa un número" data-custom-validation="onlyNumbers" data-min="1" maxlength="2">

                <label for="numero-alumnos" class="regular-label required">Número total de alumnos</label>
                <input class="regular-input" type="text" id="numero-alumnos" name="numero-alumnos" required data-error-message="Máximo tres dígitos" placeholder="Ingresa un número" data-custom-validation="onlyNumbers" data-min="1" maxlength="3">
            </div>
        </div>
    </div>

    <div class="form-set changing-inputs" data-role="inscripcion-type" data-name="individual">
        <div class="combos">
            <div class="career-combo deployed added" data-count="1">
                <h3 class="career-combo-title">
                    Carrera 1
                    <button class="career-combo-btn expand" data-func="deployCareerCombo" ></button>
                </h3>

                <?php
                $zonas_options = $idaCRM->selector_zonasadmision();
                ?>

                <div class="career-combo-fields">
                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">¿Dónde quieres estudiar?</label>
                            <select class="regular-input select" name="combo-carreras[0][sede]" data-name="selector-sede">
                                <?php echo $zonas_options; ?>
                            </select>
                        </div>
                        <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                            <label class="regular-label required">Jornada</label>
                            <select class="regular-input select" name="combo-carreras[0][jornada]" data-name="selector-jornada">
                                <option value="">Selecciona una jornada</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">Carrera</label>
                            <select class="regular-input select" name="combo-carreras[0][carrera]" data-name="selector-carrera">
                                <option value="">Selecciona una carrera</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="career-combo" data-count="2">
                <h3 class="career-combo-title">
                    Carrera 2 <span>(opcional)</span>
                    <a href="#" title="Agregar otra carrera" data-func="addRemoveCareerComboPrev" class="addothercareer">AGREGAR OTRA CARRERA</a>
                    <button class="career-combo-btn close gtm_desplegar_carrera" data-func="addRemoveCareerCombo"></button>
                    <button class="career-combo-btn expand" data-func="deployCareerCombo"></button>
                </h3>

                <div class="career-combo-fields">
                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">¿Dónde quieres estudiar?</label>
                            <select class="regular-input select" name="combo-carreras[1][sede]" data-name="selector-sede" data-notrequired>
                                <?php echo $zonas_options; ?>
                            </select>
                        </div>
                        <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                            <label class="regular-label required">Jornada</label>
                            <select class="regular-input select" name="combo-carreras[1][jornada]" data-name="selector-jornada" data-notrequired>
                                <option value="">Selecciona una jornada</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">Carrera</label>
                            <select class="regular-input select" name="combo-carreras[1][carrera]" data-name="selector-carrera" data-notrequired>
                                <option value="">Selecciona una carrera</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="career-combo" data-count="3">
                <h3 class="career-combo-title">
                    Carrera 3 <span>(opcional)</span>
                   <a href="#" title="Agregar otra carrera" data-func="addRemoveCareerComboPrev" class="addothercareer">AGREGAR OTRA CARRERA</a>                    
                    <button class="career-combo-btn close gtm_desplegar_carrera" data-func="addRemoveCareerCombo"></button>
                    <button class="career-combo-btn expand" data-func="deployCareerCombo"></button>
                </h3>

                <div class="career-combo-fields">
                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">¿Dónde quieres estudiar?</label>
                            <select class="regular-input select" name="combo-carreras[2][sede]" data-name="selector-sede" data-notrequired>
                                <?php echo $zonas_options; ?>
                            </select>
                        </div>
                        <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                            <label class="regular-label required">Jornada</label>
                            <select class="regular-input select" name="combo-carreras[2][jornada]" data-name="selector-jornada" data-notrequired>
                                <option value="">Selecciona una jornada</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group parent">
                        <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                            <label class="regular-label required">Carrera</label>
                            <select class="regular-input select" name="combo-carreras[2][carrera]" data-name="selector-carrera" data-notrequired>
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
        <input class="button secundario small wide full-vertical-tablet-down" type="submit" value="Enviar Formulario" >
        <!-- <input type="hidden" name="ws-form-name" value="tellamamos" > -->
    </div>

    <?php wp_nonce_field('enviar_formulario', 'st_nonce'); ?>
</form>
