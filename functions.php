<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    // Chargement du css/theme.css pour nos personnalisations
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/theme.css'));

}

function astra_force_remove_style() {
    wp_dequeue_style( 'astra-theme-css' );
    wp_dequeue_style( 'astra-addon-css' );
}

add_action( 'wp_enqueue_scripts', 'astra_force_remove_style', 99 );

// Active ICON
function techno_icon () {
    // Récupération de la liste de tous les terms 
    /*$allTerm = get_terms('techno-acf');  
    $field = get_field('techno');
    
    if (!empty($field) && !$field == "") {
        foreach ($field as $data) {
            // var_dump($data);

            if ($data->slug == "html") { 
                echo('<span class="icon_html" title="Utilisation de HTML5"><i class="fa-brands fa-html5"></i></span>'); 
            } 
            if ($data->slug == "css") { 
                echo('<span class="icon_css" title="Utilisation de CSS3" ><i class="fa-brands fa-css3"></i></span>'); 
            } 
            if ($data->slug == "js" || $data->slug == "javascript") { 
                echo('<span class="icon_js" title="Utilisation de JavaScript"><i class="fa-brands fa-js"></i></span>'); 
            } 
            if ($data->slug == "php") { 
                echo('<span class="icon_php" title="Utilisation de PHP8"><i class="fa-brands fa-php"></i></span>'); 
            } 
            if ($data->slug == "wp"  || $data->slug == "wordpress") { 
                echo('<span class="icon_wp" title="Utilisation de WordPress 6" ><i class="fa-brands fa-wordpress"></i></span>'); 
            }                 
            if ($data->slug == "woo commerce"  || $data->slug == "woo-commerce") { 
                echo('<span class="icon_woo-commerce woo-commerce hidden" title="Utilisation de Woo-Commerce" ><img src="'. get_stylesheet_directory_uri() . '/assets/img/woocommerce-couleur-48.png" /></span>');  
            } 
        }
    }*/
    $fruitsArray=get_the_category(the_ID());
    foreach ($fruitsArray as $fruit) {
        if($fruit->name === "wordpress"){
            echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/icons8-wordpress-240.png" alt="Pas de photo" width="77px" >';
        }
        if($fruit->name === "php"){
            echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/icons8-php-160.png" alt="Pas de photo" width="77px" >';
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
        $project_origin = "openclassroom"/*get_field('project_origin')*/;                   
        
        $string .= '<div class="'. $post_type .' article_details article_'. $post_id .'">';
        $string .= '<a class="article_link" href="'. get_the_permalink() .'">';
        $string .= get_the_post_thumbnail();
        if (!$project_origin == "") {
            $string .= '<p class="origin">Avec '. $project_origin .'</p>';
        } 
        $string .= '<p class="taxonomy-techno-acf flexrow portfolio_icon">';
        
        // Recherche des techno utilisées pour afficher les icones correspondants
        /*$field = get_field('techno');
        if (!empty($field) && !$field == "") {
            foreach ($field as $data) {
    
                if ($data->slug == "html") { 
                    $string .= '<span class="icon_html html" title="Utilisation de HTML5"><i class="fa-brands fa-html5"></i></span>'; 
                } 
                if ($data->slug == "css") { 
                    $string .= '<span class="icon_css css" title="Utilisation de CSS3" ><i class="fa-brands fa-css3"></i></span>'; 
                } 
                if ($data->slug == "js" || $data->slug == "javascript") { 
                    $string .= '<span class="icon_js javascript" title="Utilisation de JavaScript"><i class="fa-brands fa-js"></i></span>'; 
                } 
                if ($data->slug == "php") { 
                    $string .= '<span class="icon_php php" title="Utilisation de PHP8"><i class="fa-brands fa-php"></i></span>'; 
                } 
                if ($data->slug == "wp"  || $data->slug == "wordpress") { 
                    $string .= '<span class="icon_wp wordpress" title="Utilisation de WordPress 6" ><i class="fa-brands fa-wordpress"></i></span>'; 
                }                 
                if ($data->slug == "elementor") { 
                    // $string .= '<span class="icon_elementor icon_image hidden" title="Utilisation du page builder Elementor" ><img src="'. get_stylesheet_directory_uri() . '/assets/img/Elementor-couleur-24.png" /></span>'; 
                    $string .= '<span class="icon_elementor icon_image hidden" title="Utilisation du page builder Elementor" ></span>'; 
                } 
                if ($data->slug == "gutenberg") { 
                    // $string .= '<span class="icon_gutenberg icon_image hidden" title="Utilisation du page builder Gutenber" ><img src="'. get_stylesheet_directory_uri() . '/assets/img/gutenberg-couleur-48.png" /></span>'; 
                    $string .= '<span class="icon_gutenberg icon_image hidden" title="Utilisation du page builder Gutenber" ></span>'; 
                } 
                if ($data->slug == "jquery") { 
                    // $string .= '<span class="icon_jquery hidden" title="Utilisation de jQuery" ><img src="'. get_stylesheet_directory_uri() . '/assets/img/jQuery-couleur-48.png" /></span>'; 
                    $string .= '<span class="icon_jquery hidden" title="Utilisation de jQuery" ></span>'; 
                } 
                if ($data->slug == "woocommerce" || $data->slug == "woo-commerce" ) { 
                    $string .= '<span class="icon_woo-commerce icon_image hidden" title="Utilisation de Woo Commerce" ><img src="'. get_stylesheet_directory_uri() . '/assets/img/woocommerce-couleur-48.png" /></span>'; 
                } 
            }
        }*/
        $fruitsArray=get_the_category(the_ID());
        foreach ($fruitsArray as $fruit) {
            if($fruit->name === "wordpress"){
                $string .='<img src="'. get_stylesheet_directory_uri() .'/assets/images/icons8-wordpress-240.png" alt="Pas de photo" width="77px" >';
            }
            if($fruit->name === "php"){
                $string .='<img src="'. get_stylesheet_directory_uri() .'/assets/images/icons8-php-160.png" alt="Pas de photo" width="77px" >';
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
