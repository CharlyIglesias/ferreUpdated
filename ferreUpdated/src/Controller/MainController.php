<?php
// src/Controller/MainController.php
namespace App\Controller;

use App\Form\CotizacionForm;
use App\Form\ContactoForm;
use App\Service\MailService;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class MainController extends AbstractController
{
    #[Route('/', name: '_home')]
    public function home(ProductService $productService, Request $request, MailService $mailService): Response
    {
        $lastProducts = $productService->getLastProduct(6);
        return $this->render('home.html.twig', [
            'lastProducts' => $lastProducts
        ]);
    }

    /**
     * @Route("/sendMessage", name="_send_message")
     */
    public function sendMessage(ProductService $productService, Request $request, MailService $mailService)
    {
        $name = $request->query->get("name");
        $subject = $request->query->get("asunto");
        $contentCustomer = $request->query->get("description");
        $fromWho = $request->query->get("email");
        $content = $this->renderView('/EmailTemplate/ContactTemplate.html.twig', ['content' => $contentCustomer, 'user' => $name]);
        
        $response = $mailService->sendEmail($fromWho, $subject, $_ENV['base_email'], $content);
        return $this->json(["data" => $response]);
    }

    
    /**
     * @Route("/receiveQuote", name="_receive_quote")
     */
    public function receiveQuote(ProductService $productService, Request $request, MailService $mailService)
    {
        $name = $request->query->get("name");
        $telefono = $request->query->get("telefono");
        $contentCustomer = $request->query->get("message");
        $fromWho = $request->query->get("email");
        $subject = $name." ha solicitado una cotización.";
        $content = $this->renderView('/EmailTemplate/CotizacionTemplate.html.twig', ['content' => $contentCustomer, 'user' => $name, 'phone' => $telefono]);
        
        $response = $mailService->sendEmail($fromWho, $subject, $_ENV['base_email'], $content);
        return $this->json(["data" => $response]);
    }
}