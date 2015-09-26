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
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\Feat;
use Troulite\PathfinderBundle\Form\FeatType;

/**
 * Feat controller.
 *
 * @Route("/feats")
 */
class FeatController extends Controller
{

    /**
     * Lists all Feat entities.
     *
     * @Route("/", name="feats")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $dql = <<<___DQL
            SELECT f FROM TroulitePathfinderBundle:Feat f ORDER BY f.name
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
     * Finds and displays a Feat entity.
     *
     * @Route("/{id}", name="feats_show", requirements={"id": "\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param Feat $feat
     *
     * @return array
     */
    public function showAction(Feat $feat)
    {
        return array(
            'entity'      => $feat,
        );
    }

    /**
     * @Route("/{id}/edit", name="feats_edit")
     * @Method({"GET", "PUT"})
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     *
     * @param Feat $feat
     * @param Request $request
     *
     * @return array
     */
    public function editAction(Feat $feat, Request $request)
    {
        $form = $this->createForm(
            new FeatType(),
            $feat,
            array('method' => 'PUT')
        );
        $form->add('submit', 'submit', array('label' => 'save'));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', $feat . ' successfully updated');

            return $this->redirectToRoute('feats_show', array('id' => $feat->getId()));
        }

        return array(
            'form'   => $form->createView(),
            'entity' => $feat
        );
    }

    /**
     * @Route("/new", name="feats_new")
     * @Method({"GET", "POST"})
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     *
     * @param Request $request
     *
     * @return array
     */
    public function newAction(Request $request)
    {
        $feat = new Feat();

        $form = $this->createForm(
            new FeatType(),
            $feat,
            array('method' => 'POST')
        );
        $form->add('submit', 'submit', array('label' => 'save'));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($feat);
            $em->flush();

            $this->addFlash('success', $feat . ' successfully saved');

            return $this->redirectToRoute('feats_show', array('id' => $feat->getId()));
        }

        return array(
            'form'   => $form->createView(),
            'entity' => $feat
        );
    }
}
