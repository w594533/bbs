<?php

namespace App\Admin\Controllers;

use App\Models\Permission;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Role;

class PermissionController extends Controller
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
            ->header('编辑')
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
            ->header('创建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Permission);

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('name', '名称');
            $filter->like('guard_name', '标识');
        });
        $grid->disableExport();

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        $grid->id('Id');
        $grid->name('名称');
        $grid->guard_name('标识');
        $grid->roles('角色')->display(function ($roles) {
            $roles = array_map(function ($role) {
                return "<span class='label label-success'>{$role['name']}</span>";
            }, $roles);
            return join('&nbsp;', $roles);
        });
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
        $show = new Show(Permission::findOrFail($id));

        $show->id('Id');
        $show->name('名称');
        $show->guard_name('标识');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Permission);
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            // 去掉返回按钮
            $tools->disableBackButton();
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->text('name', '名称');
        $form->multipleSelect('roles', '角色')->options(Role::all()->pluck('name', 'id'));
        $form->display('guard_name', '标识')->help('修改权限标识会影响代码的调用，请不要轻易更改。');

        return $form;
    }

    public function destroy($id)
    {
        $data = [
            'status'  => false,
            'message' => '禁止删除',
        ];
        return response()->json($data);
    }
}
