<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LuckyController extends AbstractController
{
    /**
     *  @Route("lucky/number/{max?}", name="app_lucky_number", methods={"GET","HEAD"})
     */
    public function number(int $max=null, Request $request): Response
    {
        $max = $max > 1 ? $max : 100;
        $number = random_int(0, $max);
        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }
    
    /**
     *  @Route("/terms-and-conditions", name="terms-and-conditions", methods={"GET","HEAD"})
     */
    public function termsAndConditions(): Response
    {
        return $this->render('static/terms_and_conditions.html.twig', []);
    }
    /**
     * @Route("user/download", name="download")
     * force to download file
     */
    public function download(): BinaryFileResponse
    {
        
        //return $this->file('/VIKAS UNIYAL-CV.pdf');
    }
}

//ghena bidha ittawear alla telefone