
document.addEventListener("DOMContentLoaded", function () {
    console.log("HTML prêt. Lancement du script !!!");
        console.log("script.js est lancé");
        
        const parcour_pro = document.getElementById('parcourpro');
        const exppro_formation = document.getElementById('exppro');

        
        window.addEventListener('scroll', moveProfessionals);
        
        //moveClouds();
        
    function moveProfessionals() {
        console.log("scroll demarré");
            const triggerBottom = window.innerHeight / 5 * 4;
            /*const parcour_pro_top = getOffset(parcour_pro).top;
            const exppro_formation_top = getOffset(exppro_formation).top;*/
            const parcour_pro_top = parcour_pro.getBoundingClientRect().top;
            const exppro_formation_top = exppro_formation.getBoundingClientRect().top
        
            if(parcour_pro_top < triggerBottom) {
                parcour_pro.classList.add('move');
            } else {
                parcour_pro.classList.remove('move');
            }
        
            if(exppro_formation_top < triggerBottom) {
                exppro_formation.classList.add('move');
            } else {
                exppro_formation.classList.remove('move');
            }
        }

        function getOffset(el) {
            const rect = el.getBoundingClientRect();
            return {
            left: rect.left + window.scrollX,
            top: rect.top + window.scrollY
            };
        }
        
    });