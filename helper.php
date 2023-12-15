<?php

function upload_file($file, $subpath)
{
    $filename = $file->getClientOriginalName();
    $path = public_path('uploads/' . $subpath . '/');

    if (!File::isDirectory($path)) {
        File::makeDirectory($path, 0777, true);
    }
    $file->move($path, $filename);

    return $filename;
}

function delete_file($filename, $subpath)
{
    $path = public_path('uploads/' . $subpath . '/');
    if (File::exists($path . $filename) && !File::isDirectory($path . $filename)) {
        File::delete($path . $filename);
    }
}
