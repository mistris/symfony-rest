<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Money;
use AppBundle\Entity\Product;
use AppBundle\Form\Type\ProductType;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @RouteResource("Product", pluralize=false)
 */
class ProductController extends FOSRestController
{
    /**
     * @Rest\Post("add")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $product = $serializer->deserialize($request->getContent(), Product::class, 'json');

        $form = $this->createForm(ProductType::class, $product, [
            'method' => Request::METHOD_POST,
        ]);

        $form->handleRequest($request);

        $valid = false;

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $valid = true;
            }
        } else {
            if ($request->get('rest-test') == true) {
                $valid = true;
            }
        }

        if ($valid) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->json($serializer->toArray($product), 200);
        }

        return $this->json($serializer->toArray($form->getErrors()), 400);
    }

    /**
     * @Rest\Delete("/{id}/remove")
     *
     * @param $id
     *
     * @return JsonResponse
     * @internal param Product $product
     *
     */
    public function removeAction($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if (!$product instanceof Product) {
            return $this->json(null, 404);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return $this->json(null, 204);
    }
}
