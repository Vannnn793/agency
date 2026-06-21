<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\Placement;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Tampilkan halaman pending verifikasi.
     */
    public function pending(): View
    {
        return view('company.pending');
    }

    /**
     * Dashboard perusahaan.
     */
    public function dashboard(): View
    {
        $company = Auth::user()->company;

        if (!$company) {
            abort(404, 'Data perusahaan tidak ditemukan.');
        }

        $stats = [
            'jobs_count' => JobPosting::where('company_id', $company->id)->count(),
            'active_jobs' => JobPosting::where('company_id', $company->id)->where('status', 'open')->count(),
            'placements_count' => Placement::whereHas('jobPosting', function ($q) use ($company) {
                $q->where('company_id', $company->id);
            })->count(),
            'candidates_hired' => Placement::whereHas('jobPosting', function ($q) use ($company) {
                $q->where('company_id', $company->id);
            })->whereIn('status', ['accepted', 'completed'])->count(),
        ];

        $latestJobs = JobPosting::where('company_id', $company->id)->latest()->take(5)->get();

        $latestPlacements = Placement::whereHas('jobPosting', function ($q) use ($company) {
            $q->where('company_id', $company->id);
        })->with('candidate', 'jobPosting')->latest()->take(5)->get();

        return view('company.dashboard', compact('stats', 'latestJobs', 'latestPlacements'));
    }

    /*
    |--------------------------------------------------------------------------
    | JOB POSTINGS CRUD (OWN ONLY)
    |--------------------------------------------------------------------------
    */

    public function jobPostingsIndex(Request $request): View
    {
        $company = Auth::user()->company;
        $query = JobPosting::where('company_id', $company->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobPostings = $query->with('skills')->latest()->paginate(10);

        return view('company.job-postings.index', compact('jobPostings'));
    }

    public function jobPostingCreate(): View
    {
        $skills = Skill::orderBy('name')->get();
        return view('company.job-postings.create', compact('skills'));
    }

    public function jobPostingStore(Request $request): RedirectResponse
    {
        $company = Auth::user()->company;

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|gte:salary_min',
            'education_requirement' => 'nullable|string|max:100',
            'experience_years' => 'nullable|integer|min:0',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $job = JobPosting::create([
            'company_id' => $company->id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'education_requirement' => $request->education_requirement,
            'experience_years' => $request->experience_years,
            'status' => 'open',
        ]);

        if ($request->has('skills')) {
            $job->skills()->sync($request->skills);
        }

        return redirect()->route('company.job-postings.index')->with('success', 'Lowongan berhasil diterbitkan.');
    }

    public function jobPostingShow($id): View
    {
        $company = Auth::user()->company;
        $jobPosting = JobPosting::where('company_id', $company->id)->with(['skills', 'placements.candidate'])->findOrFail($id);
        $matchedCandidates = $this->calculateMatchingCandidates($jobPosting);

        return view('company.job-postings.show', compact('jobPosting', 'matchedCandidates'));
    }

    public function jobPostingEdit($id): View
    {
        $company = Auth::user()->company;
        $jobPosting = JobPosting::where('company_id', $company->id)->with('skills')->findOrFail($id);
        $skills = Skill::orderBy('name')->get();

        return view('company.job-postings.edit', compact('jobPosting', 'skills'));
    }

    public function jobPostingUpdate(Request $request, $id): RedirectResponse
    {
        $company = Auth::user()->company;
        $job = JobPosting::where('company_id', $company->id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|gte:salary_min',
            'education_requirement' => 'nullable|string|max:100',
            'experience_years' => 'nullable|integer|min:0',
            'status' => 'required|in:open,closed,filled',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $job->update($request->only([
            'title', 'description', 'location', 'salary_min', 'salary_max', 'education_requirement', 'experience_years', 'status'
        ]));

        $job->skills()->sync($request->skills ?? []);

        return redirect()->route('company.job-postings.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function jobPostingDestroy($id): RedirectResponse
    {
        $company = Auth::user()->company;
        $job = JobPosting::where('company_id', $company->id)->findOrFail($id);
        $job->delete();

        return redirect()->route('company.job-postings.index')->with('success', 'Lowongan berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | CANDIDATES SEARCH & DISCOVERY
    |--------------------------------------------------------------------------
    */

    public function viewCandidates(Request $request): View
    {
        $query = Candidates::where('status', 'tersedia');

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('skill')) {
            $query->whereHas('skills', function ($q) use ($request) {
                $q->where('skills.id', $request->skill);
            });
        }

        $candidates = $query->with('skills')->latest()->paginate(10);
        $skills = Skill::orderBy('name')->get();

        return view('company.candidates.index', compact('candidates', 'skills'));
    }

    public function showCandidate($id): View
    {
        $candidate = Candidates::where('status', 'tersedia')
            ->with(['skills', 'experiences', 'educations'])
            ->findOrFail($id);

        return view('company.candidates.show', compact('candidate'));
    }

    /*
    |--------------------------------------------------------------------------
    | MATCHING ENGINE HELPER
    |--------------------------------------------------------------------------
    */

    private function calculateMatchingCandidates(JobPosting $jobPosting): array
    {
        $candidates = Candidates::where('status', 'tersedia')
            ->with(['skills', 'experiences', 'educations'])
            ->get();

        $matched = [];
        $requiredSkills = $jobPosting->skills->pluck('id')->toArray();
        $requiredSkillCount = count($requiredSkills);
        $reqEdu = strtolower($jobPosting->education_requirement);
        $reqExp = $jobPosting->experience_years ?? 0;
        $reqLoc = strtolower($jobPosting->location);

        $eduLevels = [
            'sma' => 1,
            'smk' => 1,
            'd3' => 2,
            's1' => 3,
            's2' => 4,
            's3' => 5,
        ];

        $reqEduLevel = 0;
        foreach ($eduLevels as $key => $level) {
            if (str_contains($reqEdu, $key)) {
                $reqEduLevel = $level;
                break;
            }
        }

        foreach ($candidates as $candidate) {
            $score = 0.0;

            // 1. SKILLS (50%)
            $skillScore = 0.0;
            if ($requiredSkillCount > 0) {
                $candSkills = $candidate->skills->pluck('id')->toArray();
                $matchedSkills = array_intersect($candSkills, $requiredSkills);
                $skillScore = (count($matchedSkills) / $requiredSkillCount) * 50.0;
            } else {
                $skillScore = 50.0;
            }
            $score += $skillScore;

            // 2. EXPERIENCE YEARS (20%)
            $expYears = $candidate->experience_years;
            $expScore = 0.0;
            if ($reqExp > 0) {
                if ($expYears >= $reqExp) {
                    $expScore = 20.0;
                } else {
                    $expScore = ($expYears / $reqExp) * 20.0;
                }
            } else {
                $expScore = 20.0;
            }
            $score += $expScore;

            // 3. LOCATION (15%)
            $locScore = 0.0;
            if (!empty($reqLoc)) {
                $candLoc = strtolower($candidate->location);
                if (str_contains($candLoc, $reqLoc) || str_contains($reqLoc, $candLoc)) {
                    $locScore = 15.0;
                }
            } else {
                $locScore = 15.0;
            }
            $score += $locScore;

            // 4. EDUCATION LEVEL (15%)
            $eduScore = 0.0;
            if ($reqEduLevel > 0) {
                $candMaxLevel = 0;
                foreach ($candidate->educations as $edu) {
                    $deg = strtolower($edu->degree);
                    foreach ($eduLevels as $key => $level) {
                        if (str_contains($deg, $key)) {
                            $candMaxLevel = max($candMaxLevel, $level);
                        }
                    }
                }
                if ($candMaxLevel >= $reqEduLevel) {
                    $eduScore = 15.0;
                } elseif ($candMaxLevel > 0) {
                    $eduScore = ($candMaxLevel / $reqEduLevel) * 15.0;
                }
            } else {
                $eduScore = 15.0;
            }
            $score += $eduScore;

            $candidate->match_score = round($score);
            $matched[] = $candidate;
        }

        usort($matched, function ($a, $b) {
            return $b->match_score <=> $a->match_score;
        });

        return $matched;
    }
}
