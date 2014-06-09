<?php

require_once dirname(__FILE__)."/../../vendor/fpdf17/fpdf.php";

class PDF extends FPDF
{
// Tabla coloreada
    function FancyTable($header, $data)
    {
        $w = array(2, 4, 6, 4, 4, 5.945);
        $this->SetFillColor(19, 115, 12);
        $this->SetTextColor(255);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);
        // Colores, ancho de línea y fuente en negrita
        $this->AddFont('LeagueGothic-Regular','B','leaguegothic-regular-webfont.php');
        $this->SetFont('LeagueGothic-Regular','B', 22);

        $this->Cell(0,0.9,"Compras concretadas",1,1,'C',true);

        $this->AddFont('LeagueGothic-Regular','','leaguegothic-regular-webfont.php');

        // Datos
        $fill = true;
        foreach($data as $row)
        {
            $this->SetFillColor(255,0,0);
            $this->SetTextColor(255);
            $this->SetFont('LeagueGothic-Regular','B', 18);
            // Cabecera
            $this->SetLineWidth(.2);
            for($i=0;$i<count($header);$i++)
                $this->Cell($w[$i],0.7,$header[$i],1,0,'C',true);
            $this->Ln();
            // Restauración de colores y fuentes
            $this->SetFillColor(224,235,255);
            $this->SetTextColor(0);
            $this->SetFont('LeagueGothic-Regular','',14);

            $h = 2;
            $this->SetLineWidth(.05);
            $this->Cell($w[0],$h,$row['id'],'TLRB',0,'L',$fill);
            $this->Cell($w[1],$h,$row['useremail'],'TLB',0,'L',$fill);
            $this->Cell($w[2],$h,utf8_decode($row["username"]),'TLB',0,'L',$fill);
            $this->Cell($w[3],$h,number_format($row["ci"]),'TLRB',0,'R',$fill);
            $this->Cell($w[4],$h,$row["rif"],'TLRB',0,'R',$fill);
            $this->Cell($w[5],$h,utf8_decode($row["fecha"]),'TLRB',0,'C',$fill);
            $this->Ln();
            $this->SetFillColor(252, 255, 106);
            $this->Cell(0,0.7,"Productos",1,0,'C',true);
            $fill = !$fill;
            $this->SetFillColor(224,235,255);
            $this->Ln();
            foreach($row['productos'] as $prod){
                if(isset($prod["nombre"])){
                    $this->Cell(5,1,utf8_decode($prod["nombre"]),'TLR',0,'L',$fill);
                    $this->Cell(7,1,"Precio: Bs. ".number_format($prod["precio"]),'TLR',0,'L',$fill);
                    $this->Cell(7,1,"Cantidad Ordenada: ".number_format($prod["cantOrd"]),'TLR',0,'L',$fill);
                    $this->Cell(6.945,1,"SubTotal: Bs. ".number_format($prod['precio'] * $prod['cantOrd']),'TLR',0,'L',$fill);
                    $fill = !$fill;
                }
                else {
                    $this->Cell(0,1,"Total: Bs. ".number_format($prod['total']),'TLRB',0,'R',$fill);
                    $fill = !$fill;
                }
                $this->Ln();
            }
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }
    function Header()
    {
        $date = new DateTime('now');
        $this->AddFont('LeagueGothic-Regular','I','leaguegothic-regular-webfont.php');

        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.1);

        $this->SetFont('LeagueGothic-Regular','I',18);
        // Movernos a la derecha
        // Título
        $this->Cell(0,1,'Republic Skate S.R.L. - Tienda Online :: RIF: J-000000-0',0,1,'C');
        $this->Cell(0,1,"Fecha del reporte: ".$date->format("D, d M Y H:i:s"),'B',0,'C');
        // Salto de línea
        $this->Ln(2);
    }
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-2);
        $this->AddFont('LeagueGothic-Regular','I','leaguegothic-regular-webfont.php');
        // Arial italic 8
        $this->SetFont('LeagueGothic-Regular','I',12);
        // Número de página
        $this->Cell(0,2,utf8_decode('Página '). $this->PageNo().' de {nb}',0,0,'C');
    }
}