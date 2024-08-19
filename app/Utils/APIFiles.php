<?php

namespace App\Utils;

class APIFiles {
    private array $files = [
        'type' => [],
        'url' => [],
    ];
    
    public function setTypes(array $types): self {
        $this->files['type'] = $types;

        return $this;
    }

    public function pushType(string $type): self {
        array_push($this->files['type'], $type);

        return $this;
    }

    public function mergeType(array $types): self {
        array_merge($this->files['type'], $types);

        return $this;
    }

    public function setUrls(array $urls): self {
        $this->files['url'] = $urls;

        return $this;
    }

    public function pushUrl(string $url): self {
        array_push($this->files['url'], $url);

        return $this;
    }

    public function mergeUrl(array $urls): self {
        array_merge($this->files['url'], $urls);

        return $this;
    }
    
    public function getFiles() {
        return $this->files;
    }
}