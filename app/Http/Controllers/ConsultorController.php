<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultorController extends Controller
{
    public function index(Request $request)
    {
      
      $consultores = DB::table('consultas')
            ->join('consultors', 'consultors.id', '=', 'consultas.consultor_id')
            ->join('consultas_itens', 'consultas_itens.consulta_id','=', 'consultas.id')
            ->selectRaw('consultors.id, consultors.nome, replace(printf("%.2f", sum(consultas_itens.valor)),".",",") as valor')
            ->groupBy('consultors.nome');

      if($request->has('consultor')){
        if($request->consultor != null) $consultores->where('consultors.nome', 'like', '%' . $request->consultor . '%');
      }

      if($request->has('data_inicial') || $request->has('data_final')){
        if($request->data_final == null && $request->data_inicial != null){
          $consultores->where('consultas.data', '>=' ,date("d/m/Y",strtotime($request->data_inicial)));
        }elseif ($request->data_final != null && $request->data_inicial == null){
          $consultores->where('consultas.data', '<=' ,date("d/m/Y",strtotime($request->data_final)));
        }elseif ($request->data_final != null && $request->data_inicial != null){
          $consultores->whereBetween('consultas.data', [date("d/m/Y",strtotime($request->data_inicial)), date("d/m/Y",strtotime($request->data_final))]);
        }

      }

      $consultores = $consultores->get();
      return view('consultor.index', compact('consultores'));
    }


    public function getDadosModal(Request $request,$id){
      
      $produtos = DB::table('consultas')
                ->selectRaw('produtos.codigo, produtos.nome as produto, mecanicos.nome, replace(printf("%.2f", sum(consultas_itens.valor)),".",",") as valor')
                ->join('consultas_itens', 'consultas_itens.consulta_id','=', 'consultas.id')  
                ->join('produtos', 'consultas_itens.produto_id','=', 'produtos.id')
                ->join('mecanicos', 'consultas_itens.mecanico_id','=', 'mecanicos.id')
                ->distinct()
                ->where('consultor_id','=',$id)
                ->groupBy('produtos.codigo')
                ->groupBy('produtos.nome')
                ->groupBy('mecanicos.nome');
      if($request->has('data_inicial') || $request->has('data_final')){
        if($request->data_final == null && $request->data_inicial != null){
          $produtos->where('consultas.data', '>=' ,date("d/m/Y",strtotime($request->data_inicial)));
        }elseif ($request->data_final != null && $request->data_inicial == null){
          $produtos->where('consultas.data', '<=' ,date("d/m/Y",strtotime($request->data_final)));
        }elseif ($request->data_final != null && $request->data_inicial != null){
          $produtos->whereBetween('consultas.data', [date("d/m/Y",strtotime($request->data_inicial)), date("d/m/Y",strtotime($request->data_final))]);
        }
      }
      return $produtos->get();
    }
}
