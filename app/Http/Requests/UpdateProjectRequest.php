<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use \Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;

class UpdateProjectRequest extends FormRequest
{
    protected $errorBag = 'update';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>[
                'required',
                Rule::unique('projects')->ignore($this->route('project'))->where(function($query){
                    return $query->where('user_id',request()->user()->id);
                })
            ],
            'thumbnail'=>'image|dimensions:min_width=260,min_height=100|max:2048'
        ];
    }

    public function messages()
    {
        return[
            'name.required'=>'项目名称是必填的',
            'name.unique'=>'项目名称必须是唯一的，不能有重复项目哦~',
            'thumbnail.image'=>'请上传一个图片文件',
            'thumbnail.dimensions'=>'图片最小尺寸260x100'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->errorBag = 'update-'.$this->route('project');
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }
}
