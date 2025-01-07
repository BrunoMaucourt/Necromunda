<?php

namespace App\Controller\Admin;

use App\EasyAdmin\AdvancementField;
use App\Entity\Advancement;
use App\Enum\AdvancementEnum;
use App\service\EnumTranslator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdvancementCrudController extends AbstractCrudController
{
    private EnumTranslator $enumTranslator;
    private TranslatorInterface $translator;

    public function __construct(
        EnumTranslator $enumTranslator,
        TranslatorInterface $translator,
    ) {
        $this->enumTranslator = $enumTranslator;
        $this->translator = $translator;
    }

    public static function getEntityFqcn(): string
    {
        return Advancement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $translator = $this->translator;
        $enumTranslator = $this->enumTranslator;

        yield AssociationField::new('ganger', $this->translator->trans('Ganger'));

        yield AdvancementField::new('content', $this->translator->trans('Content'))
            ->setEnumTranslator($enumTranslator, $translator)
            ->formatValue(static function (AdvancementEnum $advancementEnum) use($translator): string {
                if ($translator->getLocale() !== 'en') {
                    $value = $translator->trans($advancementEnum->value);
                } else {
                    $value = $advancementEnum->enumToString();
                }
                return $value;
            })
        ;

        yield AssociationField::new('game', $this->translator->trans('Game'));

        yield AssociationField::new('skill', $this->translator->trans('Skill'));

        yield BooleanField::new('active', $this->translator->trans('active'));
        yield BooleanField::new('reRoll', $this->translator->trans('reRoll'));
    }
}
