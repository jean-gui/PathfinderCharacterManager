<?php

namespace App\Controller;

use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\Skill;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SkillController
 * @package App\Controller
 *
 * @Route("/skills")
 */
class SkillController extends AbstractController
{
    /**
     * Lists all Skill entities.
     *
     * @Route("/", name="skills")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $skills = $this->getDoctrine()->getRepository(Skill::class)->findAll();

        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();
        $qb
            ->select('c')
            ->addSelect('t')
            ->addSelect('cs')
            ->from(ClassDefinition::class, 'c')
            ->leftJoin('c.translations', 't')
            ->leftJoin('c.classSkills', 'cs')
            ->where('t.locale = :locale')
            ->orderBy('t.locale', 'ASC')
            ->addOrderBy('t.name', 'ASC')
            ->setParameter('locale', $request->getLocale());
        $classes = $qb->getQuery()->execute();

        return $this->render('skill/index.html.twig', ['skills' => $skills, 'classes' => $classes]);
    }
}
