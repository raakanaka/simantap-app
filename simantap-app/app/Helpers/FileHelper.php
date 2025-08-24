<?php

namespace App\Helpers;

class FileHelper
{
    /**
     * Format file size to human readable format
     */
    public static function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file extension from filename
     */
    public static function getFileExtension($filename)
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }

    /**
     * Check if file type is allowed
     */
    public static function isAllowedFileType($filename, $allowedTypes)
    {
        $extension = self::getFileExtension($filename);
        $allowedTypes = array_map('trim', explode(',', $allowedTypes));
        
        return in_array($extension, $allowedTypes);
    }

    /**
     * Get MIME type for file extension
     */
    public static function getMimeType($extension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    /**
     * Generate safe filename
     */
    public static function generateSafeFilename($originalName)
    {
        $extension = self::getFileExtension($originalName);
        $timestamp = time();
        $random = uniqid();
        
        return $timestamp . '_' . $random . '.' . $extension;
    }

    /**
     * Validate file size
     */
    public static function validateFileSize($fileSize, $maxSize)
    {
        return $fileSize <= ($maxSize * 1024); // Convert KB to bytes
    }
}
