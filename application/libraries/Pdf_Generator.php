<?php
use Dompdf\Dompdf;
use Dompdf\Options;
class Pdf_Generator {

    public $ci;
    public function __construct()
    {
        $this->ci=&get_instance();
    }

    public function get_pdf_object(){
        include_once(APPPATH.'third_party/dompdf/autoload.inc.php');
        $options = new Options();
		$options->set('isRemoteEnabled', TRUE);
		$options->set('debugKeepTemp', TRUE);
		$options->set('isHtml5ParserEnabled', true);
        return new DOMPDF($options);

    }

}
