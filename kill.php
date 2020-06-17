<?php
  $port = 43556;
  if(!empty($port) && is_numeric($port) ){
  $pid = trim(shell_exec("lsof -t -i:".$port));
  if(!empty($pid)){

   shell_exec("sudo kill -9 ".$pid);
   echo "pid : ".$pid."  killed which is listened port : ".$port."\xA";
   
  }
  else{
     echo " [X] no such process found for pid : ".$port."\xA";
  }
  }
  else{ 
     echo " invalid pid \xA";
  }
?>