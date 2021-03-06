<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller {

	public function __construct() {
		$this->middleware(['auth']);  //specific permission permission to access these resources
		$this->middleware('onlyOneUser');
		$this->middleware(['role:root']);
	}

	public function index() {
		$permissions = Permission::all(); //Get all permissions
		return view('permissions.index')->with('permissions', $permissions);
	}

	public function create() {
		$roles = Role::get(); //Get all roles
		return view('permissions.create')->with('roles', $roles);
	}

	public function store(Request $request) {
		$rules = array('name' => 'required|max:40|unique:permissions',);
		$v = Validator::make($request->all(), $rules);
		if ($v->fails()) {
			return redirect()->route('permissions.create')->with('error', 'PermissionName : '. $request->name.' Duplicate!');
		}

		$name = $request['name'];
		$permission = new Permission();
		$permission->name = $name;
		$roles = $request['roles'];
		$permission->save();

		if (!empty($request['roles'])) { //If one or more role is selected
			foreach ($roles as $role) {
				$r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record
				$permission = Permission::where('name', '=', $name)->first(); //Match input //permission to db record
				$r->givePermissionTo($permission);
			}
		}

		return redirect()->route('permissions.index')->with('success', 'PermissionName : '. $permission->name.' created successfully!');
	}

	public function show($id) {
		return redirect('permissions');
	}

	public function edit($id) {
		$permission = Permission::findOrFail($id);
		return view('permissions.edit', compact('permission'));
	}

	public function update(Request $request, $id) {
		$permission = Permission::findOrFail($id);
		$this->validate($request, [
			'name'=>'required|max:40',
		]);
		$input = $request->all();
		$permission->fill($input)->save();

		return redirect()->route('permissions.index')->with('success', 'PermissionName : '. $request->name.' edit successfully!');
	}

	public function destroy($id) {
		$permission = Permission::findOrFail($id);
		// dd($permission);
		// //Make it impossible to delete this specific permission
		// if ($permission->name == "Administer roles & permissions") {
		//	return redirect()->route('permissions.index')
		//  	->with('flash_message',
		//		'Cannot delete this Permission!');
		//}
		$permission->delete();
		return redirect()->route('permissions.index')->with('success', 'Permission deleted!');
	}
}
