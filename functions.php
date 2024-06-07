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
