<?php namespace Atomx\Resources;

use Atomx\AtomxClient;
use InvalidArgumentException;

class Creative extends AtomxClient {
    protected $endpoint = 'creative';

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setState($state)
    {
        if (!in_array($state, ['active', 'inactive']))
            throw new InvalidArgumentException('API: Invalid state provided');

        $this->state = strtoupper($state);
    }

    public function setBanner($filename, $extension)
    {
        if (!in_array($extension, ['jpg', 'gif', 'png', 'swf']))
            throw new InvalidArgumentException('API: Invalid extension provided');

        if (!file_exists($filename))
            throw new InvalidArgumentException('API: Banner file does not exists');

        $this->content   = base64_encode(file_get_contents($filename));
        $this->extension = strtoupper($extension);
    }

    public function setTypes($types)
    {
        if (!is_array($types))
            $types = [$types];

        foreach ($types as $type) {
            if (!in_array($type, ['iframe', 'popup', 'popunder', 'javascript']))
                throw new InvalidArgumentException('API: Invalid banner type provided');
        }

        $this->types = array_map('strtoupper', $types);
    }

    public function setContentType($contentType)
    {
        if (!in_array($contentType, ['image', 'flash', 'iframe', 'javascript', 'vast']))
                throw new InvalidArgumentException('API: Invalid banner contentType provided');

        $this->content_type = strtoupper($contentType);
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setClickUrl($clickUrl)
    {
        $this->click_url = $clickUrl;
    }

    public function setJavascript($js)
    {
        $this->javascript = $js;
    }

    public function setMopup($mopup)
    {
        $this->mopup = $mopup;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
}