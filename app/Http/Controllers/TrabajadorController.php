<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\TrabajadorFormRequest;
use sisVentas\Trabajador;
use DB;
use Illuminate\Encryption\Encrypter;
use Illuminate\Session\SessionManager;
class TrabajadorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function index(Request $request){
        if($request)
        {
            $consulta=trim($request->get('searchText'));
            $trabajador=DB::table('trabajador')
            ->where('nombretrabajador','like','%'.$consulta.'%')->orwhere('apellidos','like','%'.$consulta.'%')->orderBy('idtrabajador','desc')->paginate(7);

            return view('trabajador.index',['trabajador'=>$trabajador,'searchText'=>$consulta]);
        }
    }
    public function create(){
        return view('trabajador.create');
    }
    //almacenar el objeto del modelo categoria en la base datos
    public function store(TrabajadorFormRequest $request,Encrypter $encrypter){
        $trabajador=new Trabajador;
        $trabajador->nombretrabajador=$request->get('nombre');
        $trabajador->apellidos=$request->get('apellidos');
        $trabajador->telefono=$request->get('telefono');
        $trabajador->direccion=$request->get('direccion');
        $trabajador->correo=$request->get('correo');
        $trabajador->contrasenia=$encrypter->encrypt($request->get('contrasenia'));
        $trabajador->save();
        return redirect::to('trabajador');
    }
    public function show(){
        return view('trabajador.show');
    }
    public function edit($id){
        $trabajador=Trabajador::find($id);
        return view('trabajador.edit',['trabajador'=>$trabajador]);
    }
    public function update(TrabajadorFormRequest $request,$id,Encrypter $encrypter){

        $trabajador=Trabajador::find($id);
        $trabajador->nombretrabajador=$request->get('nombre');
        $trabajador->apellidos=$request->get('apellidos');
        $trabajador->telefono=$request->get('telefono');
        $trabajador->direccion=$request->get('direccion');
        $trabajador->correo=$request->get('correo');
        $trabajador->contrasenia=$encrypter->encrypt($request->get('contrasenia'));
        
        $trabajador->update();

        return redirect::to('trabajador');
    }
    public function destroy($id){
        $trabajador=Trabajador::find($id);
        if(file_exists(public_path().'/imagenes/trabajador/'.$trabajador->imagen))
        {
            unlink(public_path().'/imagenes/trabajador/'.$trabajador->imagen);
        }
        if($trabajador!=null)
        {
            $trabajador->delete();
        }
        return redirect::to('trabajador');
    }   
}
