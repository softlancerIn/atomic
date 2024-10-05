<?php

namespace App\Http\Traits;

use App\Models\File;
use Intervention\Image\Facades\Image;

trait CommonTrait
{
    public function public_path($folder)
    {
        return "/home/u404352962/domains/teknikoglobal.in/public_html/jagjiwan/api/public/" . $folder;
    }

    public function make_directory($directory)
    {
        $directory = public_path('uploads/') . $directory;

        if (!is_dir($directory)) {
            mkdir($directory);
        }
    }

    public function pa($data)
    {
        print_r($data);
        die;
    }

    public function testing($request, $request_name, $table_name, $table)
    {
        $file = $request->file($request_name);
        $extension = $file->extension();
        $fileName = date("j-M-Y-His-a") . "-" . $table_name . "-" . time() . $table->id . rand(1000000000, 9999999999) . "." . $extension;
        $path = public_path('uploads/') . $table_name;
        $file->move($path, $fileName);

        $table->$request_name = $fileName;
        $table->save();
    }

    public function same_table_images($request, $request_name, $table_name, $table)
    {
        $file = $request->file($request_name);
        $extension = $file->extension();
        $fileName = date("j-M-Y-His-a") . "-" . $table_name . "-" . time() . $table->id . rand(1000000000, 9999999999) . "." . $extension;
        $path = public_path('uploads/') . $table_name;
        $file->move($path, $fileName);

        if ($request_name == "owner_image") {
            $table->owner_image = $fileName;
        } else if ($request_name == "id_proof_image") {
            $table->id_proof_image = $fileName;
        } else if ($request_name == "licence_image") {
            $table->licence_image = $fileName;
        } else if ($request_name == "check_image") {
            $table->check_image = $fileName;
        } else {
            $table->image = $fileName;
        }
        $table->save();
    }

    public function upload_multiple_files($request, $request_name, $child_name, $doc_type, $table_name, $table_name_id)
    {
        foreach ($request->file($request_name) as $file) {
            $extension = $file->extension();
            $fileName = date("j-M-Y-His-a") . "-" . $table_name . "-" . $child_name . "-" . time() . $table_name_id . rand(1000000000, 9999999999) . "." . $extension;
            $path = public_path('uploads/') . $table_name;
            $file->move($path, $fileName);

            $files = File::create([
                'doc_type' => $doc_type,
                'doc_ext' => $extension,
                // 'doc_path' => $file->store($table_name, 'public'), //for random
                'doc_path' => $fileName, //formated way
                'child_name' => $child_name,
                'table_name' => $table_name,
                'table_name_id' => $table_name_id,
                'user_id' => auth()->id()
            ]);
        }
        // upload_multiple_files($request, "doc_image", "image", "posts", $table_name_id);
    }

    public function upload_single_file($request, $request_name, $child_name, $doc_type, $table_name, $table_name_id)
    {
        $file = $request->file($request_name);
        $extension = $file->extension();
        $fileName = date("j-M-Y-His-a") . "-" . $table_name . "-" . time() . $table_name_id . rand(1000000000, 9999999999) . "." . $extension;
        $path = public_path('uploads/') . $table_name;
        $file->move($path, $fileName);

        $file = File::create([
            'doc_type' => $doc_type,
            'doc_ext' => $extension,
            // 'doc_path' => $file->store($table_name, 'public'), //for random
            'doc_path' => $fileName, //formated way
            'child_name' => $child_name,
            'table_name' => $table_name,
            'table_name_id' => $table_name_id,
            'user_id' => auth()->id()
        ]);
        // upload_single_file($request, "doc_image", "image", "posts", $table_name_id);
    }

    public function paginator($pages)
    {
        $pages = $pages;
        if ($pages->currentPage() - 1 == "0") {
            $prev_page_url = null;
        } else {
            $prev_page_url = $pages->path() . "?page=" . $pages->currentPage() - 1;
        }

        $pages = [
            "path" => $pages->path(),
            "prev_page_url" => $prev_page_url,
            "current_page" => $pages->currentPage(),
            "next_page_url" => $pages->nextPageUrl(),
            "last_page" => $pages->lastPage(),
        ];

        return $pages;
    }

    public function crop_image($request, $request_name, $doc_type, $table_name, $table_name_id, $ratio_9 = 9, $ratio_16 = 16, $layout = "landscape")
    {
        $file = $request->file($request_name);
        [$width, $height] = getimagesize($file);
        $extension = $file->extension();
        $fileName = date("j-M-Y-His-a") . "-" . $table_name . "-" . time() . $table_name_id . rand(1000000000, 9999999999) . "." . $extension;
        $path = public_path('uploads/') . $table_name . '/';
        $imgFile = Image::make($file);

        if ($layout == "landscape") {
            $height_o = ($width * $ratio_9) / $ratio_16;
            if ($height_o < $height) {
                $height = $height_o;
            } else {
                $width_o = ($height * $ratio_16) / $ratio_9;
                $width = $width_o;
            }
        } else if ($layout == "portrait") {
            $width_o = ($height * $ratio_9) / $ratio_16;
            if ($width_o < $width) {
                $width = $width_o;
            } else {
                $height_o = ($width * $ratio_16) / $ratio_9;
                $height = $height_o;
            }
        }

        $width = round($width);
        $height = round($height);

        $imgFile->crop($width, $height)->save($path . $fileName);

        File::create([
            'doc_type' => $doc_type,
            'doc_ext' => $extension,
            // 'doc_path' => $file->store($table_name, 'public'), //for random
            'doc_path' => $fileName, //formated way
            'table_name' => $table_name,
            'table_name_id' => $table_name_id,
            'user_id' => auth()->id()
        ]);
        // crop_image($request, "doc_image", "image", "posts", $table_name_id, 10, 20, "portrait");
    }

    public function downloadImage($image)
    {
        $imagePath = Storage::url($image);

        return response()->download(public_path($imagePath));
    }

    //======================== fileuploading conponent=========================//
    public function fileupload($file, $type)
    {
        $path = "public/" . $type;
        if (file_exists($path)) {
            $filename = time() . '-' . $type . '-' . $file->getClientOriginalName();
            $file->move($path, $filename);
            return $filename;
        } else {
            mkdir($path, 0777, true);
            $filename = time() . '-' . $type . '-' . $file->getClientOriginalName();
            $file->move($path, $filename);
            return $filename;
        }
    }
}


// https://stackoverflow.com/questions/43433350/how-to-use-traits-in-laravel-5-4-18