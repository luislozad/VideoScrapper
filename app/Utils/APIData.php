<?php

namespace App\Utils;

class APIData {
    private string $platform;
    private APIFiles $files;

    private string $title = '';
    private string $cover = '';

    private int $code = -1;
    private string $id = '';
    public function __construct(string $platform) {
        $this->platform = $platform;
        $this->files = new APIFiles();
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }

    public function setCover(string $cover): self {
        $this->cover = $cover;

        return $this;
    }

    public function setID(string $id): self {
        $this->id = $id;

        return $this;
    }

    public function error(int $code): self {
        $this->code = $code;
        return $this;
    }

    public function success(int $code): self {
        $this->code = $code;
        return $this;
    }

    public function addFiles() : APIFiles {
        return $this->files;
    }

    public function build(): array {
        if ($this->code < 0) {
            return [
                'code' => $this->code
            ];
        }

        return [
            'code'=> $this->code,
            'platform' => $this->platform,
            'file' => $this->files->getFiles(),
            'title' => $this->title,
            'cover' => $this->cover,
            'id' => $this->id,            
        ];
    }
}