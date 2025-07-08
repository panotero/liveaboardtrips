<?php

class Pdf
{
    public function __construct()
    {
        // Include the Dompdf autoloader
        require_once(APPPATH . 'libraries/dompdf/autoload.inc.php');
    }

    public function create_pdf($html, $filename = '')
    {
        // Reference the Dompdf namespace
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        $dompdf->stream($filename, array("Attachment" => true));
    }
    public function upload_pdf($html, $file_path)
    {
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->load_html($html);
        $dompdf->render();

        // Save the generated PDF to the file path
        file_put_contents($file_path, $dompdf->output());
        return $dompdf->output();
    }
}
