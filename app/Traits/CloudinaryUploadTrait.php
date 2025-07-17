<?php

namespace App\Traits;


use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;

trait CloudinaryUploadTrait
{
    /**
     * Initialize Cloudinary instance
     */
    private function getCloudinaryInstance()
    {
        return new Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name') ?? env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => config('services.cloudinary.api_key') ?? env('CLOUDINARY_API_KEY'),
                'api_secret' => config('services.cloudinary.api_secret') ?? env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }

    /**
     * Upload image to Cloudinary
     * 
     * @param mixed $file The file to upload
     * @param string $folder The folder to store the file in
     * @param array $options Additional upload options
     * @return array Upload result with secure_url and public_id
     */
    public function uploadImageToCloudinary($file, string $folder = 'uploads', array $options = [])
    {
        try {
            $cloudinary = $this->getCloudinaryInstance();
            
            $defaultOptions = [
                'folder' => $folder,
                'resource_type' => 'image',
                'quality' => 'auto',
                'fetch_format' => 'auto'
            ];
            
            $uploadOptions = array_merge($defaultOptions, $options);
            
            $result = $cloudinary->uploadApi()->upload($file->getRealPath(), $uploadOptions);
            
            return [
                'success' => true,
                'secure_url' => $result['secure_url'],
                'public_id' => $result['public_id'],
                'width' => $result['width'] ?? null,
                'height' => $result['height'] ?? null,
                'format' => $result['format'] ?? null,
                'bytes' => $result['bytes'] ?? null
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary image upload error: ' . $e->getMessage(), [
                'folder' => $folder,
                'file_name' => $file->getClientOriginalName() ?? 'unknown'
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Upload video to Cloudinary
     * 
     * @param mixed $file The video file to upload
     * @param string $folder The folder to store the file in
     * @param array $options Additional upload options
     * @return array Upload result with secure_url and public_id
     */
    public function uploadVideoToCloudinary($file, string $folder = 'videos', array $options = [])
    {
        try {
            $cloudinary = $this->getCloudinaryInstance();
            
            $defaultOptions = [
                'folder' => $folder,
                'resource_type' => 'video',
                'quality' => 'auto',
                'format' => 'mp4'
            ];
            
            $uploadOptions = array_merge($defaultOptions, $options);
            
            $result = $cloudinary->uploadApi()->upload($file->getRealPath(), $uploadOptions);
            
            return [
                'success' => true,
                'secure_url' => $result['secure_url'],
                'public_id' => $result['public_id'],
                'duration' => $result['duration'] ?? null,
                'width' => $result['width'] ?? null,
                'height' => $result['height'] ?? null,
                'format' => $result['format'] ?? null,
                'bytes' => $result['bytes'] ?? null
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary video upload error: ' . $e->getMessage(), [
                'folder' => $folder,
                'file_name' => $file->getClientOriginalName() ?? 'unknown'
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Upload multiple files to Cloudinary
     * 
     * @param array $files Array of files to upload
     * @param string $folder The folder to store files in
     * @param string $type Type of files ('image' or 'video')
     * @param array $options Additional upload options
     * @return array Array of upload results
     */
    public function uploadMultipleToCloudinary(array $files, string $folder = 'uploads', string $type = 'image', array $options = [])
    {
        $results = [];
        
        foreach ($files as $index => $file) {
            if ($type === 'video') {
                $result = $this->uploadVideoToCloudinary($file, $folder, $options);
            } else {
                $result = $this->uploadImageToCloudinary($file, $folder, $options);
            }
            
            $results[$index] = $result;
        }
        
        return $results;
    }

    /**
     * Upload with thumbnail generation for videos
     * 
     * @param mixed $file The video file to upload
     * @param string $folder The folder to store the file in
     * @param array $thumbnailOptions Options for thumbnail generation
     * @return array Upload result with thumbnail info
     */
    public function uploadVideoWithThumbnail($file, string $folder = 'videos', array $thumbnailOptions = [])
    {
        $defaultThumbnailOptions = [
            'width' => 300,
            'height' => 200,
            'crop' => 'fill',
            'format' => 'jpg',
            'resource_type' => 'image'
        ];
        
        $thumbnailConfig = array_merge($defaultThumbnailOptions, $thumbnailOptions);
        
        $options = [
            'eager' => [$thumbnailConfig]
        ];
        
        return $this->uploadVideoToCloudinary($file, $folder, $options);
    }

    /**
     * Delete file from Cloudinary
     * 
     * @param string $publicId The public ID of the file to delete
     * @param string $resourceType The type of resource ('image' or 'video')
     * @return array Deletion result
     */
    public function deleteFromCloudinary(string $publicId, string $resourceType = 'image')
    {
        try {
            $cloudinary = $this->getCloudinaryInstance();
            
            $result = $cloudinary->uploadApi()->destroy($publicId, [
                'resource_type' => $resourceType
            ]);
            
            return [
                'success' => $result['result'] === 'ok',
                'result' => $result['result']
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary delete error: ' . $e->getMessage(), [
                'public_id' => $publicId,
                'resource_type' => $resourceType
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate transformed URL for existing Cloudinary asset
     * 
     * @param string $publicId The public ID of the asset
     * @param array $transformations Array of transformations to apply
     * @param string $resourceType The type of resource ('image' or 'video')
     * @return string Transformed URL
     */
    public function getTransformedUrl(string $publicId, array $transformations = [], string $resourceType = 'image')
    {
        try {
            $cloudinary = $this->getCloudinaryInstance();
            
            if ($resourceType === 'video') {
                return $cloudinary->video($publicId)->toUrl($transformations);
            } else {
                return $cloudinary->image($publicId)->toUrl($transformations);
            }
        } catch (\Exception $e) {
            Log::error('Cloudinary URL generation error: ' . $e->getMessage(), [
                'public_id' => $publicId,
                'transformations' => $transformations
            ]);
            
            return '';
        }
    }

    /**
     * Get file information from Cloudinary
     * 
     * @param string $publicId The public ID of the asset
     * @param string $resourceType The type of resource ('image' or 'video')
     * @return array File information
     */
    public function getCloudinaryFileInfo(string $publicId, string $resourceType = 'image')
    {
        try {
            $cloudinary = $this->getCloudinaryInstance();
            
            $result = $cloudinary->adminApi()->asset($publicId, [
                'resource_type' => $resourceType
            ]);
            
            return [
                'success' => true,
                'data' => $result
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary file info error: ' . $e->getMessage(), [
                'public_id' => $publicId,
                'resource_type' => $resourceType
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
