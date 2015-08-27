<?php

namespace Victoire\Widget\CardBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;


/**
 * WidgetCard form type
 */
class WidgetCardType extends WidgetType
{
    /**
     * define form fields
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('themeCard', 'choice', array(
                'label' => 'widget_card.form.themeCard.label',
                'required'       => false,
                'empty_value' => 'Default',
                'attr' => array(
                    'data-refreshOnChange' => "true",
                ),
                'choices' => array(
                    'ad' => 'Ad',
                    'product' => 'Product',
                )
            ))
            ->add('image', 'media', array(
                'label' => 'widget_image.form.image.label',
            ))
            ->add('title', null, array(
                'label' => 'widget_card.form.title.label'
            ))
            ->add('shortDescription', null, array(
                'label' => 'widget_card.form.shortDescription.label'
            ))
            ->add('buttonText', null, array(
                'label' => 'widget_card.form.buttonText.label'
            ))
            ->add('buttonIcon', 'font_awesome_picker', array(
                'label' => 'widget_card.form.buttonIcon.label',
                'required' => false,
            ))
            ->add('link', 'victoire_link', array(
                'label' => 'widget_card.form.buttonLink.label',
            ))
            ->add('legend', null, array(
                'label' => 'widget_card.form.legend.label'
            ))
            ->add('date', null, array(
                'label' => 'widget_card.form.date.label'
            ))
            ->add('price', null, array(
                'label' => 'widget_card.form.price.label'
            ))
            ->add('popover', null, array(
                'label' => 'widget_card.form.popover.label'
            ))
            ->add('cardType', null, array(
                'label' => 'widget_card.form.type.label'
            ))
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {
                self::manageThemeRelativeFields($event->getForm(), '');
            }
        );

        $builder->get('themeCard')->addEventListener(
            FormEvents::PRE_SUBMIT,
            function(FormEvent $event) {
                self::manageThemeRelativeFields($event->getForm()->getParent(), (string) $event->getData());
            }
        );

        parent::buildForm($builder, $options);
    }

    protected function generateAd(FormInterface $form) {
        $form
            ->remove('price')
            ->remove('popover')
            ->remove('legend')
            ->remove('date')
            ->add('cardType', null, array(
                'label' => 'widget_card.form.type.label'
            ))
        ;
    }

    protected function generateProduct(FormInterface $form) {
        $form
            ->remove('legend')
            ->remove('date')
            ->remove('cardType')
            ->add('price', null, array(
                'label' => 'widget_card.form.price.label'
            ))
            ->add('popover', null, array(
                'label' => 'widget_card.form.popover.label'
            ))
        ;
    }

    protected function generateDefault(FormInterface $form) {
        $form
            ->remove('price')
            ->remove('popover')
            ->remove('cardType')
            ->add('legend', null, array(
                'label' => 'widget_card.form.legend.label'
            ))
            ->add('date', null, array(
                'label' => 'widget_card.form.date.label'
            ))
        ;
    }

    protected function manageThemeRelativeFields(FormInterface $form, $theme) {
        switch ($theme) {
            case 'product':
                self::generateProduct($form);
                break;
            case 'ad':
                self::generateAd($form);
                break;
            default:
                self::generateDefault($form);
                break;
        }
    }

    /**
     * bind form to WidgetCard entity
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'data_class'         => 'Victoire\Widget\CardBundle\Entity\WidgetCard',
            'widget'             => 'Card',
            'translation_domain' => 'victoire'
        ));
    }

    /**
     * get form name
     *
     * @return string The form name
     */
    public function getName()
    {
        return 'victoire_widget_form_card';
    }
}
