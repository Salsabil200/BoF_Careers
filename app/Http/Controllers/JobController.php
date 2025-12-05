<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Job;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // INDEX
    public function index()
    {
        $pageTitle = 'Jobs';
        confirmDelete();
        return view('admin.jobs.index', compact('pageTitle'));
    }

    // DATATABLE DATA
    public function getJobs(Request $request)
    {
        $jobs = Job::query();

        return datatables()->of($jobs)
            ->addIndexColumn()
            ->addColumn('image', function ($job) {
                return $job->image
                    ? '<img src="' . asset('storage/jobs/' . $job->image) . '" width="70">'
                    : '-';
            })
            ->addColumn('action', function ($job) {
                return '
                    <a href="' . route('admin.jobs.edit', $job->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . route('admin.jobs.destroy', $job->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field("DELETE") . '
                        <button class="btn btn-sm btn-danger" onclick="return confirm(\'Delete?\')">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    // STORE JOB
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'description' => 'required'
        ]);

        $job = new Job();
        $job->title = $request->title;
        $job->description = $request->description;

        // IMAGE
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/jobs', $filename);
            $job->image = $filename;
        }

        $job->save();

        Alert::success('Success', 'Job Created Successfully!');
        return redirect()->back();
    }

    // EDIT PAGE
    public function edit($id)
    {
        $pageTitle = 'Edit Job';
        $job = Job::findOrFail($id);

        return view('admin.jobs.edit', compact('pageTitle', 'job'));
    }

    // UPDATE JOB
    public function update(Request $request, Job $job, $id)
    {
        $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $job = Job::findOrFail($id);

        $job->title = $request->title;
        $job->description = $request->description;

        // UPDATE IMAGE
        if ($request->hasFile('image')) {

            if ($job->image && Storage::exists('public/jobs/' . $job->image)) {
                Storage::delete('public/jobs/' . $job->image);
            }

            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/jobs', $filename);
            $job->image = $filename;
        }

        $job->save();

        Alert::success('Success', 'Job Updated Successfully!');
        return redirect()->back();
    }

    // DELETE JOB
    public function destroy($id)
    {
        $job = Job::findOrFail($id);

        if ($job->image && Storage::exists('public/jobs/' . $job->image)) {
            Storage::delete('public/jobs/' . $job->image);
        }

        $job->delete();

        Alert::success('Deleted', 'Job Deleted Successfully!');
        return redirect()->route('admin.jobs.index');
    }

    public function apply($id)
    {
        $job = Job::findOrFail($id);
        return view('recruitments.apply', compact('job'));
    }
}
