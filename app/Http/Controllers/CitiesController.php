<?php


namespace App\Http\Controllers;

use App\Models\Cities;

use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function returnName($id) {
        $name = Cities::where('id', $id)->get();

        return $name;
    }
}
