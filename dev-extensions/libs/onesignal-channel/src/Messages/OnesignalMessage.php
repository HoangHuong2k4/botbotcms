<?php
namespace Dev\OneSignalChannel\Messages;

class OneSignalMessage
{

    /**
     *
     * @var array
     */
    private $data;

    /**
     *
     * @param
     *            array
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * get Contents
     *
     * @return string
     */
    public function getContent()
    {
        if (array_key_exists('contents', $this->data))
            return $this->data["contents"];
        return "Content undefined";
    }

    /**
     * get Tags
     *
     * @return array
     */
    public function getTags()
    {
        if (array_key_exists('tags', $this->data))
            return $this->data["tags"];
        return array();
    }

    /**
     * get heading
     *
     * @return string|null
     */
    public function getHeading()
    {
        if (array_key_exists('headings', $this->data))
            return $this->data["headings"];
        return null;
    }

    /**
     * get subtitle
     *
     * @return string|null
     */
    public function getSubtitle()
    {
        if (array_key_exists('subtitle', $this->data))
            return $this->data["subtitle"];
        return null;
    }

    /**
     * get array customize
     *
     * @return array
     */
    public function getArrayArgs()
    {
        if (array_key_exists('customize', $this->data))
            return $this->data["customize"];
        return array();
    }
}
