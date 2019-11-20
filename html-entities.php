<?php
include 'conecta_sql.php';

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

$origem = $_POST["texto"];

$array = str_split($origem);

$i = 0;
$estado = 0;
$count = 0;
$destino = '';
$temp = '';
$char = '';
$aux = 0;
for ($i; $i < sizeof($array); $i++) {
  if ($estado == 0) {
      if ($array[$i] != '&') {
          $destino .= $array[$i];
      } else {
          $temp .= $array[$i];
          $estado = 1;
      }
    }
      if ($estado == 1) {
          if ($array[$i] == "&" && $aux == 0) {
              $aux = 1;
          } else {
              if ($array[$i] == ';') {

                  $temp .= $array[$i];


                  $tester = str_replace(array_values($ampersanArray), array_keys($ampersanArray), $temp, $count);

                  if ($count > 0) {
                      $charDecrypt = str_replace(array_values($ampersanArray), array_keys($ampersanArray), $temp);
                      $destino .= $charDecrypt;
                      $estado = 0;
                      $count = 0;
                      $aux = 0;
                      $temp = '';
                  } else{
                     $destino .= $temp;
                      $estado = 0;
                      $count = 0;
                      $temp = '';
                      $aux = 0;
                  }
              } else if ($array[$i] == '&') {
                  $temp .= $array[$i];
                  $destino .= $temp;
                   $estado = 0;
                   $count = 0;
                   $temp = '';
                   $aux = 0;
              } else {
                  $temp .= $array[$i];
              }
          }
      }
  
}
$txtDesofuscado = $destino;

echo '{"sucesso":"true", "texto_ofuscado":"'. $txtDesofuscado . '"}';