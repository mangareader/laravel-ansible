<?php
/**
 * Created by PhpStorm.
 * User: hieunt
 * Date: 2/1/16
 * Time: 6:35 AM
 */
namespace App\Http\Controllers;


use App\Models\Inventories;
use Illuminate\Http\Request;

class InvenController extends Controller
{
    public function index()
    {
        $invens = Inventories::get();
        return view("inventories.index", compact("invens"));
    }

    public function add()
    {
        return view("inventories.add");
    }

    public function add_post(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'noidung' => 'required'
        ]);

        $inv = new Inventories();
        $inv->name = $request->name;
        $inv->content = $request->noidung;
        $inv->save();

        return \Redirect::to(route("inventories"))->with('success', "Profile updated success.");
    }

    public function edit($id)
    {
        $inv = Inventories::findorFail($id);
        return view("inventories.add", compact("inv"));
    }

    public function edit_post(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'noidung' => 'required'
        ]);

        $inv = Inventories::findorFail($id);
        $inv->name = $request->name;
        $inv->content = $request->noidung;
        $inv->save();

        return \Redirect::to(route("inventories"))->with('success', "Profile updated success.");
    }
}