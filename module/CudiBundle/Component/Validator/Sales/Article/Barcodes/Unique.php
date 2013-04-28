<?php
/**
 * Litus is a project by a group of students from the K.U.Leuven. The goal is to create
 * various applications to support the IT needs of student unions.
 *
 * @author Niels Avonds <niels.avonds@litus.cc>
 * @author Karsten Daemen <karsten.daemen@litus.cc>
 * @author Bram Gotink <bram.gotink@litus.cc>
 * @author Pieter Maene <pieter.maene@litus.cc>
 * @author Kristof Mariën <kristof.marien@litus.cc>
 *
 * @license http://litus.cc/LICENSE
 */

namespace CudiBundle\Component\Validator\Sales\Article\Barcodes;

use CudiBundle\Entity\Sales\Article,
    Doctrine\ORM\EntityManager;

/**
 * Matches the given article barcode against the database to check whether it is unique or not.
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class Unique extends \Zend\Validator\AbstractValidator
{
    const NOT_VALID = 'notValid';

    /**
     * @var \Doctrine\ORM\EntityManager The EntityManager instance
     */
    private $_entityManager = null;

    /**
     * @var \CudiBundle\Entity\Sales\Article The sale article to be ignored
     */
    private $_saleArticle = array();

    /**
     * Error messages
     *
     * @var array
     */
    protected $messageTemplates = array(
        self::NOT_VALID => 'The article barcode already exists'
    );

    /**
     * Create a new Unique Article Barcode validator.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager The EntityManager instance
     * @param \CudiBundle\Entity\Sales\Article $saleArticle The sale article to be ignored
     * @param mixed $opts The validator's options
     */
    public function __construct(EntityManager $entityManager, Article $saleArticle = null, $opts = null)
    {
        parent::__construct($opts);

        $this->_entityManager = $entityManager;
        $this->_saleArticle = $saleArticle;
    }


    /**
     * Returns true if and only if a field name has been set, the field name is available in the
     * context, and the value of that field unique and valid.
     *
     * @param string $value The value of the field that will be validated
     * @param array $context The context of the field that will be validated
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
        $this->setValue($value);

        if (! is_numeric($value)) {
            $this->error(self::NOT_VALID);
            return false;
        }

        /*$article = $this->_entityManager
            ->getRepository('CudiBundle\Entity\Sales\Article')
            ->findOneByBarcode($value);

        if (!(null === $article || $article == $this->_saleArticle)) {
            $this->error(self::NOT_VALID);
            return false;
        }*/

        $barcode = $this->_entityManager
            ->getRepository('CudiBundle\Entity\Sales\Articles\Barcode')
            ->findOneByBarcode($value);

        if (null === $barcode || $barcode->getArticle() == $this->_saleArticle)
            return true;

        $this->error(self::NOT_VALID);
        return false;
    }
}