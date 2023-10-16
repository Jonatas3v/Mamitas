<?php
   // método que não deve ser usado
   echo md5("1234");

   // método ideal - acrescente em seu código acima
   $senha = "1234";
   $hash = password_hash($senha, PASSWORD_DEFAULT);
   // PASSWORD_DEFAULT é o método (um bom método) de criptografia
   echo "<p>" . $hash;
   // veja a diferença da mudança dos algorítmo md5

   // acrescente ao código
   // para verificar se a senha está correta, usamos outra função
   echo "<p>" . password_verify($senha, '$y$10$ott5xoawF/UquA6QI0dTGOWjb4Dn5KeDsNbcQ2p9zkPwW2vTlKQF2');
   // para testar em seu código, a parte alfanumérica do código acima, 
   // copie de seu código na página, para teste. O resultado de retorno 1(um), 
   // indica que foi encontrado.
  
?>
