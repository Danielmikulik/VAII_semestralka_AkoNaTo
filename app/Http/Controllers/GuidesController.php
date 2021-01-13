<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $guides = Guide::paginate(15);

        return view('guide.index', [
            'guides' => $guides
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('guide.create', [
            'action' => route('guide.store'),
            'method' => 'post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png|max:5000'
            ]);

            $request->file('image')->store('guides', 'public');

            $guide = new Guide([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'image_path' => $request->file('image')->hashName(),
                'user_id' => Auth::id(),
            ]);
        } else {
            $guide = new Guide([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'user_id' => Auth::id(),
            ]);
        }
        $guide->save();
        //dd($request->all());
        return redirect()->route('guide.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Guide $guide
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Guide $guide)
    {
        return view('guide.detail', [
            'guide' => $guide
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Guide $guide)
    {
        return view('guide.edit', [
            'action' => route('guide.update', $guide->id),
            'method' => 'put',
            'model' => $guide
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Guide $guide
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function update(Request $request, Guide $guide)
    {
        $request->validate([
            'title' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png|max:5000'
            ]);

            $request->file('image')->store('guides', 'public');
            Guide::query()->find($guide->id)->update(array('image_path' => $request->file('image')->hashName()));
        }
        $guide->update($request->all());
        return redirect()->route('guide.show', [$guide->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Guide $guide
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy(Guide $guide)
    {
        $guide->delete();
        return redirect()->route('guide.index');
    }
}
