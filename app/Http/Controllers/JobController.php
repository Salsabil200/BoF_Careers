<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use App\Models\Job;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pageTitle = "Jobs List";
        return view('admin.jobs.index', compact('pageTitle'));
    }

    public function getJobs(Request $request)
    {
        $jobs = Job::query();

        return datatables()->of($jobs)
            ->addIndexColumn()
            ->addColumn('image', function ($job) {
                return $job->image ? '<img src="' . asset('storage/jobs/' . $job->image) . '" width="70">' : '-';
            })
            ->addColumn('actions', function ($job) {
                return '
                    <a href="' . route('admin.jobs.edit', $job->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . route('admin.jobs.destroy', $job->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field("DELETE") . '
                        <button class="btn btn-sm btn-danger" onclick="return confirm(\'Delete?\')">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['image','actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('image');
        $encryptedFilename = $file ? $file->hashName() : null;

        if ($file) $file->store('public/jobs');

        Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $encryptedFilename
        ]);

        Alert::success('Added Successfully','Job Added Successfully.');
        return redirect()->route('admin.jobs.index');
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Job';
        $job = Job::findOrFail($id);
        return view('admin.jobs.edit', compact('pageTitle','job'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $job = Job::findOrFail($id);
        $file = $request->file('image');

        if ($file) {
            if ($job->image && Storage::exists('public/jobs/'.$job->image)) {
                Storage::delete('public/jobs/'.$job->image);
            }
            $job->image = $file->hashName();
            $file->store('public/jobs');
        }

        $job->title = $request->title;
        $job->description = $request->description;
        $job->save();

        Alert::success('Updated Successfully','Job Updated Successfully.');
        return redirect()->route('admin.jobs.index');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);

        if ($job->image && Storage::exists('public/jobs/'.$job->image)) {
            Storage::delete('public/jobs/'.$job->image);
        }

        $job->delete();
        Alert::success('Deleted Successfully','Job Deleted Successfully.');
        return redirect()->route('admin.jobs.index');
    }

    public function apply($id)
    {
        $job = Job::findOrFail($id);
        return view('recruitments.apply', compact('job'));
    }
}
