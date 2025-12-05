<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recruitment;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\RecruitmentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RecruitmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar recruitment (untuk admin).
     */
    // public function index()
    // {
    //     $pageTitle = 'Recruitments';
    //     $recruitments = Recruitment::with('job')->latest()->get();

    //     return view('admin.recruitments.index', compact('pageTitle', 'recruitments'));
    // }
    public function index()
    {
        $pageTitle = 'Recruitments';
        confirmDelete();
        return view('admin.recruitments.index', ['pageTitle' => $pageTitle]);
    }

    /**
     * Ambil data recruitment (untuk DataTables AJAX opsional).
     */
    public function getRecruitments(Request $request)
    {
        $recruitments = Recruitment::with('job')->get();

        if ($request->ajax()) {
            return datatables()->of($recruitments)
                ->addIndexColumn()
                ->addColumn('actions', function ($recruitment) {
                    return view('admin.recruitments.actions', compact('recruitment'));
                })
                ->toJson();
        }
    }

    /**
     * Simpan data recruitment dari form Apply (untuk user).
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email'    => 'Format :attribute tidak valid.',
            'file.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
        ];

        $validator = Validator::make($request->all(), [
            'job_id'   => 'required|exists:jobs,id',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'address'  => 'required|string',
            'file'     => 'required|file|mimes:pdf,doc,docx|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Upload file
        $path = $request->file('file')->store('public/recruitments');

        // Simpan data
        Recruitment::create([
            'user_id' => auth()->id(),
            'job_id'  => $request->job_id,
            'name'    => $request->name,
            'email'   => $request->email,
            'address' => $request->address,
            'file'    => basename($path),
            'status'  => 'Review Berkas Oleh HRD',
        ]);

        Alert::success('Apply Success', 'Your application has been sent.');
        return redirect()->route('tracking');
    }

    /**
     * Tracking (untuk user).
     */
    public function tracking()
    {
        $pageTitle = 'Recruitment Tracking';
        $recruitments = Recruitment::with('job')
            ->where('user_id', auth()->id())
            ->latest()->get();

        return view('recruitments.tracking', compact('pageTitle', 'recruitments'));
    }

    /**
     * Edit status (admin).
     */
    public function edit(Recruitment $recruitment)
    {
        $pageTitle = 'Edit Recruitment Status';
        return view('admin.recruitments.edit', compact('pageTitle', 'recruitment'));
    }

    /**
     * Update status (admin).
     */
    public function update(Request $request, Recruitment $recruitment)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $recruitment->update(['status' => $request->status]);

        Alert::success('Changed Successfully', 'Recruitment status changed successfully.');
        return redirect()->route('admin.recruitments.index');
    }

    /**
     * Hapus data recruitment.
     */
    public function destroy(Recruitment $recruitment)
    {
        if ($recruitment->file) {
            $filePath = 'public/recruitments/' . $recruitment->file;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }

        $recruitment->delete();
        Alert::success('Deleted Successfully', 'Recruitment data deleted successfully.');
        return redirect()->route('admin.recruitments.index');
    }

    /**
     * Export Excel.
     */
    public function export_excel()
    {
        return Excel::download(new RecruitmentsExport, 'recruitments.xlsx');
    }
}
