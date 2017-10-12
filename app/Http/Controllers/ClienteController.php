<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Cliente;
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests\ClienteFormRequest;
use DB;

class ClienteController extends Controller
{
    //
    public function __construct(){
        //$this->middleware('auth');
    }
    public function index(Request $request){
    	if($request)
    	{
    		$consulta=trim($request->get('searchText'));
    		$cliente=DB::table('cliente')->where('nombre','like','%'.$consulta.'%')
            ->orwhere('apellidos','like','%'.$consulta.'%')
            ->orderBy('idcliente','desc')->paginate(7);
    		return view('ventas.cliente.index',['cliente'=>$cliente,'searchText'=>$consulta]);
    	}
    }
    public function create(){

    	return view('ventas.cliente.create');
    }
    //almacenar el objeto del modelo persona en la base datos
    public function store(ClienteFormRequest $request){
    	$cliente=new Cliente;
    	$cliente->nombre=$request->get('nombre');
    	$cliente->apellidos=$request->get('apellidos');
    	$cliente->telefono=$request->get('telefono');
    	$cliente->direccion=$request->get('direccion');
    	$cliente->save();

    	return redirect::to('ventas/cliente');
    }
    public function show($id){

    	return view('ventas.cliente.show',['cliente'=>Cliente::find($id)]);
    }
    public function edit($id){
        
    	return view('ventas.cliente.edit',['cliente'=>Cliente::find($id)]);
    }
 	public function update(ClienteFormRequest $request,$id){

    	$cliente=Cliente::find($id);
    	$cliente->nombre=$request->get('nombre');
    	$cliente->apellidos=$request->get('apellidos');
    	$cliente->telefono=$request->get('telefono');
    	$cliente->direccion=$request->get('direccion');
    	$cliente->update();

    	return redirect::to('ventas/cliente');
    }
    public function destroy($id){

    	$cliente=Cliente::find($id);
    	if($cliente!=null)
    	{
    		$cliente->delete();
    	}
    	return redirect::to('ventas/cliente');
    }   
}
