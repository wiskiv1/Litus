<?php
/**
 * Litus is a project by a group of students from the KU Leuven. The goal is to create
 * various applications to support the IT needs of student unions.
 *
 * @author Niels Avonds <niels.avonds@litus.cc>
 * @author Karsten Daemen <karsten.daemen@litus.cc>
 * @author Koen Certyn <koen.certyn@litus.cc>
 * @author Bram Gotink <bram.gotink@litus.cc>
 * @author Dario Incalza <dario.incalza@litus.cc>
 * @author Pieter Maene <pieter.maene@litus.cc>
 * @author Kristof Mariën <kristof.marien@litus.cc>
 * @author Lars Vierbergen <lars.vierbergen@litus.cc>
 * @author Daan Wendelen <daan.wendelen@litus.cc>
 *
 * @license http://litus.cc/LICENSE
 */

namespace SportBundle\Form\Admin\Group;

use CommonBundle\Component\Form\Bootstrap\Element\Hidden,
    CommonBundle\Component\Form\Bootstrap\Element\Select,
    CommonBundle\Component\Form\Bootstrap\Element\Submit,
    CommonBundle\Component\Form\Bootstrap\Element\Text,
    CommonBundle\Component\Validator\Academic as AcademicValidator,
    Doctrine\ORM\EntityManager,
    Zend\InputFilter\Factory as InputFactory,
    Zend\InputFilter\InputFilter;

/**
 * Edit a group of friends.
 *
 * @author Koen Certyn <koen.certyn@litus.cc>
 */
class Edit extends \CommonBundle\Component\Form\Admin\Form
{
    /**
     * @var EntityManager The EntityManager instance
     */
    private $_entityManager = null;

    /**
     * @var array An array containing all members that should be created
     */
    private $_allMembers = array();

    /**
     * @param EntityManager   $entityManager
     * @param string[]        $allMembers
     * @param null|string|int $name          Optional name for the element
     */
    public function __construct(EntityManager $entityManager, $name = null)
    {
        parent::__construct($name);

        $this->_entityManager = $entityManager;

        $field = new Text('person_name');
        $field->setLabel('Runner')
            ->setRequired(true)
            ->setAttribute('id', 'personSearch')
            ->setAttribute('autocomplete', 'off')
            ->setAttribute('data-provide', 'typeahead');
        $this->add($field);

        $field = new Hidden('person_id');
        $field->setAttribute('id', 'personId');
        $this->add($field);

        $field = new Select('department');
        $field->setLabel('Department')
            ->setRequired(true)
            ->setAttribute('options', $this->_getDepartments());
        $this->add($field);

        $field = new Submit('submit');
        $field->setValue('Add Runner')
            ->setAttribute('class', 'product_add');
        $this->add($field);
    }

    private function _getDepartments()
    {
        $departments = $this->_entityManager
            ->getRepository('SportBundle\Entity\Department')
            ->findAll();

        $array = array('0' => '');
        foreach ($departments as $department) {
            $array[$department->getId()] = $department->getName();
        }

        return $array;
    }

    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory = new InputFactory();

        if (!isset($this->data['person_id']) || '' == $this->data['person_id']) {
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name' => 'person_name',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            new AcademicValidator(
                                $this->_entityManager,
                                array(
                                    'byId' => false,
                                )
                            ),
                        ),
                    )
                )
            );
        } else {
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name' => 'person_id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            new AcademicValidator(
                                $this->_entityManager,
                                array(
                                    'byId' => true,
                                )
                            ),
                        ),
                    )
                )
            );
        }

        return $inputFilter;
    }
}