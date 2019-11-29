<?php
// Conexão ao Banco de Dados
include 'conecta_sql.php';

?>
<script>
function salvarContato(){
      var dados = $('#usuario').serialize();
      $.ajax({
          url: "salvarbanco.php",
          data: dados
      })
}

</script>
