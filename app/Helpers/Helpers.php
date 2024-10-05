<?php

function getStatus($status)
{
    return $status == 'on' ? 1 : 0;
}


function uploadImage($data, $folderName, $old_image = null)
{
    if ($data->file('image')) {
        $imageName = time() . '.' . $data->image->getClientOriginalExtension();
        $data->image->move(public_path('uploads/' . $folderName), $imageName);
        deleteImage($old_image, $folderName);
        unset($data);
        return $imageName;
    } else {
        unset($data);
        return "";
    }
}

function deleteImage($image, $folderName)
{
    if ($image != null) {
        if (file_exists(public_path('uploads/' . $folderName . '/' . $image))) {
            @unlink(public_path('uploads/' . $folderName . '/' . $image));
        }
    }
    /*  $imageName = time().'.'.$data->image->getClientOriginalExtension();
    $data->image->move(public_path('uploads/'.$folderName), $imageName);
    return $imageName; */
}

function sendEmail($viewPath, $viewData, $to, $from, $replyTo, $subject, $params = array())
{
    try {
        Mail::send(
            $viewPath,
            $viewData,
            function ($message) use ($to, $from, $replyTo, $subject, $params) {
                $attachment = (isset($params['attachment'])) ? $params['attachment'] : '';

                if (!empty($replyTo)) {
                    $message->replyTo($replyTo);
                }

                if (!empty($from)) {
                    $message->from($from, env('APP_NAME'));
                }

                if (!empty($attachment)) {
                    $message->attach($attachment);
                }

                $message->to($to);
                $message->subject($subject);
            }
        );
    } catch (\Exception $e) {
        // Never reached
    }

    if (count(Mail::failures()) > 0) {
        return false;
    } else {
        return true;
    }
}
