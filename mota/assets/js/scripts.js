console.log("js est chargé");

// Fonction bouton
(function($) {
    $(".navbar-open").click(function () {
    console.log("navbar-trigger cliqué");
    $(".navbar-content").animate({ height: "toggle", opacity: "toggle" }, 1000);
    $(".navbar-content").toggleClass("open");
    $(".navbar-burger").toggleClass("close");
  });
  $("a").click(function () {
    if ($(".navbar-content").hasClass("open")) {
      $(".navbar-content").animate(
        { height: "toggle", opacity: "toggle" },
        1000
      );
      $(".navbar-content").removeClass("open");
      $(".navbar-burger").removeClass("close");
    }
  });    
})(jQuery);


// Fonction pour ouvrir la modale de contact avec la référence de la photo
function openContactModal(reference) {
    var contactModal = document.querySelector("#contactModal");
        
    // Préremplir le champ "RÉF. PHOTO" avec la référence de la photo
    var referenceInput = document.querySelector("#referenceInput");
    referenceInput.value = reference;
    contactModal.style.display = "block";
    console.log(reference)
}

// Ouvrir la modale lorsque le bouton contact est cliqué
document.querySelectorAll(".btn-contact").forEach(function(btn) {
    btn.addEventListener('click', function(event) {
        event.preventDefault();
        var reference = this.getAttribute("data-reference"); // Récupérer la référence de la photo
        openContactModal(reference);
    });
});

// Ouvrir la modale lorsque le lien dans le menu est cliqué
document.querySelector(".menu-item-108").addEventListener('click', function(event) {
    event.preventDefault();
    var reference = document.querySelector(".btn-contact").getAttribute("data-reference"); // Récupérer la référence de la photo à partir du premier bouton contact
    openContactModal(reference);
});

// Fonction pour fermer la modale de contact
function closeContactModal() {
    var contactModal = document.querySelector("#contactModal");
    contactModal.style.display = "none";
}

// Fermer la modale en cliquant sur le bouton de fermeture
document.querySelector(".close").addEventListener("click", closeContactModal);

// Fermer la modale en cliquant en dehors du contenu de la modale
window.addEventListener("click", function(event) {
    if (event.target === document.querySelector("#contactModal")) {
        closeContactModal();
    }
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
     console.log('la fléche gauche est cliquée')
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
     console.log('la fléche droite est cliquée')
 }

 
//* Déclarer la bibliothèque select2 pour custom les selects du formulaire de ti

jQuery(document).ready(function ($) {
    $(".js-example-basic-single").select2();
    dropdownPosition: 'below'
  });