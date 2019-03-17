<?php

foreach ($all_files as $collection_path => $collection_files) {

  foreach ($collection_files as $file) {
    $content = file_get_contents($file);
    file_put_contents($file, str_replace("\r\n", "\n", $content));
  }
}  

echo("The CRLFs has been removed successfully!\n");
