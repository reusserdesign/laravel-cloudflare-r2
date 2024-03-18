<?php

namespace Reusser\CloudflareR2\Adapters;

use League\Flysystem\FileAttributes;
use League\Flysystem\UnableToSetVisibility;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;

class CloudflareR2Adapter extends AwsS3V3Adapter
{
    public function setVisibility(string $path, string $visibility): void
    {
        throw UnableToSetVisibility::atLocation($path, '', new \Exception('Setting visibility is not supported with R2.'));
    }

    public function visibility(string $path): FileAttributes
    {
        $visibility = 'private';

        return new FileAttributes($path, null, $visibility);
    }
}
