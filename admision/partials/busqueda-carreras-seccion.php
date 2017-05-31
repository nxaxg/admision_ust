<section class="career-search-holder">
    <div class="container">
        <?php echo get_career_search_fields(); ?>
    </div>

    <section id="career-search-results" class="career-search-results-holder">
        <div class="container">
            <div class="career-search-results" >
                <input id="search-text-filter" class="career-search-text-filter" placeholder="¿Qué carrera estás buscando?" data-func="filterSearchResults" data-events="keyup.ST" >

                <div class="career-search-items-holder always-visible" data-role="results-box">
                </div>
 
                <p class="career-disclaimer">
                    * Santo Tomás sólo se obliga a otorgar servicios educacionales en los términos indicados en el respectivo contrato y se reserva el derecho a modificar la malla curricular y la oferta académica.
                </p>
            </div>
        </div>
    </section>
</section>