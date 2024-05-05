document.addEventListener("DOMContentLoaded", function () {
    var lightboxContainer = document.querySelector(".lightbox");
    var lightboxImage = lightboxContainer.querySelector(".lightbox-image");
    var lightboxReference = lightboxContainer.querySelector(".reference");
    var lightboxCategorie = lightboxContainer.querySelector(".categorie");
    var lightboxClose = lightboxContainer.querySelector(".lightbox-close");
    var postContainers = document.querySelectorAll(".post-container");
    var prevButton = lightboxContainer.querySelector(".previous");
    var nextButton = lightboxContainer.querySelector(".next");
    var allPostContainers = Array.from(postContainers);
    var currentImageIndex;

    // Fonction pour ouvrir la lightbox
    function openLightbox(element) {
        lightboxContainer.classList.add("open");

        var reference = element.querySelector(".icon").getAttribute("data-reference");
        var categorie = element.querySelector(".icon").getAttribute("data-categorie");
        var imageUrl = element.querySelector(".icon").getAttribute("data-thumbnail-url");

        lightboxImage.src = imageUrl;
        lightboxReference.textContent = reference;
        lightboxCategorie.textContent = categorie;

        // Récupérer l'index de l'image actuellement affichée
        currentImageIndex = allPostContainers.indexOf(element);
    }
    
    function addOpenLightboxEvent(postContainers) {
        postContainers.forEach(function(postContainer) {
            postContainer.addEventListener("click", function(event) {
                if (event.target.closest(".icon")) {
                    event.preventDefault();
                    openLightbox(postContainer);
                }
            });
        });
    }
// Sélectionner tous les conteneurs de publication
var allPostContainers = document.querySelectorAll(".post-container");

// Ajouter l'événement de clic pour ouvrir la lightbox à tous les conteneurs de publication
addOpenLightboxEvent(allPostContainers);
    

    // Gestionnaire d'événement pour fermer la lightbox au clic sur le bouton de fermeture
    lightboxClose.addEventListener("click", function () {
        lightboxContainer.classList.remove("open");
    });

    // Gestionnaires d'événements pour les boutons "Précédent" et "Suivant" de navigation
    prevButton.addEventListener("click", function() {
        // Décrémenter l'index de l'image actuelle
        currentImageIndex--;
        // Si l'index devient inférieur à zéro, revenir à la dernière image du catalogue
        if (currentImageIndex < 0) {
            currentImageIndex = allPostContainers.length - 1;
        }
        // Récupérer le conteneur de l'image précédente
        var prevImageContainer = allPostContainers[currentImageIndex];
        // Afficher l'image précédente dans la Lightbox
        openLightbox(prevImageContainer);
    });

    nextButton.addEventListener("click", function() {
        // Incrémenter l'index de l'image actuelle
        currentImageIndex++;
        // Si l'index dépasse la dernière image du catalogue, revenir à la première image
        if (currentImageIndex >= allPostContainers.length) {
            currentImageIndex = 0;
        }
        // Récupérer le conteneur de l'image suivante
        var nextImageContainer = allPostContainers[currentImageIndex];
        // Afficher l'image suivante dans la Lightbox
        openLightbox(nextImageContainer);
    });
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
          $(".photos .post-container").remove();
  
          // Ajoute les nouveaux articles filtrés
          $(".photos").append(response);
  
          // Réinitialise la page à 1 après avoir appliqué les filtres
          $(".photos").data("page", 1);
  
          // Affiche à nouveau le bouton "Charger plus"
          $(".btn-load").show().text("Charger plus");

          var postContainers = document.querySelectorAll(".post-container");

          addOpenLightboxEvent(postContainers);
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
          
          //Appel de la fonction pour ouvrir la lightbox quand on charge plus de photos
          var postContainers = document.querySelectorAll(".post-container");

          addOpenLightboxEvent(postContainers);

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

});

