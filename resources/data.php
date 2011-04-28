<?php

// This function should actually be a static method on Folder
// that can be shared w/ Client and Category, but PHP's OO-
// support seems a little to shaky to properly do so, in 
// particular because static methods don't have access to 
// the leaf class that's calling them.
function search($base, $cls, $parent = NULL) {
    $files = scandir($base);
    $directories = array();
    foreach ($files as $file) {
        $path = $base . "/" . $file;
        if (is_dir($path) && strpos($file, '.') !== 0) {
            array_push($directories, new $cls($path, $parent));
        }
    }
    return $directories;
}

class Folder {    
    public function __construct($path) {
        $this->path = $path;
        $this->last_changed = filemtime($path);
        $this->last_changed_iso = date(DATE_ISO8601, $this->last_changed);
        $this->humanize_name();
    }
    
    public function humanize_name() {
        $folder = array_pop(explode('/', $this->path));
        $this->machine_name = $folder;
        $this->name = str_replace(array('_', '-'), ' ', $folder);
    }
    
    public function get_absolute_url() {
        global $clean_urls;
        
        $path = CR_BASE_URL . $this->get_url_path();
        if ($clean_urls) {
            return $path;
        } else {
            return "/?q=" . $path;
        }
    }

    public static function cmp($a, $b) {
        return $a->last_changed < $b->last_changed;
    }
}

class Client extends Folder {
    public function __construct($path) {
        parent::__construct($path);
        $this->categories = Category::search($path, $this);
        $this->sort();
    }
    
    public static function search($base) {
        return search($base, 'Client');
    }

    public function sort() {
        usort($this->categories, array('Folder', 'cmp'));
    }
    
    public function get_url_path() {
        return "/" . $this->machine_name . "/";
    }
}

class Category extends Folder {
    public function __construct($path, $client) {
        parent::__construct($path);
        $this->client = $client;
        $this->concepts = Concept::search($path, $this);
        $this->sort();
    }
    
    public static function search($base, $parent) {
        return search($base, 'Category', $parent);
    }

    public function sort() {
        usort($this->concepts, array('Folder', 'cmp'));
    }
    
    public function get_url_path() {
        return $this->client->get_url_path() . $this->name . "/";
    }
}

class Concept extends Folder {
    public static function search($base, $category) {
        $garbage = array('.', '..', '.DS_Store', 'Thumbs.db');
        $types = array('png','jpeg','jpg','gif');    

        $files = scandir($base);
        $images = array();
        foreach ($files as $file) {
            $filetype = array_pop(explode('.', $file));
            if (!in_array($file, $garbage) and in_array($filetype, $types)) {
                array_push($images, new Concept($base . "/" . $file, $category));
            }
        }
        return $images;
    }
    
    public function __construct($path, $category) {
        parent::__construct($path);
        $this->category = $category;
    }
    
    public function humanize_name () {
        $info = pathinfo($this->path); 
        $name =  basename($this->path, '.' . $info['extension']);
        $this->machine_name = $name;
        $this->name = str_replace(array('_', '-'), ' ', $name);        
    }
    
    public function get_url_path() {
        return $this->category->get_url_path() . $this->name . "/";
    }
}

class License {
    public function __construct($code, $email) {
        $this->code = $code;
        $this->email = $email;
        $this->domain = str_replace('www.','',$_SERVER['SERVER_NAME']);
    }
    
    public function is_verified() {
        $salt = substr($this->email, 0, 4) . 'w3qwe' . substr($this->domain, -4);
        $code = sha1($this->email . $salt . $this->domain);
        if (CR_CODE == $code) {
            return true;
        } else {
            return false;
        }
    }
}