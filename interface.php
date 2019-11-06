<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Desofuscando URLs</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">

	<script src="script.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<!-- SCRIPT DE FUNCOES AJAx -->
	<script>
$(document).ready(function(){

	
	
	$('#btn_carregarURL').click(function(){
	var select = $('#opcoes').val();
	switch(select)
	{
	case 'percent': 
	percent();
	break;
	case 'ampersan':
	ampersan();
	break;
	case 'char':
	char();
	break;
	default:
	alert("Selecione uma Opção Valida!");
	break;
	}
	});

	function percent(){
		var novo_texto = $('#origem').val();
		$.ajax({
			url: 'percentDecrypt.php',
			data: {texto: novo_texto},
			timeout: 1200000,
			async: false,
			type: 'POST',
			dataType: 'json',
			success: function(retorno) {
				if(retorno.sucesso == 'true'){
					$('#resultURL').val(retorno.novo_texto);
				}else {
					$('#resultURL').html("deu errado");
				}
			}
		})
	}
	


});
</script>
</head>
<body>
	<div class="title">
		<h1>Desofuscamento de Dados</h1>
	</div>

	<div class="menu">
		<ul class="nav justify-content-center">
			<li class="nav-item">
				<a class="nav-link active" href="#">Active</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" tabindex="-1" aria-disabled="true" href="#">Sobre</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" tabindex="-1" aria-disabled="true" href="bloc;">Blog</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" tabindex="-1" aria-disabled="true" href="#">Contato</a>
			</li>
		</ul>
	</div>

	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card">

				<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Leitura de URL</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Upload de URL</a>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
    <form target="result">
        <div class="form-group">
            <label>URL:</label>
            <div class="url">

                <select name="select" id="opcoes">
                    <option value="0">Selecione a linguagem</option>
					<option value="percent">Percent Code</option>
                    <option value="ampersan">HTML Entities</option>
                    <option value="char">ASCII Code</option>
                </select>
                <input type="text" name="origem" id="origem" class="form-control origem">

            </div>
        </div>
        <div class="form-group">
            <label for="res">Resultado:</label>
            <input type="text" name="resultURL" id="resultURL" class="form-control">
        </div>

        <div class="buttons">
		    <button type="button" id="btn_carregarURL" name="btn_carregarURL" class="btn float">Carregar</button>
            <button type="reset" class="btn float">Cancelar</button>
        </div>

    </form>
  
</div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
  <div class="form-group">
    <label>Arquivo:</label>
    <div class="arq">
        <input type="file" name="arquivos[]" class="form-control arquivo" id="arq">
    </div>

    </div>

    <div class="buttons">
        <button type="button" id="bt_loading" class="btn float">Carregar</button>
        <button type="reset" class="btn float">Cancelar</button>
    </div>

    <div class="form-group">
        <label for="res">Resultado:</label>
        <textarea name="inputUpload" id="inputUpload" disabled></textarea>
    </div>
    <button type="" class="btn float">Download</button>

  </div>

</div>

				</div>
			</div>

			<div class="col">
				<div class="background"></div>
			</div>

		</div>
	</div>

	<!-- <div class="footer">
			<div class="container">
				<h5>footer</h5>
			</div>	
		</div> -->
</body>

</html>