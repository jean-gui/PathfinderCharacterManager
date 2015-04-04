<?php

namespace Troulite\PathfinderBundle\Controller;


use Midgard\CreatePHP\ArrayLoader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\Party;
use Troulite\PathfinderBundle\Mapper\DoctrineOrmMapper;

/**
 * Logbook controller.
 *
 * @Route("/logbook")
 */
class LogbookController extends Controller
{

    /**
     * @var array
     */
    private $config = array(
        'types' => array(
            'Troulite\\PathfinderBundle\\Entity\\Logbook' => array(
                'config'       => array(
                    'storage' => 'Logbook',
                ),
                'typeof'       => 'schema:WebPage',
                "rev"          => array("dcterms:partOf"),
                'vocabularies' => array(
                    'viejs'   => 'http://viejs.org/ns/',
                    'skos'    => 'http://www.w3.org/2004/02/skos/core#',
                    'schema'  => 'http://schema.org/',
                    'dcterms' => 'http://purl.org/dc/terms/',
                ),
                'children'     => array(
                    "entries" => array(
                        "nodeType" => "collection",
                        "rel"      => "skos:related",
                        "tag-name" => "ul",
                        "rev"      => "dcterms:partOf"
                    ),
                ),
            ),
            'Troulite\\PathfinderBundle\\Entity\\LogbookEntry' => array(
                'config'       => array(
                    'storage' => 'LogbookEntry',
                ),
                'typeof'       => 'schema:WebPage',
                "rev" => array("dcterms:partOf"),
                'vocabularies' => array(
                    'viejs'  => 'http://viejs.org/ns/',
                    'skos'   => 'http://www.w3.org/2004/02/skos/core#',
                    'schema' => 'http://schema.org/',
                    'dcterms' => 'http://purl.org/dc/terms/',
                ),
                'children'     => array(
                    'title'    => array(
                        'property' => 'viejs:headline',
                        'tag-name' => 'h2'
                    ),
                    'content'  => array(
                        'property' => 'viejs:text'
                    ),
                    "children" => array(
                        "nodeType" => "collection",
                        "rel"      => "skos:related",
                        "tag-name" => "ul",
                        //"childtypes" => array('schema:WebPage')
                        "rev"      => "dcterms:partOf"
                    ),
                ),
            ),
        )
    );

    /**
     * Lists all Feat entities.
     *
     * @Route("/{id}", name="logbook")
     * @Method("GET")
     * @Template()
     * @param Party $party
     *
     * @return array
     */
    public function indexAction(Party $party)
    {
        $mapper = new DoctrineOrmMapper(
            array('http://schema.org/WebPage' => 'Troulite\\PathfinderBundle\\Entity\\Logbook'),
            $this->getDoctrine()
        );
        $loader = new ArrayLoader($this->config);

        $manager = $loader->getManager($mapper);

        //$em = $this->getDoctrine()->getManager();

        //$logbookEntry1 = (new LogbookEntry())->setTitle('Title 3')->setContent('Content 3');
        //$party->getLogbook()->addEntry($logbookEntry1);

        //$party->setLogbook($logbook);

        //$em->flush();

        return array(
            'entity'  => $party,
            'logbook' => $manager->getEntity($party->getLogbook())
        );

    }

    /**
     * Lists all Feat entities.
     *
     * @Route("/update", name="logbook_update")
     * @Method({"PUT", "POST"})
     * @Template()
     *
     * @param Request $request
     *
     * @return array
     */
    public function updateLogbookAction(Request $request)
    {
        $mapper  = new DoctrineOrmMapper(
            array('http://schema.org/WebPage' => 'Troulite\\PathfinderBundle\\Entity\\Logbook'),
            $this->getDoctrine()
        );

        $loader = new ArrayLoader($this->config);

        $manager = $loader->getManager($mapper);
        $type = $manager->getType('Troulite\\PathfinderBundle\\Entity\\Logbook');

        $received_data = json_decode($request->getContent(), true);
        $service       = $manager->getRestHandler($received_data);

        $subject = str_replace('<', '', $received_data['@subject']);
        $subject = str_replace('>', '', $subject);

        $jsonld = $service->run($received_data, $type, $subject, strtolower($request->getMethod()));

        //$model = $mapper->getBySubject($subject);

        return array('entity' => json_encode($jsonld));
    }
}
