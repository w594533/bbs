<?php

namespace App\Admin\Controllers;

use App\Models\Role;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Permission;

class RoleController extends Controller
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
            ->header('角色')
            ->description('用户角色')
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
            ->description('用户角色')
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
            ->description('角色')
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
            ->description('角色')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Role);
        $grid->filter(function($filter) {
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
        $grid->permissions('权限')->display(function ($permissions) {
            $permissions = array_map(function ($permission) {
                return "<span class='label label-success'>{$permission['name']}</span>";
            }, $permissions);
            return join('&nbsp;', $permissions);
        });
        $grid->created_at('创建时间');

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
        $show = new Show(Role::findOrFail($id));

        $show->id('Id');
        $show->name('名称');
        $show->display('标识');
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
        $form = new Form(new Role);
        $form->disableEditingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        $form->text('name', '名称');
        $form->multipleSelect('permissions', '权限')->options(Permission::all()->pluck('name', 'id'));
        $form->text('guard_name', '标识')->help('修改标识会影响代码的调用，请不要轻易更改。');

        return $form;
    }

    /**
    * 重写HasResourceActions 不允许删除
    **/
    public function destroy($id)
    {
        $data = [
            'status'  => false,
            'message' => '禁止删除',
        ];
        return response()->json($data);
    }
}
