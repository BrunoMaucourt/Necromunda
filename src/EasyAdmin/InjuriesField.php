<?PHP

namespace App\EasyAdmin;

use App\Enum\InjuriesEnum;
use App\service\EnumTranslator;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Contracts\Translation\TranslatorInterface;

final class InjuriesField implements FieldInterface
{
    use FieldTrait;

    private ?TranslatorInterface $translator = null;

    private ?EnumTranslator $enumTranslator = null;

    /**
     * @param string|false|null $label
     */
    public static function new(string $injuriesEnum, $label = "Element"): self
    {
        $instance = new self();
        return $instance
            ->setProperty($injuriesEnum)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/enumField.html.twig')
            ->setFormType(EnumType::class)
            ->setFormTypeOptions([
                'class' => InjuriesEnum::class,
                'choice_label' => function (\UnitEnum $choice) use ($instance): string {
                    if ($instance->enumTranslator && $instance->translator->getLocale() !== 'en') {
                        return $instance->enumTranslator->translate('enum.injuries_' . str_replace(' ', '_', $choice->value));
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