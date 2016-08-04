<?php

namespace Victoire\Widget\CardBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\FormBundle\Form\Type\FontAwesomePickerType;
use Victoire\Bundle\FormBundle\Form\Type\LinkType;
use Victoire\Bundle\MediaBundle\Form\Type\MediaType;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * WidgetCard form type.
 */
class WidgetCardType extends WidgetType
{
    /**
     * define form fields.
     *
     * @param FormBuilderInterface $builder
     *
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('themeCard', ChoiceType::class, [
                'label'       => 'widget_card.form.themeCard.label',
                'required'    => false,
                'empty_value' => 'widget_card.form.themeCard.pictureTheme',
                'attr'        => [
                    'data-refreshOnChange' => 'true',
                    'target'               => '.vic-tab-pane.vic-active',
                ],
                'choices'     => [
                    'widget_card.form.themeCard.noPictureTheme' => 'nopicture',
                    'widget_card.form.themeCard.productTheme'   => 'product',
                ],
            ]);

        if ($options['mode'] === Widget::MODE_STATIC) {
            $this->addMultiThemeStaticFields($builder);
        }

        $this->addMultiModeStaticFields($builder);

        parent::buildForm($builder, $options);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($options) {
                self::manageThemeRelativeFields($event->getForm(), $event->getData()->getThemeCard(), $options);
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($options) {
                self::manageThemeRelativeFields($event->getForm(), $event->getData()['themeCard'], $options);
            }
        );
    }

    /**
     * @param FormInterface $form
     * @param $theme
     * @param array $options
     */
    protected function manageThemeRelativeFields(FormInterface $form, $theme, $options)
    {
        $node = $options['mode'] === Widget::MODE_STATIC ? $form : $form->get('fields');

        switch ($theme) {
            case 'product':
                self::generateProductTheme($node, $options);
                break;
            case 'nopicture':
                self::generateNoPictureTheme($node, $options);
                break;
            default:
                self::generatePictureTheme($node, $options);
                break;
        }
    }

    /**
     * @param FormInterface|FormBuilderInterface $node
     * @param array                              $options
     */
    protected function generatePictureTheme($node, $options)
    {
        $node
            ->remove('price')
            ->remove('popover')
            ->remove('cardType');

        if ($options['mode'] === Widget::MODE_STATIC) {
            $node
                ->add('image', MediaType::class, [
                    'label' => 'widget_card.form.image.label',
                ])
                ->add('legend', null, [
                    'label' => 'widget_card.form.legend.label',
                ])
                ->add('date', null, [
                    'label' => 'widget_card.form.date.label',
                ]);
        }
    }

    /**
     * @param FormInterface|FormBuilderInterface $node
     * @param array                              $options
     */
    protected function generateNoPictureTheme($node, $options)
    {
        $node
            ->remove('image')
            ->add('image', MediaType::class, [
                'vic_vic_widget_form_group_attr' => [
                    'class' => 'hidden',
                ],
            ])
            ->remove('price')
            ->remove('popover')
            ->remove('legend')
            ->remove('date');

        if ($options['mode'] === Widget::MODE_STATIC) {
            $node
                ->add('cardType', null, [
                    'label' => 'widget_card.form.type.label',
                ]);
        }
    }

    /**
     * @param FormInterface|FormBuilderInterface $node
     * @param array                              $options
     */
    protected function generateProductTheme($node, $options)
    {
        $node
            ->remove('legend')
            ->remove('date')
            ->remove('cardType');

        if ($options['mode'] === Widget::MODE_STATIC) {
            $node
                ->add('image', MediaType::class, [
                    'label' => 'widget_card.form.image.label',
                ])
                ->add('price', null, [
                    'label' => 'widget_card.form.price.label',
                ])
                ->add('popover', null, [
                    'label' => 'widget_card.form.popover.label',
                ]);
        }
    }

    /**
     * @param FormInterface|FormBuilderInterface $builder
     */
    protected function addMultiThemeStaticFields($builder)
    {
        $builder
            ->add('title', null, [
                'label' => 'widget_card.form.title.label',
            ])
            ->add('shortDescription', null, [
                'label' => 'widget_card.form.shortDescription.label',
            ]);
    }

    /**
     * @param FormInterface|FormBuilderInterface $builder
     */
    protected function addMultiModeStaticFields($builder)
    {
        $builder
            ->add('buttonText', null, [
                'label' => 'widget_card.form.buttonText.label',
            ])
            ->add('buttonIcon', FontAwesomePickerType::class, [
                'label'    => 'widget_card.form.buttonIcon.label',
                'required' => false,
            ])
            ->add('link', LinkType::class, [
                'label' => 'widget_card.form.buttonLink.label',
            ])
            ->add('style', ChoiceType::class, [
                'label'     => 'widget.button.form.label.style',
                'choices'   => [
                    'widget.card.form.choice.style.label.default' => 'default',
                    'widget.card.form.choice.style.label.primary' => 'primary',
                    'widget.card.form.choice.style.label.success' => 'success',
                    'widget.card.form.choice.style.label.info'    => 'info',
                    'widget.card.form.choice.style.label.warning' => 'warning',
                    'widget.card.form.choice.style.label.danger'  => 'danger',
                ],
                'required'  => true,
                'choices_as_values' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\CardBundle\Entity\WidgetCard',
            'widget'             => 'Card',
            'translation_domain' => 'victoire',
        ]);
    }
}
