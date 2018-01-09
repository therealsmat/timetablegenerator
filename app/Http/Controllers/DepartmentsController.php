<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function index(Department $department)
    {
        $title = 'All departments';
        $departments = $department->all();
        return view('departments', compact('title', 'departments'));
    }

    public function store(Department $department, Request $request)
    {
        try{
            $department->create($request->all());
            return redirect()->back()->with('success', 'Department created successfully');
        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function remove($id, Department $department)
    {
        try{
            $department->findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Record has been deleted');
        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
