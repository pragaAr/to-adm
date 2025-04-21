<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class pdf
{
  protected $ci;

  public function __construct()
  {
    $this->ci = &get_instance();
  }

  public function generate($view, $data = array(), $filename = 'Laporan', $paper = 'A4', $orientation = 'portrait')
  {
    $option = new Options();
    $option->set('isRemoteEnabled', 'true');
    $dompdf = new Dompdf($option);
    $html = $this->ci->load->view($view, $data, TRUE);
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);

    // Render the HTML as PDF
    $dompdf->render();
    $dompdf->stream($filename . ".pdf", array("Attachment" => FALSE));
  }
}
