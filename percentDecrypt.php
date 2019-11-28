<?php
// Conexão ao Banco de Dados
include 'conecta_sql.php';


// Pesquisa do banco, buscando as referencias do Ampersan e gerando em um Array de Keys => Values
$sql = "SELECT bloco, valencia FROM percent;";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();
$num_reg = count($rows);
if($num_reg>0){
  foreach($rows as $key){
    
    $percentArray[$key['bloco']] = $key['valencia'];
  }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////


            // Recebe em Origem o conteudo do Input da pagina Index por POST.
            $origem = $_POST["texto"];

            //Quebra a String Origem em um array, char por char.
            $array = str_split($origem);

            // Inicialização de Variaveis usadas no decorrer do codigo.
            $i = 0;
            $estado = 0;
            $destino = '';
            $pattern = '/[%]{1}[0-9A-Fa-f]{2}/m';
            $chaves = array_keys($percentArray);
            /////////////////////////////////////////////////////////////////////////////////////////////////////




            // Começo da desofuscação, "Estado 0 ".
            if($estado == 0){
              

          // FOR que percore o Array da String procurando uma % e concatenando em destino case não encontre
            for ($i; $i < sizeof($array); $i++) {
              if($array[$i] != '%'){
                $destino .= $array[$i];
              } else {
                $char0 = $array[$i];
                $estado++;
              }


            // Estado 1, concatena a variavel "char0" na variavel temporaria "char".
            // Definimos o valor $i em $j
            // Concatena os dois proximos indices em char.

            if($estado == 1){
              $char = $char0;
              $j = $i;
              $char .= $array[$j+1];
              $char .= $array[$j+2];


              // Verifica se o conteudo concatenado, é equivalente a um valor valido.
              // Se for um valor valido, desofusca salvando em $charDecrypt e depois concatena em destino.
              // avança o FOR em dois indices e reseta o Estado para 0.

              if(preg_match($pattern, $char)){
              $charDecrypt = str_replace(array_values($percentArray), array_keys($percentArray), $char);
              
              $destino .= $charDecrypt;
              $i++;
              $i++;
    
              $estado=0;

              // Caso não seja um valor valido, apenas concatena o indice atual e reseta o estado para 0.
              } else{
                $destino .= $array[$i];
                $estado=0;
              } 
              
             }

             //Quando acabar o for, salva todo o texto em $txtDesofuscado e devolve em tela.
             $txtDesofuscado = $destino;
            }
            echo '{"sucesso":"true", "texto_ofuscado":"'. $txtDesofuscado . '"}';
        }
?>