<?php
/**
 * The single : ATRICLE BLOG 
 *
 * @package WordPress
 * @subpackage stephane Mouron theme
 */

	get_header();

?>

<div class="single__page">
	<div class="container__info__post">
		<div class="container__title flexcolumn center">
		<h1>
			<?php echo(get_the_title()); ?>		
		</h1>	
		<h2><?php echo(get_the_content()); ?></h2>
		<p class="flexrow techno_icon single_page center">
			<!-- Affichage des icones des technologies / langages utilisés -->
			<?php techno_icon(); ?>
		</p>
		</div>

		<div class="container__top flexrow wrap">
			<div class="container__top__image flexrow center">
			<?php
			//$image1 = /*get_field('image_sup_1')*/echo get_stylesheet_directory_uri() .'/assets/images/hero-koukaki.png';
			$slider = /*get_field('project_slider')*/"";
			if (!empty($slider) && !$slider =="") {
				echo($slider);	
			} else if (!empty($image1) && !$image1 =="") {
				echo('<img src="'. $image1 .'" alt="'. get_the_title() .'" title="'. get_the_title() .'">');
			} else {
				echo(get_the_post_thumbnail()); 
			}
			?>	
			</div>	
		</div>

		<div class="separator">
			<span class="separator__element"></span>
			<span class="separator__element"></span>
			<span class="separator__element"></span>
			<span class="separator__element"></span>
			<span class="separator__element"></span>
			<span class="separator__element"></span>
			<span class="separator__element"></span>
			<span class="separator__element"></span>
		</div>
		
		<div class="container__middle flexrow wrap">
			<div class="container__middle__left background__post flexcolumn">
				<h3>Détails du projet à effectuer</h3>
            <p><?php echo(get_field('project_mission')); ?></p>	
			</div>
			<div class="container__middle__right background__post">
				<h3>Ce que j'ai fait</h3>
				<p><?php echo(get_field('tasks_completed')); ?></p>	
			</div>			
		</div>

		<div class="container__bottom flexrow wrap center">			
			<!-- <h3>Les sources et les liens</h3> -->
				<div class="container__bottom_figma background__post">
					<h4>La maquette</h4>
					<?php
					$imageMaquette = get_field('img-maquette');
					// !empty($imageMaquette) && !$imageMaquette =="" && !empty($urlMaquette) && !$urlMaquette =="" )
					if (!empty($urlMaquette) && !$urlMaquette =="" ) {
						echo ('<a class="link_figma" href="'. $urlMaquette .'" target="_blank"><i class="fa-brands fa-figma"></i> Lien vers la maquette Figma</a>');
					}
					if (!empty($imageMaquette) && !$imageMaquette =="" ) {
						echo('<a class="link_maquette" href="#imageMaquette"><img src="'. $imageMaquette .'" alt="maquette de '. get_the_title() .'" title="maquette de '. get_the_title() .'"></a>');
						echo('<div class="modal" id="imageMaquette">');
						echo('<a title="Description" href="#ferme">');
						echo('<img alt="Image" src="'. $imageMaquette .'">');
						echo('</a>');
						echo('</div>');
					} else {
						echo ("Il n'y a pas de maquette pour ce projet.");
					}
					?>	
				</div>
				<div id="externals" class="container__bottom_link background__post">
				<h4>Les liens externes</h4>	
				<?php				
				$externalLinks = /*'<a href="https://course.oc-static.com/projects/D%C3%A9veloppeur+Web/DWP+IW_P11+site+WP+complexe/P11+DWP+-+Specifications+fonctionnelles.pdf" target="_blank">Le cahier des charges</a>'*/get_field('external_links');
				//print_r($externalLinks);
                display_external_links($externalLinks);
                //echo('<p>'.$externalLinks.'</p>');
				?>	
				</div>
				<div class="container__bottom_website_link background__post">
				<h4>Le site final</h4>	
				<?php				
				$imageWebsite = get_field('img-web-site')/*get_the_post_thumbnail()*/;				
				//$urlWebsite = get_field('project_link');
				// echo('<a class="link_website" href="'. $urlWebsite .'" target="_blank"></i> Lien vers le site en ligne</a>');
                if (!empty($imageWebsite) && !$imageWebsite =="" ) {
                    echo '<a href="#imageWebsite"><img src="'. $imageWebsite.'" alt="Le site final" title="Le site final">'.'</a>';
                    echo('<div class="modal" id="imageWebsite">');
                    echo('<a title="Accueil du site" href="#ferme">');
                    echo('<img alt="Image" src="'. $imageWebsite .'">');
                    echo('</a>');
                    echo('</div>');
                } else {
                    echo ("Il n'y a pas d'image du site web' pour ce projet.");
                }
				?>	
				</div>
		</div>
	</div>


	<!-- Affichage de post précéent et du suivant -->
	<div class="container__site__navigation flexrow center">
		<div class="site__navigation__prev">
			<?php
			$prev_post = get_previous_post();							
			if($prev_post) {
				$prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
				$prev_post_id = $prev_post->ID;
				echo '<a rel="prev" href="' . get_permalink($prev_post_id) . '" title="' . $prev_title. '" class="previous_post">';
				if (has_post_thumbnail($prev_post_id)){
					?>
					<div>
						<?php echo get_the_post_thumbnail($prev_post_id, array(300,200));?>
					</div>
					<?php
					} else {
						echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/no-image.jpeg" alt="Pas de photo" width="300px" ><br>';
					}							
				echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/precedent.png" alt="Précédent" >  Réalisation précédente</a>';
			}
			?>
			</div>
			<div class="site__navigation__next">
				<!-- next_post_link( '%link', '%title', false );  -->
				<?php
				$next_post = get_next_post();
				if($next_post) {
					$next_title = strip_tags(str_replace('"', '', $next_post->post_title));
					$next_post_id = $next_post->ID;
					echo  '<a rel="next" href="' . get_permalink($next_post_id) . '" title="' . $next_title. '" class="next_post">';
					if (has_post_thumbnail($next_post_id)){
						?>
						<div>
							<?php echo get_the_post_thumbnail($next_post_id, array(300,200));?>
						</div>
						<?php
						} else{
							echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/no-image.jpeg" alt="Pas de photo" width="300px" ><br>';
						}							
					echo 'Réalisation suivante <img src="'. get_stylesheet_directory_uri() .'/assets/images/suivant.png" alt="Suivant" ></a>';
				}
				?>
					
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>
		
		