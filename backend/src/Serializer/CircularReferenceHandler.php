<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Exception\CircularReferenceException;

class CircularReferenceHandler
{
    public function __invoke($object)
    {
        return $object->getId();
    }
}
