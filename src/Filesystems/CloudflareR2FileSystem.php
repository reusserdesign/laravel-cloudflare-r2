<?php

namespace Reusser\CloudflareR2\Filesystems;

use Aws\S3\S3Client;
use Illuminate\Support\Arr;
use League\Flysystem\Visibility;
use Illuminate\Filesystem\AwsS3V3Adapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\PathPrefixing\PathPrefixedAdapter;
use League\Flysystem\ReadOnly\ReadOnlyFilesystemAdapter;
use League\Flysystem\FilesystemAdapter as FlysystemAdapter;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter as AwsS3PortableVisibilityConverter;
use Reusser\CloudflareR2\Adapters\CloudflareR2Adapter;

class CloudflareR2FileSystem
{
    public static function create(array $config)
    {
        $s3Config = static::formatS3Config($config);

        $root = (string) ($s3Config['root'] ?? '');

        $visibility = new AwsS3PortableVisibilityConverter(
            $config['visibility'] ?? Visibility::PRIVATE
        );

        $streamReads = $s3Config['stream_reads'] ?? false;

        $client = new S3Client($s3Config);
        $adapter = new CloudflareR2Adapter($client, $s3Config['bucket'], $root, $visibility, null, $config['options'] ?? [], $streamReads);

        $filesystem = static::createFlysystem($adapter, $config);

        return new AwsS3V3Adapter($filesystem, $adapter, $s3Config, $client);
    }

    /**
     * Format the given S3 configuration with the default options.
     *
     * @return array
     */
    protected static function formatS3Config(array $config)
    {
        $config += ['version' => 'latest'];

        if (!empty($config['key']) && !empty($config['secret'])) {
            $config['credentials'] = Arr::only($config, ['key', 'secret']);
        }

        if (!empty($config['token'])) {
            $config['credentials']['token'] = $config['token'];
        }

        return Arr::except($config, ['token']);
    }

    /**
     * Create a Flysystem instance with the given adapter.
     *
     * @return \League\Flysystem\FilesystemOperator
     */
    protected static function createFlysystem(FlysystemAdapter $adapter, array $config)
    {
        if ($config['read-only'] ?? false === true) {
            $adapter = new ReadOnlyFilesystemAdapter($adapter);
        }

        if (!empty($config['prefix'])) {
            $adapter = new PathPrefixedAdapter($adapter, $config['prefix']);
        }

        return new Flysystem($adapter, Arr::only($config, [
            'directory_visibility',
            'disable_asserts',
            'retain_visibility',
            'temporary_url',
            'url',
            'visibility',
        ]));
    }
}
