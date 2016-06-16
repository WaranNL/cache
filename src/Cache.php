<?php
namespace Waran;

class Cache {

  protected $directory = 'cache';
  protected $expire = 120;
  protected $types = ['raw', 'json'];

  public function __construct($directory = null)
  {
    $this->directory = (!is_null($directory)) ? $directory : $this->directory;
    if(!is_dir($this->directory)) mkdir($this->directory, 0777, true);
  }

  public function exists($name)
  {
    return file_exists($this->path($name));
  }

  public function write($name, $contents, $options = ['type' => 'raw'])
  {
    // If file name includes a path, create a folder when necessary.
    if(strpos($name, '/') !== false) {
      $info = pathinfo($name, PATHINFO_DIRNAME);
      $info = array_filter(explode('/', $info));
      $folder = $this->directory.'/'.implode('/', $info);
      if(!is_dir($folder)) {
        mkdir($folder, 0777, true);
      }
    }

    // Create and write the cache file.
    if($file = fopen($this->path($name), 'w')) {
      if($options['type'] == 'json') {
        $contents = json_encode($contents);
      }
      fwrite($file, $contents);
      fclose($file);
      return true;
    }

    return false;
  }

  public function read($name, $expire = 0, $options = ['type' => 'raw'])
  {
    if(!$this->expired($name, $expire)) {
      if($data = $this->fetch($name)) {
        $data = ($options['type'] == 'json') ? json_decode($data, true) : $data;
      }
      return $data;
    } else {
      return false;
    }
  }

  public function path($name)
  {
    return $this->directory.'/'.$name;
  }

  protected function fetch($name)
  {
    $data = file_get_contents($this->path($name));
    return ($data != null) ? $data : false;
  }

  protected function expired($name, $expire)
  {
    if($this->exists($name)) {
      // A cache passes the expired test if set to 0.
      if($expire == 0) {
        return false;
      }
      // Check filetime against $expire in milliseconds.
      elseif(filemtime($this->path($name)) > (time() - $expire)) {
        return false;
      }
      // Our two checks failed so it must be expired.
      else {
        return true;
      }
    } else {
      return true;
    }
  }
}