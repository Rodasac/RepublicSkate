<?php
use Doctrine\ORM\Tools\Pagination\Paginator;

require_once dirname(__FILE__)."/../../modulos/Carrito/PDF.php";

if(isset($_GET['tipo'])){
    $type = $_GET['tipo'];
}
else {
    $type = 1;
}

if ($type == 1){
    $query = $entityManager->createQuery('SELECT t FROM Ticket t WHERE t.status = 0 ORDER BY t.id DESC')
                        ->setMaxResults(500);
    $head = utf8_decode("Reporte Diario");
}
elseif($type == 2){
    $date = new DateTime('now');
    $query = $entityManager->createQuery('SELECT t FROM Ticket t WHERE t.status = 0 AND t.fecha LIKE :fecha2 ORDER BY t.id DESC')
    ->setParameter("fecha2", "%".$date->format('m')."%");
    $head = utf8_decode("Reporte del último mes");
}
else{
    $query = null;
}

$perfilRepo = $entityManager->getRepository("Perfil");
$user = Sentry::getUser();

$pag = new Paginator($query);

$array = array();

foreach($pag as $tic){
    $user2 = Sentry::findUserByLogin($tic->getUser());
    $perfil = $perfilRepo->findOneBy(array("user_id" => $user2->id));
    $json = json_decode($tic->getProducts());
    $products = array();
    foreach($json as $prod){
        $products[] = get_object_vars($prod);
    }

    $array[] = array(
        "id" => $tic->getId(),
        "useremail" => $tic->getUser(),
        "username" => $user2->first_name." ".$user->last_name,
        "ci" => $perfil->getCi(),
        "rif" => $perfil->getRif(),
        "fecha" => $tic->getFecha()->format("d m Y H:i:s"),
        "productos" => $products
    );
}


    $pdf = new PDF('L', 'cm', 'Letter');
    $header = array('Ticket', 'Usuario', "Nombre Completo", 'C.I.', 'RIF', 'Fecha de compra');
    $pdf->AddFont('LeagueGothic-Regular','B','leaguegothic-regular-webfont.php');
    $pdf->AliasNbPages();

    $pdf->SetDrawColor(158, 158, 158);

    $pdf->SetTitle("Reporte de ventas y transacciones (By FPDF)", true);
    $pdf->SetAuthor($user->first_name . " " . $user->last_name, true);
    $pdf->SetSubject("Reporte para registro y control de ventas", true);
    $pdf->SetCreator("Republic Skate S.R.L.", true);
    $pdf->SetMargins(1,1);

    $pdf->AddPage();
    $pdf->SetFont('LeagueGothic-Regular','B',80);
    $pdf->Cell(20,15,$head, 0, 0, 'C');
    $pdf->SetFont('LeagueGothic-Regular','B',20);
    $pdf->Ln(10);
    $pdf->Cell(20,1,utf8_decode("*Solo se mostrarán los tickets cerrados (Compras que se concretaron)"), 0, 0, 'C');

    $pdf->AddPage();
    $pdf->FancyTable($header, $array);
    $pdf->Output();