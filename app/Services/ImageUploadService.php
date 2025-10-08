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
     * Upload gera 3 variantes: original normalizada (máx 1200x1200), _lg (800x800), _sm (400x400).
     * Retorna caminho público da variante _lg (para uso principal). Mantemos original processada para futuros crops.
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
        // Original base (normalizada até 1200)
        $origFilename = $filenameBase . '.' . $extension;
        $origRel = $directory . '/' . $origFilename;
        $stored = $file->storeAs($directory, $origFilename, 'public');
        $absOrig = Storage::disk('public')->path($stored);
        $this->resizeAndCanvas($absOrig, 1200, 1200, preventUpscale: true);

        // Variante grande (_lg)
        $lgFilename = $filenameBase . '_lg.' . $extension;
        $lgRel = $directory . '/' . $lgFilename;
        copy($absOrig, Storage::disk('public')->path($lgRel));
        $this->resizeAndCanvas(Storage::disk('public')->path($lgRel), 800, 800, preventUpscale: true);

        // Variante pequena (_sm)
        $smFilename = $filenameBase . '_sm.' . $extension;
        $smRel = $directory . '/' . $smFilename;
        copy($absOrig, Storage::disk('public')->path($smRel));
        $this->resizeAndCanvas(Storage::disk('public')->path($smRel), 400, 400, preventUpscale: true);

        // Retornamos _lg por ser a principal para visualização
        return 'storage/' . $lgRel;
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

    protected function resizeAndCanvas(string $absolutePath, int $targetW, int $targetH, bool $preventUpscale = false): void
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
        if ($preventUpscale && $scale > 1) {
            // Não aumenta: apenas centraliza em canvas branco
            $scale = 1;
        }
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
