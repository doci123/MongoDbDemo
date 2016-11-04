<?php
/**
 *
 *
 * Important links
 *
 * Doctrine Common extensions
 * http://symfony.com/doc/current/doctrine/common_extensions.html
 *
 * MongoDB Config / Settings
 * http://symfony.com/doc/current/bundles/DoctrineMongoDBBundle/config.html
 *
 * MongoDB query builder
 * http://docs.doctrine-project.org/projects/doctrine-mongodb-odm/en/latest/reference/query-builder-api.html
 *
 *
 */
namespace doci123\MongoDbDemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use doci123\MongoDbDemoBundle\Document\DemoDocument;

class DemoController extends Controller
{
    public function indexAction()
    {
        $product = $this->get('doctrine_mongodb')
            ->getRepository('MongoDbDemoBundle:DemoDocument')
            ->findAll();

        $responseValue = ['No items exists, please create item.'];
        // Product is Array of BikeModel object,
        if(count($product) > 0)
        {
            $responseValue = [];
            foreach ($product as $item)
            {
                $responseValue[]=['id' => $item->getId(),'name' => $item->getName()];

            }
        }
        return new JsonResponse( $responseValue, 200,['Content-Type'=>'application/json; charset=UTF-8;']);
    }

    public function addAction(Request $request)
    {
        $name = $request->request->get('name');
        $price = $request->request->get('price');

        $product = new DemoDocument();
        $product->setName($name ? $name :'Item  ' . random_int(10,500));
        $product->setPrice($price ? $price : '9.99');

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($product);
        $dm->flush();

        $response = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
        ];
        return new JsonResponse($response, 201,['Content-Type'=>'application/json; charset=UTF-8;']);
    }

    public function showAction($id)
    {

        $product = $this->get('doctrine_mongodb')
            ->getRepository('MongoDbDemoBundle:DemoDocument')
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No item with id '.$id);
        }

        $response =  [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
        ];

        return new JsonResponse($response, 200,['Content-Type'=>'application/json; charset=UTF-8;']);
    }

    public function updateAction($id, Request $request)
    {
        // getManager, to Managing the object, save remove ...
        $dm = $this->get('doctrine_mongodb')->getManager();

        $product = $dm->getRepository('MongoDbDemoBundle:DemoDocument')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No item found with id '.$id);
        }

        if($request->request->get('name'))
            $product->setName($request->request->get('name'));
        else
            $product->setName('Update product at '. date("Y-m-d H:i:s") );
        if($request->request->get('price'))
            $product->setPrice($request->request->get('price'));

        $dm->flush();

        $response =  [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
        ];
        return new JsonResponse($response, 201,['Content-Type'=>'application/json; charset=UTF-8;']);
    }

    public function deleteAction($id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $product = $dm->getRepository('MongoDbDemoBundle:DemoDocument')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Item not found '.$id);
        }

        $dm->remove($product);
        $dm->flush();

        return new JsonResponse(
            ['id' => $id],
            200,
            ['Content-Type'=>'application/json; charset=UTF-8;']
        );
    }

}
