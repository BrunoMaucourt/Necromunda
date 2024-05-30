<?PHP

namespace App\EasyAdmin;

use App\Enum\TerritoriesEnum;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class TerritoriesField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $territoriesEnum, $label = "Element"): self
    {
        return (new self())
            ->setProperty($territoriesEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions(['class' => TerritoriesEnum::class,
                'choice_label' => static function (\UnitEnum $choice): string {
                    return $choice->value;
                },
            ])
        ;
    }
}