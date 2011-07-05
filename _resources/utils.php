<?php

class Paginator {
    public $pointer, $list;

    public function __construct($list) {
        $this->list = $list;
        $this->pointer = 0;
    }
    
    public function current($i = NULL, $discriminator = NULL) {
        if ($i === NULL) {
            return $this->list[$this->pointer];
        } else {
            if (is_object($i)) {
                if ($discriminator) {
                    $concepts = array_map($discriminator, $this->list);
                    $location = array_search($i->path, $concepts);
                } else {
                    $location = array_search($i, $this->list);
                }
            } else if (is_integer($i)) {
                $location = $i;
            }
            $this->pointer = $location;
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