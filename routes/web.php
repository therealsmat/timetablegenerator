<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::get('courses', 'CourseController@index')->name('courses');
    Route::get('courses/store', 'CourseController@store')->name('course.store');

    Route::get('departments', 'DepartmentsController@index')->name('departments');
    Route::post('departments/store', 'DepartmentsController@store')->name('department.store');
    Route::delete('departments/remove/{id}', 'DepartmentsController@remove')->name('department.remove');
    Route::get('time-table', 'TimeTableController@index')->name('timetable.index');

    Route::get('level', 'LevelsController@index')->name('level');

    Route::get('venues', 'VenuesController@index')->name('venues');
    Route::post('venues/store', 'VenuesController@store')->name('venue.store');

    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::post('settings/store', 'SettingsController@store')->name('settings.store');

    Route::get('generate', 'TimeTableController@generate');

});
