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
 * @author Mathijs Cuppens <mathijs.cuppens@litus.cc>
 * @author Floris Kint <floris.kint@vtk.be>
 *
 * @license http://litus.cc/LICENSE
 */

namespace BrBundle\Controller\Admin\Match;

use BrBundle\Entity\Match\Profile;
use BrBundle\Entity\Match\Profile\ProfileCompanyMap;
use BrBundle\Entity\Match\Profile\ProfileFeatureMap;
use BrBundle\Entity\Match\Profile\ProfileStudentMap;
use Laminas\View\Model\ViewModel;

/**
 * ProfileController
 *
 * @author Robin Wroblowski <robin.wroblowski@vtk.be>
 */
class ProfileController extends \CommonBundle\Component\Controller\ActionController\AdminController
{
    public function manageAction()
    {
        $profiles = $this->getEntityManager()
            ->getRepository('BrBundle\Entity\Match\Profile')
            ->findAll();

        $paginator = $this->paginator()->createFromArray(
            $profiles,
            $this->getParam('page')
        );

        return new ViewModel(
            array(
                'paginator'         => $paginator,
                'paginationControl' => $this->paginator()->createControl(true),
                'em'                => $this->getEntityManager(),
            )
        );
    }

    public function matchesAction()
    {
        $profile = $this->getProfileEntity();

        $matches = array();
        if ($profile->getProfileType() == 'student') {
            $student = $this->getEntityManager()->getRepository('BrBundle\Entity\Match\Profile\ProfileStudentMap')
                ->findOneByProfile($profile)->getStudent();
            $maps = $this->getEntityManager()->getRepository('BrBundle\Entity\Match\MatcheeMap\StudentMatcheeMap')
                ->findByStudent($student);
            foreach ($maps as $map) {
                $matches[] = $this->getEntityManager()->getRepository('BrBundle\Entity\Match')
                    ->findOneByStudentMatchee($map);
            }
        } elseif ($profile->getProfileType() == 'company') {
            $company = $this->getEntityManager()->getRepository('BrBundle\Entity\Match\Profile\ProfileCompanyMap')
                ->findOneByProfile($profile)->getCompany();
            $maps = $this->getEntityManager()->getRepository('BrBundle\Entity\Match\MatcheeMap\CompanyMatcheeMap')
                ->findByCompany($company);
            foreach ($maps as $map) {
                $matches[] = $this->getEntityManager()->getRepository('BrBundle\Entity\Match')
                    ->findOneByCompanyMatchee($map);
            }
        }

        $paginator = $this->paginator()->createFromArray(
            $matches,
            $this->getParam('page')
        );

        return new ViewModel(
            array(
                'paginator'         => $paginator,
                'paginationControl' => $this->paginator()->createControl(true),
                'student'           => $student ?? null,
                'company'           => $company ?? null,
            )
        );
    }

