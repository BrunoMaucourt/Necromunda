<?PHP

namespace App\EasyAdmin;

use App\Enum\EquipementsEnum;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class EquipementsField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $equipementsEnum, $label = "Element"): self
    {
        return (new self())
            ->setProperty($equipementsEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/field/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions(['class' => EquipementsEnum::class,
                'choice_label' => static function (\UnitEnum $choice): string {
                    return $choice->value;
                },
            ])
        ;
    }
}