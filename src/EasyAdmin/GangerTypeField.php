<?PHP

namespace App\EasyAdmin;

use App\Enum\GangerTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class GangerTypeField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $gangerTypeEnum, $label = "Element"): self
    {
        return (new self())
            ->setProperty($gangerTypeEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/field/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions(['class' => GangerTypeEnum::class,
                'choice_label' => static function (\UnitEnum $choice): string {
                    return $choice->value;
                },
            ])
        ;
    }
}