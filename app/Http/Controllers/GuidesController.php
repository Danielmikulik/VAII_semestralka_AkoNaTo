<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $guides = Guide::paginate(5);

        return view('guide.index', [
            'guides' => $guides
        ]);
    }

    /**
     * Display a listing of the resource by user_id.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showAuthorsGuides(int $id)
    {
        $guides = Guide::query()->where('user_id', '=', $id)->paginate(5);

        return view('guide.index', [
            'guides' => $guides,
            'author_id' => $id
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
            'title' => 'required|max:255',
            'description' => 'required'
        ]);

        $request->validate([
            'addstep.*.step' => 'required|max:255',
            'addstep.*.procedure' => 'required',
            'addstep.*.image_step' => 'mimes:jpeg,jpg,png|max:5000'
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

        if ($request->has('addstep')) {
            $id = Guide::max('id');
            (new GuideStepsController)->store($request, $id);
        }

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
        $steps = $this->getMySteps($guide->id);
        $author = User::query()->find($guide->user_id);
        $authorName = empty($author) ? '' : $author->name;

        return view('guide.detail', [
            'guide' => $guide,
            'steps' => $steps,
            'author_id' => $guide->user_id,
            'author_name' => $authorName,
            'user_role' => Auth::user()->role
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
        $steps = $this->getMySteps($guide->id);

        return view('guide.edit', [
            'action' => route('guide.update', $guide->id),
            'method' => 'put',
            'model' => $guide,
            'steps' => $steps
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
            'title' => 'required',
            'description' => 'required'
        ]);

        $request->validate([
            'addstep.*.step' => 'required|max:255',
            'addstep.*.procedure' => 'required',
            'addstep.*.image_step' => 'mimes:jpeg,jpg,png|max:5000'
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png|max:5000'
            ]);

            $request->file('image')->store('guides', 'public');
            Guide::query()->find($guide->id)->update(array('image_path' => $request->file('image')->hashName()));
        }
        $guide->update($request->all());

        if ($request->has('addstep')) {
            (new GuideStepsController)->update($request, $guide->id);
        }

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

    private function getMySteps(int $id)
    {
        $steps = DB::table('guide_steps')
            ->select('*')
            ->where('guide_id', '=', $id)
            ->orderBy('order', 'asc')
            ->get();
        return $steps;
    }
}
