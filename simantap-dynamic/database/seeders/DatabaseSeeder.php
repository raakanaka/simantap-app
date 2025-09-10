<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Admin;
use App\Models\Lecturer;
use App\Models\ExamType;
use App\Models\ExamRequirement;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Students
        $studentsData = json_decode(file_get_contents('/home/nunians/Documents/simantap-simple/data/students.json'), true);
        foreach ($studentsData as $studentData) {
            // Hash password dengan Bcrypt
            $studentData['password'] = Hash::make($studentData['password']);
            Student::create($studentData);
        }

        // Seed Admins
        $adminsData = json_decode(file_get_contents('/home/nunians/Documents/simantap-simple/data/admins.json'), true);
        foreach ($adminsData as $adminData) {
            // Hash password dengan Bcrypt
            $adminData['password'] = Hash::make($adminData['password']);
            Admin::create($adminData);
        }

        // Seed Study Programs first
        $this->call(StudyProgramSeeder::class);

        // Seed Lecturers
        $lecturersData = json_decode(file_get_contents('/home/nunians/Documents/simantap-simple/data/lecturers.json'), true);
        $studyPrograms = StudyProgram::all();
        
        foreach ($lecturersData as $lecturerData) {
            // Hash password dengan Bcrypt
            $lecturerData['password'] = Hash::make($lecturerData['password']);
            // Assign random study program to each lecturer
            $lecturerData['study_program_id'] = $studyPrograms->random()->id;
            Lecturer::create($lecturerData);
        }

        // Seed Exam Types
        $examTypesData = json_decode(file_get_contents('/home/nunians/Documents/simantap-simple/data/exam-types.json'), true);
        foreach ($examTypesData as $examTypeData) {
            ExamType::create($examTypeData);
        }

        // Seed Exam Requirements
        $examRequirementsData = json_decode(file_get_contents('/home/nunians/Documents/simantap-simple/data/exam-requirements.json'), true);
        foreach ($examRequirementsData as $requirementData) {
            ExamRequirement::create($requirementData);
        }
    }
}
