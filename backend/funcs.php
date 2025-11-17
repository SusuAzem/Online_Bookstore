<?php

# validation
function is_empty($var, $text, $file, $msg, $data)
{
   if (empty($var)) {
      $errmsg = "The " . $text . " is required";
      header("Location: $file?$msg=$errmsg&$data");
      exit;
   }
   return 0;
}