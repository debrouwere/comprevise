<?php

class Paginator {
    public $pointer, $list;

    public function __construct($list) {
        $this->list = $list;
        $this->pointer = 0;
    }
    
    public function current($i = NULL) {
        if ($i === NULL) {
            return $this->list[$this->pointer];
        } else {
            $this->pointer = $i;
        }
    }
    
    public function prev() {
        if ($this->pointer > 0) {
            return $this->list[$this->pointer-1];
        } else {
            return false;
        }
    }
    
    public function next() {
        if ($this->pointer < sizeof($this->list)-1) {
            return $this->list[$this->pointer+1];
        } else {
            return false;
        }
    }
    
    public function is_first() {
        if ($this->pointer == 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function is_last() {
        if ($this->pointer == sizeof($this->list)-1) {
            return true;
        } else {
            return false;
        }
    }
}


class License {
    public function __construct($code, $email) {
        $this->code = $code;
        $this->email = $email;
        $this->domain = str_replace('www.', '', $_SERVER['SERVER_NAME']);
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