    public function addAction()
    {
        $form = $this->getForm('br_match_profile_add');

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->setData($formData);

            if ($form->isValid()) {
                $profile = $form->hydrateObject();
                $this->getEntityManager()->persist($profile);

                if ($formData['type'] === 'student') {
                    $student = $this->getEntityManager()->getRepository('CommonBundle\Entity\User\Person')
                        ->findOneById($formData['student']['id']);
                    $map = new ProfileStudentMap($student, $profile);
                    $this->getEntityManager()->persist($map);
                } elseif ($formData['type'] === 'company') {
                    $company = $this->getEntityManager()->getRepository('BrBundle\Entity\Company')
                        ->findOneById($formData['company'][0]);
                    $map = new ProfileCompanyMap($company, $profile);
                    $this->getEntityManager()->persist($map);
                }

                foreach (array_values($formData['features_ids']) as $feature) {
                    $map = new ProfileFeatureMap(
                        $this->getEntityManager()
                            ->getRepository('BrBundle\Entity\Match\Feature')
                            ->findOneById($feature),
                        $profile
                    );
                    $this->getEntityManager()->persist($map);
                    $profile->addFeature($map);
                }
                $this->getEntityManager()->flush();
                $this->flashMessenger()->success(
                    'Success',
                    'The profile was successfully created!'
                );

                $this->redirect()->toRoute(
                    'br_admin_match_profile',
                    array(
                        'action' => 'manage',
                    )
                );

                return new ViewModel();
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
            )
        );
    }

    public function editAction()
    {
        $profile = $this->getProfileEntity();
        if ($profile === null) {
            return new ViewModel();
        }

        $form = $this->getForm('br_match_profile_edit', array('features' => $profile->getFeatures()->toArray(), 'profile' => $profile));

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->setData($formData);

            if ($form->isValid()) {
                // Set the new features and remove the old profileFeatureMaps

                // Get old features
                $oldFeatures = $profile->getFeatures()->toArray();
                $oldFeaturesIds = array();
                foreach ($oldFeatures as $oldFeature) {
                    $oldFeaturesIds[] = $oldFeature->getFeature()->getId();
                }

                // Get new features
                $newFeatureIds = array_values($formData['features_ids']);

                // Add the new profileFeatureMaps to the database
                foreach ($newFeatureIds as $feature) {
                    if (!in_array($feature, $oldFeaturesIds)) {
                        $map = new ProfileFeatureMap(
                            $this->getEntityManager()
                                ->getRepository('BrBundle\Entity\Match\Feature')
                                ->findOneById($feature),
                            $profile
                        );
                        $this->getEntityManager()->persist($map);
                        $profile->addFeature($map);
                    }
                }

                // Remove old profileFeatureMaps from database
                foreach (array_diff($oldFeaturesIds, $newFeatureIds) as $removableFeatures) {
                    $map = $this->getEntityManager()
                        ->getRepository('BrBundle\Entity\Match\Profile\ProfileFeatureMap')
                        ->findOneByProfileAndFeatureId($profile, $removableFeatures);
                    $this->getEntityManager()->remove($map);
                }

                $this->getEntityManager()->flush();

                $this->flashMessenger()->success(
                    'Success',
                    'The profile was succesfully updated!'
                );

                $this->redirect()->toRoute(
                    'br_admin_match_profile',
                    array(
                        'action' => 'manage',
                    )
                );

                return new ViewModel();
            }
        }

        return new ViewModel(
            array(
                'form'    => $form,
                'profile' => $profile,
            )
        );
    }

    public function deleteAction()
    {
        $this->initAjax();

        $profile = $this->getProfileEntity();
        if ($profile === null) {
            return new ViewModel();
        }

        foreach ($profile->getFeatures() as $f) {
            $this->getEntityManager()->remove($f);
        }
        if ($profile->getProfileType() == 'student') {
            $this->getEntityManager()->remove(
                $this->getEntityManager()->getRepository('BrBundle\Entity\Match\Profile\ProfileStudentMap')
                    ->findOneByProfile($profile)
            );
        } elseif ($profile->getProfileType() == 'company') {
            $this->getEntityManager()->remove(
                $this->getEntityManager()->getRepository('BrBundle\Entity\Match\Profile\ProfileCompanyMap')
                    ->findOneByProfile($profile)
            );
        }

        $this->getEntityManager()->remove($profile);

        $this->getEntityManager()->flush();

        return new ViewModel(
            array(
                'result' => (object) array('status' => 'success'),
            )
        );
    }

    /**
     * @return Profile|null
     */
    private function getProfileEntity()
    {
        $profile = $this->getEntityById('BrBundle\Entity\Match\Profile');

        if (!($profile instanceof Profile)) {
            $this->flashMessenger()->error(
                'Error',
                'No profile was found!'
            );

            $this->redirect()->toRoute(
                'br_admin_match_profile',
                array(
                    'action' => 'manage',
                )
            );

            return;
        }

        return $profile;
    }
}