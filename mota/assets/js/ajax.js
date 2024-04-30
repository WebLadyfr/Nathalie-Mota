console.log("ajax.js est chargé");
jQuery(function ($) {
    //* Fonction pour gérer les changements de filtres
  
    function handleFilterChange() {
      // Collecte des valeurs des filtres sélectionnés
      var categorie = $("#categories").val();
      var format = $("#formats").val();
      var annee = $("#annee").val();
      var url = jQuery(".btn-load").data('ajaxurl');

      // Requête AJAX pour récupérer les articles filtrés
      $.ajax({
        url,
        type: "POST",
        data: {
          action: "load_more_photos",
          categorie: categorie,
          format: format,
          annee: annee,
        },
        success: function (response) {
          // Supprime les articles existants du catalogue
          $("#catalogue .post-container").remove();
  
          // Ajoute les nouveaux articles filtrés
          $("#catalogue").append(response);
  
          // Réinitialise la page à 1 après avoir appliqué les filtres
          $("#catalogue").data("page", 1);
  
          // Affiche à nouveau le bouton "Charger plus"
          $(".btn-load").show().text("Charger plus");
        },
      });
    };

function loadMorePosts() {
    var catalogue = jQuery(".photos");
    var currentPage = parseInt(catalogue.data("page"));
    var url = jQuery(".btn-load").data('ajaxurl');
    var categorie = jQuery("#categories").val(); // Valeur de la catégorie sélectionnée
    var format = jQuery("#formats").val(); // Valeur du format sélectionné
    var annee = jQuery("#annee").val();
    console.log('les filtres sont chargés')


    // Effectuer la requête Ajax
    jQuery.ajax({
      url,
      type: "POST",
      dataType: "html",
      data: {
        action: "load_more_photos",
        page: currentPage,
        categorie: categorie,
        format: format,
        annee: annee,
      },
    
      success: function (response) {
        console.log('la fonction est chargé')

        if (response) {
          // Ajouter les nouvelles images au catalogue
          catalogue.append(response);
          // Mettre à jour le numéro de page dans le conteneur
          catalogue.data("page", currentPage + 1);
          // Rétablir le texte du bouton "Charger plus"
          jQuery(".btn-load").text("Charger plus");
        } else {
          // Aucune nouvelle image disponible, cacher le bouton
          jQuery(".btn-load").hide();
        }
      },
      error: function () {
        // Gérer les erreurs
        jQuery(".btn-load").text("Erreur lors du chargement");
      },
    });
  }

  jQuery(document).ready(function($) {

 // Écoute des changements de valeur des filtres
 $("#categories, #formats, #annee").on("change", handleFilterChange);
 
    // Écoute du clic sur le bouton "Charger plus"
    $(".btn-load").on("click", function () {
        console.log('le bouton est cliqué')

      loadMorePosts();
    });
});
});
