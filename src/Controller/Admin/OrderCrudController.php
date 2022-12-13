<?php

namespace App\Controller\Admin;


use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class OrderCrudController extends AbstractCrudController
{
    // Je flush les donées liée à la modification des statut de commande à l'aide de doctrine
    private $entityManager;
    private $adminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator  $adminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator; // Permet de générer un URL de redirection
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    // Configuration des nouvelles actions de easy admin en plus de l'affichage par défault
    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Préparation en cours', 'fas fa-box-open')->linkToCrudAction('UpdatePreparation'); // Initialisation du bouton updatePreparation Préparation en cours
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cours', 'fas fa-truck')->linkToCrudAction('UpdateDelivery'); // Initialisation du bouton updateDelivery Livraison en cours

        return $actions
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->add('index', 'detail');
    }

    public function updatePreparation(AdminContext $context)
    {
        // Initialisation de la variable order dans easy admin
        $order = $context->getEntity()->getInstance();
        // Définition de la nouvelle valeur de la propriété State de l'object de l' entité Order
        $order->setState(2);

        // Mise à jour de la base de donnée
        $this->entityManager->flush();
 
        // initialisation de l'url
        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        // Notification
        $this->addFlash('notice', '<span style="color:green;"><strong>La commande' . $order->getReference() . ' est bien en cours de préparation</strong></span>');  

        // Redirection avec les paramètres le l'url 
        return $this->redirect($url);
    }

    public function updateDelivery(AdminContext $context)
    {
        // Initialisation de la variable order dans easy admin
        $order = $context->getEntity()->getInstance();
        // Définition de la nouvelle valeur de la propriété State de l'object de l' entité Order
        $order->setState(3);

        $this->entityManager->flush();
 
        // initialisation de l'url
        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        // Notification
        $this->addFlash('notice', '<span style="color:blue;"><strong>La commande' . $order->getReference() . ' est bien en cours de livraison</strong></span>');

        // Redirection avec les paramètres le l'url 
        return $this->redirect($url);
    }

    // Modification du trie par défault (Du plus ancien au plus vieux DESC)
    public function configureCrud(Crud $crud): Crud
    {
        // J'affiche mes id par défaut par ordre décroissant
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    // Configuration des champs de easy admin en lien avec l'entité Order
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createdAt', 'Passée le')->setFormat('dd-MM-yyyy hh:mm:ss'),
            TextField::new('user.getFullName', 'Client'),
            TextEditorField::new('delivery', 'Adresse de livraison')->formatValue(function ($value) { return $value; })->onlyOnDetail(),
            MoneyField::new('total', 'Total produit')->setCurrency('EUR'),
            TextField::new('carrierName', 'Transporteur'),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),
            ChoiceField::new('state')->setChoices([
                'Non payée' => 0,
                'Payée' => 1,
                'Préparation en cours' => 2,
                'Livraison en cours' => 3,
                'Livrée' => 4
            ]),
            ArrayField::new('orderDetails', 'Produits achetés')->hideOnIndex()
        ];
    }

}
