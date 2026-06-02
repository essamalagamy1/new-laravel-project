<?php

namespace App\Actions\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;

class GenerateRandomImageAction
{
    public function execute(HasMedia&Model $model, string $collection = 'image', string $disk = 'public'): void
    {
        $stubPath = base_path('public/png.png');
        if (! file_exists($stubPath)) {
            throw new \RuntimeException('Stub image not found.');
        }
        // Prevent duplicates if re-seeding
        if ($model->getMedia($collection)->isNotEmpty()) {
            return;
        }

        $model->addMedia($stubPath)->preservingOriginal()->usingName(Str::random(10).'-'.time())->toMediaCollection($collection, $disk);
    }

    public function executeSvg(HasMedia&Model $model, string $collection = 'image', string $disk = 'public'): void
    {
        $stubPath = base_path('public/600x400.svg');
        if (! file_exists($stubPath)) {
            throw new \RuntimeException('Stub image not found.');
        }
        // Prevent duplicates if re-seeding
        if ($model->getMedia($collection)->isNotEmpty()) {
            return;
        }

        $model->addMedia($stubPath)->preservingOriginal()->usingName(Str::random(10).'-'.time())->toMediaCollection($collection, $disk);
    }
}
