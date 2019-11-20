<?php
include 'conecta_sql.php';

//////////////////////////////////////////////////
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
//////////////////////////////////////////////////
$sql = "SELECT bloco, valencia FROM char_code;";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();
$num_reg = count($rows);
if($num_reg>0){
  foreach($rows as $key){
   
    $charArray[$key['bloco']] = $key['valencia'];
  }
}
//////////////////////////////////////////////////
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
//////////////////////////////////////////////////




//////////////// LEITURA DO ARQUIVO \\\\\\\\\\\\\\
$arq_caminho = getcwd() . "\\arq\\";
if (!(is_dir($arq_caminho)))
{
    (mkdir($arq_caminho,0777));
}
chdir($arq_caminho);
if(isset($_FILES))
{
    $i = 0;
    $arquivos = array( array( ) );
    foreach(  $_FILES as $key=>$info ) {
        foreach( $info as $key=>$dados ) {
            for( $i = 0; $i < sizeof( $dados ); $i++ ) {
                $arquivos[$i][$key] = $info[$key][$i];
            }
        }
    }
    foreach( $arquivos as $file ) {
        if( $file['name'] != '')
        {
            $arquivoTmp = $file['tmp_name'];
            $arquivo = $file['name'];
            move_uploaded_file( $arquivoTmp, $arq_caminho. $arquivo ); 
        }
        else{
            echo "Arquivo vazio ou não informado.";
        }
    }
    
}
else
{
    echo "Problemas na carga dos arquivos.\n";
}

$array_arq = array();

$arq = fopen($arq_caminho . "\\" . $arquivo,"r");
	while(!feof($arq)){

        $linha = fgets($arq);
        array_push($array_arq,$linha);
    }
    fclose($arq);

        // FOR QUE VAI PERCORRER O ARRAY QUE É O ARQUIVO E DESOFUSCAR.
    
        $estadoGeral = 0;

        for ($p = 0; $p < sizeof($array_arq); $p++){


            if($estadoGeral == 0) {
            $origem = $array_arq[$p];
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
              $charDecrypt = str_replace(array_values($percentArray), array_keys($percentArray), strtolower($char));
              
              $destino .= $charDecrypt;
              $i++;
              $i++;
    
              $estado=0;
              } else{
                $destino .= $array[$i];
                $estado=0;
              } 
              
             }
             $percentDesofuscado = $destino;
            }
            $estadoGeral = 1;
        }
    }


    if($estadoGeral == 1) {

            $origem = $percentDesofuscado;

            $arrayOrigem = str_split($origem);
    
            // Variaveis utilizadas no deccorer do codigo.
            $i = 0;
            $estado = 0;
            $destino = '';
            $chaves = array_keys($charArray);
            $valores = array_values($charArray);
            $aux = '';
            $aux2 = '';
            $contador = sizeof($arrayOrigem);
            $pattern = '/(?:char\([3][2-9]\))|(?:char\([4-9][0-9]\))|(?:char\([1][0-1][0-9]\))|(?:char\([1][2][0-6]\))/m';


            if($estado == 0){

                for ($i=0; $i < $contador; $i++) {

                    if($arrayOrigem[$i] != 'c'){
                      $destino .= $arrayOrigem[$i];
      
                     } else {
                        $estado = 1;
                     }

                    if ($estado == 1) {
                        $position1 = $arrayOrigem[$i];
                                           
                        $position2 = $arrayOrigem[$i+1];
                        
                        $position3 = $arrayOrigem[$i+2];
                        
                        $position4 = $arrayOrigem[$i+3];
                        
                        $position5 = $arrayOrigem[$i+4];
                        
                        $aux = $position1 . $position2 . $position3 . $position4 . $position5;

                        if ($aux == 'char(') {
                            $estado = 2;
                        } else{
                            $destino .= $arrayOrigem[$i];
                            $estado = 0;
                        }
                    }

                    if ($estado == 2) {

                        $position6 = $arrayOrigem[$i+5];
                        $position7 = $arrayOrigem[$i+6];
                        $position8 = $arrayOrigem[$i+7];
                        $position9 = $arrayOrigem[$i+8];

                        $pos8 = $arrayOrigem[$i+7];
                        $pos9 = $arrayOrigem[$i+8];

                        $concat89 = $position8 . $position9;

                        $aux2 = is_numeric($pos8) ? $concat89 : $position8;



                        $aux3 = $aux . $position6 . $position7 . $aux2;

                        $estado = 0;

                        if (preg_match_all($pattern, $aux3)) {
                            $charDecrypt = str_replace($valores, $chaves, $aux3);
                            $destino .= $charDecrypt;
                            $strlen = strlen($aux3);
                            if($strlen == 8){
                            $i += 7;
                            }else{
                            $i += 8;
                            }
                        } else {
                            $destino .= $arrayOrigem[$i];
       
                        }
                        
                    }

                }
                $charDesofuscado = $destino;
            }
            $estadoGeral = 2;
        }

        if($estadoGeral == 2){

            $origem = $charDesofuscado;

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
$ampersanDesofuscado = $destino;
$linhaDesofuscada = $ampersanDesofuscado;
 $estadoGeral = 3;
        }



        if($estadoGeral == 3){
            $tamanho = sizeof($array_arq);

            if($p == $tamanho){
                $array_arq[$p] = $linhaDesofuscada;
                $estadoGeral = 4;
            }else{
                $array_arq[$p] = $linhaDesofuscada;
                $estadoGeral = 0;
            }
            
        }

  
        


    } // FIM

    echo "<div id='textoOrigem'>";
    for ($fim = 0; $fim < sizeof($array_arq); $fim++){

        echo htmlentities($array_arq[$fim]) ."<br>";
    }
    echo "</div>";