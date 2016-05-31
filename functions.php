
function ntc_list_category_post($atts) {  
   
 extract( shortcode_atts( array(
        'category' => 0,
         'per_page' => 1,
         'pagerange' =>2,
	 'post_type' => 3,
    ), $atts ) );
   $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
   $cat_name = $category;
   $per_page=$per_page;
   $pagerange=$pagerange;
   $post_type=$post_type;
   $args = array( 'category'=>$category,'post_type' => $post_type,'posts_per_page' =>$per_page,'paged' => $paged, 'order'=> 'ASC', 'orderby' => 'id' );
   
                    $postslist = new WP_Query( $args );
					
                   if ( $postslist->have_posts() ) :
        
		   while ( $postslist->have_posts() ) : $postslist->the_post();
		      ?>
                            <div id="blogbackground">
                               <div class="post-body">
                                 <li class="blog-list-title" id="postnum1432883">
                                    <span class="blog-list-title-only">
                                    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                    </span>
                                   <div id="postText1432883">
                                    <div class="blog-thumbnail"><?php the_post_thumbnail(); ?></div>
                                    <?php the_excerpt(); ?>
                                    <a class="blog-read-more" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">read&nbsp;more&nbsp;»</a>
                                   </div>
                                 </li>
                                </div>
                            </div>
<?php
                   endwhile;          

                   endif; 
                      
                   
        echo '<div style="clear:both;"></div>';
      if (function_exists(ntc_custom_pagination)) {
        ntc_custom_pagination($postslist->max_num_pages,$pagerange,$paged);
      }
    
		wp_reset_postdata();
}
add_shortcode('ntclistcategorypost', 'ntc_list_category_post');

function ntc_custom_pagination($numpages = '', $pagerange = '', $paged='') {

  if (empty($pagerange)) {
    $pagerange = 2;
  }

  /**
   * This first part of our function is a fallback
   * for custom pagination inside a regular loop that
   * uses the global $paged and global $wp_query variables.
   * 
   * It's good because we can now override default pagination
   * in our theme, and use this function in default quries
   * and custom queries.
   */
  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }
  if ($numpages == '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
        $numpages = 1;
    }
  }

  /** 
   * We construct the pagination arguments to enter into our paginate_links
   * function. 
   */
  $pagination_args = array(
    'base'            => get_pagenum_link(1) . '%_%',
    'format'          => '?page=%#%',
    'total'           => $numpages,
    'current'         => $paged,
    'show_all'        => False,
    'end_size'        => 1,
    'mid_size'        => $pagerange,
    'prev_next'       => True,
    'prev_text'       => __('&laquo;'),
    'next_text'       => __('&raquo;'),
    'type'            => 'plain',
    'add_args'        => false,
    'add_fragment'    => ''
  );

  $paginate_links = paginate_links($pagination_args);

  if ($paginate_links) {
    echo "<nav class='custom-pagination'>";
      echo "<span class='page-numbers page-num'>Page " . $paged . " of " . $numpages . "</span> ";
      echo $paginate_links;
    echo "</nav>";
  }

}
