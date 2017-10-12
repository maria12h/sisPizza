<?php
namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\VentaFormRequest;
use sisVentas\Venta;
use sisVentas\DetalleVenta;
use Illuminate\Session\SessionManager;
use DB;
use Illuminate\Contracts\Routing\ResponseFactory as Responses;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
class VentaController extends Controller
{
    public function __construct(){
        //$this->middleware('auth');
    }
    public function index(Request $request){
    	if($request)
    	{
    		$consulta=trim($request->get('searchText'));//trim es para borrar espacios al inico y al final
    		$venta=DB::table('venta as v')
    		->join('cliente as c','v.idcliente','=','c.idcliente')
            ->join('trabajador as t','t.idtrabajador','=','v.idtrabajador')
    		->join('detalleventa as dv','v.idventa','=','dv.idventa')
    		->where('v.nrocomprobante','like','%'.$consulta.'%')
    		->orderBy('v.idventa','desc')
    		->paginate(7);
    		return view('ventas.venta.index',['venta'=>$venta,'searchText'=>$consulta]);
    	}
    }
    public function create(){
    	$cliente=DB::table('cliente')->get();
    	$producto=DB::table('producto')->get();
    	return view('ventas.venta.create',["cliente"=>$cliente,"producto"=>$producto]);
    }
    //almacenar el objeto del modelo persona en la base datos
    public function store(VentaFormRequest $request,SessionManager $sessionManager){
    	try {
    		DB::beginTransaction();
    		$venta= new Venta;
    		$venta->tipoComprobante=$request->get('tipoComprobante');
    		$venta->serieComprobante=$request->get('serieComprobante');
    		$venta->nrocomprobante=$request->get('numeroComprobante');
            $mytime=Carbon::now('America/Lima');
            $venta->fechaventa=$mytime->toDateTimeString();
    		$venta->total=$request->get('totalVenta');
            $venta->idcliente=$request->get('idcliente');
            $venta->idtrabajador=$sessionManager->get('idUsuario');
    		$venta->save();

    		$idproducto=$request->get('idproducto');
    		$cantidad=$request->get('cantidad');
    		$precioventa=$request->get('precioVenta');

    		$cont=0;

    		while($cont < count($idproducto)){
    			$detalle= new DetalleVenta;
    			$detalle->cantidad=$cantidad[$cont];
    			$detalle->precio=$precioventa[$cont];
                $detalle->idventa=$venta->idventa;
                $detalle->idproducto=$idproducto[$cont];
    			$detalle->save();
    			$cont=$cont+1;
    		}
    		DB::commit();
    	} catch (Exception $e) {
    		DB::rollback();
    	}
    	return Redirect::to('ventas/venta');
    }
    public function show($id){

    	$venta=DB::table('venta as v')
    		->join('cliente as c','v.idcliente','=','c.idcliente')
            ->join('trabajador as t','t.idtrabajador','=','v.idtrabajador')
    		->join('detalleventa as dv','v.idventa','=','dv.idventa')
    		->where('v.idventa','=',$id)->first();
    	$detalles=DB::table('detalleventa as dv')
    		->join('producto as a','dv.idproducto','=','a.idproducto')
    		->where('dv.idventa','=',$id)->get();
    	return view('ventas.venta.show',["venta"=>$venta,"detalles"=>$detalles]);
    }
    
    public function destroy($id){

    	$venta=Venta::find($id);
    	if($venta!=null)
    	{
    		$venta->delete();
    	}
    	return redirect::to('ventas/venta');
    }
    //boleta factura ticked 
    public function actionPdfComprobante(Responses $response,Request $request,$id)
    {
        $venta=DB::table('venta as v')
            ->join('cliente as c','v.idcliente','=','c.idcliente')
            ->join('detalleventa as dv','v.idVenta','=','dv.idVenta')
            ->where('v.idVenta','=',$id)->first();
        $detalles=DB::table('detalleventa as dv')
            ->join('producto as p','dv.idproducto','=','p.idproducto')
            ->where('dv.idVenta','=',$id)->get();
        $pdf=app('FPDF');

        $pdf->AddPage('L');
        //$pdf->Image('../public/logo/logo.jpg',10,8,33);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(40,10,'',0,1,'C');

        $pdf->Cell(250,3,'');
        $pdf->Cell(10,3,$venta->tipoComprobante);
        $pdf->Cell(40,10,'',0,1,'C');
        $pdf->Cell(250,3,'');
        $pdf->Cell(10,3,$venta->serieComprobante."-".$venta->nrocomprobante);
        $pdf->Cell(40,10,'',0,1,'C');
        $pdf->Cell(50,3,'');
        $pdf->Cell(200,3,$venta->nombre." ".$venta->apellidos);
        $pdf->Cell(90,3,$venta->telefono);
        $pdf->Cell(40,10,'',0,1,'C');
        $pdf->Cell(50,3,'');
        $pdf->Cell(190,3,'Jr. Lima 512 - Abancay');
        $pdf->Cell(90,3,$venta->fechaventa);
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
