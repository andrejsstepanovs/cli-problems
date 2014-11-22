<?php

namespace App\Service;


/**
 * Class Reflection
 *
 * @package App\Service
 */
class Reflection
{
    /**
     * @param string $class
     *
     * @return \ReflectionClass
     */
    private function getReflectionClass($class)
    {
        return new \ReflectionClass($class);
    }

    /**
     * @return array
     */
    public function getClassConstants($class)
    {
        return $this->getReflectionClass($class)->getConstants();
    }

    /**
     * @param string $class
     *
     * @return array
     */
    public function getDocsData($class)
    {
        $data    = [];
        $comment = $this->getReflectionClass($class)->getDocComment();
        if (empty($comment)) {
            return $data;
        }

        $lines = explode(PHP_EOL, $comment);
        if (empty($lines)) {
            return $data;
        }

        $regexp  = '/@([a-z]+)\s+(.*?)\s*(?=$|@[a-z]+\s)/s';
        foreach ($lines as $line) {
            preg_match_all($regexp, $line, $matches);
            if (!empty($matches[1][0]) && !empty($matches[2][0])) {
                $data[$matches[1][0]] = $matches[2][0];
            }
        }

        return $data;
    }
}
