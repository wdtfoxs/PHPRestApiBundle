<?php
/**
 * Created by PhpStorm.
 * User: wdtfoxs
 * Date: 14.01.18
 * Time: 0:51
 */
namespace RestApiBundle\Controllers;

use JMS\Serializer\SerializerInterface;
use RestApiBundle\Interfaces\RestApiService;
use RestApiBundle\Utils\ServiceFinder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RestController extends Controller implements RestApiService
{
    private $serviceFinder;
    private $serializer;


    /**
     * RestController constructor.
     */
    public function __construct(ServiceFinder $serviceFinder, SerializerInterface $serializer)
    {
        $this->serviceFinder = $serviceFinder;
        $this->serializer = $serializer;
    }

    function findAll()
    {
        // TODO: Implement findAll() method.
    }

    function find($id)
    {
        // TODO: Implement find() method.
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
    }

    function update($id, $object)
    {
        // TODO: Implement update() method.
    }

    function save($object)
    {
        // TODO: Implement save() method.
    }


}