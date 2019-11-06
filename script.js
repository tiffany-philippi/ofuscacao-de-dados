document.writeln("<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>");
document.writeln("<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js' integrity='sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49' crossorigin='anonymous'></script>");
document.writeln("<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js' integrity='sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy' crossorigin='anonymous'></script>");

$(document).ready(function(){
	$('#bt_loadURL').click(function(){
		var original = $('#origem').val();

		$.ajax({
			url: 'percentDecrypt.php',
			data: {texto: original},
			timeout: 1200000,
			async: false,
			type: 'POST',
			dataType: 'json',
		
			success: function(retorno) {
				if(retorno.sucesso == 'true'){
					$('#resultURL').val(retorno.original);
				} else {
					$('#resultURL').val("ERROR!");
				}
			}
		})
	});
});