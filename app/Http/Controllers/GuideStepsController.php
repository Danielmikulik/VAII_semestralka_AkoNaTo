<?php

namespace App\Http\Controllers;

use App\Models\GuideStep;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->addmore as $key => $value) {

            $value->validate([
                'step' => 'required',
                'procedure' => 'required'
            ]);

            if ($value->hasFile('image')) {
                $value->validate([
                    'image' => 'mimes:jpeg,jpg,png|max:5000'
                ]);

                $value->file('image')->store('guide steps', 'public');

                $guideStep = new GuideStep([
                    'step' => $value->get('step'),
                    'procedure' => $value->get('procedure'),
                    'image_path' => $value->file('image')->hashName(),
                    //'user_id' => Auth::id(),
                ]);
            } else {
                $guideStep = new GuideStep([
                    'step' => $value->get('step'),
                    'procedure' => $value->get('procedure'),
                    //'guide_id' => Auth::id(),
                ]);
            }
            GuideStep::create($value);
            $guideStep->save();
        }
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
