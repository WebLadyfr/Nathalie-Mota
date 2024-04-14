// Fonction pour ouvrir la modale de contact
function openContactModal(reference) {
    var contactModal = document.querySelector("#contactModal");
    contactModal.style.display = "block";
        
}

// Fonction pour fermer la modale de contact
function closeContactModal() {
    var contactModal = document.querySelector("#contactModal");
    contactModal.style.display = "none";
    };

// Fermer la modale en cliquant sur le bouton de fermeture
document.querySelector(".close").addEventListener("click", closeContactModal);

// Fermer la modale en cliquant en dehors du contenu de la modale
window.addEventListener("click", function(event) {
    if (event.target === document.querySelector("#contactModal")) {
        closeContactModal();
    }
});

// Ouvrir la modale de contact lorsque la page se charge
window.addEventListener("load", function() {
    openContactModal(); // Ouvrir la modale de contact par défaut au chargement de la page
});
var btnContacts = document.querySelectorAll(".btn-contact");

jQuery(document).ready(function($) {
    // Votre code jQuery ici
    $(".btn-contact").click(function() {
        var referenceValue = $(this).data("reference");
        $("#referenceField").val(referenceValue);
    });
});
// Slider miniature single custom post

const thumbnails = document.querySelectorAll('.thumbnails');
const arrowLeft = document.querySelector('.arrow-left');
const arrowRight = document.querySelector('.arrow-right');

let currentSlide = 0;
let isHovering = false;

// Fonction pour cacher toutes les diapositives
function hideSlides() {
    thumbnails.forEach((thumbnail) => {
        thumbnail.style.display = 'none';
    });
}
// Cacher les vignettes au chargement de la page
hideSlides();

// Fonction pour afficher la diapositive correspondant à l'index donné
function showSlide() {
    thumbnails.forEach((thumbnail, index) => {
      // condition ternaire
    thumbnail.style.display = index === currentSlide ? "block" : "none";
  });
}
// Fonction pour passer à la diapositive suivante
function nextSlide() {
    currentSlide++;
    if (currentSlide >= thumbnails.length) {
        currentSlide = 0; // Revenir à la première diapositive
    }
    showSlide(currentSlide);
}

// Fonction pour passer à la diapositive précédente
function prevSlide() {
    currentSlide--;
    if (currentSlide < 0) {
        currentSlide = thumbnails.length - 1; // Passer à la dernière diapositive
    }
    showSlide(currentSlide);
    
}
// Gérer l'affichage des vignettes avec les flèches de navigation

// fleche gauche   
if (arrowLeft) {
     //au survol
    arrowLeft.addEventListener('mouseenter', () => {
        isHovering = true;
        prevSlide()
    });  
    //au clic
    arrowLeft.addEventListener('click', prevSlide);
}

// fleche droite
if (arrowRight) {
    //au survol
    arrowRight.addEventListener('mouseenter', () => {
        isHovering = true;
        nextSlide()
    });
    //au clic
    arrowRight.addEventListener('click', nextSlide);
}