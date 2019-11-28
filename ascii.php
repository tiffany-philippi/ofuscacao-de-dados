<?php

// Conexão ao Banco de Dados
include 'conecta_sql.php';


// Pesquisa do banco, buscando as referencias do Ampersan e gerando em um Array de Keys => Values
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
/////////////////////////////////////////////////////////////////////////////////////////////////////



 // Recebe em Origem o conteudo do Input da pagina Index por POST.
            $origem = $_POST["texto"];


            //Quebra a String Origem em um array, char por char.
            $arrayOrigem = str_split($origem);
    
             // Inicialização de Variaveis usadas no decorrer do codigo.
            $i = 0;
            $estado = 0;
            $destino = '';
            $chaves = array_keys($charArray);
            $valores = array_values($charArray);
            $aux = '';
            $aux2 = '';
            $contador = sizeof($arrayOrigem);
            $pattern = '/(?:char\([3][2-9]\))|(?:char\([4-9][0-9]\))|(?:char\([1][0-1][0-9]\))|(?:char\([1][2][0-6]\))/m';
            /////////////////////////////////////////////////////////////////////////////////////////////////////



            // Começo da desofuscação. ESTADO 0
            if($estado == 0){


                // FOR que percore o Array da String procurando um char com valor C e concatenando em destino case não encontre
                for ($i=0; $i < $contador; $i++) {


                     

                    if($arrayOrigem[$i] != 'c'){
                      $destino .= $arrayOrigem[$i];
      
                     } else {
                        $estado = 1;
                     }


                     // Estado 1
                     // As variaveis posicoes são variaveis temporarias que salva os valores do indice atual + valor da posicao.
                    if ($estado == 1) {
                        $position1 = $arrayOrigem[$i];
                                           
                        $position2 = $arrayOrigem[$i+1];
                        
                        $position3 = $arrayOrigem[$i+2];
                        
                        $position4 = $arrayOrigem[$i+3];
                        
                        $position5 = $arrayOrigem[$i+4];
                        

                        // Concatena todas as 5 posicoes
                        $aux = $position1 . $position2 . $position3 . $position4 . $position5;


                        // Verifica se as posicoes concatenadas são iguais a "char(", se sim avança para o estado 2, caso contrario
                        // apenas concatena e volta ao estado 0.
                        if ($aux == 'char(') {
                            $estado = 2;
                        } else{
                            $destino .= $arrayOrigem[$i];
                            $estado = 0;
                        }
                    }


                    // Estado 2, pega as proximas posicoes.
                    if ($estado == 2) {

                        $position6 = $arrayOrigem[$i+5];
                        $position7 = $arrayOrigem[$i+6];
                        $position8 = $arrayOrigem[$i+7];
                        $position9 = $arrayOrigem[$i+8];

                        $pos8 = $arrayOrigem[$i+7];
                        $pos9 = $arrayOrigem[$i+8];


                        // Concatena apenas a posicao 8 e 9 para talvez utilizar mais a frente.
                        $concat89 = $position8 . $position9;


                        // Verifica se a pos 8 é numerica, caso seja, usamos a concatenação 8 e 9, caso não seja usamos apenas a posicao 8.
                        // POr que isso? por que dentro de "char()" podemos ter 2 numeros ou 3, e a concatenação verifica exatamente isso.
                        // Se a palavra concatena é "numero + )" ou "numero + numero".
                        $aux2 = is_numeric($pos8) ? $concat89 : $position8;


                        // concateno o $aux (Estado 1), e a posicao 6 e 7 e depois o valor adquirido da verificação acima.
                        // Reseta o estado para 0.
                        $aux3 = $aux . $position6 . $position7 . $aux2;



                        $estado = 0;


                        // Verifica se todo o conteudo concatenado, é um regex de ascii, caso seja ele desofusca concatena em destino.
                        // Verifica se o tamanho é um ascii de 3 numeros ou 2, e avança a quantidade de indices necessários.
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
                            // Caso conctrario apenas concatena o indice atual.
                            $destino .= $arrayOrigem[$i];
       
                        }
                        
                    }

                }

                // Salva toda a string desofuscada em $txtDesofuscado e retorna na tela.
                $txtDesofuscado = $destino;

                echo '{"sucesso":"true", "texto_ofuscado":"'. $txtDesofuscado . '"}';
            }