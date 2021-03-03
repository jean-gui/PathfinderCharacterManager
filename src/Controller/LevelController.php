<?php

namespace App\Controller;

use App\Entity\Characters\Character;
use App\Entity\Characters\CharacterClassPower;
use App\Entity\Characters\CharacterFeat;
use App\Entity\Characters\Level;
use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\Feat;
use App\Form\EditLevelType;
use App\Form\LevelUpFlow;
use App\Repository\ClassSpellRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Level controller.
 *
 * @Route("/characters")
 */
class LevelController extends AbstractController
{

    /**
     * Edits an existing Character entity.
     *
     * @Route("/{id}/levelup", name="characters_levelup")
     * @Template()
     * @Security("is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character   $character
     * @param LevelUpFlow $flow
     *
     * @return array|RedirectResponse
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function levelUpAction(Character $character, LevelUpFlow $flow)
    {
        $level = new Level();
        $level->setValue($character->getLevel() + 1);
        $level->setClassDefinition($character->getFavoredClass());
        $character->addLevel($level);

        if ($level->getClassDefinition() && $level->getClassDefinition()->isPrestige()) {
            $level->setParentClass($character->getFavoredClass());
        }

        $flow->bind($level);

        foreach ($level->getClassDefinition()->getPowers(
            $character->getLevel($level->getClassDefinition())
        ) as $power) {
            $alreadyAdded = false;
            foreach ($level->getClassPowers() as $classPower) {
                if ($classPower->getClassPower() === $power) {
                    $alreadyAdded = true;
                    break;
                }
            }
            if (!$alreadyAdded) {
                $level->addClassPower((new CharacterClassPower())->setClassPower($power));
            }
        }

        // Add powers coming from subclasses
        foreach ($character->getLevels() as $lowerLevel) {
            if (
                $lowerLevel->getClassDefinition() === $level->getClassDefinition()
                && $lowerLevel->getSubClasses()->count() > 0
            ) {
                $levelValue = $character->getLevel($level->getClassDefinition());
                foreach ($lowerLevel->getSubClasses() as $subClass) {
                    $alreadyAdded = false;
                    foreach ($subClass->getPowers($levelValue) as $power) {
                        foreach ($level->getClassPowers() as $classPower) {
                            if ($classPower->getClassPower() === $power) {
                                $alreadyAdded = true;
                                break;
                            }
                        }
                        if (!$alreadyAdded) {
                            $level->addClassPower((new CharacterClassPower())->setClassPower($power));
                        }
                    }
                }
            }
        }
        $flow->bind($level);

        // form of the current step
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished

                // Cleanup empty skills as well
                foreach ($level->getSkills() as $levelSkill) {
                    if ($levelSkill->getValue() === 0) {
                        $level->removeSkill($levelSkill);
                    }
                }

                // Max HP for first level
                if ($character->getLevel() === 1) {
                    $character->getLevels()[0]->setHpRoll($character->getLevels()[0]->getClassDefinition()->getHpDice());
                }

                /** @var $em EntityManager */
                $em = $this->getDoctrine()->getManager();

                // Add fixed extra feats granted by this level
                foreach ($level->getClassPowers() as $power) {
                    $effects = $power->getClassPower()->getEffects();
                    // Extra Feat
                    if (
                        $power->getClassPower()->hasEffects() &&
                        array_key_exists('feat', $effects) &&
                        $effects['feat']['type'] !== 'oneof'
                    ) {
                        // TODO: weird
                        $qb = $em->getRepository(Feat::class)->createQueryBuilder('f');
                        $qb
                            ->leftJoin('f.translations', 't')
                            ->where('t.locale = :locale')
                            ->andWhere('t.name = :name')
                            ->setParameter('locale', 'en')
                            ->setParameter('name', $effects['feat']['value'])
                        ;
                        $feat = $qb->getQuery()->getSingleResult();
                        if ($feat) {
                            $level->addFeat((new CharacterFeat())->setFeat($feat));
                        }
                    }
                    // Extra spell
                    elseif (
                        $power->getClassPower()->hasEffects() &&
                        array_key_exists('spell', $effects) &&
                        $effects['spell']['type'] !== 'oneof'
                    ) {
                        /** @var ClassSpellRepository $csRepo */
                        $csRepo = $em->getRepository(ClassSpell::class);
                        /** @var ClassSpell $classSpell */
                        $classSpell = $csRepo->findByNameAndClass(
                            $effects['spell']['value'],
                            $level->getClassDefinition(),
                            $character->getSubClassesFor($level->getClassDefinition())
                        );
                        if ($classSpell && !$character->getLearnedSpell($classSpell->getSpell(), $level->getClassDefinition())) {
                            $level->addLearnedSpell($classSpell);
                        }
                    }
                }

                $em->persist($level);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    $character . ' is now level ' . $character->getLevel()
                );

                return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
            }
        }

        return array(
            'form'   => $form->createView(),
            'flow'   => $flow,
            'entity' => $character
        );
    }

    /**
     * Edits an existing Character entity.
     *
     * @Route("/{character}/levels/{level}/edit", name="characters_levels_edit")
     * @ParamConverter("level", options={"mapping": {"character" = "character", "level" = "value"}})
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', level.getCharacter()) or is_granted('ROLE_ADMIN')")
     *
     * @param Level   $level
     * @param Request $request
     *
     * @return array|RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function editLevelAction(Level $level, Request $request)
    {
        $character = $level->getCharacter();

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(
            EditLevelType::class,
            $level,
            [
                'action' => $this->generateUrl(
                    'characters_levels_edit',
                    ['character' => $character->getId(), 'level' => $level->getValue()]
                ),
                'method' => 'PUT',
            ]
        );
        $form->add('submit', SubmitType::class, array('label' => 'Update'));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
        }

        return array(
            'form'   => $form->createView(),
            'entity' => $character,
            'level'  => $level
        );
    }
}
