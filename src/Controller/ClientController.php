<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends AbstractController
{
    /**
     * @Route("api/client", name="client", methods={"POST"})
     */
    public function create(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
            $soap = new \SoapClient($this->getParameter('uri'));

            $result = $soap->__call('client', $data);
        } 
        catch (\SoapFault $e)
        {
            return $this->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ]);
        }

        return $this->json([
            'message' => 'Client created',
            'status' => 'success',
        ]);
    }

    /**
     * @Route("api/reload", name="reload", methods={"POST"})
     */
    public function reload(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $soap = new \SoapClient($this->getParameter('uri'), 
                                ['trace' => 1, 
                                'cache_wsdl'=> WSDL_CACHE_NONE ]);

        $result = $soap->__call('reload', $data);

        try {
            
        } 
        catch (\SoapFault $e)
        {
            
            return $this->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ]);
        }

        return $this->json([
            'message' => 'Wallet recharged',
            'status' => 'success',
        ]);
    }
}
