<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Idols;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
class RegistrarController extends Controller
{
    public function registrarUsuario(){
        $infoIdols = Idols::paginate(4);
        return view('registrar' )->with(compact('infoIdols'));
    }

    public function Buscador(Request $request)
    {
      $datoBuscar = $request->datos;
      if (isset($datoBuscar)) {
        $buscadorIdol = Idols::select('id','nombre','edad','actividad','datos_curiosos')
                               ->where('nombre',$datoBuscar)
                               ->get();
      }else {
        $buscadorIdol = Idols::take(4)->get();
      }
        return response()->json([
          'resultado' => $buscadorIdol
        ]);
    }

  public function dataIdols(Request $request){

      $perPage = $request->input('per_page', 2);
      $data = Idols::paginate($perPage);
      return response()->json([
          'data de busqueda ' => $data,
      ]);
}

    public function AgregarTrabajador(Request $request)
    {
      $validatedData = $request->validate([
        'nombre' => 'required|string|max:40',
        'edad' => 'required|integer|min:0|max:127',
        'datos_curiosos' => 'nullable|string',
        'actividad' => 'required|string|max:240',
        'foto' => 'nullable|string|max:255',
    ]);

    $registrarIdol = Idols::create($validatedData);
    $infoIdols = Idols::all();

    return response()->json([
        'exito en el controlador' => $validatedData,
        'info del idol' => $infoIdols
    ]);
    }

    public function eliminarTrabjador(Request $request){
      $id = $request->id;

      $borrarIdol = Idols::select(['id' ,'nombre', 'edad','datos_curiosos','actividad','foto' ])
                           ->where('id', $id)
                           ->delete();

      return response()->json([
        'controlador reportandose kkk' => $borrarIdol
      ] );
    }

    public function editarTrabajador(Request $request)
{
    $id = $request->datos['identificador'];
    $trabajador = Idols::find($id);

    if (!$trabajador) {
        return response()->json(['error' => 'Trabajador no encontrado'], 404);
    }
    $datosActualizados = array_filter($request->datos, function ($value) {
        return !is_null($value);
    });
    $trabajador->update($datosActualizados);
    return response()->json([
        'mensaje' => 'Trabajador actualizado correctamente',
        'trabajador' => $trabajador,
    ]);
  }

   public function perfil (Request $request){
     $id = $request->perfilData;
     $queryPerfil = Idols::select('nombre', 'edad','datos_curiosos','actividad')->where('id',$id)->get();
     return response()->json([
       'query perfil controller ' => $queryPerfil,
     ]);
   }
};
