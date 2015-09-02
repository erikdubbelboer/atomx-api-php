<?php namespace Atomx\Resources;

use Atomx\AtomxClient;
use InvalidArgumentException;

class Domain extends AtomxClient {
    protected $endpoint = 'domain';

    public function setLanguage($lan = 'en')
    {
        if(empty($lan)) $lan = 'en';
        $this->language_id = $lan;
    }

    public function setCategory($cat = 0)
    {
        if(empty($cat)) $cat = 0;
        $this->category = $cat;
    }

    public function setAttributes($att = [])
    {
        if(!isset($att)) $att = [];
        $this->attributes = $att;
    }



}
