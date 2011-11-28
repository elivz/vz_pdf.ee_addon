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
        
        if ($this->EE->TMPL->fetch_param('disable', false) == 'yes') {
            $this->return_data = $this->EE->TMPL->tagdata;
            return;
        }
        
        // Get tag parameters
        $html = $this->EE->TMPL->tagdata;
        $filename = $this->EE->TMPL->fetch_param('filename');
        $caching = $this->EE->TMPL->fetch_param('cache', 'on');
        $save_only = $this->EE->TMPL->fetch_param('display') == 'off';
        $output = $this->EE->TMPL->fetch_param('in_browser') == 'yes' ? 'inline' : 'attachment';

        if (empty($filename) || empty($html)) return;
        
        // See if we have a cached copy already
        $cache_folder = APPPATH.'cache/vz_pdf/';
        $cache_file = $cache_folder.md5($html);
        if ($caching != 'no' && file_exists($cache_file))
        {
            // Use the cached PDF
            $pdf = file_get_contents($cache_file);
        } else {
            // Generate a new PDF
            $pdf = $this->_render_pdf($html);
            
            // & cache the sucker
            if ($caching != 'no')
            {
                if (!file_exists($cache_folder))
                {
                    mkdir($cache_folder);
                }
                file_put_contents($cache_file, $pdf);
            }
        }
        
        // Send the PDF to the browser
        if (!$save_only)
        {
            $this->_stream_pdf($pdf, $filename, $output);
        }
        
        // Kill EE before it screws up the good thing we have going
        die();
    }
	
    private function _render_pdf($html)
    {
        // Get parameters
    	$paper_size = $this->EE->TMPL->fetch_param('size', 'letter');
    	$orientation = $this->EE->TMPL->fetch_param('orientation', 'portrait');
    
        // Create the PDF
    	require_once("dompdf/dompdf_config.inc.php");
    	$dompdf = new DOMPDF();
    	$dompdf->set_paper($paper_size, $orientation);
        $dompdf->load_html($html);
        $dompdf->set_base_path("/srv/www/eli/skramfurniture.com/public/");
        $dompdf->render();
        return $dompdf->output();
    }
    
    private function _stream_pdf($pdf, $filename, $output)
    {
        // Send the PDF headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: application/pdf");
        header("Content-Transfer-Encoding: binary");
        header("Content-Disposition: $output; filename=$filename");
        
        // And send the PDF itself
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