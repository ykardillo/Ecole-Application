<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\EncodageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/homes', 'HomeController@index')->name('home');


Auth::routes();

Route::group(['middleware' => ['auth', 'teacher']], function () {

    Route::get('/home', function () {
        return view('admin.home');
    });

    Route::get('/presences', 'PresencesController@index');
    Route::get('/presences/calendar', 'PresencesController@indexCalendar');
    Route::get('/presences/calendar/showStudents/{date_start}/{date_end}', 'PresencesController@getStudentsOfClass');
    Route::put('/presences/calendar/add/{classe_id}/{date_start}/{date_end}', 'PresencesController@store');
    Route::delete('/presences/delete/{date}/{classe_id}', 'PresencesController@destroy');
    Route::get('/presences/info/{classe_id}/{date_start}/{date_end}', 'PresencesController@show');
    Route::get('/presences/edit/{classe_id}/{date_start}/{date_end}', 'PresencesController@edit');
    Route::put('/presences/update/{classe_id}/{date_start}/{date_end}', 'PresencesController@update');

    Route::get('interrogations', 'EncodageController@index');
    Route::get('/interrogation/{id}', 'EncodageController@show');
    Route::put('/interrogation/add', 'EncodageController@store');
    Route::put('/interrogation/update/{id}', 'InterrogationController@update');
    Route::delete('/interrogation/delete/{classe_id}/{interro_id}', 'InterrogationController@destroy');


    Route::get('notes/{id}', 'EncodageController@showNotes');
    Route::put('/note/update/{idInterro}', 'EncodageController@updateInterros');

    
    Route::get('matieres/coefficient/{id}','MatiereController@getCoeff');
});

Route::group(['middleware' => ['auth', 'admin']], function () {


    Route::get('/users', 'UserController@index');
    Route::put('/users/add', 'UserController@store');
    Route::put('/users/edit/{id}', 'UserController@edit');
    Route::delete('/users/delete/{id}', 'UserController@destroy');

    Route::get('/students/info/{info}', 'StudentController@showStudent');
    Route::put('/students/update/{id}', 'StudentController@update');
    Route::get('/students/edit/{id}', 'StudentController@edit');
    Route::get('/students/subscribe_eID', 'StudentController@subscribeStudenteID');
    Route::get('/students/subscribe', 'StudentController@subscribeStudent');
    Route::get('/students', 'StudentController@index');
    Route::put('/students/add', 'StudentController@store');
    Route::put('/students/add/eid', 'StudentController@storeEid');
    Route::delete('/students/delete/{id}', 'StudentController@destroy');
    Route::put('/students/payer/{id}', 'StudentController@payer');


    Route::get('/teachers', 'TeacherController@index');
    Route::delete('/teachers/delete/{id}', 'TeacherController@destroy');
    Route::put('/teachers/update/{id}', 'TeacherController@update');
    Route::put('/teachers/add', 'TeacherController@store');


    Route::get('/classes', 'ClassesController@index');
    Route::get('/classes/info/{id}', 'ClassesController@show');
    Route::put('/classes/update/{id}', 'ClassesController@update');
    Route::delete('/classes/delete/{id}', 'ClassesController@destroy');
    Route::put('/classes/add', 'ClassesController@store');

    Route::get('/attributions', 'AttributionsController@index');
    Route::put('/attributions/teacher_to_class/', 'AttributionsController@attributeProfToClasse');
    Route::put('/attributions/students_to_class/', 'AttributionsController@attributeStudToClasse');
    Route::put('/attributions/classes_to_group/', 'AttributionsController@attributeClassToGroup');
    Route::delete('/attributions/teacher_to_class/delete/{classe_id}/{teacher_id}/', 'AttributionsController@destroyProfToClasse');
    Route::put('/attributions/student_to_class/delete/{student_id}/', 'AttributionsController@destroyStudToClasse');
    Route::put('/attributions/classes_to_group/delete/{classe_id}/', 'AttributionsController@destroyClassToGroup');
    
    Route::get('/paiement', 'StudentController@paiement');
    Route::get('/paiement/export', 'StudentController@export');


    Route::get('/import_export', 'ImportExportController@index');
    Route::get('/import_teachers/export', 'ImportProfController@export');
    Route::post('/import_teachers/import', 'ImportProfController@import');
    Route::get('/import_students/export', 'ImportEleveController@export');
    Route::post('/import_students/import', 'ImportEleveController@import');


    Route::get('/gestion_horaires', 'CalendarController@index');
    Route::get('/horaire/{idGroup}', 'CalendarController@horaire');

    // Cours
    Route::delete('/cours/delete/{id}', 'CoursController@destroy');
    Route::put('/cours/add', 'CoursController@store');
    Route::put('/cours/update/{id}', 'CoursController@update');

    Route::delete('/groupes/delete/{id}', 'GroupeController@destroy');
    Route::put('/groupes/update/{id}', 'GroupeController@update');
    Route::put('/groupes/add', 'GroupeController@store');

    Route::get('bulletin/{id}','BulletinController@index');
    Route::get('bulletin/generate/class/{id}','BulletinController@generateBulletinOfAClass');

    
    Route::put('notes/addStudentToInterrogation/','EncodageController@addStudentToInterrogation');
    Route::get('/matieres', 'MatiereController@index');
    Route::delete('/matieres/delete/{id}', 'MatiereController@destroy');
    Route::put('/matieres/update/{id}', 'MatiereController@update');
    Route::put('/matieres/add', 'MatiereController@store');

});
