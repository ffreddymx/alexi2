<?php
require('../../librerias/pdf/fpdf.php');
require_once "../../clases/Conexion.php";
require_once "../../clases/Ventas.php";

class PDF extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

//==========================================================================                Configuracion de tablas
function Row($data,$alinea)
{
    //Calculate the height of the row
    $nb=0;
    for($i=1;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=6*$nb;//alto de la fila
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    $fill = true;
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        if($i<=0)// verifico menor que 5 para alinear las columnas
         $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        else // verifico si es encabezado para alinearlo a la izquierda
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border

        $this->Rect($x,$y,$w,$h);
        $this->MultiCell($w,6,$data[$i],8,$a,'true'); //aqui modifique ante 5,1
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);

    }
    //Go to the next line
    $this->Ln($h);
}

//==========================================================================                Configuracion de tablas

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

//==========================================================================             Encabezados

function Header()
{

$this->Image('../../img/logo.jpg',4,2,30,30);
//$mysqli -> set_charset("utf8");
    $this->SetFont('Arial','B',10);
    $this->Cell(0,6,utf8_decode("Tacotalpa, Tabasco, Fraccionamiento Nuevo San Ramón"),0,1,'C');
    $this->SetFont('Arial','',10);
    $this->Cell(0,6,utf8_decode("Carretera Tacotalpa - Santa Rosa km. 2+200, Ria. Santa Rosa, Tacotalpa, Tabasco."),0,1,'C');
    $this->Ln(-1);
    $this->SetFont('Arial','B',10);
    $this->Cell(0,6,utf8_decode("Recibo de Pago"),0,1,'C');

}

//==========================================================================             Pie de la pagina

function Footer()
{


 
}
//==========================================================================      Cuerpo del programas
}



    $idventa = $_GET["idventa"];

    $pdf=new PDF('P','mm','Letter'); //P es verical y L horizontal
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetMargins(10,10,10);
	$pdf->AliasNbPages();

    $c= new conectar();
    $conexion=$c->conexion();

    $obj= new ventas();

    $sql="SELECT id_venta,
                fechaCompra,
                id_cliente 
            from ventas  where id_venta = '$idventa' ";
    $result=mysqli_query($conexion,$sql); 

     $pdf->Ln(5);

while ($fila = mysqli_fetch_array($result)){



  $pdf->SetXY(20,40);
  $pdf->Cell(80,10,'Folio/ID:   '.$fila['id_venta'] ,0,0,'L');


  $pdf->SetXY(140,40);
  $pdf->Cell(80,10,'Fecha:   '.$fila['fechaCompra'],0,0,'L');


  $pdf->SetXY(20,50);
  if($obj->nombreCliente($fila['id_cliente'])==" ")
      $pdf->Cell(80,10,'Nombre del Cliente:   S/C ',0,0,'L');
   else
      $pdf->Cell(80,10,'Nombre del Cliente:    '.$obj->nombreCliente($fila['id_cliente']),0,0,'L');


  $pdf->SetXY(20,60);
  $pdf->Cell(80,10,'Total de Pago:      $'.$obj->obtenerTotal($fila['id_venta']),0,0,'L');


  $pdf->SetXY(30,80);
  $pdf->Cell(80,10,'____________________________',0,0,'L');
  $pdf->SetXY(35,90);
  $pdf->Cell(187,10,'Firma de Administrador',0,0,'L');


  $pdf->SetXY(120,80);
  $pdf->Cell(80,10,'____________________________',0,0,'L');
  $pdf->SetXY(135,90);
  $pdf->Cell(187,10,'Firma del Cliente',0,0,'L');

}

   $pdf->Ln(-15);

$pdf->Output();
?>