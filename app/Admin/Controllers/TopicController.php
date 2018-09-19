<?php

namespace App\Admin\Controllers;

use App\Models\Topic;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Category;
use App\Models\User;

class TopicController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('列表')
            ->description('话题')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('详情')
            ->description('话题')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Topic);
        $grid->filter(function($filter) {
          $filter->disableIdFilter();
          $filter->like('title', '标题');
          $filter->equal('category_id', '分类')->select(Category::all()->pluck('name', 'id')->toArray());
          $filter->between('created_at', '创建时间')->datetime();
        });
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        $grid->id('Id');
        $grid->title('标题')->limit(30);

        $grid->view_count('点击量');
        $grid->reply_count('回复量');
        $grid->user()->name('用户');
        $grid->category()->name('分类');
        $grid->created_at('创建时间');
        // $grid->updated_at('更新时间');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Topic::findOrFail($id));
        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
        });
        $show->id('Id');
        $show->title('标题');
        $show->body('内容');
        $show->slug('友好url');
        $show->excert('摘要');
        $show->view_count('点击量');
        $show->reply_count('回复量');
        $show->user()->name('用户');
        $show->category()->name('分类');
        $show->created_at('创建时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Topic);

        $form->text('title', 'Title');
        $form->textarea('body', 'Body');
        $form->text('slug', 'Slug');
        $form->textarea('excert', 'Excert');
        $form->number('view_count', 'View count');
        $form->number('reply_count', 'Reply count');
        $form->number('user_id', 'User id');
        $form->number('category_id', 'Category id');

        return $form;
    }
}
