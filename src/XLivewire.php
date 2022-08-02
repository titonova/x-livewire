<?php

namespace Titonova\XLivewire;

class XLivewire
{
    public static function propertyIsPublic($property, $object) { $r_object = new \ReflectionObject($object); $properties = $r_object->getProperties(\ReflectionProperty::IS_PUBLIC); if (is_array($properties) && count($properties) >0) { foreach ($properties as $ppt) { if ($ppt->name == $property) { return true; } } } return false; }
}
