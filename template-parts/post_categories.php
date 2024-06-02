<?php $taxonomy = 'category';

// Get the term IDs assigned to post.
$post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );

// Separator between links.
$separator = ', ';

if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {

	$term_ids = implode( ',' , $post_terms );

	$terms = wp_list_categories( array(
		'title_li' => '',
		'style'    => 'none',
		'echo'     => false,
		'taxonomy' => $taxonomy,
		//'include'  => $term_ids
    ));

	$terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );
    $fruitsArray = explode(',', $terms);
 
// Output each element of the
// resulting array
foreach ($fruitsArray as $fruit) {
    print_r($fruit);
    if($fruit === "wordpress"){
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/icons8-wordpress-240.png" alt="Pas de photo" width="77px" ><br>';
    }else{
        echo "pas de wordpress";
    }
}

	// Display post categories.
	//print_r($fruitsArray) ;
}