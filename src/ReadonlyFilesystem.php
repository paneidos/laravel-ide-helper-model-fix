<?php

namespace Paneidos\LaravelIdeHelper;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ReadOnlyFilesystem extends Filesystem
{
    /**
     * @var array
     */
    private $only;
    /**
     * @var array
     */
    private $except;

    public function __construct($only = [], $except = []) {
        $this->only = (array)($only ?? []);
        $this->except = (array)($except ?? []);
    }

    private function _shouldBlock($path) : bool {
        if (count($this->only)) {
            return Str::is($this->only, $path);
        }
        if (count($this->except)) {
            return !Str::is($this->except, $path);
        }
        return true;
    }

    public function put($path, $contents, $lock = false) {
        if ($this->_shouldBlock($path)) {
            return strlen($contents);
        }
        return parent::put($path, $contents, $lock);
    }

    public function append($path, $data) {
        if ($this->_shouldBlock($path)) {
            return strlen($data);
        }
        return parent::append($path, $data);
    }

    public function chmod($path, $mode = null) {
        if ($mode && $this->_shouldBlock($path)) {
            return true;
        }
        return parent::chmod($path, $mode);
    }

    public function delete($paths) {
        $paths = array_filter($paths, function($path) {
            return !$this->_shouldBlock($path);
        });
        if (count($paths)) {
            return parent::delete($paths);
        } else {
            return true;
        }
    }

    public function move($path, $target) {
        if ($this->_shouldBlock($path) || $this->_shouldBlock($target)) {
            return true;
        }
        return parent::move($path, $target);
    }

    public function copy($path, $target) {
        if ($this->_shouldBlock($path) || $this->_shouldBlock($target)) {
            return true;
        }
        return parent::copy($path, $target);
    }

    public function link($target, $link) {
        if ($this->_shouldBlock($link) || $this->_shouldBlock($target)) {
            return;
        }
        parent::link($target, $link);
    }

    public function makeDirectory($path, $mode = 0755, $recursive = false, $force = false) {
        if ($this->_shouldBlock($path)) {
            return true;
        }
        return parent::makeDirectory($path, $mode, $recursive, $force);
    }

    public function moveDirectory($from, $to, $overwrite = false) {
        if ($this->_shouldBlock($from) || $this->_shouldBlock($to)) {
            return true;
        }
        return parent::moveDirectory($from, $to, $overwrite);
    }

    public function copyDirectory($directory, $destination, $options = null) {
        if ($this->_shouldBlock($directory) || $this->_shouldBlock($destination)) {
            return true;
        }
        return parent::copyDirectory($directory, $destination, $options);
    }

    public function deleteDirectory($directory, $preserve = false) {
        if ($this->_shouldBlock($directory)) {
            return true;
        }
        return parent::deleteDirectory($directory, $preserve);
    }
}

