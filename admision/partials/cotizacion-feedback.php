<?php
    $datos = $GLOBALS['datosForm'];
?>
<div class="complex-form-feedback">
    <h2 class="feedback-title">¡Gracias! El formulario se envió con éxito con los siguientes datos:</h2>

    <div class="feedback-body">
        <div class="grid-6 grid-smalltablet-12">
            <h3 class="feedback-subtitle">Datos personales</h3>
            <p><strong><?php echo $datos['nombre']; ?></strong></p>
            <p>RUT: <?php echo $datos['rut']; ?></p>
            <p>Mail: <?php echo $datos['mail']; ?></p>
            <p>Celular: <?php echo $datos['celular']; ?></p>
        </div>
        <div class="grid-6 grid-smalltablet-12">
            <h3 class="feedback-subtitle">Educación</h3>
            <p><strong><?php echo $datos['colegio']; ?></strong></p>
            <p> <?php echo $datos['comuna']; ?>,  <?php echo $datos['region']; ?></p>
            <p>Curso: <?php echo $datos['curso']; ?></p>
            <p>Año de egreso: <?php echo $datos['egreso']; ?></p>
        </div>

        <div class="grid-12">
            <h3 class="feedback-subtitle">Carreras de tu interés</h3>

            <?php
                $i = 1;
                foreach( $datos['carreras'] as $carrera ):
            ?>

            <div class="career-summary">
                <p class="career-summary-title">
                    <?php
                        echo 'Carrera '. $i .': '. $carrera->name;
                    ?>
                </p>
                <table class="career-summary-table">
                    <tr>
                        <th>Institución</th>
                        <th>Sede</th>
                        <th>Jornada</th>
                        <th>Matrícula<small>*</small></th>
                        <th>Arancel anual</th>
                    </tr>
                    <tr>
                        <td data-label="Institución"><?php echo $carrera->institucion; ?></td>
                        <td data-label="Sede"><?php echo $carrera->sede; ?></td>
                        <td data-label="Jornada"><?php echo $carrera->jornada; ?></td>
                        <td data-label="Matrícula">$<?php echo number_format($carrera->matricula, 0, ',', '.'); ?></td>
                        <td data-label="Arancel anual">$<?php echo number_format($carrera->arancel, 0, ',', '.'); ?></td>
                    </tr>
                </table>
            </div>

            <?php $i++; endforeach; ?>
            <em class="warning-message"><?php echo get_field('texto_legal', 'options'); ?></em>
        </div>
    </div>

    <button id="backToForm" class="button secundario small wide full-vertical-tablet-down">Volver a postular</button>
</div>
