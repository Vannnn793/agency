<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Placement;
use App\Models\User;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Tampilkan halaman landing publik.
     */
    public function landing(): View
    {
        $stats = [
            'total_jobs' => JobPosting::where('status', 'open')->count(),
            'total_companies' => User::where('role', 'company')->whereNotNull('verified_at')->count(),
            'total_placements' => Placement::whereIn('status', ['accepted', 'completed'])->count(),
        ];

        $featuredJobs = JobPosting::where('status', 'open')
            ->with('company', 'skills')
            ->latest()
            ->take(6)
            ->get();

        return view('public.landing', compact('stats', 'featuredJobs'));
    }

    /**
     * Tampilkan daftar pekerjaan publik.
     */
    public function jobs(): View
    {
        $jobs = JobPosting::where('status', 'open')
            ->with('company', 'skills')
            ->paginate(12);

        return view('public.jobs', compact('jobs'));
    }

    /**
     * Tampilkan detail pekerjaan publik.
     */
    public function jobDetail(JobPosting $job): View
    {
        if ($job->status !== 'open') {
            abort(404);
        }

        return view('public.job-detail', compact('job'));
    }

    /**
     * Tampilkan halaman tentang kami.
     */
    public function about(): View
    {
        return view('public.about');
    }
}
