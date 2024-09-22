<?PHP

namespace App\EasyAdmin;

use App\Enum\WeaponsEnum;
use App\service\EnumTranslator;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Contracts\Translation\TranslatorInterface;

final class WeaponsField implements FieldInterface
{
    use FieldTrait;

    private ?TranslatorInterface $translator = null;

    private ?EnumTranslator $enumTranslator = null;

    /**
     * @param string|false|null $label
     */
    public static function new(string $weaponEnum, $label = "Element"): self
    {
        $instance = new self();
        return $instance
            ->setProperty($weaponEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions([
                'class' => WeaponsEnum::class,
                'choice_attr' => function (WeaponsEnum $choice) {
                    if (!$choice->isAvailableOnMenu()) {
                        return [
                            'class' => 'hide',
                        ];
                    }
                    return [];
                },
                'choice_label' => function (WeaponsEnum $choice) use ($instance): string {
                    if ($choice->getVariableDicesNumber() > 0) {
                        $cost = " - " . $choice->getFixedCost() . " " . $instance->translator->trans('credits') . "*";
                    } else {
                        $cost = " - " . $choice->getFixedCost() . " " . $instance->translator->trans('credits');
                    }
                    if ($instance->enumTranslator && $instance->translator->getLocale() !== 'en') {
                        return $instance->enumTranslator->translate('enum.weapon_' . str_replace(' ', '_', $choice->value)) . $cost;
                    }
                    return $choice->value . $cost;
                },
                'group_by' => function(WeaponsEnum $choice) use ($instance) {
                    if ($instance->enumTranslator && $instance->translator->getLocale() !== 'en') {
                        return $instance->enumTranslator->translate('enum.weapon_types.' . str_replace(' ', '_', $choice->getWeaponType()));
                    }
                    return $choice->getWeaponType();
                },
            ])
        ;
    }


    public function setEnumTranslator(
        EnumTranslator $enumTranslator,
        TranslatorInterface $translator
    ): self
    {
        $this->enumTranslator = $enumTranslator;
        $this->translator = $translator;
        return $this;
    }
}