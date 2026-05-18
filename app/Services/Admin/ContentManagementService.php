<?php

namespace App\Services\Admin;

use App\Models\Achievement;
use App\Models\Gallery;
use App\Models\News;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class ContentManagementService
{
    private function storeImage(UploadedFile $photo, string $folder): string
    {
        // 5 MB = 5 * 1024 * 1024 = 5242880 bytes
        if ($photo->getSize() > 5242880) {
            try {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($photo->getRealPath());

                // Resize proportionally to a max of 1920x1920
                $image->scaleDown(1920, 1920);

                // Generate a secure filename with .jpg since we convert to jpeg
                $filename = Str::random(40) . '.jpg';
                $path = $folder . '/' . $filename;

                // Ensure directory exists
                Storage::disk('public')->makeDirectory($folder);

                // Encode as JPEG with 75% quality to save space
                $fullPath = Storage::disk('public')->path($path);
                $image->encode(new JpegEncoder(75))->save($fullPath);

                return $path;
            } catch (\Throwable $e) {
                // Fallback to original upload if compression fails
                return $photo->store($folder, 'public');
            }
        }

        return $photo->store($folder, 'public');
    }

    public function listNews()
    {
        return News::query()
            ->orderBy('publish_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function createNews(array $payload, ?UploadedFile $photo): News
    {
        if ($photo) {
            $payload['photo_path'] = $this->storeImage($photo, 'news');
        }

        unset($payload['photo']);

        return News::query()->create($payload);
    }

    public function updateNews(News $news, array $payload, ?UploadedFile $photo): News
    {
        if ($photo) {
            if ($news->photo_path && Storage::disk('public')->exists($news->photo_path)) {
                Storage::disk('public')->delete($news->photo_path);
            }

            $payload['photo_path'] = $this->storeImage($photo, 'news');
        }

        unset($payload['photo']);
        $news->update($payload);

        return $news->fresh();
    }

    public function deleteNews(News $news): void
    {
        if ($news->photo_path && Storage::disk('public')->exists($news->photo_path)) {
            Storage::disk('public')->delete($news->photo_path);
        }

        $news->delete();
    }

    public function listAchievements()
    {
        return Achievement::query()
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function createAchievement(array $payload, ?UploadedFile $photo): Achievement
    {
        if (($payload['type'] ?? null) === 'club') {
            $payload['member_id'] = null;
        }

        if ($photo) {
            $payload['photo_path'] = $this->storeImage($photo, 'achievements');
        }

        unset($payload['photo']);

        return Achievement::query()->create($payload);
    }

    public function updateAchievement(Achievement $achievement, array $payload, ?UploadedFile $photo): Achievement
    {
        $type = $payload['type'] ?? $achievement->type;
        if ($type === 'club') {
            $payload['member_id'] = null;
        }

        if ($photo) {
            if ($achievement->photo_path && Storage::disk('public')->exists($achievement->photo_path)) {
                Storage::disk('public')->delete($achievement->photo_path);
            }

            $payload['photo_path'] = $this->storeImage($photo, 'achievements');
        }

        unset($payload['photo']);
        $achievement->update($payload);

        return $achievement->fresh();
    }

    public function deleteAchievement(Achievement $achievement): void
    {
        if ($achievement->photo_path && Storage::disk('public')->exists($achievement->photo_path)) {
            Storage::disk('public')->delete($achievement->photo_path);
        }

        $achievement->delete();
    }

    public function listGalleries()
    {
        return Gallery::query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function createGallery(array $payload, ?UploadedFile $photo): Gallery
    {
        if ($photo) {
            $payload['photo_path'] = $this->storeImage($photo, 'galleries');
        }

        unset($payload['photo']);

        return Gallery::query()->create($payload);
    }

    public function updateGallery(Gallery $gallery, array $payload, ?UploadedFile $photo): Gallery
    {
        if ($photo) {
            if ($gallery->photo_path && Storage::disk('public')->exists($gallery->photo_path)) {
                Storage::disk('public')->delete($gallery->photo_path);
            }

            $payload['photo_path'] = $this->storeImage($photo, 'galleries');
        }

        unset($payload['photo']);
        $gallery->update($payload);

        return $gallery->fresh();
    }

    public function deleteGallery(Gallery $gallery): void
    {
        if ($gallery->photo_path && Storage::disk('public')->exists($gallery->photo_path)) {
            Storage::disk('public')->delete($gallery->photo_path);
        }

        $gallery->delete();
    }
}
