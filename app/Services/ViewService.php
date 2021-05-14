<?php

namespace App\Services;

class ViewService
{
    /**
    * @var string  used for setting the <title> tag of the application.
    */
    protected string $title;

    /**
    * @return object
    */
    public function all(): object
    {
        return (object) [
            'title' => $this->getTitle()
        ];
    }

    /**
    * @param string $title
    * @return $this
    */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
    * Get the website title, if it's not set then we're going to utilise the APP_NAME env variable.
    *
    * @return string
    */
    public function getTitle(): string
    {
        return ! empty($this->title)
            ? env('APP_NAME') . " | $this->title"
            : env('APP_NAME');
    }
}
