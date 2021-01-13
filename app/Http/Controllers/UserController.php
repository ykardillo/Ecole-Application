<?php

namespace App\Http\Controllers;

use App\User;
use App\Model\Teacher;
use Illuminate\Http\Request;

class UserController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users-list')->with('users', $users);
    }



    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $nom = "a";

        if (!User::emailExist($user->email, $request->input('email'))) {
            return redirect('/users')->with('statusBad', 'La nouvelle adresse mail existe déjà.');
        } else {
            $user->name = ucfirst($request->input('nom'));
            $user->firstname = ucfirst($request->input('prenom'));
            $user->email = $request->input('email');

            $checkTeacher = Teacher::getTeacherIfExisteWithUserId($id);

            switch ($request->input('type')) {
                case "pasDeType":
                    $user->usertype = null;
                    if (!empty($checkTeacher)) {
                        $teacher = Teacher::findOrFail($checkTeacher->id);
                        $teacher->delete();
                    }
                    break;
                case "admin":
                    $user->usertype = $request->input('type');
                    if (!empty($checkTeacher)) {
                        $teacher = Teacher::findOrFail($checkTeacher->id);
                        $teacher->delete();
                    }
                    break;
                case "teacher":
                    $user->usertype = $request->input('type');

                    if (!empty($checkTeacher)) {
                        $teacher = Teacher::findOrFail($checkTeacher->id);

                        $teacher->nom = ucfirst($request->input('nom'));
                        $teacher->prenom = ucfirst($request->input('prenom'));
                        $teacher->user_id = $id;

                        $teacher->update();
                    } else {
                        $teacher = new Teacher;

                        $teacher->nom = ucfirst($request->input('nom'));
                        $teacher->prenom = ucfirst($request->input('prenom'));
                        $teacher->user_id = $id;

                        $teacher->save();
                    }
                    break;

                default:
                    # code...
                    break;
            }

            $user->update();

            return redirect('/users')->with('statusGood', "L'utilisateur a bien été modifié.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users')->with('statusGood', 'L\'utilisateur a bien été supprimé.');
    }
}
