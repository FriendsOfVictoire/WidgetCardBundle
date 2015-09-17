<?php

namespace Victoire\Widget\CardBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\WidgetBundle\Entity\Widget;


/**
 * WidgetCard form type
 */
class WidgetCardType extends WidgetType
{

    private $mode;

    /**
     * define form fields
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $this->mode = $options['mode'];

        $builder
            ->add('themeCard', 'choice', array(
                'label' => 'widget_card.form.themeCard.label',
                'required'       => false,
                'empty_value' => 'widget_card.form.themeCard.pictureTheme',
                'attr' => array(
                    'data-refreshOnChange' => "true",
                    'target' => '.vic-tab-pane.vic-active'
                ),
                'choices' => array(
                    'nopicture' => 'widget_card.form.themeCard.noPictureTheme',
                    'product' => 'widget_card.form.themeCard.productTheme',
                )
            ));

        if ($this->mode === Widget::MODE_STATIC) {
            $this->addMultiThemeStaticFields($builder);
        }

        $this->addMultiModeStaticFields($builder);

        parent::buildForm($builder, $options);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {
                self::manageThemeRelativeFields($event->getForm(), $event->getData()->getThemeCard() );
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function(FormEvent $event) {
                self::manageThemeRelativeFields($event->getForm(), $event->getData()['themeCard']);
            }
        );


    }

    protected function manageThemeRelativeFields(FormInterface $form, $theme)
    {
        $node = $this->mode === Widget::MODE_STATIC ? $form : $form->get('fields');

        switch ($theme) {
            case 'product':
                self::generateProductTheme($node);
                break;
            case 'nopicture':
                self::generateNoPictureTheme($node);
                break;
            default:
                self::generatePictureTheme($node);
                break;
        }
    }

    protected function generatePictureTheme($node)
    {
        $node
            ->remove('price')
            ->remove('popover')
            ->remove('cardType');

        if ($this->mode === Widget::MODE_STATIC) {
            $node
                ->add('image', 'media', array(
                    'label' => 'widget_card.form.image.label'
                ))
                ->add('legend', null, array(
                    'label' => 'widget_card.form.legend.label'
                ))
                ->add('date', null, array(
                    'label' => 'widget_card.form.date.label'
                ));
        }
    }

    protected function generateNoPictureTheme($node)
    {
        $node
            ->remove('image')
            ->remove('price')
            ->remove('popover')
            ->remove('legend')
            ->remove('date');

        if ($this->mode === Widget::MODE_STATIC) {
            $node
                ->add('cardType', null, array(
                    'label' => 'widget_card.form.type.label'
                ));
        }
    }

    protected function generateProductTheme($node)
    {
        $node
            ->remove('legend')
            ->remove('date')
            ->remove('cardType');

        if ($this->mode === Widget::MODE_STATIC) {
            $node
                ->add('image', 'media', array(
                    'label' => 'widget_card.form.image.label'
                ))
                ->add('price', null, array(
                    'label' => 'widget_card.form.price.label'
                ))
                ->add('popover', null, array(
                    'label' => 'widget_card.form.popover.label'
                ));
        }
    }

    protected function addMultiThemeStaticFields($builder)
    {
        $builder
            ->add('title', null, array(
                'label' => 'widget_card.form.title.label'
            ))
            ->add('shortDescription', null, array(
                'label' => 'widget_card.form.shortDescription.label'
            ))
        ;
    }

    protected function addMultiModeStaticFields($builder)
    {
        $builder
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
            ->add('style', 'choice', array(
                'label'   => 'widget.button.form.label.style',
                'choices'   => array(
                    'default' => 'widget.card.form.choice.style.label.default',
                    'primary' => 'widget.card.form.choice.style.label.primary',
                    'success' => 'widget.card.form.choice.style.label.success',
                    'info'    => 'widget.card.form.choice.style.label.info',
                    'warning' => 'widget.card.form.choice.style.label.warning',
                    'danger'  => 'widget.card.form.choice.style.label.danger',
                ),
                'required'  => true,
            ));
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
