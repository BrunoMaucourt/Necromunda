<?PHP

namespace App\EasyAdmin;

use App\Enum\SkillsEnum;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class SkillsField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $skillsEnum, $label = "Element"): self
    {
        return (new self())
            ->setProperty($skillsEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions(['class' => SkillsEnum::class,
                'choice_label' => static function (\UnitEnum $choice): string {
                    return $choice->value;
                },
            ])
        ;
    }
}