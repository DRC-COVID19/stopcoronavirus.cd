<?php

namespace App\Admin\Forms\Category;

use App\Category;
use App\CategoryTranslation;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Encore\Admin\Widgets\StepForm;
use Illuminate\Support\Facades\DB;

class CategoryForm extends StepForm
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Info';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        try {
            DB::beginTransaction();
            if (isset($this->all()['Info. général']['id'])) {
                $dataCategory=$this->all()['Info. général'];
                Category::find($dataCategory['id'])->update($dataCategory);
                CategoryTranslation::find($this->all()['Français']['id'])->update($this->all()['Français']);
                CategoryTranslation::find($this->all()['Kikongo']['id'])->update($this->all()['Kikongo']);
                CategoryTranslation::find($this->all()['Lingala']['id'])->update($this->all()['Lingala']);
                CategoryTranslation::find($this->all()['Swahili']['id'])->update($this->all()['Swahili']);
                CategoryTranslation::find($this->all()['Tshiluba']['id'])->update($this->all()['Tshiluba']);
            } else {
                $category = Category::create($this->all()['Info. général']);
                $translate1 = CategoryTranslation::create(array_merge($this->all()['Français'], ['category_id' => $category->id]));
                $translate2 = CategoryTranslation::create(array_merge($this->all()['Kikongo'], ['category_id' => $category->id]));
                $translate3 = CategoryTranslation::create(array_merge($this->all()['Lingala'], ['category_id' => $category->id]));
                $translate4 = CategoryTranslation::create(array_merge($this->all()['Swahili'], ['category_id' => $category->id]));
                $translate5 = CategoryTranslation::create(array_merge($this->all()['Tshiluba'], ['category_id' => $category->id]));
            }
            Db::commit();
            $this->clear();
            admin_success('Processed successfully.');
            //return back();
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            DB::rollback();
            admin_error($th->getMessage());
            return back();
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->hidden('id');
        $this->text('icon', __('Icon'));
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return parent::data();
    }
}
