<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
     private $entityManager;
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;	
	}
    
    // dd($this->getUser()->getAdresses()->getValue());
    // getUser : get current user
    // getAddresses : get les addresses mais BdD relationnelle => il nous faut les valeurs correspondantes
    // getValues : get les valeurs correspondantes
    #[Route('/commande', name: 'app_order')]
   public function index(Cart $cart, Request $request): Response
    {
    //   if( ! $this->getUser()->getAddresses()->getValues()){
    //         return $this->redirectToRoute('account_address_add');
    //     }
        
        // createForm : OrderType / null (instance de la classe ex : $search etc..) / [current user]
        $form = $this->createForm(OrderType::class, null,[
            'user' => $this->getUser()
        ]); 

        $form = $form->handleRequest($request); // 1. ecoute de la request

        if ($form->isSubmitted() && $form->isValid()){// if 2(ecoute) && 3(check EmailType etc...)
            // dd($form->getData());
        }
   
        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }

    #[Route('/commande/recapitutulatif', name: 'app_order_recap')]
    public function add(Cart $cart, Request $request): Response
    {

        // createForm : OrderType / null (instance de la classe ex : $search etc..) / [current user]
        $form = $this->createForm(OrderType::class, null,[
            'user' => $this->getUser()
        ]); 

        $form = $form->handleRequest($request); // 1. ecoute de la request

        if ($form->isSubmitted() && $form->isValid()){// if 2(ecoute) && 3(check EmailType etc...)
            $form = $this->createForm(OrderType::class, null, [
                'user' => $this->getUser()
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $date = new \DateTimeImmutable();
                $carriers = $form->get('carriers')->getData();
                $delivery = $form->get('address')->getData();
                $delivery_content = $delivery->getFirstName().' '.$delivery->getLastName();
                $delivery_content .= '<br>'.$delivery->getPhone();
                
                if ($delivery->getCompany()) {
                    $delivery_content .= '<br>'.$delivery->getCompany();
                }

                $delivery_content .= '<br>'.$delivery->getAddress();
                $delivery_content .= '<br>'.$delivery->getPostal().' '.$delivery->getCity();
                $delivery_content .= '<br>'.$delivery->getCountry();

                // dd($delivery_content);

                //Enregistre ma commande Order()
                $order = new Order();
                $order->setUser($this->getUser());
                $order->setCreatedAt($date);
                $order->setCarrierName($carriers->getName());
                $order->setCarrierPrice($carriers->getPrice());
                $order->setDelivery($delivery_content);
                $order->setIsPaid(0);

                $this->entityManager->persist($order);

                // Enregistre mes produits OrderDetails()
                foreach ($cart->getFull() as $product) {
                    $orderDetails = new OrderDetails();
                    $orderDetails->setMyOrder($order);
                    $orderDetails->setProduct($product['product']->getName());
                    $orderDetails->setQuantity($product['quantity']);
                    $orderDetails->setPrice($product['product']->getPrice());
                    $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                    // dd($product);

                    $this->entityManager->persist($orderDetails);
                }

                // $this->entityManager->flush();
            }
        }
        return $this->render('order/add.html.twig', [
            'cart' => $cart->getFull(),
            'carrier' => $carriers,
            'delivery' => $delivery_content
        ]);

        
        return $this->redirectToRoute('app_cart');
    }

}
