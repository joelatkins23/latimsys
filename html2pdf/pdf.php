
	


<?php 
$content='';
			

	


        $content .= '<div style="padding:50px;">';
		$content .= '<div style="width:50%; height:300px;">';
		$content .= '<img src="./img/logo.png" style="width:130px; float:left;">';
			$content .= '<div style="float:right; position:relative; left:10px;">';
			$content .= '<strong><p style="font-weight:700; font-size:1.3em;">Latim Cargo & Trading</p></strong>';
			$content .= '<p style="margin-top:-10px;">Hengli north street, Hengli cun, Renhe town,</p>';
			$content .= '<p style="margin-top:-10px;">Baiyun District, Guangzhou City, CHINA / +86.132.6811.6490</p>';
			$content .= '<p style="margin-top:-10px;">广州市拉汀国际贸易有限公司</p>';
			$content .= '<p style="margin-top:-10px;">广州市白云区人和镇横沥村拱津西㇐巷2号</p>';
			$content .= '<p style="color:red; margin-top:-14px; text-decoration:underline;">www.latimcargo.com</p>';
			$content .= '</div>';
		$content .= '<div style="float:right; position:relative; left:400px; top:0px;">';
			$content .= '<p><span style="font-weight:700;">Invoice N°</span> <span style="border-bottom:2px solid black; color:red; ">018               </span>.</p>';
		$content .= '</div>';



		$content .= '</div>';
			$content .= '<br>';


		 $content .= '<div style="width:100%;">';
        $content .= '<table>';

        $content .= '<tr><td>Mail To</td> <td>' . '$mailto' . '</td> </tr>';
        $content .= '<tr><td>Mail From</td>   <td>' . '$mailfrom' . '</td> </tr>';
        $content .= '<tr><td>Mail Subject</td>   <td>' . '$mailsubject' . '</td> </tr>';
        $content .= '<tr><td>Firstname</td>   <td>' . '$firstname' . '</td> </tr>';
        $content .= '<tr><td>Lastname</td>   <td>' . '$lastname' . '</td> </tr>';
        $content .= '<tr><td>Description</td>   <td>' . '$description' . '</td> </tr>';

        $content .= '</table>';
         $content .= '</div>';

        $content .= '</div>';




?>
<?php
ob_start();
include(dirname(__FILE__).'/res/pdf_demo.php');
$content = ob_get_clean();

// conversion HTML => PDF
require_once(dirname(__FILE__).'/html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P','A4', 'fr', false, 'ISO-8859-15');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('pdf_demo.pdf'); 
}
catch(HTML2PDF_exception $e) { echo $e; }
?>