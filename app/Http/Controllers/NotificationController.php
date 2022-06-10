<?php

namespace App\Http\Controllers;


use App\Form;
use App\Hospital;
use App\Notification;
use Illuminate\Http\Request;
use App\AdminUserNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('dashboard');
    }

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

    public function getFormByHospital($hospital_id){
        $formsAllVisibility = Form::where(['visible_all_hospitals' => true])
        ->where('publish', true)
        ->get();

        $hospitalForms = Hospital::with('forms')
        ->find($hospital_id)
        ->forms
        ->filter(fn($form) => $form->publish)
        ->merge($formsAllVisibility);

        return $hospitalForms;

    }

    public function notificationHospital($hospital_id){
        $notifications = Notification::with('form')
                                    ->whereIn('form_id', $this->getFormByHospital($hospital_id)->pluck('id'))
                                    ->get();
        return response()->json($notifications);
    }
    public function notificationHospitalByDate($hospital_id){
        $notifications = Notification::with('form')
                                    ->whereIn('form_id', $this->getFormByHospital($hospital_id)->pluck('id'))
                                    ->select('*')
                                    ->selectRaw(DB::raw('CAST( created_at AS DATE) as date'))
                                    ->orderBy('date', 'desc')
                                    ->get();
        $notificationsByDate = $notifications->groupBy('date');
        return response()->json($notificationsByDate);
    }

    public function indexNotificationByPaginate($hospital_id){
        $notifications = Notification::with('form')
                                    ->whereIn('form_id', $this->getFormByHospital($hospital_id)->pluck('id'))
                                    ->paginate(15);
        return response()->json($notifications);
    }

    public function getNotificationNotReadUser($hospital_id){
        $userId =  $this->guard()->user()->id;
        $notifications = Notification::with('adminUsers')
                                            ->whereIn('form_id', $this->getFormByHospital($hospital_id)->pluck('id'))
                                            ->get();
                
        $notificationsNotRead = $notifications->filter(function ($notification) use ($userId) {
            return !$notification->adminUsers->first(function ($adminUser) use ($userId) {
                return $adminUser->pivot->read && $adminUser->id == $userId;
            });
        });

        return response()->json($notificationsNotRead);
                                           
    }

    public function setNotificationByHospital($hospital_id,Notification $notification){
        $userId =  $this->guard()->user()->id;
        $notificationNotReads = $this->getNotificationNotReadUser($hospital_id)->original;
         foreach($notificationNotReads as $notificationNotRead){
            $notificationNotRead->adminUsers()->attach([$userId => ['read' => true]]);
         }
        return response()->json(null,200);
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
