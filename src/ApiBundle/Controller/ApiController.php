<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * ApiController
 */
class ApiController extends FOSRestController
{
    /**
     * Authenticate user and return JWT token
     *
     * @Post("/login")
     *
     * @ApiDoc(
     *  description="Member Login",
     *  section="Member",
     *  requirements={
     *    {
     *      "name"="username",
     *      "dataType"="string",
     *      "requirement"="\w+",
     *      "description"="Username"
     *    },{
     *      "name"="password",
     *      "dataType"="string",
     *      "requirement"="\w+",
     *      "description"="Password"
     *    }
     *  },
     *  parameters={
     *      {"name"="remember_me", "dataType"="boolean", "required"=true, "description"="Remember"}
     *  },
     *  statusCodes={
     *    200="Returned when successful",
     *    401="Returned when not have token or token expired",
     *    400="Returned if not validated",
     *  }
     * )
     *
     * @return array
     */
    public function loginAction(Request $request)
    {
        // This controller is only to display in API Doc
    }

    /**
     * Demo API
     *
     * @Post("/demo")
     *
     * @ApiDoc(
     *  description="Demo API",
     *  section="Demo",
     *  statusCodes={
     *    200="Returned when successful",
     *    401="Returned when not have token or token expired",
     *    400="Returned if not validated",
     *  }
     * )
     *
     * @return array
     */
    public function demoAction(Request $request)
    {
        $response = array(
            'firstName' => 'Nguyen',
            'lastName' => 'Nhu Tuan',
            'sex' => 'Male',
            'age' => 33,
            'job' => 'Web Developer',
            'email' => 'tuanquynh0508@gmail.com'
        );

        return $response;
    }
}
