<?php
include 'conecta_sql.php';

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
            $origem = $_POST["texto"];
            //$origem = '%41%%6c%6f%5b%5d';
            $array = str_split($origem);
            $i = 0;
            $estado = 0;
            $destino = '';
            $pattern = '/[%]{1}[0-9A-Fa-f]{2}/m';
            $chaves = array_keys($percentArray);
    
            if($estado == 0){
              
            for ($i; $i < sizeof($array); $i++) {
              if($array[$i] != '%'){
                $destino .= $array[$i];
              } else {
                $char0 = $array[$i];
                $estado++;
              }
            if($estado == 1){
              $char = $char0;
              $j = $i;
              $char .= $array[$j+1];
              $char .= $array[$j+2];


              if(preg_match($pattern, $char)){
              $charDecrypt = str_replace(array_values($percentArray), array_keys($percentArray), $char);
              
              $destino .= $charDecrypt;
              $i++;
              $i++;
    
              $estado=0;
              } else{
                $destino .= $array[$i];
                $estado=0;
              } 
              
             }
             $txtDesofuscado = $destino;
            }
            echo '{"sucesso":"true", "texto_ofuscado":"'. $txtDesofuscado . '"}';
        }
?>