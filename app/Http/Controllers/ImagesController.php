<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;


class ImagesController extends Controller
{

    private ImageService $images;

    public function __construct(ImageService $imageService)
    {
        $this->images = $imageService;
    }

   public function index() {
        $images = $this->images->getAll();
        return view('welcome', ['imagesInView' => $images]);
    }

    function create() {

        return view('create');
    }

    function store(Request $request) {
        $image = $request->file('image');
        $this->images->add($image);

        return redirect(
            '/'
        );
    }

    function show($id) {
        $myImage = $this->images->getOne($id);
        return view('show', [
            'imageInView' => $myImage->image
        ]);
    }

    function edit($id) {
        $myImage = $this->images->getOne($id);

        return view('edit', [
            'imageInView' => $myImage,
        ]);
    }

    function update(Request $request, $id) {
        $this->images->update($id, $request->image);
        return redirect('/');
    }

    function delete($id) {
        $this->images->delete($id);
        return redirect('/');
    }
}
