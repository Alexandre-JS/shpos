<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    protected array $allowed = ['image/jpeg', 'image/png', 'image/webp'];
    protected int $maxSize = 2_048_000; // 2MB

    /**
     * Upload com criação de duas versões (800x800 e 400x400). Retorna caminho público da versão grande.
     */
    public function upload(UploadedFile $file, string $directory = 'uploads'): string
    {
        if (! in_array($file->getMimeType(), $this->allowed)) {
            throw new Exception('Formato inválido');
        }
        if ($file->getSize() > $this->maxSize) {
            throw new Exception('Ficheiro muito grande');
        }
        $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        if ($extension === 'jpeg') {
            $extension = 'jpg';
        }
        $filenameBase = uniqid('img_', true);
        $filename = $filenameBase . '.' . $extension;
        $relative = $directory . '/' . $filename;

        $stored = $file->storeAs($directory, $filename, 'public');
        $abs = Storage::disk('public')->path($stored);

        $this->resizeAndCanvas($abs, 800, 800); // grande
        $smallFilename = $filenameBase . '_sm.' . $extension;
        $smallRel = $directory . '/' . $smallFilename;
        copy($abs, Storage::disk('public')->path($smallRel));
        $this->resizeAndCanvas(Storage::disk('public')->path($smallRel), 400, 400);

        return 'storage/' . $relative;
    }

    public function delete(?string $publicPath): void
    {
        if (!$publicPath) return;
        $relative = str_replace('storage/', '', $publicPath);
        $disk = Storage::disk('public');
        if ($disk->exists($relative)) {
            $disk->delete($relative);
        }
        $info = pathinfo($relative);
        $small = $info['dirname'] . '/' . $info['filename'] . '_sm.' . ($info['extension'] ?? 'jpg');
        if ($disk->exists($small)) {
            $disk->delete($small);
        }
    }

    protected function resizeAndCanvas(string $absolutePath, int $targetW, int $targetH): void
    {
        [$w, $h, $type] = @getimagesize($absolutePath);
        if (!$w || !$h) return;
        $src = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($absolutePath),
            IMAGETYPE_PNG => @imagecreatefrompng($absolutePath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($absolutePath) : null,
            default => null,
        };
        if (!$src) return;
        $scale = min($targetW / $w, $targetH / $h);
        $newW = (int) floor($w * $scale);
        $newH = (int) floor($h * $scale);
        $dst = imagecreatetruecolor($targetW, $targetH);
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);
        $dstX = (int) floor(($targetW - $newW) / 2);
        $dstY = (int) floor(($targetH - $newH) / 2);
        imagecopyresampled($dst, $src, $dstX, $dstY, 0, 0, $newW, $newH, $w, $h);
        $ext = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
        match ($ext) {
            'jpg', 'jpeg' => imagejpeg($dst, $absolutePath, 85),
            'png' => imagepng($dst, $absolutePath, 6),
            'webp' => function_exists('imagewebp') ? imagewebp($dst, $absolutePath, 80) : imagejpeg($dst, $absolutePath, 85),
            default => imagejpeg($dst, $absolutePath, 85),
        };
        imagedestroy($src);
        imagedestroy($dst);
    }
}
