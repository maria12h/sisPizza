<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Producto;
use sisVentas\Cliente;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use DB;
class PdfController extends Controller
{
	//lista de articulos
	public function actionPdfProducto(Response $response,Request $request)
	{
		$listaProducto=Producto::all();
		$pdf=app('FPDF');
			$header = array('Nombre', 'Tipo Pizza','descripcion');
			$pdf->SetFont('Arial','',14);
			$pdf->AddPage();
		    // Colores, ancho de línea y fuente en negrita
		    $pdf->SetFillColor(255,0,0);
		    $pdf->SetTextColor(255);
		    $pdf->SetDrawColor(128,0,0);
		    $pdf->SetLineWidth(.3);
		    $pdf->SetFont('','B');
		    // Cabecera
		    $w = array(46,66,76);
		    for($i=0;$i<count($header);$i++)
		        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
		    $pdf->Ln();
		    // Restauración de colores y fuentes
		    $pdf->SetFillColor(224,235,255);
		    $pdf->SetTextColor(0);
		    $pdf->SetFont('','',12);
		    // Datos
		    $fill = false;
			foreach ($listaProducto as $key => $value) {
				# code...
				$pdf->Cell($w[0],6,$value->nombre,'LR',0,'L',$fill);
				$pdf->Cell($w[1],6,$value->tipoproducto,'LR',0,'L',$fill);
				$pdf->Cell($w[2],6,$value->descripcion,'LR',0,'L',$fill);
				$pdf->Ln();
		        $fill = !$fill;
			}
			$pdf->Cell(array_sum($w),0,'','T');
		$headers=['Content-Type' => 'application/pdf'];

		return $response	->make($pdf->Output('I'), 200, $headers);
	}
	//lista de ingresos 
	public function actionPdfPedido(Response $response,Request $request)
	{
		$listaPedidos=DB::table('pedido as p')
    		->join('cliente as c','p.idcliente','=','c.idcliente')
    		->join('trabajador as e','p.idtrabajador','=','e.idtrabajador')
    		->join('detallepedido as dp','p.idpedido','=','dp.idpedido')
    		->select('e.nombretrabajador','p.idpedido','p.fechapedido','c.nombre','p.tipoComprobante','p.serieComprobante','p.nrocomprobante',DB::raw('sum(dp.cantidad*precio) as total'))
    		->groupBy('e.nombretrabajador','p.idpedido','p.fechapedido','c.nombre','p.tipoComprobante','p.serieComprobante','p.nrocomprobante')
    		->get();
		$pdf=app('FPDF');
			$header = array('Empleado','cliente', 'Fecha','Comprobante','Total');
			$pdf->SetFont('Arial','',14);
			$pdf->AddPage('L');
		    // Colores, ancho de línea y fuente en negrita
		    $pdf->SetFillColor(255,0,0);
		    $pdf->SetTextColor(255);
		    $pdf->SetDrawColor(128,0,0);
		    $pdf->SetLineWidth(.3);
		    $pdf->SetFont('','B');
		    // Cabecera
		    $w = array(52,50,35,62,40);
		    for($i=0;$i<count($header);$i++)
		        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
		    $pdf->Ln();
		    // Restauración de colores y fuentes
		    $pdf->SetFillColor(224,235,255);
		    $pdf->SetTextColor(0);
		    $pdf->SetFont('','',12);
		    // Datos
		    $fill = false;
		foreach ($listaPedidos as $key => $value) {
			# code...
			$pdf->Cell($w[0],6,$value->nombretrabajador,'LR',0,'L',$fill);
			$pdf->Cell($w[1],6,$value->nombre,'LR',0,'L',$fill);
			$pdf->Cell($w[2],6,$value->fechapedido,'LR',0,'L',$fill);
			$pdf->Cell($w[3],6,$value->tipoComprobante." ".$value->serieComprobante."-".$value->nrocomprobante,'LR',0,'L',$fill);
			$pdf->Cell($w[4],6,$value->total,'LR',0,'L',$fill);
			$pdf->Ln();
		    $fill = !$fill;
		}
		$pdf->Cell(array_sum($w),0,'','T');
		$headers=['Content-Type' => 'application/pdf'];

		return $response	->make($pdf->Output('I'),200, $headers);
	}
	//lista de ventas 
	public function actionPdfVenta(Response $response,Request $request)
	{
		$listaVentas=DB::table('venta as v')
    		->join('cliente as c','v.idcliente','=','c.idcliente')
            ->join('trabajador as t','t.idtrabajador','=','v.idtrabajador')
    		->join('detalleventa as dv','v.idventa','=','dv.idventa')->get();
		$pdf=app('FPDF');
			$header = array('Empleado','Cliente', 'Fecha','Comprobante','Total Venta');
			$pdf->SetFont('Arial','',14);
			$pdf->AddPage('L');
		    // Colores, ancho de línea y fuente en negrita
		    $pdf->SetFillColor(255,0,0);
		    $pdf->SetTextColor(255);
		    $pdf->SetDrawColor(128,0,0);
		    $pdf->SetLineWidth(.3);
		    $pdf->SetFont('','B');
		    // Cabecera
		    $w = array(50,50,35,60,40);
		    for($i=0;$i<count($header);$i++)
		        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
		    $pdf->Ln();
		    // Restauración de colores y fuentes
		    $pdf->SetFillColor(224,235,255);
		    $pdf->SetTextColor(0);
		    $pdf->SetFont('','',12);
		    // Datos
		    $fill = false;
		foreach ($listaVentas as $key => $value) {
			# code...
			$pdf->Cell($w[0],6,$value->nombretrabajador,'LR',0,'L',$fill);
			$pdf->Cell($w[1],6,$value->nombre,'LR',0,'L',$fill);
			$pdf->Cell($w[2],6,$value->fechaventa,'LR',0,'L',$fill);
			$pdf->Cell($w[3],6,$value->tipoComprobante." ".$value->serieComprobante."-".$value->nrocomprobante,'LR',0,'L',$fill);
			$pdf->Cell($w[4],6,$value->total,'LR',0,'L',$fill);
			$pdf->Ln();
		    $fill = !$fill;
		}
		$pdf->Cell(array_sum($w),0,'','T');
		$headers=['Content-Type' => 'application/pdf'];

		return $response	->make($pdf->Output('I'), 200, $headers);
	}
	
