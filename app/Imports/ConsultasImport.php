<?php
namespace App\Imports;

use App\Models\Consulta;
use App\Models\Consultas_iten;
use App\Models\Consultor;
use App\Models\Mecanico;
use App\Models\Produto;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class ConsultasImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Consulta|null
     */

     
    public function model(array $row)
    {
        //create consultor
        $consultor = Consultor::firstOrNew([
           'nome' => $row['consultor'] 
        ]);
        if(!isset($consultor->id)){
            $consultor->save();
        }
        $consultor = $consultor->id;
        
        //create mecanico
        $mecanico = Mecanico::firstOrNew([
            'nome' => $row['mecanico'] 
         ]);
        if(!isset($mecanico->id)){
            $mecanico->save();
        }
        $mecanico = $mecanico->id;

        //create produto
        $produto = Produto::firstOrNew([
            'codigo' => $row['cod_produto']
         ]);
         
        if(!isset($produto->id)){
            $produto->nome = $row['descricao_produto'];
            $produto->save();
        }
        $produto = $produto->id;

        //create consulta
        $consulta = Consulta::firstOrNew([
            'codigo_os' => $row['no_os']
        ]);

        if(!isset($consulta->id)){
            $consulta->data = Date::excelToDateTimeObject(intval($row['data']))->format('d/m/Y');
            $consulta->consultor_id = $consultor;
            $consulta->save();
        }

        //create itens

        $item = new Consultas_iten;
        $item->mecanico_id = $mecanico;
        $item->produto_id = $produto;
        $item->consulta_id = $consulta->id;
        $item->valor = $row['valor_total'];
        $item->quantidade = $row['quantidade_vendida'];
        $item->save();
        return $consulta;

    }
}