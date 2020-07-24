<?php


 function saveImage($folder ,$image)
{
    $image->store('/',$folder);
    $file_name=$image->hashName();
    $path='images/'.$folder.'/'.$file_name;
    return $path;
}