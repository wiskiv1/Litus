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

namespace CudiBundle\Controller\Admin\Sales\Article;

use CommonBundle\Component\FlashMessenger\FlashMessage,
    CudiBundle\Entity\Sales\Articles\Discounts\Discount,
    CudiBundle\Form\Admin\Sales\Article\Discounts\Add as AddForm,
    Zend\View\Model\ViewModel;

/**
 * DiscountController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class DiscountController extends \CudiBundle\Component\Controller\ActionController
{
    public function manageAction()
    {
        if (!($article = $this->_getSaleArticle()))
            return new ViewModel();

        $form = new AddForm($article, $this->getEntityManager());

        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->setData($formData);

            if ($form->isValid()) {
                $formData = $form->getFormData($formData);

                $discount = new Discount($article);

                if ($formData['template'] == 0) {
                    $discount->setDiscount(
                        $formData['value'],
                        $formData['method'],
                        $formData['type'],
                        $formData['rounding'],
                        $formData['apply_once']
                    );
                } else {
                    $template = $this->getEntityManager()
                        ->getRepository('CudiBundle\Entity\Sales\Articles\Discounts\Template')
                        ->findOneById($formData['template']);

                    $discount->setTemplate($template);
                }

                $this->getEntityManager()->persist($discount);

                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'SUCCESS',
                        'The discount was successfully created!'
                    )
                );

                $this->redirect()->toRoute(
                    'cudi_admin_sales_article_discount',
                    array(
                        'action' => 'manage',
                        'id' => $article->getId(),
                    )
                );

                return new ViewModel();
            }
        }

        $discounts = $this->getEntityManager()
            ->getRepository('CudiBundle\Entity\Sales\Articles\Discounts\Discount')
            ->findByArticle($article);

        return new ViewModel(
            array(
                'article' => $article,
                'discounts' => $discounts,
                'form' => $form,
            )
        );
    }

    public function deleteAction()
    {
        $this->initAjax();

        if (!($discount = $this->_getDiscount()))
            return new ViewModel();

        $this->getEntityManager()->remove($discount);
        $this->getEntityManager()->flush();

        return new ViewModel(
            array(
                'result' => (object) array("status" => "success"),
            )
        );
    }

    private function _getSaleArticle()
    {
        if (null === $this->getParam('id')) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Error',
                    'No ID was given to identify the article!'
                )
            );

            $this->redirect()->toRoute(
                'cudi_admin_sales_article',
                array(
                    'action' => 'manage'
                )
            );

            return;
        }

        $article = $this->getEntityManager()
            ->getRepository('CudiBundle\Entity\Sales\Article')
            ->findOneById($this->getParam('id'));

        if (null === $article) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Error',
                    'No article with the given ID was found!'
                )
            );

            $this->redirect()->toRoute(
                'cudi_admin_sales_article',
                array(
                    'action' => 'manage'
                )
            );

            return;
        }

        return $article;
    }

    private function _getDiscount()
    {
        if (null === $this->getParam('id')) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Error',
                    'No ID was given to identify the discount!'
                )
            );

            $this->redirect()->toRoute(
                'cudi_admin_sales_article',
                array(
                    'action' => 'manage'
                )
            );

            return;
        }

        $discount = $this->getEntityManager()
            ->getRepository('CudiBundle\Entity\Sales\Articles\Discounts\Discount')
            ->findOneById($this->getParam('id'));

        if (null === $discount) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Error',
                    'No discount with the given ID was found!'
                )
            );

            $this->redirect()->toRoute(
                'cudi_admin_sales_article',
                array(
                    'action' => 'manage'
                )
            );

            return;
        }

        return $discount;
    }
}