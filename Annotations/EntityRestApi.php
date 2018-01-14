<?php
/**
 * Created by PhpStorm.
 * User: wdtfoxs
 * Date: 14.01.18
 * Time: 0:46
 */

namespace RestApiBundle\Annotations;

/**
 * @Annotation
 * @Target("CLASS")
 */
class EntityRestApi
{
    /**
     * @Required
     *
     * @var string
     */
    public $path;

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }
}