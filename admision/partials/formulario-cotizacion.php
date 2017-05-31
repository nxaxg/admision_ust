<?php
    needs_script('funciones_cotizacion');

    global $idaCRM;
    $id_prefix = "regular";

    if( isset($GLOBALS['cotizacion_prefix']) ){
        $id_prefix = $GLOBALS['cotizacion_prefix'];
    }

    // if (isset($_POST["ws-form-name"]) && $_POST["ws-form-name"] === "postulacion" && $_POST) {
    //     $statusFrom = $GLOBALS["idaCRM"]->push_postulacion();
    //     if (!$statusFrom) {
    //         echo "Lo siento hubo un error, intente de nuevo";
    //     } else {
    //         echo "El contacto se realizó con éxito";
    //     }
    // }

?>
<form id="<?php echo $id_prefix . '-'; ?>formulario-cotizacion" class="complex-form" action="#" method="post" data-validation="cotizacion" autocomplete="off">
    <section class="complex-form-header">
        <div class="complex-form-progress-holder">
            <span class="progress current" data-index="0">Paso 1:<br>Datos personales</span>
            <span class="progress" data-index="1">Paso 2:<br>Educación</span>
            <span class="progress" data-index="2">Paso 3:<br>Carreras</span>
        </div>
        <h1 class="complex-form-title">Consulta tu arancel <small>en 3 simples pasos</small></h1>
    </section>

    <div class="form-fieldsets">
        <fieldset id="<?php echo $id_prefix . '-'; ?>paso-1" class="complex-form-step current" data-index="0" data-equalize="children" data-mq="vertical-tablet-down">
            <legend class="first">
                <span>
                    <strong>Ingresa</strong> tus datos personales y de contacto
                </span>
            </legend>
            <div class="fieldset-body">
                <div class="island">
                    <p class="regular-form-helper">Los campos con (*) son obligatorios</p>
                </div>
                <div class="parent">
                    <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                        <label for="contacto-rut" class="regular-label required">RUT</label>
                        <input class="regular-input" type="text" id="<?php echo $id_prefix . '-'; ?>contacto-rut" maxlength="10" name="contacto-rut" required placeholder="Ingresa tu RUT con guión y sin puntos" data-name="input-rut" data-custom-validation="validateRut">

                        <label for="contacto-nombre" class="regular-label required">Nombre(s)</label>
                        <input class="regular-input" type="text" id="<?php echo $id_prefix . '-'; ?>contacto-nombre" maxlength="25" name="contacto-nombre" required  data-error-message="Campo obligatorio, solo letras"  placeholder="Ingresa tu(s) nombre(s)" data-ws="name.first" data-custom-validation="onlyString">

                        <label for="contacto-apellido-paterno" class="regular-label required">Apellido paterno</label>
                        <input class="regular-input" type="text" id="<?php echo $id_prefix . '-'; ?>contacto-apellido-paterno" maxlength="15" name="contacto-apellido-paterno" required data-error-message="Campo obligatorio, solo letras" placeholder="Ingresa tu apellido paterno" data-ws="name.last" data-custom-validation="onlyString">

                        <label for="contacto-apellido-materno" class="regular-label">Apellido materno</label>
                        <input class="regular-input required" type="text" id="<?php echo $id_prefix . '-'; ?>contacto-apellido-materno" maxlength="15" name="contacto-apellido-materno" data-error-message="Solo letras" placeholder="Ingresa tu apellido materno" data-custom-validation="onlyString">
                    </div>
                    <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                        <?php $codigos = get_phone_codes(); ?>

                        <div class="input-group inline-group">
                            <label for="contacto-celular" class="regular-label required">Celular</label>
                            <select class="regular-input select inline-input" id="<?php echo $id_prefix . '-'; ?>contacto-celular-codigo" maxlength="8" name="contacto-celular-codigo" required >
                                <option value="">Elige</option>
                                <option value="9">9</option>
                            </select>

                            <input class="regular-input inline-input" type="text" id="<?php echo $id_prefix . '-'; ?>contacto-celular-numero" maxlength="8" name="contacto-celular-numero"  placeholder="Escribe tu celular" required data-error-message="Obligatorio, solo números" data-custom-validation="onlyNumbers" data-ws="mobilePhone.number">
                        </div>

                        <div class="input-group inline-group">
                            <label for="contacto-telefono" class="regular-label ">Teléfono</label>
                            <select class="regular-input select inline-input" id="<?php echo $id_prefix . '-'; ?>contacto-telefono-codigo" name="contacto-telefono-codigo">
                                <option value="">Elige</option>
                                <?php
                                    foreach( $codigos as $code ){
                                        echo '<option value="'. $code .'">'. $code .'</option>';
                                    }
                                ?>
                            </select>

                            <input class="regular-input inline-input" type="text" id="<?php echo $id_prefix . '-'; ?>contacto-telefono-numero" name="contacto-telefono-numero" maxlength="8" placeholder="Escribe tu teléfono" data-custom-validation="onlyNumbers" data-ws="phone.number">
                        </div>

                        <label for="contacto-email" class="regular-label required">Mail</label>
                        <input class="regular-input" type="email" id="<?php echo $id_prefix . '-'; ?>contacto-email" name="contacto-email" required data-error-message="Campo obligatorio, formato email" placeholder="Ingresa tu mail" data-ws="email">

                        <label for="contacto-mail-confirm" class="regular-label required">Confirmar mail</label>
                        <input class="regular-input" type="email" id="<?php echo $id_prefix . '-'; ?>contacto-mail-confirm" name="contacto-mail-confirm" required data-error-message="Campo obligatorio, formato email" placeholder="Confirma tu mail" data-custom-validation="equalToEmail" data-sample="<?php echo $id_prefix . '-'; ?>contacto-email" data-func="preventPaste" data-events="paste">
                    </div>
                </div>

                <div class="form-controls-holder form-control">
                    <div class="island">
                        <p class="regular-form-helper">*Campos requeridos</p>
                    </div>
                    <div class="island">
                        <button class="button secundario small wide full-vertical-tablet-down" data-func="formControl" data-direction="next">Siguiente</button>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset id="<?php echo $id_prefix . '-'; ?>paso-2" class="complex-form-step" data-index="1" data-equalize="children" data-mq="vertical-tablet-down">
            <legend class="second">
                <span>
                    <strong>Indica</strong> en qué curso vas o si ya egresaste del colegio
                </span>
            </legend>
            <div class="fieldset-body">
                <div class="island">
                    <p class="regular-form-helper">Los campos con (*) son obligatorios</p>
                </div>
                <div class="parent">
                    <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                        <label for="cotizacion-region" class="regular-label required">Región</label>
                        <select class="regular-input select" id="<?php echo $id_prefix . '-'; ?>cotizacion-region" name="cotizacion-region" required data-name="selector-region">
                            <?php echo $idaCRM->selector_region(); ?>
                        </select>

                        <label for="cotizacion-comuna" class="regular-label required">Comuna</label>
                        <select class="regular-input select" id="<?php echo $id_prefix . '-'; ?>cotizacion-comuna" name="cotizacion-comuna" required  data-name="selector-comuna">
                            <option value="" >Selecciona una Comuna</option>
                        </select>

                        <label for="cotizacion-colegio" class="regular-label required">Colegio</label>
                        <select class="regular-input select" id="<?php echo $id_prefix . '-'; ?>cotizacion-colegio" name="cotizacion-colegio" required data-name="selector-colegio">
                            <option value="" >Selecciona un Colegio</option>
                        </select>
                    </div>
                    <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                        <label for="cotizacion-ano-cursado" class="regular-label required">¿Qué año cursas?</label>
                        <select class="regular-input select" id="<?php echo $id_prefix . '-'; ?>cotizacion-ano-cursado" name="cotizacion-ano-cursado" required data-name="selector-curso" data-func="inputControl" data-events="change.st" data-group="situacion-type">
                            <option value="" >Selecciona una año</option>
                            <option value="1º" >Primero Medio</option>
                            <option value="2º" >Segundo Medio</option>
                            <option value="3º" >Tercero Medio</option>
                            <option value="4º" >Cuarto Medio</option>
                            <option value="egresado" >Egresado</option>
                        </select>

                        <div class="changing-inputs" data-role="situacion-type" data-name="egresado" style="margin-top:20px;">
                            <label for="cotizacion-ano-egreso" class="regular-label required">Año de egreso</label>
                            <select class="regular-input select" id="<?php echo $id_prefix . '-'; ?>cotizacion-ano-egreso" name="cotizacion-ano-egreso" data-name="selector-egreso">
                                <option value="" >Selecciona una año de egreso</option>
                                <?php
                                    $year = date('Y', strtotime('-1 year'));
                                    for( $i = 0; $i <= 10; $i++ ){
                                        // Año actual
                                        if( $i === 0 ){
                                            echo '<option value="'. ($year + 1) .'" >'. ($year + 1) .'</option>';
                                        }
                                        echo '<option value="'. ($year - $i) .'" >'. ($year - $i) .'</option>';

                                        // la ultima opcion debe ser un rango menos al ultimo año
                                        if( $i === 10 ){
                                            echo '<option value="antes del '. ($year - $i) .'" >Antes del '. ($year - $i) .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-controls-holder form-control">
                    <div class="island">
                        <p class="regular-form-helper">*Campos requeridos</p>
                    </div>
                    <div class="island">
                        <button class="button seamless back-icon back-arrow full-vertical-tablet-down" data-func="formControl" data-direction="prev">Anterior</button>
                        <button class="button secundario small wide full-vertical-tablet-down" data-func="formControl" data-direction="next">Siguiente</button>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset id="<?php echo $id_prefix . '-'; ?>paso-3" class="complex-form-step" data-index="2" data-equalize="children" data-mq="vertical-tablet-down">
            <legend class="third">
                <span>
                    <strong>Selecciona</strong> hasta tres carreras de tu interés
                </span>
            </legend>
            <div class="fieldset-body">
              <div class="fieldset-body">
                  <div class="island">
                      <p class="regular-form-helper">Los campos con (*) son obligatorios</p>
                  </div>
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
                                    <select class="regular-input select" name="combo-carreras[0][sede]" required data-name="selector-sede" id="selector-sede">
                                        <?php echo $zonas_options; ?>
                                    </select>
                                </div>
                                <div class="grid-6 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                                    <label class="regular-label required">Jornada</label>
                                    <select class="regular-input select" name="combo-carreras[0][jornada]" required data-name="selector-jornada"  id="selector-jornada" >
                                        <option value="">Selecciona una jornada</option>
                                    </select>
                                </div>
                            </div>

                            <div class="input-group parent">
                                <div class="grid-6 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                                    <label class="regular-label required">Carrera</label>
                                    <select class="regular-input select" name="combo-carreras[0][carrera]" required data-name="selector-carrera" id="selector-carrera" >
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
                            <a href="#" title="Agregar otra carrera" data-func="addRemoveCareerComboPrev" class="addothercareer">AGREGAR OTRA CARRERA</a>
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


                <div class="island">
                    <p class="regular-form-helper">*Campos requeridos</p>
                </div>
                <div class="island">
                    <button class="button seamless back-icon back-arrow form-control full-vertical-tablet-down" data-func="formControl" data-direction="prev">Anterior</button>
                    <input class="button secundario small wide full-vertical-tablet-down" type="submit" value="Enviar datos">
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="ws-form-name" value="postulacion" >
    <input type="hidden" name="form-type" value="<?php echo $id_prefix; ?>" >
    <?php //wp_nonce_field('enviar_formulario_cotizacion', 'st_nonce'); ?>
</form>
