<?PHP

namespace App\EasyAdmin;

use App\Enum\InjuriesEnum;
use App\Enum\WeaponsEnum;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class WeaponsField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $weaponEnum, $label = "Element"): self
    {
        return (new self())
            ->setProperty($weaponEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions(['class' => WeaponsEnum::class,
                'choice_label' => static function (\UnitEnum $choice): string {
                    return $choice->value;
                },
            ])
        ;
    }
}