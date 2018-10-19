<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */
namespace App\Utils\Generic;

use App\Exception\TypeErrorException;

class ObjectServicesGeneric
{

    /**
     * @param $object
     *
     * @return array
     *
     * @throws TypeErrorException
     * @throws \Exception
     */
    public static function getArrayFromObject($object): array
    {
        if (!is_object($object)) {
            throw new TypeErrorException("Parameter must be a valid object");
        }

        try {
            $arrPropertyReflection = self::getPropertiesWithReflexion($object);
            return self::getParamsValuesWithGetter($arrPropertyReflection, $object);

        } catch (\Exception $e) {
            throw new \Exception("Error occurred when use reflection to obtain parameters value in object " . $e -> getMessage());
        }
    }

    /**
     * @param \ReflectionProperty[] $arrReflectionProperty
     * @param object $object
     *
     * @return array
     */
    private function getParamsValuesWithGetter(array $arrReflectionProperty, $object): array
    {
        $arrParams = [];

        foreach ($arrReflectionProperty as $reflectionProperty) {
            $getter = "get" . ucfirst($reflectionProperty -> getName());

            if (method_exists($object, $getter)) {
                $arrParams[$reflectionProperty -> getName()] = $object->$getter();
            }
        }
        return $arrParams;
    }

    /**
     * @param string $property
     *
     * @param object $object
     *
     * @return bool
     *
     * @throws TypeErrorException
     */
    public static function isSetter(string $property, $object): bool
    {
        if (!is_object($object)) {
            throw new TypeErrorException("Object parameter isn't a valid object");
        }

        $setter = "set" . ucfirst($property);

        return method_exists($object, $setter);
    }


    /**
     * @param $object
     *
     * @return \ReflectionProperty[]
     *
     * @throws \ReflectionException
     */
    public static function getPropertiesWithReflexion($object): array
    {
        try {
            $reflection = new \ReflectionClass($object);
            return $reflection -> getProperties();
        } catch (\ReflectionException $e) {
            throw $e;
        }
    }
}
