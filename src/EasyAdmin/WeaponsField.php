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
                'choice_label' => function (\UnitEnum $choice) use ($instance): string {
                    if ($instance->enumTranslator && $instance->translator->getLocale() !== 'en') {
                        return $instance->enumTranslator->translate('enum.weapon_' . str_replace(' ', '_', $choice->value));
                    }
                    return $choice->value;
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