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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Troulite\PathfinderBundle\Entity\Item;
use Troulite\PathfinderBundle\Entity\Weapon;
use Troulite\PathfinderBundle\Form\Item\ItemType;
use Troulite\PathfinderBundle\Form\Item\WeaponType;


/**
 * Item controller.
 *
 * @Route("/items")
 */
class ItemsController extends Controller
{
    /**
     * @Route("/", name="list_items")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('TroulitePathfinderBundle:Item')->findAll();

        return array('entities' => $items);
    }

    /**
     * @Route("/{id}", name="items_show")
     *
     * @param Item $item
     *
     * @return array
     */
    public function showAction(Item $item)
    {
        $class_fragments = explode('\\', get_class($item));
        $type = strtolower($class_fragments[count($class_fragments) - 1]);

        $template = 'TroulitePathfinderBundle:Items:show_' . $type . '.html.twig';

        if (!$this->get('templating')->exists($template)) {
            $template = 'TroulitePathfinderBundle:Items:show.html.twig';
        }

        return $this->render(
            $template,
            array('entity' => $item)
        );
    }

    /**
     * @Route("/{id}/edit", name="items_edit")
     * @Method({"GET", "PUT"})
     * @Template()
     *
     * @param Item $item
     * @param Request $request
     *
     * @return array
     */
    public function editAction(Item $item, Request $request)
    {
        $formType = new ItemType();
        if ($item instanceof Weapon) {
            $formType = new WeaponType();
        }

        $form = $this->createForm(
            $formType,
            $item,
            array(
                'method' => 'PUT',
            )
        );
        $form->add('submit', 'submit', array('label' => 'Update'));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', $item->getName() . ' successfully saved');
        }

        return array('entity' => $item, 'form' => $form->createView());
    }
}