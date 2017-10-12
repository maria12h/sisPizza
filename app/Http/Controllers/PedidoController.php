<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\PedidoFormRequest;
use sisVentas\Pedido;
use sisVentas\DetallePedido;
use DB;
use Illuminate\Contracts\Routing\ResponseFactory as Responses;
use Illuminate\Session\SessionManager;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
class PedidoController extends Controller
{
    public function __construct(){
        //$this->middleware('auth');
    }
    public function index(Request $request){
    	if($request)
    	{
    		$consulta=trim($request->get('searchText'));
    		$pedido=DB::table('pedido as p')
    		->join('cliente as c','p.idcliente','=','c.idcliente')
    		->join('detallepedido as dp','p.idpedido','=','dp.idpedido')
    		->select('p.idpedido','p.fechapedido','c.nombre','p.tipoComprobante','p.serieComprobante','p.nrocomprobante',DB::raw('sum(dp.cantidad*precio) as total'))
    		->where('p.nrocomprobante','like','%'.$consulta.'%')
    		->orderBy('p.idpedido','desc')
    		->groupBy('p.idpedido','p.fechapedido','c.nombre','p.tipoComprobante','p.serieComprobante','p.nrocomprobante')
    		->paginate(7);
    		return view('pedido.index',['pedido'=>$pedido,'searchText'=>$consulta]);
    	}
    }
    public function create(){
    	$cliente=DB::table('cliente')->get();
    	$producto=DB::table('producto')->get();
    	return view('pedido.create',["cliente"=>$cliente,"producto"=>$producto]);
    }
    //almacenar el objeto del modelo persona en la base datos
    public function store(PedidoFormRequest $request,SessionManager $sessionManager){
    	try {
    		DB::beginTransaction();
    		$pedido= new Pedido;
    		$pedido->tipoComprobante=$request->get('tipoComprobante');
    		$pedido->serieComprobante=$request->get('serieComprobante');
    		$pedido->nrocomprobante=$request->get('nrocomprobante');
    		$mytime=Carbon::now('America/Lima');
    		$pedido->fechapedido=$mytime->toDateTimeString();
    		$pedido->idcliente=$request->get('idcliente');
            $pedido->idtrabajador=$sessionManager->get('idUsuario');
    		$pedido->save();

    		$idproducto=$request->get('idproducto');
    		$cantidad=$request->get('cantidad');
    		$precio=$request->get('precioVenta');

    		$cont=0;

    		while($cont < count($idproducto)){
    			$detalle= new DetallePedido;
    			$detalle->cantidad=$cantidad[$cont];
    			$detalle->precio=$precio[$cont];
                $detalle->idproducto=$idproducto[$cont];
                $detalle->idpedido=$pedido->idpedido;
    			$detalle->save();
    			$cont=$cont+1;
    		}
    		DB::commit();
    	} catch (Exception $e) {
    		DB::rollback();
    	}
    	return Redirect::to('pedido');
    }
    public function show($id){

    	$pedido=DB::table('pedido as p')
    		->join('cliente as c','p.idcliente','=','c.idcliente')
    		->join('detallepedido as dp','p.idpedido','=','dp.idpedido')
    		->select('p.idpedido','p.fechapedido','c.nombre','p.tipoComprobante','p.serieComprobante','p.nrocomprobante',DB::raw('sum(dp.cantidad*precio) as total'))
            ->groupBy('p.idpedido','p.fechapedido','c.nombre','p.tipoComprobante','p.serieComprobante','p.nrocomprobante')
    		->where('p.idpedido','=',$id)->first();
    	$detalles=DB::table('detallepedido as dp')
    		->join('producto as pr','dp.idproducto','=','pr.idproducto')
    		->where('dp.idpedido','=',$id)->get();
    	return view('pedido.show',['pedido'=>$pedido,"detalles"=>$detalles]);
    }
    
    public function destroy($id){

    	$pedido=Pedido::find($id);
    	if($pedido!=null)
    	{
    		$pedido->delete();
    	}
    	return redirect::to('pedido');
    }   
    public function actionPdfComprobante(Responses $response,Request $request,$id)
    {
        $pedido=DB::table('pedido as p')
            ->join('cliente as c','p.idcliente','=','c.idcliente')
            ->join('detallepedido as dv','p.idpedido','=','dv.idpedido')
            ->where('p.idpedido','=',$id)->first();
        $detalles=DB::table('detallepedido as dv')
            ->join('producto as p','dv.idproducto','=','p.idproducto')
            ->where('dv.idpedido','=',$id)->get();
        $pdf=app('FPDF');

        $pdf->AddPage('L');
        //$pdf->Image('../public/logo/logo.jpg',10,8,33);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(40,10,'',0,1,'C');

        $pdf->Cell(250,3,'');
        $pdf->Cell(10,3,$pedido->tipoComprobante);
        $pdf->Cell(40,10,'',0,1,'C');
        $pdf->Cell(250,3,'');
        $pdf->Cell(10,3,$pedido->serieComprobante."-".$pedido->nrocomprobante);
        $pdf->Cell(40,10,'',0,1,'C');
        $pdf->Cell(50,3,'');
        $pdf->Cell(200,3,$pedido->nombre." ".$pedido->apellidos);
        $pdf->Cell(90,3,$pedido->telefono);
        $pdf->Cell(40,10,'',0,1,'C');
        $pdf->Cell(50,3,'');
        $pdf->Cell(190,3,'Jr. Lima 512 - Abancay');
        $pdf->Cell(90,3,$pedido->fechapedido);
        $pdf->SetFont('','',12);

            $header = array('Cantidad', 'Pizza','Monto','total');
            
            $w = array(50, 70,40,40);
            for($i=0;$i<count($header);$i++)
                $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
            $pdf->Ln();
            // Restauración de colores y fuentes
            $pdf->SetFillColor(224,235,255);
            $pdf->SetTextColor(0);
            $pdf->SetFont('','',12);
            // Datos
            $fill = false;
            $totalPago=0;
            foreach($detalles as $key => $value)
            {
                $pdf->Cell(50,3,'');
                $pdf->Cell($w[0],6,$value->cantidad);
                $pdf->Cell($w[1],6,$value->nombre);
                $pdf->Cell($w[1],6,$value->precio);
                $pdf->Cell($w[1],6,$value->cantidad*$value->precio);
                $pdf->Ln();
                $fill = !$fill;
                $totalPago=$totalPago+$value->cantidad*$value->precio;
            }
            
            $pdf->Cell(40,10,'',0,1,'C');
            $pdf->Cell(50,3,'');
            $pdf->Cell(190,3,'Total a Pagar:');
            $pdf->Cell(1,3,'$.'.$totalPago);
        $headers=['Content-Type' => 'application/pdf'];

        return $response    ->make($pdf->Output('I'), 200, $headers);
    }
}
