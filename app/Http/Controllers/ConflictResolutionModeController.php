<?php

namespace App\Http\Controllers;

use App\ConflictResolutionMode;
use Illuminate\Http\Request;

class ConflictResolutionModeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conflictResolutionModes = ConflictResolutionMode::all();
        return response()->json($conflictResolutionModes,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = ConflictResolutionMode::create($this->validator());
        return response()->json( $result, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conflictResolutionMode = ConflictResolutionMode::find($id);
        return response()->json($conflictResolutionMode, 200);
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
        $result = ConflictResolutionMode::find($id)->update($this->updateValidator());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ConflictResolutionMode::find($id)->delete();
    }

    private function validator()
    {
        return request()->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);
    }

    private function updateValidator()
    {
        return request()->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);
    }
}
