<section class="career-search-holder">
    <div class="container">
        <?php
        global $id_area, $name_area;
        echo get_career_search_area($id_area, $name_area); ?>
    </div>

    <section id="career-search-results" class="career-search-results-holder">
        <div class="container">
            <div class="career-search-results" >
                <div class="career-search-items-holder always-visible" data-role="results-box">
                </div>
 
                <p class="career-disclaimer">
                    * Santo Tomás sólo se obliga a otorgar servicios educacionales en los términos indicados en el respectivo contrato y se reserva el derecho a modificar la malla curricular y la oferta académica.
                </p>
            </div>
        </div>
    </section>
</section>

<script>
    onload(function(){
        $("option[value='46']").attr('selected','selected');
    })
</script>