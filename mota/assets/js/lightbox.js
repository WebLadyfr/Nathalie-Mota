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

    // Gestionnaire d'événement pour ouvrir la lightbox au clic sur une image
    postContainers.forEach(function(postContainer) {
        postContainer.addEventListener("click", function(event) {
            if (event.target.closest(".icon")) {
                event.preventDefault();
                openLightbox(postContainer);
            }
        });
    });

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
});
