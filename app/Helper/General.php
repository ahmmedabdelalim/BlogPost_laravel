<?php


/*function SaveImage($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    $path = 'http://localhost/blog_project/blog_lara/assets/images/' . $folder . '/' . $filename;
    return $path;
}*/

function save($request)
{
    $file_path= time(). '.' .$request->image->getClientOriginalExtension();
    $request->image->move(public_path('image',$file_path));
}
?>
