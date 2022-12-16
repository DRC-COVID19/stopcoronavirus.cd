<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $forms = Form::with('formRecurrence')
      ->orderBy('title')
      ->get();
    return response()->json($forms, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store()
  {
    $result = Form::create($this->validator());
    return response()->json($result, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Form $form)
  {
    $form->load([
      'formRecurrence',
      'hospitals',
      'completedForms',
      'formSteps.formFields.formFieldType',
      'formFields.formFieldType',
    ]);
    return response()->json($form, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Form $form)
  {
    try {
      $result = $form->update($this->updateValidator());

      return response()->json($result, 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function updateFormVisibility($form_id)
  {
    try {
      $data = $this->updateValidator();
      DB::beginTransaction();
      $form = Form::find($form_id);
      $form->update($data);
      $form->hospitals()->sync($data['hospitals_id']);

      DB::commit();
      return response()->json($form, 200);
    } catch (\Throwable $th) {
      DB::rollback();
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Form $form)
  {
    $form->delete();
    return response()->json(null, 200);
  }

  public function validator()
  {
    return request()->validate([
      'title' => 'required|string|max:255',
      'publish' => 'nullable|boolean',
      'form_recurrence_value' => 'nullable|string|max:255',
      'form_recurrence_number' => 'nullable|integer',
      'form_recurrence_id' => 'required|integer|exists:form_recurrences,id',
      'conflict_resolution_mode_id' =>
        'required|integer|exists:conflict_resolution_modes,id',
    ]);
  }
  public function updateValidator()
  {
    return request()->validate([
      'title' => 'sometimes|string|max:255',
      'publish' => 'nullable|boolean',
      'visible_all_hospitals' => 'nullable|boolean',
      'form_recurrence_value' => 'nullable|string|max:255',
      'form_recurrence_number' => 'nullable|integer',
      'hospitals_id' => 'nullable|array',
      'form_recurrence_id' => 'sometimes|integer|exists:form_recurrences,id',
      'conflict_resolution_mode_id' =>
        'sometimes|integer|exists:conflict_resolution_modes,id',
    ]);
  }
  public function recentForm()
  {
    $forms = Form::with('formRecurrence')
      ->orderBy('created_at', 'DESC')
      ->limit(4)
      ->get();
    return response()->json($forms, 200);
  }
  public function getFormFiltered(Request $request)
  {
    try {
      $form_date = $request->input('form_date');
      $published_form = $request->input('published_form');
      $unpublished_form = $request->input('unpublished_form');
      $recurrence_form = $request->input('recurrence_form');
      $paginate = $request->input('paginate');

      $forms = Form::with('formRecurrence')
        ->withCount('completedForms')
        ->where(function ($query) use (
          $recurrence_form,
          $form_date,
          $published_form,
          $unpublished_form
        ) {
          if ($form_date) {
            $query->whereDate('created_at', $form_date);
          }
          if ($recurrence_form) {
            $query->where('form_recurrence_id', $recurrence_form);
          }
          if ($published_form == true) {
            $query->where('publish', true);
          }
          if ($unpublished_form == true) {
            $query->where('publish', false);
          }
        })
        ->paginate($paginate);
      return response()->json($forms, 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }
  public function filter(Request $request)
  {
    try {
      $key_words = $request->get('key_words');
      $forms = Form::with('formRecurrence')
        ->withCount('completedForms')
        ->where('title', 'LIKE', "%{$key_words}%")
        ->orWhere('title', 'LIKE', "%{$key_words}%")
        ->paginate(15);
      Log::info('forms', [$forms]);
      if (!$forms) {
        return response()->json(['message' => 'No form found'], 404);
      }
      return response()->json($forms, 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }
}
