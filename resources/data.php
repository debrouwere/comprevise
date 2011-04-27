<?php

class License {}

// This function should actually be a static method on Folder
// that can be shared w/ Client and Category, but PHP's OO-
// support seems a little to shaky to properly do so, in 
// particular because static methods don't have access to 
// the leaf class that's calling them.
function search($base, $cls) {
    $files = scandir($base);
    $directories = array();
    foreach ($files as $file) {
        $path = $base . "/" . $file;
        if (is_dir($path) && strpos($file, '.') !== 0) {
            array_push($directories, new $cls($path));
        }
    }
    return $directories;
}

class Folder {    
    public function __construct($path) {
        $this->path = $path;
        $this->humanize_name();
    }
    
    public function humanize_name() {
        $folder = array_pop(explode('/', $this->path));
        $this->name = str_replace(array('_', '-'), ' ', $folder);
    }
}

class Client extends Folder {
    public function __construct($path) {
        parent::__construct($path);
        $this->categories = Category::search($path);
    }

    public static function search($base) {
        return search($base, 'Client');
    }
}

class Category extends Folder {
    public function __construct($path) {
        parent::__construct($path);
        $this->concepts = Concept::search($path);
    }

    public static function search($base) {
        return search($base, 'Category');
    }
}

class Concept extends Folder {
    public static function search($base) {
        $garbage = array('.', '..', '.DS_Store', 'Thumbs.db');
        $types = array('png','jpeg','jpg','gif');    

        $files = scandir($base);
        $images = array();
        foreach ($files as $file) {
            $filetype = array_pop(explode('.', $file));
            if (!in_array($file, $garbage) and in_array($filetype, $types)) {
                array_push($images, new Concept($file));
            }
        }
        return $images;
    }
    
    public function humanize_name () {
        $info = pathinfo($this->path); 
        $name =  basename($this->path, '.' . $info['extension']);
        $this->name = str_replace(array('_', '-'), ' ', $name);        
    }
}