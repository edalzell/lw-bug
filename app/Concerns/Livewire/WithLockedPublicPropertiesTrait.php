<?php

namespace App\Concerns\Livewire;

use App\Exceptions\LockedPublicPropertyTamperException;
use Illuminate\Support\Str;
use ReflectionException;

/**
 * @see https://stefrouschop.nl/how-to-secure-model-ids-in-livewire-and-why-this-is-important
 */
trait WithLockedPublicPropertiesTrait
{
    /**
     * @throws LockedPublicPropertyTamperException|ReflectionException
     */
    public function updatingWithLockedPublicPropertiesTrait($name): void
    {
        $propertyName = Str::of($name)->explode('.')->first();
        $reflectionProperty = new \ReflectionProperty($this, $propertyName);
        if (Str::of($reflectionProperty->getDocComment())->contains('@locked')) {
            throw new LockedPublicPropertyTamperException("You are not allowed to tamper with the protected property {$propertyName}");
        }
    }
}
