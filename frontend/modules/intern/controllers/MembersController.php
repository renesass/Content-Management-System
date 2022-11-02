<?php

namespace frontend\modules\intern\controllers;

use Spipu\Html2Pdf\Html2Pdf;

class MembersController extends \yii\web\Controller
{
    public function actionList()
    {
        // init HTML2PDF
		$html2pdf = new Html2Pdf('L', 'A4', 'de', true, 'UTF-8', array(0, 0, 0, 0));
	
		// display the full page
		$html2pdf->pdf->SetDisplayMode('fullpage');
	
		// get the HTML
		$content = $this->renderPartial('list');
        
        $html2pdf->pdf->setTitle('Adressliste');
		
		// convert
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	
		// send the PDF
		$html2pdf->Output('Adressliste.pdf');
    }
}
