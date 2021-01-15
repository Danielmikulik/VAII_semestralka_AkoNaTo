<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\GuideStep;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GuideStepsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(Request $request)
    {
        $id = Guide::max('id');
        $i = 0;
        foreach ($request->addstep as $key => $value) {
            if (Arr::has($value, 'image_step')) {
                $value['image_step']->store('guide_steps', 'public');
                $guideStep = new GuideStep([
                    'step' => $value['step'],
                    'procedure' => $value['procedure'],
                    'image_path' => $value['image_step']->hashName(),
                    'guide_id' => $id,
                ]);
            } else {
                $guideStep = new GuideStep([
                    'step' => $value['step'],
                    'procedure' => $value['procedure'],
                    'guide_id' => $id,
                ]);
            }
            $guideStep->save();
            $i++;
        }
        return redirect()->route('guide.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
