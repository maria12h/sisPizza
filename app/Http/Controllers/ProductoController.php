<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\ProductoFormRequest;
use sisVentas\Producto;
use DB;
class ProductoController extends Controller
{
    //
    public function __construct(){
        //$this->middleware('auth');
    }
    public function index(Request $request){
    	if($request)
    	{
    		$consulta=trim($request->get('searchText'));
    		$producto=DB::table('producto as p')
    		->where('nombre','like','%'.$consulta.'%')
            ->orderBy('idproducto','desc')->paginate(7);

    		return view('cocina.producto.index',['producto'=>$producto,'searchText'=>$consulta]);
    	}
    }
    public function create(){
    	return view('cocina.producto.create');
    }
    //almacenar el objeto del modelo categoria en la base datos
    public function store(ProductoFormRequest $request){
    	$producto=new Producto;
    	$producto->nombre=$request->get('nombre');
    	$producto->descripcion=$request->get('descripcion');
        $producto->tipoproducto=$request->get('tipoproducto');
    	if(Input::hasFile('imagen'))
    	{
    		$file=Input::file('imagen');
    		$file->move(public_path().'/imagenes/producto',$file->getClientOriginalName());
    		$producto->imagen=$file->getClientOriginalName();
    	}
    	$producto->save();
    	return redirect::to('cocina/producto');
    }
    public function show($id){

    	return view('cocina.producto.show',['producto'=>Producto::find($id)]);
    }
    public function edit($id){
        $producto=Producto::find($id);
    	return view('cocina.producto.edit',['producto'=>$producto]);
    }
 	public function update(ProductoFormRequest $request,$id){

    	$producto=Producto::find($id);
        $producto->nombre=$request->get('nombre');
    	$producto->descripcion=$request->get('descripcion');
        $producto->tipoproducto=$request->get('tipoproducto');
    	if(Input::hasFile('imagen'))
    	{
    		$file=Input::file('imagen');
    		$file->move(public_path().'/imagenes/producto',$file->getClientOriginalName());
    		$producto->imagen=$file->getClientOriginalName();
    	}
    	$producto->update();

    	return redirect::to('cocina/producto');
    }
    public function destroy($id){
    	$producto=Producto::find($id);
    	if(file_exists(public_path().'/imagenes/producto/'.$producto->imagen))
    	{
    		unlink(public_path().'/imagenes/producto/'.$producto->imagen);
    	}
    	if($producto!=null)
    	{
    		$producto->delete();
    	}
    	return redirect::to('cocina/producto');
    }   
}
