<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::with('form')->get();
        return response()->json($notifications, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $result = Notification::create($this->validator());
      return response()->json($result, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        return response()->json($notification, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Notification $notification)
    {
        $result = $notification->update($this->updateValidator());
        return response()->json( $result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(null, 200);
    }

    public function validator(){
        return request()->validate([
            'form_id'               => 'required|integer|exists:forms,id',
            'title'                 => 'required|string|max:255',
            'message'               => 'required|string'
        ]);
    }

    public function updateValidator(){
        return request()->validate([
            'form_id'               => 'sometimes|integer|exists:forms,id',
            'title'                 => 'sometimes|string|max:255',
            'message'               => 'sometimes|string'
        ]);
    }
}
