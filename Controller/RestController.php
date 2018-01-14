<?php
/**
 * Created by PhpStorm.
 * User: wdtfoxs
 * Date: 14.01.18
 * Time: 0:51
 */

namespace RestApiBundle\Controller;


use RestApiBundle\Utils\ServiceFinder;
use RestApiBundle\Interfaces\RestApiService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class RestController extends Controller
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

    public function findAll(string $entity)
    {
        $restService = $this->getRestService($this->serviceFinder->findService($entity));
        $encoded = $this->serializer->serialize($restService->findAll(), 'json');
        return new Response($encoded, 200, array('Content-Type' => 'application/json'));
    }


    public function find(string $entity, $id)
    {
        $restService = $this->getRestService($this->serviceFinder->findService($entity));
        $encoded = $this->serializer->serialize($restService->find($id), 'json');
        return new Response($encoded, 200, array('Content-Type' => 'application/json'));
    }


    public function delete(string $entity, $id)
    {
        $restService = $this->getRestService($this->serviceFinder->findService($entity));
        try {
            $restService->delete($id);
            return new Response(null, 200, array('Content-Type' => 'application/json'));
        } catch (\Exception $e) {
            return new Response('Something went wrong', 400, array('Content-Type' => 'application/json'));
        }
    }


    public function deleteAll(string $entity)
    {
        $restService = $this->getRestService($this->serviceFinder->findService($entity));
        try {
            $restService->deleteAll();
            return new Response(null, 200, array('Content-Type' => 'application/json'));
        } catch (\Exception $e) {
            return new Response('Something went wrong', 400, array('Content-Type' => 'application/json'));
        }
    }


    public function update(string $entity, $id, Request $request)
    {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = $request->getContent();
            //$request->request->replace(is_array($data) ? $data : []);
            $restService = $this->getRestService($this->serviceFinder->findService($entity));
            try {
                $restService->update($id, $data);
                return new Response(null, 201);
            } catch (\Exception $e) {
                return new Response('Invalid request', 400, array('Content-Type' => 'application/json'));
            }
        } else {
            return new Response('Invalid request', 400, array('Content-Type' => 'application/json'));
        }
    }


    public function save(string $entity, Request $request)
    {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = $request->getContent();
            //$request->request->replace(is_array($data) ? $data : []);
            $restService = $this->getRestService($this->serviceFinder->findService($entity));
            try {
                $restService->save($data);
                return new Response("{OK}", 201,array('Content-Type' => 'application/json'));
            } catch (\Exception $e) {
                return new Response('{Invalid request}', 400, array('Content-Type' => 'application/json'));
            }
        } else {
            return new Response('Invalid request', 400, array('Content-Type' => 'application/json'));
        }
    }


    private function getRestService(string $serviceClass): RestApiService
    {
        return $this->get($serviceClass);
    }
}
