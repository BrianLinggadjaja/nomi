<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ImageCRUDContract;
use App\Models\ImagePriority;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

/**
 * Intervention implementation of image CRUD.
 */
class ImageCRUDService implements ImageCRUDContract
{
    /** Image uploading functionality. */
    public function upload()
    {
        $image = request()->media;
        $email = \str_replace('nr_', '', request()->email);
        $email = \substr($email, 0, \strpos($email, '@'));

        $data = [
            'image' => $image,
        ];

        $rules = [
            'image' => 'required|mimes:jpeg,jpg,png|max:10000',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return 'Failed';
        }

        $image->move(env('IMAGE_UPLOAD_LOCATION') . '/' . $email . '/', 'likeness.jpg');

        for ($i = 0; $i < 10; ++$i) {
            Cache::forget('students_' . $i);
        }

        return 'Uploaded';
    }

    /** Retrieve image priority
     * @param $student_ids
     *
     * @return array
     */
    public function getPriority($student_ids)
    {
        $array = [];
        $out = [];

        foreach ($student_ids as $student_id) {
            \array_push($array, 'members:' . $student_id);
        }

        $users = User::with('ImagePriority')
            ->whereIn('user_id', $array)
            ->get();

        foreach ($users as $user) {
            if (null !== $user->imagePriority) {
                \array_push($out, \explode(',', $user->imagePriority->image_priority));
            } else {
                \array_push($out, ['likeness', 'avatar', 'official']);
            }
        }

        for ($i = 0; $i < 10; ++$i) {
            Cache::forget('students_' . $i);
        }

        return $out;
    }

    /** Update image_priority table */
    public function updatePriority()
    {
        $user = User::with('ImagePriority')
            ->where('user_id', 'members:' . request()->student_id)
            ->firstOrFail();

        if (null !== $user->imagePriority) {
            $user->imagePriority->image_priority = request()->image_priority;
            $user->imagePriority->save();
        } else {
            $user->imagePriority()->create(['image_priority' => request()->image_priority]);
        }

        for ($i = 0; $i < 10; ++$i) {
            Cache::forget('students_' . $i);
        }

        return "Completed.\n";
    }
}
