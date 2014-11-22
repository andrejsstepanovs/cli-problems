<?php

namespace App\Value;


/**
 * Class Docs
 *
 * @package App\Value
 */
class Docs
{
    const DESCRIPTION = 'description';
    const NAME        = 'name';

    /** @var array */
    private $data = [];

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->get(self::DESCRIPTION);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->get(self::NAME);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function get($key)
    {
        if (!array_key_exists($key, $this->data)) {
            throw new \RuntimeException('Key "' . $key . '" is not available');
        }

        return $this->data[$key];
    }
}