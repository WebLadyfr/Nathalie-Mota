<footer class="footer">
		<?php 
			// Affichage du menu footer déclaré dans functions.php
			wp_nav_menu(array(
                'theme_location' => 'footer',
            )); 
		?>
        <!-- Lance la popup contact -->
	<?php 
        get_template_part ( 'template-parts/modale-contact'); 		
    ?>
        <!-- lightbox -->
        <?php
    get_template_part('template-parts/lightbox');
    ?>

</footer>
<?php wp_footer(); ?>
  </body>
</html>