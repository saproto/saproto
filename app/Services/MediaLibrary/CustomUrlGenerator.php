<?php

namespace App\Services\MediaLibrary;

use DateTimeInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;

class CustomUrlGenerator extends BaseUrlGenerator
{
    public function getUrl(): string
    {
        $public_disks = ['public', 'garage-public'];
        $isPrivateConversion = $this->conversion instanceof Conversion && ! in_array($this->media->conversions_disk, $public_disks);
        $isPrivateOriginal = ! $this->conversion instanceof Conversion && ! in_array($this->media->disk, $public_disks);
        if ($isPrivateConversion || $isPrivateOriginal) {
            return route('media::show', [
                'id' => $this->media->id,
                'conversion' => $this->conversion?->getName(),
            ]);
        }

        $url = $this->versionUrl($this->getDisk()->url($this->getPathRelativeToRoot()));

        // do not cache the garage disk via cloudflare for now
        $conversionOnGarage = $this->conversion instanceof Conversion && $this->media->conversions_disk == 'garage-public';
        $originalOnGarage = ! $this->conversion instanceof Conversion && $this->media->disk == 'garage-public';
        if (Config::get('app-proto.assets-domain') != null && ! $conversionOnGarage && ! $originalOnGarage) {
            return str_replace(Config::string('app-proto.primary-domain'), Config::string('app-proto.assets-domain'), $url);
        }

        return $url;
    }

    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return $this->getDisk()->temporaryUrl($this->getPathRelativeToRoot(), $expiration, $options);
    }

    public function getBaseMediaDirectoryUrl(): string
    {
        return $this->getDisk()->url('/');
    }

    public function getPath(): string
    {
        return $this->getRootOfDisk().$this->getPathRelativeToRoot();
    }

    public function getResponsiveImagesDirectoryUrl(): string
    {
        $public_disks = ['public', 'garage-public'];
        $isPrivateConversion = $this->conversion instanceof Conversion && ! in_array($this->media->conversions_disk, $public_disks);
        $isPrivateOriginal = ! $this->conversion instanceof Conversion && ! in_array($this->media->disk, $public_disks);
        if ($isPrivateConversion || $isPrivateOriginal) {
//            dd($this->media);
            return route('responsive::show', [
                'id' => $this->pathGenerator->getPathForResponsiveImages($this->media),
            ]);
        }
//
//        $path = $this->pathGenerator->getPathForResponsiveImages($this->media);
//
//        $diskName = $this->media->conversions_disk;
//
//        return Str::finish(Storage::disk($diskName)->url($path), '/');
    }

    protected function getRootOfDisk(): string
    {
        return $this->getDisk()->path('/');
    }
}
