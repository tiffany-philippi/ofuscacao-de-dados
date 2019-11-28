<?php
// Conexão ao Banco de Dados
include 'conecta_sql.php';


// Pesquisa do banco, buscando as referencias do Ampersan e gerando em um Array de Keys => Values
$sql = "SELECT bloco, valencia FROM ampersan;";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();
$num_reg = count($rows);
if($num_reg>0){
  foreach($rows as $key){
    
    $ampersanArray[$key['bloco']] = $key['valencia'];
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
$count = 0;
$destino = '';
$temp = '';
$char = '';
$aux = 0;
/////////////////////////////////////////////////////////////////////////////////////////////////////



// Começo da desofuscação.

// FOR que percore o Array da String procurando um & comercial e concatenando em destino case não encontre.
for ($i; $i < sizeof($array); $i++) {
  if ($estado == 0) {

        // Se o indice do array for diferente do & comercial ele entra no estado 1, salvando o & comercial em uma variavel temporaria.
      if ($array[$i] != '&') {
          $destino .= $array[$i];
      } else {
          $temp .= $array[$i];
          $estado = 1;
      }
    }

        // Estado um, ESTADO que concatena os proximos caracteres procurando por outro & comercial ou ;
      if ($estado == 1) {

        // Verifica se o indice do Array é igual a & comercial e se a variavel "Aux" é 0.
        // Desta maneira ele irá rodar o for passando para o proximo indice sem tentar desofuscar nada.
        // Quando ele passar aqui a segunda vez, ele ira entrar no código de desofuscação.
        // Este IF foi feito para poder pular o código e passar para o proximo indice, e não fazer uma concatenação errada.
          if ($array[$i] == "&" && $aux == 0) {
              $aux = 1;
          } else {

            // Verifica se o indice do array é igual a ;
              if ($array[$i] == ';') {


                // Se for igual a ; ele concatena com o que já tem salvo em TEMP.
                  $temp .= $array[$i];

                // Variavel "Tester" é um STRreplace para verificar se ele consegue desofuscar a string "Temp" baseado nas referencias do banco.
                // Caso ele consiga retorna a contagem de 1 caso contrario fica a contagem como 0. ( True or False).
                  $tester = str_replace(array_values($ampersanArray), array_keys($ampersanArray), $temp, $count);
                 
                  // Se a do STRreplace for maior que zero ele realmente desofusca o código, concatena e reseta as variaveis e o estado
                  // para que possa passar para os proximos caracteres da String.
                  if ($count > 0) {
                      $charDecrypt = str_replace(array_values($ampersanArray), array_keys($ampersanArray), $temp);
                      $destino .= $charDecrypt;
                      $estado = 0;
                      $count = 0;
                      $aux = 0;
                      $temp = '';
                  } else{
                      // Caso seja menor que zero, ele apenas concatena o conteudo de temp e reseta as variaveis para que se possa ser repetido
                      // o processo.
                      $destino .= $temp;
                      $estado = 0;
                      $count = 0;
                      $temp = '';
                      $aux = 0;
                  }
                  
                  
                  //Ele entrará nesse else if, caso o codigo não seja ; para verificar se não é um & , pois se for um &
                  // Sabemos que o código para tras é apenas parte da String e não um codigo ofuscado.
                  // Concatena o indice na temp e a temp no destino, reseta os estados e roda o programa de novo.
              } else if ($array[$i] == '&') {
                  $temp .= $array[$i];
                  $destino .= $temp;
                   $estado = 0;
                   $count = 0;
                   $temp = '';
                   $aux = 0;
              } else {

                // Caso ele não seja ; e nem & ele concatena e continua no estado 1.
                  $temp .= $array[$i];
              }
          }
      }
  
}

// Salva a String desofuscada em "txtDesofuscado"
$txtDesofuscado = $destino;


// Retorna para o index.
echo '{"sucesso":"true", "texto_ofuscado":"'. $txtDesofuscado . '"}';
