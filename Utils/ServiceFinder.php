<?php
/**
 * Created by PhpStorm.
 * User: wdtfoxs
 * Date: 14.01.18
 * Time: 0:55
 */

namespace RestApiBundle\Utils;

use zpt\anno\Annotations;

class ServiceFinder
{

    const ANNOTATION_NAME = 'EntityRestApi';
    private $servicesPath;

    public function __construct(string $servicesPath)
    {
        $this->servicesPath = $servicesPath;
    }

    public function findServicePath($entity) :string
    {
        $fullClassName = null;
        foreach (glob($this->servicesPath . '/*.*') as $file) {
            $fp = fopen($file, 'r');
            $class = $namespace = $buffer = '';
            $i = 0;
            while (!$class) {
                if (feof($fp)) break;
                $buffer .= fread($fp, 512);
                $tokens = token_get_all($buffer);
                if (strpos($buffer, '{') === false) continue;
                for (; $i < count($tokens); $i++) {
                    if ($tokens[$i][0] === T_NAMESPACE) {
                        for ($j = $i + 1; $j < count($tokens); $j++) {
                            if ($tokens[$j][0] === T_STRING) {
                                $namespace .= '\\' . $tokens[$j][1];
                            } else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                                break;
                            }
                        }
                    }
                    if ($tokens[$i][0] === T_CLASS) {
                        for ($j = $i + 1; $j < count($tokens); $j++) {
                            if ($tokens[$j] === '{') {
                                $class = $tokens[$i + 2][1];
                            }
                        }
                    }
                }
            }
            $className = $namespace . '\\' . $class;
            $class = new \ReflectionClass($className);
            $classAnnotations = new Annotations($class);
            if ($classAnnotations->isAnnotatedWith(self::ANNOTATION_NAME)) {
                $urlPath = $classAnnotations->asArray()[self::ANNOTATION_NAME]['path'];
                if ($urlPath === $entity) {
                    if ($class->implementsInterface('RestApiBundle\RestApiService')) {
                        $fullClassName = $className;
                        break;
                    }
                }
            }

        }
        if (is_null($fullClassName)) {
            throw new \InvalidArgumentException();
        }
        return ltrim($fullClassName, '\\');
    }
}