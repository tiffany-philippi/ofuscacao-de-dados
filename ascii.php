<?php
include 'conecta_sql.php';

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
            $origem = $_POST["texto"];

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
                $txtDesofuscado = $destino;

                echo '{"sucesso":"true", "texto_ofuscado":"'. $txtDesofuscado . '"}';
            }