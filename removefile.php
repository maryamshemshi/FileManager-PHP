<?php
function myRemoveDir($path)
{
    $content = scandir($path);
    foreach ($content as $file) {
        if ($file == '.' or $file == '..')
            continue;
        if (is_dir($path . '/' . $file)) {
            myRemoveDir($path . '/' . $file);
        } else {
            unlink($path . '/' . $file);
        }
    }
    rmdir($path);
}