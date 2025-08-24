<?php

namespace App\Constants;

class ExamConstants
{
    // Exam Types
    const EXAM_TYPE_KOMPREHENSIF = 'UK';
    const EXAM_TYPE_SEMINAR_PROPOSAL_ARTIKEL = 'SPDAJI';
    const EXAM_TYPE_SEMINAR_PROPOSAL_SKRIPSI = 'SPS';
    const EXAM_TYPE_SIDANG_KOLOKIUM = 'SKJ';
    const EXAM_TYPE_SIDANG_MUNAQASYAH = 'SMS';

    // Submission Status
    const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    const STATUS_BERKAS_DITERIMA = 'berkas_diterima';
    const STATUS_BERKAS_DITOLAK = 'berkas_ditolak';

    // Document Status
    const DOCUMENT_STATUS_UPLOADED = 'uploaded';
    const DOCUMENT_STATUS_VERIFIED = 'verified';
    const DOCUMENT_STATUS_REJECTED = 'rejected';

    // File Types
    const ALLOWED_FILE_TYPES = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
    ];

    // File Size Limits (in KB)
    const MAX_FILE_SIZE = 20480; // 20MB
    const MAX_DOCUMENT_SIZE = 2048; // 2MB
    const MAX_IMAGE_SIZE = 1024; // 1MB

    // Exam Type Names
    const EXAM_TYPE_NAMES = [
        self::EXAM_TYPE_KOMPREHENSIF => 'Ujian Komprehensif',
        self::EXAM_TYPE_SEMINAR_PROPOSAL_ARTIKEL => 'Seminar Proposal Draf Artikel Jurnal Ilmiah',
        self::EXAM_TYPE_SEMINAR_PROPOSAL_SKRIPSI => 'Seminar Proposal Skripsi',
        self::EXAM_TYPE_SIDANG_KOLOKIUM => 'Sidang Kolokium Jurnal',
        self::EXAM_TYPE_SIDANG_MUNAQASYAH => 'Sidang Munaqasyah Skripsi',
    ];

    // Status Labels
    const STATUS_LABELS = [
        self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
        self::STATUS_BERKAS_DITERIMA => 'Berkas Diterima',
        self::STATUS_BERKAS_DITOLAK => 'Berkas Ditolak',
    ];

    // Status Colors (for Bootstrap)
    const STATUS_COLORS = [
        self::STATUS_MENUNGGU_VERIFIKASI => 'warning',
        self::STATUS_BERKAS_DITERIMA => 'success',
        self::STATUS_BERKAS_DITOLAK => 'danger',
    ];

    // Document Status Labels
    const DOCUMENT_STATUS_LABELS = [
        self::DOCUMENT_STATUS_UPLOADED => 'Uploaded',
        self::DOCUMENT_STATUS_VERIFIED => 'Verified',
        self::DOCUMENT_STATUS_REJECTED => 'Rejected',
    ];

    // Document Status Colors
    const DOCUMENT_STATUS_COLORS = [
        self::DOCUMENT_STATUS_UPLOADED => 'secondary',
        self::DOCUMENT_STATUS_VERIFIED => 'success',
        self::DOCUMENT_STATUS_REJECTED => 'danger',
    ];
}
