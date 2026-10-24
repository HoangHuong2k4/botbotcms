<?php

namespace Dev\Media\Chunks\Storage;

use Dev\Media\Chunks\ChunkFile;
use Dev\Media\Facades\AppMedia;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ChunkStorage
{
    public const CHUNK_EXTENSION = 'part';

    protected FilesystemAdapter $disk;

    protected string $directory;

    public function __construct()
    {
        $config = AppMedia::getConfig('chunk.storage');

        $this->disk = Storage::disk($config['disk'] ?? 'local');
        $this->directory = $config['chunks'] ?? 'chunks';
    }

    public static function storage(): self
    {
        return app(static::class);
    }

    public function disk(): FilesystemAdapter
    {
        return $this->disk;
    }

    public function directory(): string
    {
        return $this->directory . '/';
    }

    public function getDiskPathPrefix(): string
    {
        return $this->disk->path('');
    }

    public function files(?\Closure $filter = null): Collection
    {
        $files = collect($this->disk->files($this->directory()));

        if ($filter) {
            $files = $files->reject($filter);
        }

        return $files;
    }

    public function allFiles(): Collection
    {
        return $this->files()
            ->filter(fn (string $file) => str_ends_with($file, '.' . self::CHUNK_EXTENSION))
            ->map(fn (string $file) => new ChunkFile($file, $this->disk->lastModified($file), $this));
    }

    public function oldChunkFiles(): Collection
    {
        $timestamp = strtotime(AppMedia::getConfig('chunk.clear.timestamp', '-3 HOURS'));

        return $this->allFiles()
            ->filter(fn (ChunkFile $file) => $file->getModifiedTime() < $timestamp);
    }
}
