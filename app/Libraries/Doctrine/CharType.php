<?php
namespace App\Libraries\Doctrine;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
class CharType extends StringType
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration, true);
    }
    public function getName()
    {
        return 'char';
    }
}
