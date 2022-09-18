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
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Préparation en cous', 'fas fa-box-open')->linkToCrudAction('UpdatePreparation');
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cous', 'fas fa-truck')->linkToCrudAction('UpdateDelivery');

        return $actions
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->add('index', 'detail');
    }

    public function updatePreparation(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(2);

        $this->entityManager->flush();
 
        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        $this->addFlash('notice', '<span style="color:green;"><strong>La commande' . $order->getReference() . ' est bien en cours de préparation</strong></span>');

        return $this->redirect($url);
    }

    public function updateDelivery(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(3);

        $this->entityManager->flush();
 
        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        $this->addFlash('notice', '<span style="color:blue;"><strong>La commande' . $order->getReference() . ' est bien en cours de livraison</strong></span>');

        return $this->redirect($url);
    }

    public function configureCrud(Crud $crud): Crud
    {
        // J'affiche mes id par défaut par ordre décroissant
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

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
            ]),
            ArrayField::new('orderDetails', 'Produits achetés')->hideOnIndex()
        ];
    }

}
