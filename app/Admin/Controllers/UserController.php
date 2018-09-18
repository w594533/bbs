<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Role;

class UserController extends Controller
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
            ->description('用户')
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
            ->description('用户')
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
            ->description('用户')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    // public function create(Content $content)
    // {
    //     return $content
    //         ->header('Create')
    //         ->description('description')
    //         ->body($this->form());
    // }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $grid->filter(function($filter) {
          $filter->disableIdFilter();
          $filter->like('name', '姓名');
          $filter->equal('email', '邮箱');
          $filter->equal('phone', '手机号');
          $filter->between('created_at', '注册时间')->datetime();
        });
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        $grid->id('Id');
        $grid->name('姓名');
        $grid->phone('手机号');
        $grid->email('邮箱');
        $grid->avatar('头像')->display(function ($avatar) {
            return $this->avatar_url;
        })->image(30, 30);
        $grid->roles('角色')->display(function ($roles) {
            $roles = array_map(function ($role) {
                return "<span class='label label-success'>{$role['name']}</span>";
            }, $roles);
            return join('&nbsp;', $roles);
        });
        $grid->created_at('注册时间');

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
        $show = new Show(User::findOrFail($id));
        $show->panel()->tools(function ($tools) {
            $tools->disableDelete();
        });
        $show->id('Id');
        $show->name('姓名');
        $show->phone('手机号');
        $show->email('邮箱');
        $show->avatar('头像')->as(function ($avatar) {
            return "<img src='{$this->avatar_url}' width='100'/>";
        })->setEscape(false);
        $show->roles('角色')->as(function ($roles) {
            $roles = array_map(function ($role) {
                return "<span class='label label-success'>{$role['name']}</span>";
            }, $roles->toArray());
            return join('&nbsp;', $roles);
        });
        $show->weixin_openid('微信 openid');
        $show->weixin_unionid('微信 unionid');
        $show->introduce('简介');
        $show->created_at('注册时间');
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            //去掉删除
            $tools->disableDelete();
        });
        $form->tab('个人资料', function($form) {
          $form->display('name', '姓名');
          $form->display('phone','手机号');
          $form->display('email', '邮箱');
          //更复杂的显示
          $form->display('avatar', '头像')->with(function ($avatar) {
              return "<img src='{$this->avatar_url}' width='100'/>";
          });
          $form->display('weixin_openid', '微信 openid');
          $form->display('weixin_unionid', '微信 unionid');
          $form->display('introduce', '简介');
          $form->display('created_at', '注册时间');
        })->tab('角色', function($form) {
          $form->multipleSelect('roles', '角色')->options(Role::all()->pluck('name', 'id'));
        });
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
