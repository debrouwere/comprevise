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

    // depending on how the application is configured, 
    // we either sort files/folders alphabetically or 
    // by when they were last changed
    public static function cmp($a, $b) {
        if (CR_SORT_ORDER == 'alphabetical') {
            $list = array($a->machine_name, $b->machine_name);
            natcasesort($list);
            if ($a->machine_name == array_shift($list)) {
                return false;
            } else {
                return true;
            }
        } else {
            return $a->last_changed > $b->last_changed;
        }
    }
    
    public function __toString() {
        return $this->machine_name;
    }
}


function is_visible($client) {
    return (strpos($client->path, '_backend') === false && strpos($client->path, '_themes') === false);
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
        $results = search($base, 'Client');
        return array_filter($results, "is_visible");
    }
    
    public static function reverse($request) {
        $client_path = "../" . $request["client"];
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


// categories have underlying concept folders
function is_category($category) {
    if (!file_exists($category->path)) return false;
    
    foreach (scandir($category->path) as $file) {
        if (substr($file, 0, 1) != '.' && is_dir($category->path . "/" . $file)) return true;
    }
    return false;
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
        $results = search($base, 'Category', $parent);
        return array_filter($results, "is_category");       
        
    }

    public static function reverse($request) {
        $client = Client::reverse($request);
        if ($request["category"] == "uncategorized") {
            return Category::from_client($client); 
        } else {
            $category_path = $client->path . "/" . $request["category"]; 
            $category = new Category($category_path, $client);
            if (is_category($category)) {
                return $category;
            } else {
                return Category::from_client($client);
            }
        }    
    }

    public function sort() {
        usort($this->concepts, array('Folder', 'cmp'));
    }
    
    public function get_latest_concept() {
        $concepts = $this->concepts;
        return array_pop($concepts);
    }
    
    public function get_url_path() {
        return $this->client->get_url_path() . $this->machine_name . "/";
    }
}


// concepts don't have underlying folders
function is_concept($concept) {
    if (!file_exists($concept->path)) return false;

    foreach (scandir($concept->path) as $file) {
        if (substr($file, 0, 1) != '.' && is_dir($concept->path . "/" . $file)) return false;
    }
    return true;
}


class Concept extends Folder {
    public static function search($base, $parent) {
        $results = search($base, 'Concept', $parent);
        return array_filter($results, "is_concept");
    }

    public static function reverse($request) {   
        $category = Category::reverse($request);    
        $concept_path = $category->path . "/" . $request["concept"];
        return new Concept($concept_path, $category);        
    }

    public function __construct($path, $category) {
        parent::__construct($path);
        $this->category = $category;
        $this->revisions = Revision::search($path, $this);
        $this->sort();
                
        if ($category->name == "uncategorized") {
            $this->uncategorized = true;
        } else {
            $this->uncategorized = false;
        }
    }

    public function sort() {
        usort($this->revisions, array('Folder', 'cmp'));
    }
    
    public function get_latest_revision() {
        $revisions = $this->revisions;
        return array_pop($revisions);
    }

    public function get_url_path() {
        if ($this->category->name == "uncategorized") {
            return $this->category->client->get_url_path() . $this->machine_name . "/";
        } else {
            return $this->category->get_url_path() . $this->machine_name . "/";  
        }
    }
}

class Revision extends Folder {
    public static function search($base, $category) {    
        if (!file_exists($base)) return array();  
    
        $garbage = array('.', '..', '.DS_Store', 'Thumbs.db');
        $types = array('png','jpeg','jpg','gif');    

        if (!file_exists($base)) return array();
        $files = scandir($base);
        $images = array();
        foreach ($files as $file) {
            $filetype = array_pop(explode('.', $file));
            if (!in_array($file, $garbage) and in_array($filetype, $types)) {
                array_push($images, new Revision($base . "/" . $file, $category));
            }
        }
        return $images;
    }
    
    public static function reverse($request) {   
        $concept = Concept::reverse($request);    
        $revision_path = $concept->path . "/" . $request["revision"];
        
        // search for extension
        $matches = glob($revision_path . "*");
        if ($matches) {
            $revision_path = array_shift($matches);
        }
        $revision = new Revision($revision_path, $concept);        
        return $revision;
    }
    
    public function __construct($path, $concept) {
        parent::__construct($path);
        $this->concept = $concept;
        
        if ($concept->category->name == "uncategorized") {
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
        return $this->concept->get_url_path() . $this->machine_name . "/";
    }
    
    public function get_image_url() {
        return CR_BASE_URL . $this->concept->get_url_path() . $this->filename;
    }
}