<?PHP

namespace App\EasyAdmin;

use App\Enum\AdvancementEnum;
use App\Service\EnumTranslator;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Contracts\Translation\TranslatorInterface;

final class AdvancementField implements FieldInterface
{
    use FieldTrait;

    private ?TranslatorInterface $translator = null;

    private ?EnumTranslator $enumTranslator = null;

    /**
     * @param string|false|null $label
     */
    public static function new(string $propertyName, ?string $label = "Element"): self
    {
        $instance = new self();
        return $instance
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions([
                'class' => AdvancementEnum::class,
                'choice_label' => function (\UnitEnum $choice) use ($instance): string {
                    if ($instance->enumTranslator && $instance->translator->getLocale() !== 'en') {
                        return $instance->enumTranslator->translate($choice->value);
                    }
                    return $choice->value;
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
