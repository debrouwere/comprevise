<?php

// This function should actually be a static method on Folder
// that can be shared w/ Client and Category, but PHP's OO-
// support seems a little to shaky to properly do so, in 
// particular because static methods don't have access to 
// the leaf class that's calling them.
function search($base, $cls, $parent = NULL) {
    if (!file_exists($base)) return array();

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
        if (file_exists($path)) {
            $this->exists = true;
            $this->last_changed = filemtime($path);
            $this->last_changed_iso = date(DATE_ISO8601, $this->last_changed);
            $this->humanize_name();        
        } else {
            $this->exists = false;
        }
    }
    
    public function humanize_name() {
        $folder = array_pop(explode('/', $this->path));
        $this->machine_name = $folder;
        $this->name = str_replace(array('_', '-'), ' ', $folder);
    }
    
    public function get_absolute_url() {
        global $clean_urls;
        
        if ($clean_urls) {
            return CR_BASE_URL . $this->get_url_path();
        } else {
            return "?q=" . $this->get_url_path();
        }
    }

    public static function cmp($a, $b) {
        return $a->last_changed < $b->last_changed;
    }
}


class Client extends Folder {
    public function __construct($path) {
        parent::__construct($path);
        // concepts can belong to categories, but can also
        // be freestanding
        $this->categories = Category::search($path, $this);
        $undefined = Category::from_client($this);
        $this->concepts = Concept::search($path, $undefined);
        $this->sort();
    }
    
    public static function search($base) {
        return search($base, 'Client');
    }
    
    public static function reverse($request) {
        $client_path = "../clients/" . $request["client"];
        $client = new Client($client_path);
        return $client;
    }

    public function sort() {
        usort($this->categories, array('Folder', 'cmp'));
        usort($this->concepts, array('Folder', 'cmp'));
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
    
    // uses the client base path rather than a category folder
    // to make a category for "leftovers".
    public static function from_client($client) {
        $uncategorized = new Category($client->path, $client);
        $uncategorized->machine_name = $uncategorized->name = "uncategorized";
        return $uncategorized;
    }
    
    public static function search($base, $parent) {
        return search($base, 'Category', $parent);
    }

    public static function reverse($request) {
        $client = Client::reverse($request);
        if ($request["category"] == "uncategorized") {
            return Category::from_client($client); 
        } else {
            $category_path = $client->path . "/" . $request["category"]; 
            return new Category($category_path, $client);
        }    
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
        if (!file_exists($base)) return array();  
    
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
    
    public static function reverse($request) {   
        $category = Category::reverse($request);    
        $concept_path = $category->path . "/" . $request["concept"];
        
        // search for extension
        $concept_path = array_shift(glob($concept_path . "*"));
        $concept = new Concept($concept_path, $category);        
        return $concept;
    }
    
    public function __construct($path, $category) {
        parent::__construct($path);
        $this->category = $category;
        
        if ($category->name == "uncategorized") {
            $this->uncategorized = true;
        } else {
            $this->uncategorized = false;
        }
    }
    
    public function humanize_name () {
        $info = pathinfo($this->path);
        $this->filename = basename($this->path);
        $name = basename($this->path, '.' . $info['extension']);
        $this->machine_name = $name;
        $this->name = str_replace(array('_', '-'), ' ', $name);        
    }
    
    public function get_url_path() {
        if ($this->category->name == "uncategorized") {
            return $this->category->client->get_url_path() . $this->machine_name . "/";
        } else {
            return $this->category->get_url_path() . $this->machine_name . "/";  
        }
    }
    
    public function get_image_url() {
        if ($this->category->name == "uncategorized") {
            $url_path = $this->category->client->get_url_path();
        } else {
            $url_path = $this->category->get_url_path();
        }
    
        return CR_BASE_URL . "/clients" . $url_path . $this->filename;
    }
}