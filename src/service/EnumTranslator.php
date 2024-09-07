<?php

namespace App\service;

use Symfony\Contracts\Translation\TranslatorInterface;

class EnumTranslator
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function translate(string $enumKey): string
    {
        return $this->translator->trans($enumKey);
    }
}
