<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ExamType;
use App\Models\ExamRequirement;

class ExamSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $examTypeId = $this->route('examType');
        $examType = ExamType::find($examTypeId);
        
        $rules = [];
        
        if ($examType) {
            $requirements = $examType->requirements()->required()->get();
            
            foreach ($requirements as $requirement) {
                $fieldName = "documents.{$requirement->id}";
                $rules[$fieldName] = 'required|file|max:20480'; // 20MB max
                
                // Add file type validation if specified
                if ($requirement->file_types) {
                    $allowedTypes = explode(',', $requirement->file_types);
                    $mimeTypes = [];
                    
                    foreach ($allowedTypes as $type) {
                        $type = trim($type);
                        switch ($type) {
                            case 'pdf':
                                $mimeTypes[] = 'application/pdf';
                                break;
                            case 'doc':
                                $mimeTypes[] = 'application/msword';
                                break;
                            case 'docx':
                                $mimeTypes[] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                                break;
                            case 'jpg':
                            case 'jpeg':
                                $mimeTypes[] = 'image/jpeg';
                                break;
                            case 'png':
                                $mimeTypes[] = 'image/png';
                                break;
                        }
                    }
                    
                    if (!empty($mimeTypes)) {
                        $rules[$fieldName] .= '|mimes:' . implode(',', $allowedTypes);
                    }
                }
            }
        }
        
        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        $examTypeId = $this->route('examType');
        $examType = ExamType::find($examTypeId);
        
        $messages = [];
        
        if ($examType) {
            $requirements = $examType->requirements()->required()->get();
            
            foreach ($requirements as $requirement) {
                $fieldName = "documents.{$requirement->id}";
                $messages[$fieldName . '.required'] = "Dokumen '{$requirement->document_name}' wajib diupload.";
                $messages[$fieldName . '.file'] = "Dokumen '{$requirement->document_name}' harus berupa file.";
                $messages[$fieldName . '.max'] = "Dokumen '{$requirement->document_name}' maksimal 20MB.";
                
                if ($requirement->file_types) {
                    $allowedTypes = explode(',', $requirement->file_types);
                    $messages[$fieldName . '.mimes'] = "Dokumen '{$requirement->document_name}' harus berformat: " . strtoupper(implode(', ', $allowedTypes));
                }
            }
        }
        
        return $messages;
    }
}
