<?php
/**
 * Created by PhpStorm.
 * User: hieunt
 * Date: 2/3/16
 * Time: 9:17 AM
 */
namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\Templates;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Templates::get();
        return view("template.index", compact("templates"));
    }

    public function add()
    {
        $roles = Tasks::getRoles();
        return view("template.add", compact("roles"));
    }

    public function edit($id)
    {
        $template = Templates::findOrFail($id);
        $roles = Tasks::getRoles();
        return view("template.add", compact("roles", "template"));
    }

    public function edit_post(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'roles' => 'required',
            'vars' => 'required'
        ]);
        $template = Templates::findOrFail($id);

        $template->name = $request->name;
        $template->roles = $request->roles;
        $template->vars = $request->vars;

        $template->save();

        return \Redirect::to(route("template_edit", ["id" => $id]))->with('success', "Profile updated success.");
    }

    public function add_post(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'roles' => 'required',
            'vars' => 'required',
        ]);


        $template = new Templates();
        $template->name = $request->name;
        $template->roles = $request->roles;
        $template->vars = $request->vars;
        $template->save();

        return \Redirect::to(route("template"))->with('success', "Profile updated success.");
    }

    public function vars($id)
    {
        $template = Templates::findOrFail($id);
        return $template->vars;
    }

}