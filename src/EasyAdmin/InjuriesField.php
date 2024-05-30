<?PHP

namespace App\EasyAdmin;

use App\Enum\InjuriesEnum;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class InjuriesField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $injuriesEnum, $label = "Element"): self
    {
        return (new self())
            ->setProperty($injuriesEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions(['class' => InjuriesEnum::class,
                'choice_label' => static function (\UnitEnum $choice): string {
                    return $choice->value;
                },
            ])
        ;
    }
}