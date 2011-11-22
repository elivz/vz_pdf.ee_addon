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
	'pi_version'	=> '0.5.0',
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
    }
    
    public function render()
    {
		$this->EE =& get_instance();
		
		// Get tag parameters
		$html = $this->EE->TMPL->tagdata;
		$filename = $this->EE->TMPL->fetch_param('filename');
		$cache_path = $this->EE->TMPL->fetch_param('cache_path');
		$cache_time = $this->EE->TMPL->fetch_param('refresh', 60);
		$save_only = $this->EE->TMPL->fetch_param('display') == 'off';
		$attachment = $this->EE->TMPL->fetch_param('save_file') == 'yes';
		
		if (empty($filename) || empty($html)) return;
		
		// Get the PDF data
		$pdf = $this->_render_pdf($html);
		
		// Send the PDF to the browser
		if (!$save_only)
		{
		  $this->_stream_pdf($pdf, $filename);
		}
		
		$this->return_data = '';
	}
	
	private function _render_pdf($html)
	{
        // Get parameters
		$paper_size = $this->EE->TMPL->fetch_param('paper_size', 'letter');
		$orientation = $this->EE->TMPL->fetch_param('orientation', 'portrait');
	
        // Create the PDF
		require_once("dompdf/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->set_paper($paper_size, $orientation);
        $dompdf->load_html($html);
        $dompdf->render();
        return $dompdf->output();
	}
	
	private function _stream_pdf($pdf, $filename)
	{
    	header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public"); 
        header("Content-Description: File Transfer"); 
        header("Content-Type: application/pdf"); 
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Transfer-Encoding: binary");
        echo $pdf;
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