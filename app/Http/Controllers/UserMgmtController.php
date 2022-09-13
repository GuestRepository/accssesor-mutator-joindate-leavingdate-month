<?php

namespace App\Http\Controllers;

use App\Models\UserMgmt;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use DateTime;

class UserMgmtController extends Controller
{
    public function index(){
        return view('user-mgmnt-system.dashboard');
    }


    public function fetchAllUserManagementSystem() {
		// $userManagment = UserMgmt::all();
		$userManagment = UserMgmt::orderBy('id', 'DESC')->get();
		$output = '';
		if ($userManagment->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle " id="dataTable">
            <thead>
              <tr>
                <th>Avatar</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Exprience</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($userManagment as $userSystem) {
				$output .= '<tr>
                <td><img src="storage/images/' . $userSystem->avatar . '" width="50" class="img-thumbnail rounded-circle"></td>
                <td>' . $userSystem->name .  '</td>
                <td>' . $userSystem->email . '</td>
                <td>' . $userSystem->ToatalExp . '</td>
                <td>

                  <a href="#" style="text-decoration:none;" id="' . $userSystem->id . '" class="text-danger mx-1 deleteIcon"><i class="fa fa-trash"></i> Remove</a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}


    // handle insert a new UserMgmt ajax request
	public function store(Request $request) {
		$file = $request->file('avatar');
		$fileName = time() . '.' . $file->getClientOriginalExtension();
		$file->storeAs('public/images', $fileName);
    Log::info('still working value'.$request->still_working_status);
		$userData = [
		'name' => $request->name,
		'email' => $request->email, 
		'date_of_joining' => $request->date_of_joining, 
		'date_of_leaving' => $request->date_of_leaving, 
		'still_working_status' => $request->still_working_status, 
		'avatar' => $fileName];
		UserMgmt::create($userData);
		return response()->json([
			'status' => 200,
		]);
	}


    public function delete(Request $request) {
		$id = $request->id;
		$userSystem = UserMgmt::find($id);
		if (Storage::delete('public/images/' . $userSystem->avatar)) {
			UserMgmt::destroy($id);
		}
	}
}
