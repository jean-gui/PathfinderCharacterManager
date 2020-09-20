<?php

namespace App\Controller;

use App\Entity\Items\Item;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Item controller.
 *
 * @Route("/items")
 */
class ItemsController extends AbstractController
{
    /**
     * @Route(
     *      "/{slot}",
     *      name="list_items",
     *      requirements={"slot": "item|belt|eyes|chest|armor|body|headband|weapon|feet|hands|wrists|ring|shield|shoulders|neck"},
     *      defaults={"slot": "item"})
     * @Template()
     *
     * @param string $slot
     *
     * @return array
     */
    public function indexAction($slot = 'item')
    {
        $em = $this->getDoctrine()->getManager();

        $class = ucfirst($slot);
        $items = $em->getRepository('App\\Entity\\Items\\' . $class)->findAll();

        return array('entities' => $items);
    }

    /**
     * @Route("/{id}", name="items_show", requirements={"id"="\d+"})
     *
     * @param Item $item
     *
     * @return Response
     */
    public function showAction(Item $item)
    {
        $class_fragments = explode('\\', get_class($item));
        $type = strtolower($class_fragments[count($class_fragments) - 1]);

        $template = '/items/show_' . $type . '.html.twig';

        if (!$this->get('twig')->getLoader()->exists($template)) {
            $template = 'items/show.html.twig';
        }

        return $this->render(
            $template,
            ['entity' => $item]
        );
    }
}