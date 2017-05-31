<div class="special-info-holder bg-blanco">
    <div class="grid-12 no-padding">
        <div class="row malla__simbologia">
            <div class="grid-2 grid-smalltablet-12">
                Simbología
            </div>
            <div class="grid-3 grid-smalltablet-12">
                <div class="malla__tag">
                    <span class="malla__square malla__square--especificas"></span>
                    <p>Asignaturas específicas de la carrera</p>
                </div>
            </div>
            <div class="grid-3 grid-smalltablet-12">
                <div class="malla__tag">
                    <span class="malla__square malla__square--basica"></span>
                    <p>Asignaturas de formación básica</p>
                </div>
            </div>
            <div class="grid-3 grid-smalltablet-12">
                <div class="malla__tag">
                    <span class="malla__square malla__square--general"></span>
                    <p>Asignaturas de formación general</p>
                </div>
            </div>
        </div>

        <?php
        $malla_virtual = get_field('malla_virtual');
        $count = 0;
        if($malla_virtual){
            foreach($malla_virtual as $ano_malla){
                // printMe($ano_malla);
                $ano_title = $ano_malla['malla_virtual_ano_titulo'];
                $semestres = $ano_malla['malla_virtual_semestre'];
                if($count>0){
                $printmallavirtual .= '<hr>';
                }
                $printmallavirtual .=    '<div class="row">';
                $printmallavirtual .=        '<div class="grid-12">';
                $printmallavirtual .=            '<h2 class="malla__title">'.$ano_title.'</h2>';
                $printmallavirtual .=        '</div>';
                foreach($semestres as $semestre){
                    // printMe($semestre);
                    $ramos = $semestre['malla_virtual_ramo'];

                    $printmallavirtual .= '<div class="grid-6 grid-smalltablet-12">';
                    $printmallavirtual .=   '<h4 class="malla-semestre__title">'.$semestre['malla_virtual_semestre_titulo'].'</h4>';
                    $printmallavirtual .=   '<div class="malla__container">';
                    foreach($ramos as $ramo){
                        // printMe($ramo);
                        if($ramo['malla_virutal_ramo_tipo']=='ramo_especifico'){
                            $ramo_clase = 'especificas';
                        }else if($ramo['malla_virutal_ramo_tipo']=='ramo_general'){
                            $ramo_clase =   'general';
                        }else{
                            $ramo_clase = 'basica';
                        }
                        $printmallavirtual .=   '<div class="malla__box">';
                        $printmallavirtual .=       '<button class="malla__button malla__button--'.$ramo_clase.' to-collapse">';
                        $printmallavirtual .=           $ramo['malla_virtual_ramo_titulo'];
                        $printmallavirtual .=       '</button>';
                        $printmallavirtual .=       '<div class="malla__body malla__body--'.$ramo_clase.' body-collapse">';
                        $printmallavirtual .=           $ramo['malla_virtual_ramo_descripcion'];
                        $printmallavirtual .=       '</div>';
                        $printmallavirtual .=   '</div>';
                    }
                    $printmallavirtual .=   '</div>';
                    $printmallavirtual .= '</div>';
                }
                $printmallavirtual .=    '</div>';
                $count++;
            }
            echo $printmallavirtual;

            $certificados_carrera = get_field('certificaciones_virtual');
            $archivo_certificaciones = get_field('archivo_certificaciones');
            if($certificados_carrera){
                $url_certificado = $archivo_certificaciones['url'];
                $printcertificados .=   '<div class="row">';
                $printcertificados .=       '<div class="grid-12">';
                $printcertificados .=           '<h2 class="malla__title malla__title--special">Certificaciones';
                if($archivo_certificaciones){
                $printcertificados .=               '<a href="'.ensure_url($url_certificado).'" class="malla__title--special__link" download>(Ver detalle en pdf)</a>';
                }
                $printcertificados .=           '</h2>';
                $printcertificados .=       '</div>';
                $printcertificados .=       '<div class="grid-12">';
                $printcertificados .=           '<div class="malla__container">';
                foreach($certificados_carrera as $certificado){
                    $printcertificados .=           '<div class="malla__box malla__box--certificado">';
                    $printcertificados .=               '<span class="malla__certificado__icon">'.$certificado['certificado_siglas'].'</span>';
                    $printcertificados .=               '<p class="malla__certificado__title">'.$certificado['certificado_titulo'].'</p>';
                    $printcertificados .=           '</div>';
                }
                $printcertificados .=           '</div>';
                $printcertificados .=       '</div>';
                $printcertificados .=   '</div>';

                echo $printcertificados;
            }
        }
        ?>
        
            <?php
            $malla = get_field('malla_curricular');
                if(!empty($malla)){
                    $printmalla  =  '<div class="island">';
                    $printmalla .=      '<a href="'.$malla['url'].'" class="button secundario download" download>';
                    $printmalla .=          'Descargar malla curricular';
                    $printmalla .=      '</a>';
                    $printmalla .=  '</div>';
                    
                    
                    $printdocmalla  = '<div class="row row-padd">';
                    $printdocmalla .=       $printmalla;
                    $printdocmalla .= '</div>';

                    echo $printdocmalla;
                }
            ?>
    </div>
</div>