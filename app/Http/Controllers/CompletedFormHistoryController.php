<?php

namespace App\Http\Controllers;

use App\CompletedFormHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompletedFormHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $completedFormHistories = CompletedFormHistory::with(['form', 'adminUser','hospital'])->get();
        return response()->json($completedFormHistories, 200);
    }

    public function getCompletedFormHistoryByConflict(Request $request){
        $formId         = $request->query('form_id');
        $dateConflict   = $request->query('date_conflict');

        $perPage = $request->query('per_page') ?? 15;
        $sortBy = $request->query('sort_by') ?? 'last_update';
        $sortDirection = $request->query('sort_desc') ? 'desc' : 'asc';

        $query = CompletedFormHistory::with(['form', 'adminUser','hospital','completedFormFieldHistories'])->where('conflict', 1);

        if($formId){
            $query->where('form_id', $formId);
        }
        if($dateConflict){
            $query = $query->where('last_update', $dateConflict);
        }
        if($sortBy ==='form'){
            $query->join('forms', 'form_id', '=', 'forms.id')
                ->select('completed_forms.*', 'forms.title as form_title')
                ->orderBy('form_title', $sortDirection);
        }
        else{
            $query->orderBy($sortBy, $sortDirection);
        }

        $completedFormHistories = $query->paginate($perPage);

        return response()->json($completedFormHistories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $result = CompletedFormHistory::create($this->validator());
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
        $completedFormHistory = CompletedFormHistory::with(['form', 'adminUser','hospital'])->find($id);
        return response()->json($completedFormHistory, 200);
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
        $result = CompletedFormHistory::find($id)->update($this->updateValidator());
        return response()->json( $result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = CompletedFormHistory::destroy($id);
        return response()->json( $result, 200);
    }

    public function validator(){
        return request()->validate([
            'reference'                    => 'required|string|max:255',
            'synchronized'                 => 'nullable|boolean',
            'form_id'                      => 'required|integer|exists:forms,id',
            'admin_user_id'                => 'required|integer|exists:admin_users,id',
            'hospital_id'                  => 'required|integer|exists:hospitals,id',
            'created_manager_name'         => 'required|string|max:255',
            'created_manager_first_name'   => 'required|string|max:255',
            'last_update'                  => 'required|date',
            'conflict'                     => 'nullable|boolean'
        ]);
    }
    public function updateValidator(){
        return request()->validate([
            'reference'                    => 'sometimes|string|max:255',
            'synchronized'                 => 'nullable|boolean',
            'form_id'                      => 'sometimes|integer|exists:forms,id',
            'admin_user_id'                => 'sometimes|integer|exists:admin_users,id',
            'hospital_id'                  => 'sometimes|integer|exists:hospitals,id',
            'created_manager_name'         => 'sometimes|string|max:255',
            'created_manager_first_name'   => 'sometimes|string|max:255',
            'last_update'                  => 'sometimes|date',
            'conflict'                     => 'nullable|boolean'

        ]);
    }
}
