<?php
/**
 * Commentaires
 */
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
    
    
    // getUser : get current user
    // getAddresses : get les addresses mais BdD relationnelle => il nous faut les valeurs correspondantes
    // getValues : get les valeurs correspondantes
    #[Route('/commande', name: 'app_order')]
    public function index(Cart $cart)
    {
        $count = $cart->count();

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if (!$this->getUser()->getAddresses()->getValues())// si pas d'adresse => redir vers ajouter une adresse
        {
            return $this->redirectToRoute('app_account_address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull(),
            'count' => $count,
        ]);
    }

    #[Route('/commande/recapitutulatif', name: 'app_order_recap')]
    public function add(Cart $cart, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // createForm : OrderType / null (instance de la classe ex : $search etc..) / [current user]
        $form = $this->createForm(OrderType::class, null,[
            'user' => $this->getUser()
        ]); 

        $form = $form->handleRequest($request); // 1. ecoute de la request

        if ($form->isSubmitted() && $form->isValid()){// if 2(ecoute) && 3(check EmailType etc...)
            // dd($form);
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('address')->getData();
    
            $delivery_content = $delivery->getFirstName().' '.$delivery->getLastName();
            $delivery_content .= '<br>'.$delivery->getPhone();

            if($delivery->getCompany()){
                $delivery_content .= '<br>'.$delivery->getCompany();
            }

            $delivery_content .= '<br>'.$delivery->getAddress().'<br>'.$delivery->getPostal().' '.$delivery->getCity();
    
            // dd($form->getData());

            $date = new \DateTimeImmutable();

            $order = new Order();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);

            // enregistrer la commande Order
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setState(0);

            $this->entityManager->persist($order);


            foreach($cart->getFull() as $product){

                $orderDetails = new OrderDetails();
                // enregistrer les produits OrderDetails
                $orderDetails->setMyOrder($order); // MyOrder est la propri??t?? de la relation Id avec l'entity Order
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['quantity'] * $product['product']->getPrice()  );
                $orderDetails->setMyOrder($order);

                // dd($order);

                $this->entityManager->persist($orderDetails);
                // dump($product['product']);
            }
            // dd($order);

            $this->entityManager->flush(); // enregistrement BdD

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $carriers,
                'delivery' => $delivery_content,
                'reference' => $order->getReference(),
                'count' => $cart->count()
            ]);
        }
        return $this->redirectToRoute('cart');
    }

}
