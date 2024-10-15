<?PHP

namespace App\EasyAdmin;

use App\Entity\CustomRules;
use App\Enum\ScenariosEnum;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class ScenarioField implements FieldInterface
{
    use FieldTrait;

    private ?CustomRules $customRules = null;

    /**
     * @param string|false|null $label
     */
    public static function new(string $scenariosEnum, $label = "Element"): self
    {
        $instance = new self();
        return $instance
            ->setProperty($scenariosEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions(['class' => ScenariosEnum::class,
                'choice_label' => static function (ScenariosEnum $choice): string {
                    return $choice->value;
                },
                'choice_attr' => function (ScenariosEnum $choice) use ($instance) {

                    if (
                        $choice == ScenariosEnum::BlindFight &&
                        $instance->customRules->isBlindFightRemoved() === true
                    ) {
                        return [
                            'class' => 'hide',
                        ];
                    }
                    return [];
                },
            ])
        ;
    }

    public function setCustomRules( CustomRules $customRules ): self {
        $this->customRules = $customRules;
        return $this;
    }
}