<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    // Chargement du css/theme.css pour nos personnalisations
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/theme.css'));

}
function theme_scripts() {    
    //if (is_single()){
        wp_enqueue_script('skollr-scroll', 'https://cdnjs.cloudflare.com/ajax/libs/skrollr/0.6.30/skrollr.min.js', array('jquery'));
        wp_enqueue_script('script', get_stylesheet_directory_uri() . '/assets/js/script.js', array('skollr-scroll'));
    //}
   
}
add_action('wp_enqueue_scripts', 'theme_scripts');


function astra_force_remove_style() {
    wp_dequeue_style( 'astra-theme-css' );
    wp_dequeue_style( 'astra-addon-css' );
}
add_action( 'wp_enqueue_scripts', 'astra_force_remove_style', 99 );

// Active ICON
function techno_icon () {
    // Récupération de la liste de tous les terms 
    $post_id = get_the_id();
    $fruitsArray=get_the_category($post_id );
    foreach ($fruitsArray as $fruit) {
        if($fruit->name === "wordpress"){
            echo '<span class="icon_wp" title="Utilisation de WordPress 6" ><i class="fa-brands fa-wordpress"></i></span>'; 
        }
        if($fruit->name === "php"){
            echo '<span class="icon_php" title="Utilisation de PHP"><i class="fa-brands fa-php"></i></span>'; 

        }
        if($fruit->name === "javascript"){
            echo '<span class="icon_js javascript" title="Utilisation de JavaScript"><i class="fa-brands fa-js"></i></span>';
        }
        if($fruit->name === "html"){
            echo '<span class="icon_html html" title="Utilisation de HTML5"><i class="fa-brands fa-html5"></i></span>';
            '<span class="icon_css css" title="Utilisation de CSS3" ><i class="fa-brands fa-css3"></i></span>';
            
        }
        if($fruit->name === "css"){
            echo '<span class="icon_css css" title="Utilisation de CSS3" ><i class="fa-brands fa-css3"></i></span>';
            
        }
    }
}
  
function display_external_links($external){
        if( $external){ 
        
                // Get sub field values.
                $figma = $external['figma'];
                //echo $figma["url"];
                $git = $external['git'];
                $cdc= $external['cdc'];
                $urlsite= $external['site_en_ligne'];
                $tmphtml='<ul class="container_link">';
                if( $figma != ""){
                    $tmphtml .='<li><a class="link" href="';
                    $tmphtml .= esc_url( $figma["url"] );
                    $tmphtml .='" target="';
                    $tmphtml .= esc_html( $figma['target'] );
                    $tmphtml .='" rel="noreferrer noopener nofollow">';
                    $tmphtml .= esc_html( $figma['title'] ).'</a></li>';
                }
                if( $git != ""){
                    $tmphtml .='<li><a class="link" href="'.esc_url( $git["url"] ).'" target="'.esc_html( $git['target'] ).'" rel="noreferrer noopener nofollow">'.esc_html( $git['title'] ).'</a></li>';
                }
                if( $cdc != ""){
                    $tmphtml .='<li><a class="link" href="'.esc_url( $cdc["url"] ).'" target="'.esc_html( $cdc['target'] ).'" rel="noreferrer noopener nofollow">'.esc_html( $cdc['title'] ).'</a></li>';
                }
                if( $urlsite != ""){
                    $tmphtml .='<li><a class="link" href="'.esc_url( $urlsite["url"] ).'" target="'.esc_html( $urlsite['target'] ).'" rel="noreferrer noopener nofollow">'.esc_html( $urlsite['title'] ).'</a></li>';
                }
                $tmphtml .="</ul>";
                echo $tmphtml;
    
        }
}

 /**
 * 
 * Shortcode pour générer la liste des articles à afficher 
 * sur la page qui affiche toutes les réalisations
 * 
 * type = type d'articles que l'on souhaite avoir
 *    Les 3 types de post possible : post / formation-wordpress / exercice
 *    Par défaut on a post
 * 
 * nb = nombre de post que l'on souhaite afficher à la fois. 
 *    Par défaut on a -1 (= tous les post)
 * 
 */
