<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Student;
use App\Models\ExamType;
use App\Models\ExamRequirement;
use App\Models\ExamSubmission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ExamSubmissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_student_can_view_exam_types()
    {
        $student = Student::factory()->create();
        $examType = ExamType::create([
            'name' => 'Ujian Komprehensif',
            'code' => 'UK',
            'description' => 'Test description',
            'status' => 'active'
        ]);

        $response = $this->actingAs($student)
            ->get('/exam-types');

        $response->assertStatus(200);
        $response->assertSee('Ujian Komprehensif');
    }

    public function test_student_can_view_exam_requirements()
    {
        $student = Student::factory()->create();
        $examType = ExamType::create([
            'name' => 'Ujian Komprehensif',
            'code' => 'UK',
            'description' => 'Test description',
            'status' => 'active'
        ]);

        $requirement = ExamRequirement::create([
            'exam_type_id' => $examType->id,
            'document_name' => 'Test Document',
            'description' => 'Test requirement',
            'is_required' => true,
            'file_types' => 'pdf',
            'max_size' => 2048,
            'order' => 1,
            'status' => 'active'
        ]);

        $response = $this->actingAs($student)
            ->get("/exam-types/{$examType->id}/requirements");

        $response->assertStatus(200);
        $response->assertSee('Test Document');
    }

    public function test_student_can_create_exam_submission()
    {
        $student = Student::factory()->create();
        $examType = ExamType::create([
            'name' => 'Ujian Komprehensif',
            'code' => 'UK',
            'description' => 'Test description',
            'status' => 'active'
        ]);

        $requirement = ExamRequirement::create([
            'exam_type_id' => $examType->id,
            'document_name' => 'Test Document',
            'description' => 'Test requirement',
            'is_required' => true,
            'file_types' => 'pdf',
            'max_size' => 2048,
            'order' => 1,
            'status' => 'active'
        ]);

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($student)
            ->post("/submissions/{$examType->id}", [
                "documents[{$requirement->id}]" => $file
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('exam_submissions', [
            'student_id' => $student->id,
            'exam_type_id' => $examType->id,
            'status' => 'menunggu_verifikasi'
        ]);
    }

    public function test_student_can_view_their_submissions()
    {
        $student = Student::factory()->create();
        $examType = ExamType::create([
            'name' => 'Ujian Komprehensif',
            'code' => 'UK',
            'description' => 'Test description',
            'status' => 'active'
        ]);

        $submission = ExamSubmission::create([
            'student_id' => $student->id,
            'exam_type_id' => $examType->id,
            'submission_number' => 'SUB-20250101-0001',
            'status' => 'menunggu_verifikasi',
            'submitted_at' => now()
        ]);

        $response = $this->actingAs($student)
            ->get('/submissions');

        $response->assertStatus(200);
        $response->assertSee('SUB-20250101-0001');
    }

    public function test_student_can_view_submission_detail()
    {
        $student = Student::factory()->create();
        $examType = ExamType::create([
            'name' => 'Ujian Komprehensif',
            'code' => 'UK',
            'description' => 'Test description',
            'status' => 'active'
        ]);

        $submission = ExamSubmission::create([
            'student_id' => $student->id,
            'exam_type_id' => $examType->id,
            'submission_number' => 'SUB-20250101-0001',
            'status' => 'menunggu_verifikasi',
            'submitted_at' => now()
        ]);

        $response = $this->actingAs($student)
            ->get("/submissions/{$submission->id}");

        $response->assertStatus(200);
        $response->assertSee('SUB-20250101-0001');
    }

    public function test_student_cannot_access_other_student_submission()
    {
        $student1 = Student::factory()->create();
        $student2 = Student::factory()->create();
        $examType = ExamType::create([
            'name' => 'Ujian Komprehensif',
            'code' => 'UK',
            'description' => 'Test description',
            'status' => 'active'
        ]);

        $submission = ExamSubmission::create([
            'student_id' => $student1->id,
            'exam_type_id' => $examType->id,
            'submission_number' => 'SUB-20250101-0001',
            'status' => 'menunggu_verifikasi',
            'submitted_at' => now()
        ]);

        $response = $this->actingAs($student2)
            ->get("/submissions/{$submission->id}");

        $response->assertStatus(404);
    }

    public function test_unauthenticated_user_cannot_access_protected_routes()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/submissions');
        $response->assertRedirect('/login');

        $response = $this->get('/exam-types');
        $response->assertRedirect('/login');
    }
}
