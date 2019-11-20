<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Form;


class AjaxController extends Controller
{
    public function status(Request $request)
    {
        if($request->ajax()){

            $model = "App\\" . $request->input('model');

            $field = $request->input('field');

            $item = $model::find($request->input('id'));

            $item->$field = 1 - $item->$field;
            $item->save();

            $response = [
                "id" => $item->id,
                "status" => $item->$field
                ];
            return json_encode($response);
        }

        return redirect()->route('admin.dashboard');
    }

}