	//lista de clientes 
	public function actionPdfCliente(Response $response,Request $request)
	{
		$listaClientes=DB::table('cliente')->get();
		$pdf=app('FPDF');
			$header = array('Nombre', 'Apellidos','Telefono','Direccion');
			$pdf->SetFont('Arial','',14);
			$pdf->AddPage('L');
		    // Colores, ancho de línea y fuente en negrita
		    $pdf->SetFillColor(255,0,0);
		    $pdf->SetTextColor(255);
		    $pdf->SetDrawColor(128,0,0);
		    $pdf->SetLineWidth(.3);
		    $pdf->SetFont('','B');
		    // Cabecera
		    $w = array(65,75,75,45);
		    for($i=0;$i<count($header);$i++)
		        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
		    $pdf->Ln();
		    // Restauración de colores y fuentes
		    $pdf->SetFillColor(224,235,255);
		    $pdf->SetTextColor(0);
		    $pdf->SetFont('','',12);
		    // Datos
		    $fill = false;
		foreach ($listaClientes as $key => $value) {
			# code...
			$pdf->Cell($w[0],6,$value->nombre,'LR',0,'L',$fill);
			$pdf->Cell($w[1],6,$value->apellidos,'LR',0,'L',$fill);
			$pdf->Cell($w[2],6,$value->telefono,'LR',0,'L',$fill);
			$pdf->Cell($w[3],6,$value->direccion,'LR',0,'L',$fill);
			$pdf->Ln();
		    $fill = !$fill;
		}
		$pdf->Cell(array_sum($w),0,'','T');
		$headers=['Content-Type' => 'application/pdf'];

		return $response	->make($pdf->Output('I'), 200, $headers);
	}
	public function actionPdfTrabajador(Response $response,Request $request)
	{
		$listaTrabajador=DB::table('trabajador')->get();
		$pdf=app('FPDF');
			$header = array('Nombre', 'Apellidos','Telefono','Direccion');
			$pdf->SetFont('Arial','',14);
			$pdf->AddPage('L');
		    // Colores, ancho de línea y fuente en negrita
		    $pdf->SetFillColor(255,0,0);
		    $pdf->SetTextColor(255);
		    $pdf->SetDrawColor(128,0,0);
		    $pdf->SetLineWidth(.3);
		    $pdf->SetFont('','B');
		    // Cabecera
		    $w = array(65,75,75,45);
		    for($i=0;$i<count($header);$i++)
		        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
		    $pdf->Ln();
		    // Restauración de colores y fuentes
		    $pdf->SetFillColor(224,235,255);
		    $pdf->SetTextColor(0);
		    $pdf->SetFont('','',12);
		    // Datos
		    $fill = false;
		foreach ($listaTrabajador as $key => $value) {
			# code...
			$pdf->Cell($w[0],6,$value->nombretrabajador,'LR',0,'L',$fill);
			$pdf->Cell($w[1],6,$value->apellidos,'LR',0,'L',$fill);
			$pdf->Cell($w[2],6,$value->telefono,'LR',0,'L',$fill);
			$pdf->Cell($w[3],6,$value->direccion,'LR',0,'L',$fill);
			$pdf->Ln();
		    $fill = !$fill;
		}
		$pdf->Cell(array_sum($w),0,'','T');
		$headers=['Content-Type' => 'application/pdf'];

		return $response	->make($pdf->Output('I'), 200, $headers);
	}
}
