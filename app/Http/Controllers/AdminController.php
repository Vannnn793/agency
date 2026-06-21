<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\Company;
use App\Models\Education;
use App\Models\Experience;
use App\Models\JobPosting;
use App\Models\Placement;
use App\Models\Skill;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Dashboard admin.
     */
    public function index(): View
    {
        $stats = [
            'candidates_available' => Candidates::where('status', 'tersedia')->count(),
            'companies_pending' => User::where('role', 'company')->whereNull('verified_at')->count(),
            'companies_verified' => User::where('role', 'company')->whereNotNull('verified_at')->count(),
            'jobs_active' => JobPosting::where('status', 'open')->count(),
            'placements_success' => Placement::where('status', 'accepted')->orWhere('status', 'completed')->count(),
        ];

        $pendingCompanies = Company::whereHas('user', function ($query) {
            $query->whereNull('verified_at');
        })->with('user')->latest()->take(5)->get();

        $latestCandidates = Candidates::latest()->take(5)->get();
        $latestJobs = JobPosting::with('company')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pendingCompanies', 'latestCandidates', 'latestJobs'));
    }

    /*
    |--------------------------------------------------------------------------
    | CANDIDATES CRUD
    |--------------------------------------------------------------------------
    */

    public function candidatesIndex(Request $request): View
    {
        $query = Candidates::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

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

        return view('admin.candidates.index', compact('candidates', 'skills'));
    }

    public function candidateCreate(): View
    {
        $skills = Skill::orderBy('name')->get();
        return view('admin.candidates.create', compact('skills'));
    }

    public function candidateStore(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'headline' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'expected_salary' => 'nullable|string|max:100',
            'availability' => 'nullable|string|max:100',
            'status' => 'required|in:tersedia,disalurkan,tidak_aktif',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            // Experiences Arrays
            'exp_position' => 'nullable|array',
            'exp_company' => 'nullable|array',
            'exp_start_date' => 'nullable|array',
            'exp_end_date' => 'nullable|array',
            'exp_description' => 'nullable|array',
            // Educations Arrays
            'edu_institution' => 'nullable|array',
            'edu_degree' => 'nullable|array',
            'edu_start_year' => 'nullable|array',
            'edu_end_year' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {
            $candidate = Candidates::create([
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'headline' => $request->headline,
                'about' => $request->about,
                'location' => $request->location,
                'expected_salary' => $request->expected_salary,
                'availability' => $request->availability,
                'status' => $request->status,
            ]);

            if ($request->has('skills')) {
                $candidate->skills()->sync($request->skills);
            }

            // Save experiences
            if ($request->has('exp_position')) {
                foreach ($request->exp_position as $key => $position) {
                    if (!empty($position)) {
                        Experience::create([
                            'candidate_id' => $candidate->id,
                            'position' => $position,
                            'company' => $request->exp_company[$key] ?? '',
                            'start_date' => $request->exp_start_date[$key] ?? null,
                            'end_date' => $request->exp_end_date[$key] ?? null,
                            'description' => $request->exp_description[$key] ?? null,
                        ]);
                    }
                }
            }

            // Save educations
            if ($request->has('edu_institution')) {
                foreach ($request->edu_institution as $key => $inst) {
                    if (!empty($inst)) {
                        Education::create([
                            'candidate_id' => $candidate->id,
                            'institution' => $inst,
                            'degree' => $request->edu_degree[$key] ?? '',
                            'start_year' => $request->edu_start_year[$key] ?? null,
                            'end_year' => $request->edu_end_year[$key] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.candidates.index')->with('success', 'Kandidat berhasil ditambahkan.');
    }

    public function candidateShow($id): View
    {
        $candidate = Candidates::with(['skills', 'experiences', 'educations', 'placements.jobPosting.company'])->findOrFail($id);
        return view('admin.candidates.show', compact('candidate'));
    }

    public function candidateEdit($id): View
    {
        $candidate = Candidates::with(['skills', 'experiences', 'educations'])->findOrFail($id);
        $skills = Skill::orderBy('name')->get();
        return view('admin.candidates.edit', compact('candidate', 'skills'));
    }

    public function candidateUpdate(Request $request, $id): RedirectResponse
    {
        $candidate = Candidates::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'headline' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'expected_salary' => 'nullable|string|max:100',
            'availability' => 'nullable|string|max:100',
            'status' => 'required|in:tersedia,disalurkan,tidak_aktif',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            // Experiences Arrays
            'exp_position' => 'nullable|array',
            'exp_company' => 'nullable|array',
            'exp_start_date' => 'nullable|array',
            'exp_end_date' => 'nullable|array',
            'exp_description' => 'nullable|array',
            // Educations Arrays
            'edu_institution' => 'nullable|array',
            'edu_degree' => 'nullable|array',
            'edu_start_year' => 'nullable|array',
            'edu_end_year' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request, $candidate) {
            $candidate->update([
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'headline' => $request->headline,
                'about' => $request->about,
                'location' => $request->location,
                'expected_salary' => $request->expected_salary,
                'availability' => $request->availability,
                'status' => $request->status,
            ]);

            $candidate->skills()->sync($request->skills ?? []);

            // Clear old experiences & educations, then write new ones to avoid complex diff mapping
            Experience::where('candidate_id', $candidate->id)->delete();
            if ($request->has('exp_position')) {
                foreach ($request->exp_position as $key => $position) {
                    if (!empty($position)) {
                        Experience::create([
                            'candidate_id' => $candidate->id,
                            'position' => $position,
                            'company' => $request->exp_company[$key] ?? '',
                            'start_date' => $request->exp_start_date[$key] ?? null,
                            'end_date' => $request->exp_end_date[$key] ?? null,
                            'description' => $request->exp_description[$key] ?? null,
                        ]);
                    }
                }
            }

            Education::where('candidate_id', $candidate->id)->delete();
            if ($request->has('edu_institution')) {
                foreach ($request->edu_institution as $key => $inst) {
                    if (!empty($inst)) {
                        Education::create([
                            'candidate_id' => $candidate->id,
                            'institution' => $inst,
                            'degree' => $request->edu_degree[$key] ?? '',
                            'start_year' => $request->edu_start_year[$key] ?? null,
                            'end_year' => $request->edu_end_year[$key] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.candidates.index')->with('success', 'Kandidat berhasil diperbarui.');
    }

    public function candidateDestroy($id): RedirectResponse
    {
        $candidate = Candidates::findOrFail($id);
        $candidate->delete();
        return redirect()->route('admin.candidates.index')->with('success', 'Kandidat berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | COMPANIES MANAGEMENT
    |--------------------------------------------------------------------------
    */

    public function companiesIndex(Request $request): View
    {
        $query = Company::query();

        if ($request->status === 'pending') {
            $query->whereHas('user', function ($q) {
                $q->whereNull('verified_at');
            });
        } elseif ($request->status === 'verified') {
            $query->whereHas('user', function ($q) {
                $q->whereNotNull('verified_at');
            });
        }

        $companies = $query->with('user')->latest()->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    public function companyShow($id): View
    {
        $company = Company::with(['user', 'jobPostings'])->findOrFail($id);
        return view('admin.companies.show', compact('company'));
    }

    public function companyVerify($id): RedirectResponse
    {
        $company = Company::findOrFail($id);
        $company->user->update(['verified_at' => now()]);

        return redirect()->back()->with('success', 'Perusahaan "' . $company->name . '" telah berhasil diverifikasi.');
    }

    public function companyReject($id): RedirectResponse
    {
        $company = Company::findOrFail($id);
        $user = $company->user;
        
        DB::transaction(function () use ($company, $user) {
            $company->delete();
            $user->delete();
        });

        return redirect()->route('admin.companies.index')->with('success', 'Pendaftaran perusahaan telah ditolak dan akun dihapus.');
    }

    public function companyDestroy($id): RedirectResponse
    {
        $company = Company::findOrFail($id);
        $user = $company->user;

        DB::transaction(function () use ($company, $user) {
            $company->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.companies.index')->with('success', 'Perusahaan berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | JOB POSTINGS CRUD
    |--------------------------------------------------------------------------
    */

    public function jobPostingsIndex(Request $request): View
    {
        $query = JobPosting::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $jobPostings = $query->with(['company', 'skills'])->latest()->paginate(10);
        $companies = Company::orderBy('name')->get();

        return view('admin.job-postings.index', compact('jobPostings', 'companies'));
    }

    public function jobPostingCreate(): View
    {
        $companies = Company::whereHas('user', function ($q) {
            $q->whereNotNull('verified_at');
        })->orderBy('name')->get();
        $skills = Skill::orderBy('name')->get();
        return view('admin.job-postings.create', compact('companies', 'skills'));
    }

    public function jobPostingStore(Request $request): RedirectResponse
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
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

        $job = JobPosting::create($request->only([
            'company_id', 'title', 'description', 'location', 'salary_min', 'salary_max', 'education_requirement', 'experience_years', 'status'
        ]));

        if ($request->has('skills')) {
            $job->skills()->sync($request->skills);
        }

        return redirect()->route('admin.job-postings.index')->with('success', 'Lowongan berhasil dibuat.');
    }

    public function jobPostingEdit($id): View
    {
        $jobPosting = JobPosting::with('skills')->findOrFail($id);
        $companies = Company::whereHas('user', function ($q) {
            $q->whereNotNull('verified_at');
        })->orderBy('name')->get();
        $skills = Skill::orderBy('name')->get();

        return view('admin.job-postings.edit', compact('jobPosting', 'companies', 'skills'));
    }

    public function jobPostingUpdate(Request $request, $id): RedirectResponse
    {
        $job = JobPosting::findOrFail($id);

        $request->validate([
            'company_id' => 'required|exists:companies,id',
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
            'company_id', 'title', 'description', 'location', 'salary_min', 'salary_max', 'education_requirement', 'experience_years', 'status'
        ]));

        $job->skills()->sync($request->skills ?? []);

        return redirect()->route('admin.job-postings.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function jobPostingShow($id): View
    {
        $jobPosting = JobPosting::with(['company', 'skills', 'placements.candidate'])->findOrFail($id);
        $matchedCandidates = $this->calculateMatchingCandidates($jobPosting);

        return view('admin.job-postings.show', compact('jobPosting', 'matchedCandidates'));
    }

    public function jobPostingDestroy($id): RedirectResponse
    {
        $job = JobPosting::findOrFail($id);
        $job->delete();
        return redirect()->route('admin.job-postings.index')->with('success', 'Lowongan berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | MATCHING ENGINE
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
                $skillScore = 50.0; // If no skills required, full points
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

        // Sort descending by match score
        usort($matched, function ($a, $b) {
            return $b->match_score <=> $a->match_score;
        });

        return $matched;
    }

    /*
    |--------------------------------------------------------------------------
    | PLACEMENTS
    |--------------------------------------------------------------------------
    */

    public function placementsIndex(Request $request): View
    {
        $query = Placement::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $placements = $query->with(['candidate', 'jobPosting.company'])->latest()->paginate(10);
        return view('admin.placements.index', compact('placements'));
    }

    public function placementCreate(Request $request): View
    {
        $candidates = Candidates::where('status', 'tersedia')->orderBy('full_name')->get();
        $jobPostings = JobPosting::where('status', 'open')->with('company')->latest()->get();

        $selected_candidate = $request->candidate_id;
        $selected_job = $request->job_posting_id;

        return view('admin.placements.create', compact('candidates', 'jobPostings', 'selected_candidate', 'selected_job'));
    }

    public function placementStore(Request $request): RedirectResponse
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'job_posting_id' => 'required|exists:job_postings,id',
            'notes' => 'nullable|string',
        ]);

        // Check if candidate already has a placement for this job posting
        $exists = Placement::where('candidate_id', $request->candidate_id)
            ->where('job_posting_id', $request->job_posting_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['placement' => 'Kandidat ini sudah terdaftar dalam proses penempatan untuk lowongan tersebut.']);
        }

        Placement::create([
            'candidate_id' => $request->candidate_id,
            'job_posting_id' => $request->job_posting_id,
            'status' => 'pending',
            'placed_at' => null,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.placements.index')->with('success', 'Penyaluran kandidat berhasil dijadwalkan.');
    }

    public function placementUpdateStatus(Request $request, $id): RedirectResponse
    {
        $placement = Placement::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,completed',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $placement) {
            $placement->update([
                'status' => $request->status,
                'notes' => $request->notes,
                'placed_at' => ($request->status === 'accepted' || $request->status === 'completed') ? now() : $placement->placed_at,
            ]);

            // If status is accepted/completed, candidate status becomes 'disalurkan'
            if ($request->status === 'accepted' || $request->status === 'completed') {
                $placement->candidate->update(['status' => 'disalurkan']);
            } elseif ($request->status === 'rejected') {
                // If rejected, verify if candidate has any active accepted placements, if not restore to 'tersedia'
                $hasActive = Placement::where('candidate_id', $placement->candidate_id)
                    ->whereIn('status', ['accepted', 'completed'])
                    ->exists();
                if (!$hasActive) {
                    $placement->candidate->update(['status' => 'tersedia']);
                }
            }
        });

        return redirect()->back()->with('success', 'Status penyaluran berhasil diperbarui.');
    }

    public function placementDestroy($id): RedirectResponse
    {
        $placement = Placement::findOrFail($id);
        $candidate = $placement->candidate;

        DB::transaction(function () use ($placement, $candidate) {
            $placement->delete();
            
            // Recalculate status of candidate
            $hasActive = Placement::where('candidate_id', $candidate->id)
                ->whereIn('status', ['accepted', 'completed'])
                ->exists();
            if (!$hasActive) {
                $candidate->update(['status' => 'tersedia']);
            }
        });

        return redirect()->route('admin.placements.index')->with('success', 'Data penyaluran berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | SKILLS
    |--------------------------------------------------------------------------
    */

    public function skillsIndex(): View
    {
        $skills = Skill::withCount(['candidates', 'jobPostings'])->orderBy('name')->get();
        return view('admin.skills.index', compact('skills'));
    }

    public function skillStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:skills,name',
        ]);

        Skill::create(['name' => trim($request->name)]);

        return redirect()->route('admin.skills.index')->with('success', 'Skill berhasil ditambahkan.');
    }

    public function skillDestroy($id): RedirectResponse
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('success', 'Skill berhasil dihapus.');
    }
}
