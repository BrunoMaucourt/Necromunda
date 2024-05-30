<?PHP

namespace App\EasyAdmin;

use App\Enum\HouseEnum;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class HouseField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $houseEnum, $label = "Element"): self
    {
        return (new self())
            ->setProperty($houseEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions(['class' => HouseEnum::class,
                'choice_label' => static function (\UnitEnum $choice): string {
                    return $choice->value;
                },
            ])
        ;
    }
}