<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * VZ PDF Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Eli Van Zoeren
 * @link		http://elivz.com
 */

$plugin_info = array(
	'pi_name'		=> 'VZ PDF',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Eli Van Zoeren',
	'pi_author_url'	=> 'http://elivz.com',
	'pi_description'=> 'Generates PDF files using EE templates',
	'pi_usage'		=> Vz_pdf::usage()
);


class Vz_pdf {

	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
		$html = $this->EE->TMPL->tagdata;
		
		// Get tag parameters
		$file_name = $this->EE->TMPL->fetch_param('file_name');
		$cache_path = $this->EE->TMPL->fetch_param('cache_path');
		$cache_time = $this->EE->TMPL->fetch_param('refresh', 60);
		$save_only = $this->EE->TMPL->fetch_param('display', NULL);
		$paper_size = $this->EE->TMPL->fetch_param('paper_size', 'letter');
		$orientation = $this->EE->TMPL->fetch_param('orientation', 'portrait');
		
		
		if (empty($file_name) || empty($html)) return;
		
		$this->return_data = "";
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

Renders HTML as a PDF using the dompdf library. Will optionally cache the PDF file on the server.

<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}

/* End of file pi.vz_pdf.php */
/* Location: /system/expressionengine/third_party/vz_pdf/pi.vz_pdf.php */