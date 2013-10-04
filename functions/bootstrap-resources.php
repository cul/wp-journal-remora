<?php
/**
 * Loads the twitter Bootstrap styles and scripts into WordPress.
 * 
 * NOTE: This needs to be called via do_action rather than add_action because a 
 * variable is passed for where to get the source. Other than that, it 
 * loads the resources with the standard WordPress methods.
 * 
 */ 

function bootstrap_resources($local = true) {

	$bsScript = ($local) ? get_template_directory_uri() . '/assets/js/bootstrap.min.js' : '//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js';
	$bsStyle = ($local) ? get_template_directory_uri() . '/assets/css/bootstrap.min.css' : '//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css';

	wp_register_script('bootstrap-scripts', $bsScript);
	wp_register_style('bootstrap-styles', $bsStyle);

	//if($local) wp_enqueue_style('bootstrap-styles-cdn', '//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css');
	wp_enqueue_script('bootstrap-scripts', $bsScript, array('jquery'), '3.0.0', true);
	wp_enqueue_style('bootstrap-styles', $bsStyle, null, '3.0.0', true);

}

if(!is_admin()) add_action('load_bootstrap_resources', 'bootstrap_resources', 10, 1);

/**
 * A wp_link_pages which takes advantage of Bootstrap
 */
function bootstrap_wp_link_pages($args = '') {
    $defaults = array(
            'before' => '' ,
        'after' => '',
            'link_before' => '', 
        'link_after' => '',
            'next_or_number' => 'number', 
        'nextpagelink' => __('Next page'),
            'previouspagelink' => __('Previous page'), 
        'pagelink' => '%',
            'echo' => 1
    );
    
    $r = wp_parse_args( $args, $defaults );
    $r = apply_filters( 'wp_link_pages_args', $r );
    extract( $r, EXTR_SKIP );
    
    global $page, $numpages, $multipage, $more, $pagenow;
    
    $output = '';
    if ( $multipage ) {
            if ( 'number' == $next_or_number ) {
                    $output .= $before . '<ul>';
                    $laquo = $page == 1 ? 'class="disabled"' : '';
                    $output .= '<li ' . $laquo .'>' . _wp_link_page($page -1) . '&laquo;</a></li>';
                    for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
                            $j = str_replace('%',$i,$pagelink);
                            
                            if ( ($i != $page) || ((!$more) && ($page==1)) ) {
                                $output .= '<li>';
                                    $output .= _wp_link_page($i) ;
                            }
                            else{
                                $output .= '<li class="active">';
                                    $output .= _wp_link_page($i) ;
                            }
                            $output .= $link_before . $j . $link_after ;
                            $output .= '</a>';
    
                $output .= '</li>';
                    }
                    $raquo = $page == $numpages ? 'class="disabled"' : '';
                    $output .= '<li ' . $raquo .'>' . _wp_link_page($page +1) . '&raquo;</a></li>';
                    $output .= '</ul>' . $after;
            } else {
                    if ( $more ) {
                            $output .= $before . '<ul class="pager">';
                            $i = $page - 1;
                            if ( $i && $more ) {
                                    $output .= '<li class="previous">' . _wp_link_page($i);
                                    $output .= $link_before. $previouspagelink . $link_after . '</a></li>';
                            }
                            $i = $page + 1;
                            if ( $i <= $numpages && $more ) {
                                    $output .= '<li class="next">' .  _wp_link_page($i);
                                    $output .= $link_before. $nextpagelink . $link_after . '</a></li>';
                            }
                            $output .= '</ul>' . $after;
                    }
            }
    }
    
    if ( $echo )
            echo $output;
    
    return $output;
}