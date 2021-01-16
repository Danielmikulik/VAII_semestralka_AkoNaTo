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
    public function store(Request $request, int $guideId)
    {
        //$id = Guide::max('id');
        $i = 0;
        foreach ($request->addstep as $key => $value) {
            if (!Arr::has($value, 'id')) {
                if (Arr::has($value, 'image_step')) {
                    $value['image_step']->store('guide_steps', 'public');
                    $guideStep = new GuideStep([
                        'step' => $value['step'],
                        'procedure' => $value['procedure'],
                        'image_path' => $value['image_step']->hashName(),
                        'guide_id' => $guideId,
                        'order' => $i
                    ]);
                } else {
                    $guideStep = new GuideStep([
                        'step' => $value['step'],
                        'procedure' => $value['procedure'],
                        'guide_id' => $guideId,
                        'order' => $i
                    ]);
                }
                $guideStep->save();
            }
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
     * @param \Illuminate\Http\Request $request
     * @param int $guideId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, int $guideId)
    {
        $stepIDs = GuideStep::query()->where('guide_id', '=', $guideId)->pluck('id')->toArray();
        foreach ($stepIDs as $id) {
            $exists = false;
            foreach ($request->addstep as $key => $value) {
                if (Arr::has($value, 'id') && $value['id'] == $id) {
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $this->destroy($id);
            }
        }
        $i = 0;
        foreach ($request->addstep as $key => $value) {

            if (Arr::has($value, 'id')) {
                if (Arr::has($value, 'image_step')) {
                    $value['image_step']->store('guide_steps', 'public');
                    GuideStep::query()->find($value['id'])->update(array('image_path' => $value['image_step']->hashName()));
                }

                GuideStep::query()->find($value['id'])->update(array(
                    'step' => $value['step'],
                    'procedure' => $value['procedure'],
                    'guide_id' => $guideId,
                    'order' => $i));
                $i++;
            } else {
                $this->store($request, $guideId);
            }
        }
        return redirect()->route('guide.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        GuideStep::destroy($id);
    }
}
