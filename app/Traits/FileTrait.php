<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileTrait
{
	/**
	 * Upload file
	 *
	 * @param UploadedFile $file
	 * @param string $path
	 * @param string $disk
	 * @return string
	 */
	public function uploadFile(UploadedFile $file, string $path = null, $disk = 'public'): string
	{
		$fileName = Str::random() . '.' . $file->getClientOriginalExtension();

		return Storage::disk($disk)->putFileAs($path, $file, $fileName);
	}

	/**
	 * Get file type (image, video, document)
	 *
	 * @param UploadedFile $file
	 * @return string|null
	 */
	public function getFileType(UploadedFile $file): string|null
	{
		$fileExtension = $file->extension();

		if (in_array($fileExtension, ['png', 'jpg', 'jpeg', 'gif'])) {
			return 'image';
		} else if (in_array($fileExtension, ['mp4', 'm4v'])) {
			return 'video';
		}

		return null;
	}

	public function deleteFile(string|null $path, $disk = 'public'): bool
	{
		if ($path && Storage::disk($disk)->exists($path)) {
			return Storage::disk($disk)->delete($path);
		}

		return false;
	}
}
