<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Mail\SendNewMail;
use Illuminate\Support\Facades\Mail;


use App\User;
use App\InfoUser;
use App\Page;
use App\Category;
use App\Tag;
use App\Photo;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::paginate(25);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $photos = Photo::all();

        return view('admin.pages.create', compact('categories', 'tags', 'photos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $now = Carbon::now()->format('Y-m-d-H-i-s');
        $data['slug'] = Str::slug($data['title'] , '-') . $now;

        if (isset($data['photo'])) {
            $path = Storage::disk('public')->put('images', $data['photo']);
            $photo = new Photo;
            $photo->user_id = Auth::id();
            $photo->name = $data['title'];
            $photo->path = $path;
            $photo->description = 'Descrizione Foto';
            $photo->save();
        }

        $validator = Validator::make($data, [
            'title' => 'required|max:200',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'photos.*' => 'exists:photos,id'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.pages.create')
                ->withErrors($validator)
                ->withInput();
        }

        $page = new Page;

        $page->fill($data);
        $saved = $page->save();

        $page->tags()->attach($data['tags']);

        if(!empty($photo)) {
            $page->photos()->attach($photo);
        }

        if (!$saved) {
            return redirect()->route('admin.pages.create')
                ->with('failure', 'Pagina non inserita.');
        }

        // Mail::to('mail@mail.it')->send(new SendNewMail($page));
        return redirect()->route('admin.pages.show', $page->id)
            ->with('success', 'Pagina ' . $page->id . ' inserita correttamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        $photos = Photo::all();

        return view('admin.pages.edit', compact('page','categories', 'tags', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $data = $request->all();

        $userId = Auth::id();
        $author = $page->user_id;

        if($userId != $author) {
            return redirect()->route('admin.pages.index')
                ->with('failure', 'Non puoi modificare una pagina che non hai creato tu');
        }

        if (isset($data['photo-file'])) {
            $photosThisPage = $page->photos;
            foreach($photosThisPage as $photo) {
                $deleted = Storage::disk('public')->delete($photo->path);
                $page->photos()->detach($photo->id);
                $photoDb = Photo::find($photo->id);
                $photoDb->delete();
            }

            $path = Storage::disk('public')->put('images', $data['photo-file']);

            $photo = new Photo;
            $photo->user_id = Auth::id();
            $photo->name = $data['title'];
            $photo->path = $path;
            $photo->description = 'Lorem ipsum';
            $saved = $photo->save();

            $page->photos()->attach($photo->id);
        }

        $validator = Validator::make($data, [
            'title' => 'max:200',
            'category_id' => 'exists:categories,id',
            'tags' => 'array',
            'photos' => 'array',
            'tags.*' => 'exists:tags,id',
            'photos.*' => 'exists:photos,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $page->fill($data);
        $updated = $page->update();

        $page->tags()->sync($data['tags']);
        $page->photos()->sync($data['photos']);

        if (!$updated) {
            return redirect()->back()
                ->with('failure', 'Pagina non modificata.');
        }

        return redirect()->route('admin.pages.show', $page->id)
            ->with('success', 'Pagina ' . $page->id . ' modificata correttamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);

        $page->tags()->detach();
        $page->photos()->detach();
        $deleted = $page->delete();

        if(!$deleted){
            return redirect()->route('admin.pages.index')
                ->with('failure', 'Pagina ' . $page->id . ' non eliminata.');
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Pagina ' . $page->id . ' eliminata correttamente.');
    }
}
