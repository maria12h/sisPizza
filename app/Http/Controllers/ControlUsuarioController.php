<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Trabajador;
use DB;
use Illuminate\Encryption\Encrypter;
use Illuminate\Session\SessionManager;
class ControlUsuarioController extends Controller
{
    
    public function actionLogIn(SessionManager $sessionManager,Encrypter $encrypter,Request $request)
        {
            $tusuario=Trabajador::whereRaw('correo=?',[$request->input('correo')])->first();
            if($tusuario==null or ($encrypter->decrypt($tusuario->contrasenia)!=$request->input('contrasenia')))
            {
                $sessionManager->flash('mensajeGeneral','Dato incorrecto');
                $sessionManager->flash('color',env('COLOR_ERROR'));
                return redirect('/');
            }
            $sessionManager->put('idUsuario',$tusuario->idtrabajador);
            $sessionManager->put('email',$tusuario->correo);
            $sessionManager->put('nombre',$tusuario->nombretrabajador);
            $sessionManager->put('apellidos',$tusuario->apellidos);

            $sessionManager->flash('mensajeGeneral','Datos correctos');
            $sessionManager->flash('color',env('COLOR_CORRECTO'));

            return redirect('ventas/venta');
        } 
    public function actionLogOut(SessionManager $sessionManager)
    {
        $sessionManager->flush();
        return redirect('/');
    }
}
