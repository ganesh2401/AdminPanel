<?php   
  // The plain text password to be hashed 
  $plaintext_password = "Ganesh@123"; 
  
  // The hash of the password that 
  // can be stored in the database 
  $hash = crypt($plaintext_password,'rl'); 
  
  // Print the generated hash 
  echo "Generated hash: ".$hash; 
?>  
