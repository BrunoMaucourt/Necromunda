<?PHP

namespace App\EasyAdmin;

use App\Enum\EquipementsEnum;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Contracts\Translation\TranslatorInterface;

final class EquipementsField implements FieldInterface
{
    use FieldTrait;

    private ?TranslatorInterface $translator = null;

    /**
     * @param string|false|null $label
     */
    public static function new(string $equipementsEnum, $label = "Element"): self
    {
        $instance = new self();
        return $instance
            ->setProperty($equipementsEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions([
                'class' => EquipementsEnum::class,
                'choice_label' => function (EquipementsEnum $choice) use ($instance): string {
                    if ($choice->getVariableDicesNumber() > 0) {
                        $cost = " - " . $choice->getFixedCost() . " " . $instance->translator->trans('credits') . "*";
                    } else {
                        $cost = " - " . $choice->getFixedCost() . " " . $instance->translator->trans('credits');
                    }
                    return $instance->translator->trans($choice->value) . $cost;
                },
                'group_by' => function(EquipementsEnum $choice) use ($instance) {
                    return $choice->getType();
                },
            ])
            ;
    }

    public function setTranslator(
        TranslatorInterface $translator
    ): self
    {
        $this->translator = $translator;
        return $this;
    }
}