<?php
namespace WPFac\HostedPage\Src;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Templating engine.
 */
class Templating
{
    
	/**
	 * Adaptation of wordpress get_template_part
	 * @param string $slug template file slug
	 * @param string $name template fila name
	 * @param array $args arguments to pass to template file
	 * @return void
	 */ 
	public function get_template_part(string $slug, string $name = null, $args = []) 
    {
    	if(!get_template_part($slug, $name, $args )) 
        {
        	if( !get_template_part(WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . "/{$slug}", $name, $args ) ) 
            {
            	extract($args, EXTR_SKIP);
            
        		include( 	sprintf("%s/templates/%s.php", WP_FAC_HOSTED_PAGE_PATH , (empty($name)? $slug : "{$slug}-{$name}") ) );
            }
        }
    }
}