function portfolio_post_list($items) {

    $items = shortcode_atts(array (
        'type' => '',
        'nb' => ''
    ), $items , 'css_separator');
    
    // Si on ne récupère aucune information pour le filtre du type d'articles
    // on concidère que l'on veut le type d'article par défaut qui est 'post'
    if ($items ['type'] == "") {
        $post_type = "post";
    } else {
        $post_type = $items ['type'];
    }
    
    // Si on ne récupère aucune information pour le nombre d'articles à la fois
    // on concidère que l'on veut la quantité d'articles par défaut qui est '-1' (= tout afficher)
    if ($items ['nb'] == "") {
        $posts_per_page = '-1';
    } else {
        $posts_per_page = $items ['nb'];
    }
    
    $string = "";

    // Initialisation de la requette Query
    $custom_args = array(
        'post_type' => $post_type,
        'posts_per_page' => $posts_per_page,
        'nopaging' => true,
    );           
    
    $query_portfolio = new WP_Query( $custom_args ); 

    // On récupère le nombre total d'articles qui sont trouvé avec cette requete
    $nb_total_post  = $query_portfolio->found_posts;
    // Mise en place 
    $string .= '<div class="container_article flexrow wrap">';
    
    // Génération la liste des articles à afficher dans le slider
    if($query_portfolio->have_posts()) : ?>
        <?php while($query_portfolio->have_posts()) : $query_portfolio->the_post(); ?>
        
        <?php       
        // Initialisation des variables de chaque post   
        $term = get_queried_object();
    
        $post_id = get_the_id();
        $post_date = get_the_time('d/m/Y');
        $post_content = get_the_content();
        // $post_name = get_the_title();
        $project_goal = get_field('project_goal');   
        $project_mission = get_field('project_mission');  
        $length_mission = strlen($project_mission); 
        if ($length_mission > 150) {
            $project_mission = mb_substr($project_mission , 0, 150,'UTF-8'); 
            $project_mission .= " ...";
        }
        $project_origin = "openclassroom";                   
        
        $string .= '<div class="'. $post_type .' article_details article_'. $post_id .'">';
        $string .= '<a class="article_link" href="'. get_the_permalink() .'">';
        $string .= get_the_post_thumbnail();
        if (!$project_origin == "") {
            $string .= '<p class="origin">Avec '. $project_origin .'</p>';
        } 
        $string .= '<p class= "techno_web flexrow portfolio_icon">';
        
        // Recherche des techno utilisées pour afficher les icones correspondants
        $fruitsArray=get_the_category($post_id);
        foreach ($fruitsArray as $fruit) {
            if($fruit->name === "wordpress"){
                $string .= '<span class="icon_wp" title="Utilisation de WordPress 6" ><i class="fa-brands fa-wordpress"></i></span>'; 
            }
            if($fruit->name === "php"){
                $string .= '<span class="icon_php" title="Utilisation de PHP"><i class="fa-brands fa-php"></i></span>'; 
            }
            if($fruit->name === "html"){
                $string .='<span class="icon_html html" title="Utilisation de HTML5"><i class="fa-brands fa-html5"></i></span>';
            }
            if($fruit->name === "css"){
                $string .='<span class="icon_css css" title="Utilisation de CSS3" ><i class="fa-brands fa-css3"></i></span>';
            }
            if($fruit->name === "javascript"){
                $string .='<span class="icon_js javascript" title="Utilisation de JavaScript"><i class="fa-brands fa-js"></i></span>';
            }
        }
        $string .= '</p>';   
        $string .= '<div class="container__article_info">';                 
        $string .= '<h3 class="title">' . get_the_title() . '</h3>';
        $string .= '<p>Le ' . $post_date . '</p>';
        $string .= '<h4>Objectif de cette réalisation</h4>';        
        $string .= $post_content;
        $string .= '<h4>A réaliser</h4>';        
        $string .= '<p>' . $project_mission . '</p>';        

        $string .= '<div class="btn_more flexrow">';        
        $string .= '<a class="button center article_link" href="'. get_the_permalink() .'">Lire la suite</a>';
        $string .= '</div>';
        
        $string .= '</div>';
        
        $string .= '</a>';  
        $string .= '</div>';
        
        endwhile; 
    endif; 

    $string .= '</div>';
    
    wp_reset_postdata(); 

    // Pages de test du Swiper 
    if ($items ['type'] == "tests" || $items ['type'] == "test") {
        get_template_part ( 'template-parts/post/post' , 'tests' ); 
    }

	/** On retourne le code  */
	return $string;
}

/** On publie le shortcode  */
add_shortcode('portfolio_post', 'portfolio_post_list');


function shortcode_resume(){
    $string = "";

    $string .= '<div class="studies__jobs">';
            $string .= '<ol class="circle">';
                $string .= '<li><strong>Formations</strong>';
                    $string .= '<ul class="square">';
                        $string .= '<li><strong>2024 - OpenClassrooms</strong><p>Développeur intégrateur web (titre RNCP de niveau V).</p></li>';
                        $string .= '<li><strong>2003 - Ecole des Techniques du Génie Logiciel  </strong><p>Ingénieur Génie Logiciel - CFA AFTI (78) (7_ Yvelines)</p></li>';
                        $string .= '<li><strong>2001 - Université Montpellier II- IUT GEII (34 Montpellier)</strong><p>Bac+2 Technicien Electronique et Informatqiue Industriel</p></li>';
                    $string .= '</ul>';
                $string .= '</li><br><br>';
                    $string .= '<li><strong>Expériences</strong>';
                    $string .= '<ul class="square">';
                        $string .= '<li><strong>Juin 2020 à Dec 2021 - Ingénieur IOT/Embarqué chez BEOGA</strong><p>Développement en C/shell pour un router LAN/WAN avec module Wifi, Zigbee, Modbus, GSM (4G), pour gestion/control des données onduleurs photovoltaïque et compteur Linky.</p></li>';
                        $string .= '<li><strong>Oct 2011 à Aout 2017 - Ingénieur Validation/Développement chez ALTEN  </strong><p>Développement en C pour cible Microblaze (FPGA), noyau temps réel FreeRTOS, pile IP LWIP</p></li>';
                        $string .= '<li><strong>Oct 2007 à Nov 2010 - Consultant chez EUROGICIEL</strong><p>Ingénieur Validation logiciel embarqué aéronautique système de freinage éléctrique du boeing 787 (Norme DO178B DAL A)</p></li>';
                        $string .= '<li><strong>Jan 2005 à Juil 2007 - Consultant chez SOLENT</strong><p>Ingénieur DéveloppementValidation logiciel embarqué aéronautique Avion AIRBUS A400M et A380</p></li>';
                        $string .= '</ul>';
                $string .= '</li>';
    
        $string .= '</ol>';
    $string .='</div>';
 
    return $string;
}

/** On publie le shortcode  */
add_shortcode('resume_content', 'shortcode_resume');