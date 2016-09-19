<?php

namespace SmartCore\Module\Texter\Form\Type;

use SmartCore\Bundle\CMSBundle\Module\AbstractNodePropertiesFormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class NodePropertiesFormType extends AbstractNodePropertiesFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text_item_id', IntegerType::class, ['attr' => ['autofocus' => 'autofocus']]) // 'integer'
            ->add('editor', CheckboxType::class,      ['required' => false, 'label' => 'Визуальный редактор']) // 'checkbox'
        ;
    }

    public function getName()
    {
        return 'smart_module_texter_node_properties';
    }
}
