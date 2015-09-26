<?php

/*
 * Copyright 2015 Jean-Guilhem Rouel
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Troulite\PathfinderBundle\Controller;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Troulite\PathfinderBundle\Entity\Spell;

/**
 * Spell controller.
 *
 * @Route("/spells")
 */
class SpellController extends Controller
{

    /**
     * Lists all Spell entities.
     *
     * @Route("/", name="spells")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $dql = <<<___DQL
            SELECT s, cs, c FROM TroulitePathfinderBundle:Spell s
            JOIN s.classes cs
            JOIN cs.class c
             ORDER BY s.name
___DQL;

        $query = $em->createQuery($dql);

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $query->useResultCache(
            true,
            3600
        );

        $entities = $query->getResult();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Spell entity.
     *
     * @Route("/{id}", name="spells_show")
     * @Method("GET")
     * @Template()
     *
     * @param Spell $spell
     *
     * @return array
     */
    public function showAction(Spell $spell)
    {
        return array(
            'entity'      => $spell,
        );
    }
}
