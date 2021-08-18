<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ImageService
{
    public function getAll(): array
    {
        $images = DB::table('images')->select('*')->get();
        return $images->all();
    }

    public function add($image)
    {
        DB::table('images')->insert([
            'image' => $image->store('uploads')
        ]);
    }

    public function getOne($id)
    {
        return DB::table('images')->select('*')->where('id', $id)->first();
    }

    public function update($id, $newImage)
    {
        $image = DB::table('images')->select('*')->where('id', $id)->first();
        Storage::delete($image->image);

        $filename = $newImage->store('uploads');

        DB::table('images')->where('id', $id)->update([
            'image' => $filename
        ]);
    }

    public function delete($id)
    {
        $image = $this->getOne($id);
        Storage::delete($image->image);
        DB::table('images')->delete($id);
    }
}
