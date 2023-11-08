<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Imports\ConsultasImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    //
    public function index(Request $request)
    {
      
      $consultas = DB::table('consultas')
            ->join('consultors', 'consultors.id', '=', 'consultas.consultor_id')
            ->select('consultas.data', 'consultas.codigo_os', 'consultors.nome');

      if($request->has('codigo_os')){
        if($request->codigo_os != null) $consultas->where('codigo_os', 'like', '%' . $request->codigo_os . '%');
      }
      if($request->has('consultor')){
        if($request->consultor != null) $consultas->where('consultors.nome', 'like', '%' . $request->consultor . '%');
      }
      if($request->has('data')){
        if($request->data != null) $consultas->where('data',date("d/m/Y",strtotime($request->data)) );
      }

      $consultas = $consultas->get();
      return view('consulta.index', compact('consultas'));
    }

    public function import(Request $request){
      
      Excel::import(new ConsultasImport, $request->file('file')->store('files'));
      return redirect()->back();
  }
}
