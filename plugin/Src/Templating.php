<?php
namespace WPFac\HostedPage\Src;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Templating engine.
 */
class Templating
{
    /**
     * Render a template.
     *
     * @param string $path Path to the template to render, relative to the
     *                     `templates/` directory
     * @param array  $data This array can be referenced in the template
     * @param bool	$return Return the template markup. False to print.
     */
    public function render($path, $data = array(), $return = false)
    {
    	$file = __DIR__."/../../asset/templates/$path.php";
    	if($return) 
        {
        	ob_start();		
			include($file);
			$contents = ob_get_contents();
			ob_end_clean();
        
        	return <<<TEMPLATE
            {$contents}
            TEMPLATE;
        }
    
        include realpath($file);
    }
}
