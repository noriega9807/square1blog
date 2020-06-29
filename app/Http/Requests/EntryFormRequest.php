<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntryFormRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'title' => 'required|unique:posts|max:255',
      'title' => array('Regex:/^[A-Za-z0-9 ]+$/'),
      'description' => 'required'
    ];
  }
}