<?php

namespace Database\Seeders;

use App\Models\Candidates;
use App\Models\Company;
use App\Models\Education;
use App\Models\Experience;
use App\Models\JobPosting;
use App\Models\Placement;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin
        User::create([
            'name' => 'Admin Agency',
            'email' => 'admin@agency.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'verified_at' => now(),
        ]);

        // 2. Seed Skills
        $skillsData = [
            'PHP', 'JavaScript', 'Laravel', 'React', 'Vue.js', 'MySQL', 'UI/UX Design',
            'Python', 'Flutter', 'Tailwind CSS', 'Project Management', 'Digital Marketing',
            'Copywriting', 'Customer Service', 'Data Entry', 'Accounting', 'Human Resources',
            'Graphic Design', 'Java', 'Node.js'
        ];

        $skills = [];
        foreach ($skillsData as $name) {
            $skills[] = Skill::create(['name' => $name]);
        }

        // 3. Seed Companies
        // Verified Company 1
        $u1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'tech@tokopedia.com',
            'password' => Hash::make('password'),
            'role' => 'company',
            'verified_at' => now(),
        ]);
        $c1 = Company::create([
            'user_id' => $u1->id,
            'name' => 'Tokopedia',
            'industry' => 'E-Commerce / Teknologi',
            'address' => 'Gedung Tokopedia Tower, Jakarta Selatan',
            'phone' => '021-1234567',
            'email' => 'tech@tokopedia.com',
            'contact_person' => 'Budi Santoso',
            'description' => 'Tokopedia adalah perusahaan teknologi Indonesia dengan misi mencapai pemerataan ekonomi secara digital.',
        ]);

        // Verified Company 2
        $u2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'hrd@bankmandiri.co.id',
            'password' => Hash::make('password'),
            'role' => 'company',
            'verified_at' => now(),
        ]);
        $c2 = Company::create([
            'user_id' => $u2->id,
            'name' => 'Bank Mandiri',
            'industry' => 'Perbankan / Keuangan',
            'address' => 'Plaza Mandiri, Jl. Jend. Gatot Subroto, Jakarta Selatan',
            'phone' => '021-7654321',
            'email' => 'hrd@bankmandiri.co.id',
            'contact_person' => 'Siti Aminah',
            'description' => 'Bank Mandiri adalah bank terbesar di Indonesia dalam hal aset, pinjaman, dan deposit.',
        ]);

        // Pending Company
        $u3 = User::create([
            'name' => 'Rian Hidayat',
            'email' => 'info@majusolusi.id',
            'password' => Hash::make('password'),
            'role' => 'company',
            'verified_at' => null,
        ]);
        Company::create([
            'user_id' => $u3->id,
            'name' => 'PT. Maju Solusi Integrasi',
            'industry' => 'Konsultan TI',
            'address' => 'Sudirman Central Business District, Jakarta Pusat',
            'phone' => '081234567890',
            'email' => 'info@majusolusi.id',
            'contact_person' => 'Rian Hidayat',
            'description' => 'PT Maju Solusi Integrasi menyediakan layanan integrasi sistem TI dan pengembangan aplikasi kustom.',
        ]);

        // 4. Seed Candidates
        // Candidate 1 (Tersedia)
        $cand1 = Candidates::create([
            'full_name' => 'Adit Pratama',
            'phone' => '081211112222',
            'email' => 'adit.pratama@gmail.com',
            'date_of_birth' => '1998-05-15',
            'gender' => 'Laki-laki',
            'headline' => 'Junior Laravel Developer',
            'about' => 'Saya seorang pengembang web junior yang berfokus pada PHP dan framework Laravel. Berpengalaman dalam membuat RESTful API.',
            'location' => 'Jakarta Selatan',
            'expected_salary' => '6.000.000',
            'availability' => 'Segera',
            'status' => 'tersedia',
        ]);
        $cand1->skills()->sync([$skills[0]->id, $skills[1]->id, $skills[2]->id, $skills[5]->id]); // PHP, JS, Laravel, MySQL
        Experience::create([
            'candidate_id' => $cand1->id,
            'position' => 'Web Developer Intern',
            'company' => 'PT. Digital Solusi',
            'start_date' => '2023-01-10',
            'end_date' => '2023-07-10',
            'description' => 'Membantu pengembangan modul e-commerce dan memelihara database MySQL.',
        ]);
        Education::create([
            'candidate_id' => $cand1->id,
            'institution' => 'Universitas Indonesia',
            'degree' => 'S1 Teknik Informatika',
            'start_year' => 2018,
            'end_year' => 2022,
        ]);

        // Candidate 2 (Tersedia)
        $cand2 = Candidates::create([
            'full_name' => 'Rina Wijaya',
            'phone' => '081233334444',
            'email' => 'rina.wijaya@outlook.com',
            'date_of_birth' => '1997-09-20',
            'gender' => 'Perempuan',
            'headline' => 'UI/UX Designer',
            'about' => 'UI/UX Designer dengan ketertarikan tinggi pada pembuatan wireframe, prototyping, dan user research untuk aplikasi mobile.',
            'location' => 'Surabaya',
            'expected_salary' => '7.000.000',
            'availability' => 'Pemberitahuan 1 Bulan',
            'status' => 'tersedia',
        ]);
        $cand2->skills()->sync([$skills[1]->id, $skills[6]->id, $skills[17]->id]); // JS, UI/UX, Graphic Design
        Experience::create([
            'candidate_id' => $cand2->id,
            'position' => 'UI/UX Designer',
            'company' => 'Creative Agency Surabaya',
            'start_date' => '2022-03-01',
            'end_date' => '2024-03-01',
            'description' => 'Mendesain antarmuka untuk 5+ aplikasi klien dan melakukan usability testing.',
        ]);
        Education::create([
            'candidate_id' => $cand2->id,
            'institution' => 'Institut Teknologi Sepuluh Nopember',
            'degree' => 'S1 Desain Komunikasi Visual',
            'start_year' => 2017,
            'end_year' => 2021,
        ]);

        // Candidate 3 (Disalurkan)
        $cand3 = Candidates::create([
            'full_name' => 'Faisal Reza',
            'phone' => '081255556666',
            'email' => 'faisal.reza@gmail.com',
            'date_of_birth' => '1995-12-05',
            'gender' => 'Laki-laki',
            'headline' => 'Senior Frontend Engineer',
            'about' => 'Frontend Engineer berpengalaman 4+ tahun dalam membangun aplikasi SPA menggunakan React dan Vue.js.',
            'location' => 'Jakarta Barat',
            'expected_salary' => '12.000.000',
            'availability' => 'Segera',
            'status' => 'disalurkan',
        ]);
        $cand3->skills()->sync([$skills[1]->id, $skills[3]->id, $skills[4]->id, $skills[9]->id]); // JS, React, Vue, Tailwind
        Experience::create([
            'candidate_id' => $cand3->id,
            'position' => 'Software Engineer Frontend',
            'company' => 'PT. Global Tekno',
            'start_date' => '2020-01-05',
            'end_date' => '2024-05-01',
            'description' => 'Memimpin tim frontend untuk merombak arsitektur web internal menggunakan React.js.',
        ]);
        Education::create([
            'candidate_id' => $cand3->id,
            'institution' => 'Binus University',
            'degree' => 'S1 Sistem Informasi',
            'start_year' => 2013,
            'end_year' => 2017,
        ]);

        // 5. Seed Job Postings
        // Job 1
        $job1 = JobPosting::create([
            'company_id' => $c1->id,
            'title' => 'Laravel Backend Developer',
            'description' => "Tokopedia sedang mencari Laravel Backend Developer untuk tim pembayaran kami.\n\nTanggung Jawab:\n- Mengembangkan API yang andal dan aman\n- Mengintegrasikan layanan pihak ketiga\n- Mengoptimalkan performa kueri database\n\nKualifikasi:\n- Minimal 1 tahun pengalaman Laravel\n- Menguasai SQL dan Git",
            'location' => 'Jakarta Selatan',
            'salary_min' => 6000000,
            'salary_max' => 10000000,
            'education_requirement' => 'S1',
            'experience_years' => 1,
            'status' => 'open',
        ]);
        $job1->skills()->sync([$skills[0]->id, $skills[2]->id, $skills[5]->id]); // PHP, Laravel, MySQL

        // Job 2
        $job2 = JobPosting::create([
            'company_id' => $c1->id,
            'title' => 'UI/UX Designer (Junior)',
            'description' => "Tokopedia sedang mencari Junior UI/UX Designer untuk memperkuat visual produk e-commerce.\n\nKualifikasi:\n- Menguasai Figma dan Adobe Creative Suite\n- Memahami prinsip-prinsip desain berpusat pada pengguna\n- Portofolio desain UI/UX aktif",
            'location' => 'Jakarta Selatan',
            'salary_min' => 5000000,
            'salary_max' => 8000000,
            'education_requirement' => 'S1',
            'experience_years' => 0,
            'status' => 'open',
        ]);
        $job2->skills()->sync([$skills[6]->id, $skills[17]->id]); // UI/UX, Graphic Design

        // Job 3
        $job3 = JobPosting::create([
            'company_id' => $c2->id,
            'title' => 'Senior Frontend Developer (React)',
            'description' => "Bank Mandiri mencari Senior Frontend Developer untuk mengembangkan portal layanan nasabah mandiri.\n\nKualifikasi:\n- 3+ tahun pengalaman dengan React.js\n- Memahami State Management (Redux/Zustand)\n- Berpengalaman dengan Tailwind CSS",
            'location' => 'Jakarta Selatan',
            'salary_min' => 10000000,
            'salary_max' => 15000000,
            'education_requirement' => 'S1',
            'experience_years' => 3,
            'status' => 'open',
        ]);
        $job3->skills()->sync([$skills[1]->id, $skills[3]->id, $skills[9]->id]); // JS, React, Tailwind

        // 6. Seed Placements
        Placement::create([
            'candidate_id' => $cand3->id,
            'job_posting_id' => $job3->id,
            'status' => 'accepted',
            'placed_at' => now(),
            'notes' => 'Telah lolos tahap wawancara direksi dan menandatangani kontrak penempatan.',
        ]);

        Placement::create([
            'candidate_id' => $cand1->id,
            'job_posting_id' => $job1->id,
            'status' => 'pending',
            'placed_at' => null,
            'notes' => 'Wawancara dengan HRD dijadwalkan pada hari Selasa jam 10.00 WIB.',
        ]);
    }
}
