
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <title>Consultas</title>
  
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-warning">
  <div class="container-fluid">
      <div class="justify-end ">
        <div class="col ">
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <div class="custom-file text-left">
                    
                    <input type="file" name="file" class="custom-file-input" id="customFile">
                    
                    <button class="btn btn-primary">Importar dados</button>
                </div>
                
            </div>
        </form>
        </div>
      </div>
    </div>
  </nav>
  <div class="container mt-5">
    <div class='col'>
        <form action="{{ route('consultor.index') }}" method="GET">
        <table class="table">
        <thead>
        <tr>
            <th><label id="consultor">Consultor &nbsp;</label><input type='text' id='consultor_input' name="consultor"></th>
            <th><label id="data_inicial">Data inicial &nbsp;</label><input type='date' id='data_inicial_input' name="data_inicial"></th>
            <th><label id="data_final">Data final &nbsp;</label><input type='date' id='data_final_input' name="data_final"></th>
            <th><button class="btn btn-primary">Filtrar</button></th>
        </tr>
        </thead>
        </table>
        </form>
    </div>
    <div class="row">
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Consultores</th>
            <th>Valor total</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($consultores as $consultor)
        <tr style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#myModal" onClick="ControlModal({{ $consultor->id }})">
            <td>{{ $consultor->id }} </td>
            <td>{{ $consultor->nome }}</td>
            <td>R$ &nbsp; {{ $consultor->valor }}</td>
        </tr>
        @endforeach
        </tbody>
  </table>
    </div>
  </div>

  <!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Consultor</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="d-flex justify-content-center">
        <div class="spinner-border" id='loading_modal' ></div></div>
          <div class="row" id='dados_modal' style='display:none'  >
          <table class="table">
        <thead>
        <tr>
            <th>Codigo Produto</th>
            <th>Produto</th>
            <th>Mecanico</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody name='tbody_modal'>

        </tbody>
        </table>
        </div>
      </div>


      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
      </div>

    </div>
  </div>
</div>

<script>
  $(window).ready(function(){
    let searchParams = new URLSearchParams(window.location.search);
    $("#data_inicial_input").val(searchParams.get('data_inicial'))
    $("#data_final_input").val(searchParams.get('data_final'))
    $("#consultor_input").val(searchParams.get('consultor'))
  });
  function ControlModal(line){
    
    $("#dados_modal").css("display","none");
    $("#loading_modal").css("display","block");
    $("#dados_modal > tbody").html("");
    $.ajax({url: "./getDadosModal/"+line+window.location.search,
      success: function(result){
        var tbodyRef = document.getElementById('dados_modal').getElementsByTagName('tbody')[0];
        result.forEach(function(row){
            // Insert a row at the end of table
            var newRow = tbodyRef.insertRow();

            // Insert a cell at the end of the row
            var newCell = newRow.insertCell();
            // Append a text node to the cell
            var newText = document.createTextNode(row.codigo);
            newCell.appendChild(newText);
            
            
            var newCell = newRow.insertCell();
            // Append a text node to the cell
            var newText = document.createTextNode(row.produto);
            newCell.appendChild(newText);

            var newCell = newRow.insertCell();
            // Append a text node to the cell
            var newText = document.createTextNode(row.nome);
            newCell.appendChild(newText);
            
            var newCell = newRow.insertCell();
            // Append a text node to the cell
            var newText = document.createTextNode(row.valor);
            newCell.appendChild(newText);  

            $("#dados_modal").css("display","block");
            $("#loading_modal").css("display","none");
        });
      
        }});
    }
</script>
</body>
</html>
