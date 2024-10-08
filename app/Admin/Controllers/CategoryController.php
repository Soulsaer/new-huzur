<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use \App\Models\Category;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Category';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->column('id', __('Id'));
        $grid->column('parentCategory.name', __('Parent Category'));
        $grid->column('image', __('Image'))->image('', 100, 100);
        $grid->column('name', __('Name'));
        $grid->column('status', __('Status'))->icon([
            0 => 'toggle-off',
            1 => 'toggle-on',
        ], $default = '');

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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('parent_category', __('Parent category'));
        $show->field('name', __('Name'));
        $show->field('title', __('Title'));
        $show->field('url', __('Url'));
        $show->field('meta_title', __('Meta title'));
        $show->field('meta_description', __('Meta description'));
        $show->field('other_meta', __('Other meta'));
        $show->field('meta_keyword', __('Meta keyword'));
        $show->field('description', __('Description'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        $categories = Category::whereNull('parent_category')->get()->pluck('name', 'id');

        $form->select('parent_category', __('Parent Category'))->options($categories);
        $form->text('name', __('Name'));
        $form->text('title', __('Title'));
        $form->url('url', __('Url'));
        $form->textarea('meta_title', __('Meta title'));
        $form->textarea('meta_description', __('Meta description'));
        $form->textarea('other_meta', __('Other meta'));
        $form->textarea('meta_keyword', __('Meta keyword'));
        $form->ckeditor('description', __('Description'));
        $form->switch('status', __('Status'));

        $form->hasMany('faqs', function (Form\NestedForm $form) {
            $form->text('question', __('Question'));
            $form->ckeditor('answer', __('Answer'));
        });

        return $form;
    }
}
