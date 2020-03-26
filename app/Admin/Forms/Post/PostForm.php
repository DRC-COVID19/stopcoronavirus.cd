<?php

namespace App\Admin\Forms\Post;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Post;
use App\PostTranslation;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\StepForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostForm extends StepForm
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '';

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
            if (isset($this->all()['Info général']['id'])) {
                $dataPost = $this->all()['Info général'];
                $file = request()->file('image_path');
                if ($file && $file->isValid()) {
                    $dataPost['image_path'] = $this->upload('image_path');
                }
                Post::find($dataPost['id'])->update($dataPost);
                Post::find($this->all()['Français']['id'])->update($this->all()['Français']);
                Post::find($this->all()['Kikongo']['id'])->update($this->all()['Kikongo']);
                Post::find($this->all()['Lingala']['id'])->update($this->all()['Lingala']);
                Post::find($this->all()['Swahili']['id'])->update($this->all()['Swahili']);
                Post::find($this->all()['Tshiluba']['id'])->update($this->all()['Tshiluba']);
            } else {
                $dataPost = $this->all()['Info général'];
                $dataPost['image_path'] = $this->upload('image_path');
                $post = Post::create($dataPost);
                PostTranslation::create(array_merge($this->all()['Français'], ['post_id' => $post->id]));
                PostTranslation::create(array_merge($this->all()['Kikongo'], ['post_id' => $post->id]));
                PostTranslation::create(array_merge($this->all()['Lingala'], ['post_id' => $post->id]));
                PostTranslation::create(array_merge($this->all()['Swahili'], ['post_id' => $post->id]));
                PostTranslation::create(array_merge($this->all()['Tshiluba'], ['post_id' => $post->id]));
            }
            Db::commit();
            $this->clear();
            admin_success('Processed successfully.');
            return redirect()->route('posts.index');
        } catch (\Throwable $th) {
            DB::rollback();
            admin_error($th->getMessage());
            return back();
        }
    }

    private function upload($value)
    {
        $file = request()->file($value);
        if ($file && $file->isValid()) {
            $path = $file->store("/posts", ['disk' => 'public']);
            return $path;
        }
        return null;
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->hidden('id');
        $this->image('image_path', __("Illustration image"));
        $this->select('category_id', __('Category'))->options(function () {
            $collection = CategoryResource::collection(Category::get())->toArray(request());
            $array = [];
            foreach ($collection as $value) {
                $array[$value['id']] = $value['name'];
            }
            return $array;
        })->required()->rules('required');
        $this->number('order', __('Order'));
        $this->number('width', __('Width'))->default(4)->rules(['max:12|min:1|required']);
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
