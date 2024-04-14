<!-- Modale de contact -->
<div id="contactModal" class="modal hidden">
  <!-- Contenu de la modale -->
  <div class="modal-content">
    <div class="modal-title"></div>
    <div class="modal-title"></div>

    <!-- Bouton pour fermer la modale -->
    <span class="close">&times;</span>
       <?php 
       // get_field('reference')
				$reference = "";
				if (get_field('reference')) {
					$reference = get_field('reference');
				};  
       echo do_shortcode('[contact-form-7 id="3e98797" title="Formulaire modale"]'); ?>
    </div>
</div>