<?PHP
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

// print_r($_FILES);
if(isset($_POST["name"]) && isset($_FILES["upload"]) && isset($_FILES["upload"]["tmp_name"]) && $_FILES["upload"]["type"] == "application/pdf" ){
    
    require('vendor/autoload.php');
    
    $pdf = new Fpdi();  
    // add a page
    $pdf->addPage();  
    // set the sourcefile  
    // $pdf->setSourceFile('sample.pdf');  
    $pdf->setSourceFile($_FILES["upload"]["tmp_name"]);  
    
    // import page 1  
    $tplIdx = $pdf->importPage(1);  
    // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    // now write some text above the imported page
    $pdf->AddFont('MsMadi-Regular', '', 'MsMadi-Regular.php', 32);
    
    $pdf->SetTextColor(160, 64, 0 );
    $pdf->SetFont('MsMadi-Regular','',20);  
    $pdf->SetXY(-60, -30);  
    $pdf->Write(0, $_POST["name"]);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',6);  
    $pdf->SetXY(-60, -24);  
    $pdf->Write(0, date("d M Y h:i:s A"));
    $pdf->SetFont('Arial','B',5);  
    $pdf->SetXY(-60, -22);  
    $pdf->Write(0, "Client Ip : ".get_client_ip());
    $pdf->Output();

}






function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="container py-5">
    <form method="post" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label>Pdf File</label>
            <input type="file" required name="upload" accept="application/pdf,application/vnd.ms-excel" class="form-control" />
        </div>
        <div class="form-group mb-3">
            <label>Signed By</label>
            <input type="text" required name="name"  class="form-control" placeholder="Signed By" />
        </div>
        <div class="form-group">
            <input type="submit" value="Submit" class="btn w-100 btn-danger" />
        </div>
    </form>
</div>