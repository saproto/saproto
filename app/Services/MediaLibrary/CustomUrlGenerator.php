<?php

namespace App\Services\MediaLibrary;

use DateTimeInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;

class CustomUrlGenerator extends BaseUrlGenerator
{
    public function getUrl(): string
    {
        if ($this->media->disk === 'local') {
            return route('media::show', [
                'id' => $this->media->id,
                'conversion' => null,
            ]);
        }
        $url = $this->versionUrl($this->getDisk()->url($this->getPathRelativeToRoot()));

        if (Config::get('app-proto.assets-domain') != null) {
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
        $path = $this->pathGenerator->getPathForResponsiveImages($this->media);

        return Str::finish($this->getDisk()->url($path), '/');
    }

    protected function getRootOfDisk(): string
    {
        return $this->getDisk()->path('/');
    }
}
