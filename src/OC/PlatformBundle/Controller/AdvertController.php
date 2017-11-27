<?php
namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Form\AdvertEditType;
use OC\PlatformBundle\Repository\AdvertRepository;
use OC\PlatformBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\QueryBuilder;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use OC\PlatformBundle\Form\AdvertType;

class AdvertController extends Controller
{
    public function indexAction($page)

    {

        // On ne sait pas combien de pages il y a

        // Mais on sait qu'une page doit être supérieure ou égale à 1

        if ($page < 1) {

            // On déclenche une exception NotFoundHttpException, cela va afficher

            // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)

            throw new NotFoundHttpException('Page Demandée"'.$page.'" Non Trouvée.');

        }


        // Ici, on récupérera la liste des annonces, puis on la passera au template


        // Mais pour l'instant, on ne fait qu'appeler le template

        return $this->render('OCPlatformBundle:Advert:index.html.twig');

    }


    public function viewAction($id)

    {

        // Ici, on récupérera l'annonce correspondante à l'id $id


        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(

            'id' => $id

        ));

    }


    public function addAction(Request $request)

    {

        // Création de l'entité

        $advert = new Advert();

        $advert->setTitre('Recherche développeur Symfony.');

        $advert->setAuthor('Alexandre');

        $advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");


        // Création de l'entité Image

       // $image = new Image();

      //  $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');

      //  $image->setAlt('Job de rêve');


        // On lie l'image à l'annonce

        //$advert->setImage($image);


        // On récupère l'EntityManager

       // $em = $this->getDoctrine()->getManager();


        // Étape 1 : On « persiste » l'entité

       // $em->persist($advert);


        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},

        // on devrait persister à la main l'entité $image

        // $em->persist($image);


        // Étape 2 : On déclenche l'enregistrement

       // $em->flush();


        // Reste de la méthode qu'on avait déjà écrit

        /*
        if ($request->isMethod('POST')) {

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');


            // Puis on redirige vers la page de visualisation de cettte annonce

            return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));

        }
        */

        // Si on n'est pas en POST, alors on affiche le formulaire


        // Création d'une première candidature

        $application1 = new Application();

        $application1->setAuthor('Marine');

        $application1->setContent("J'ai toutes les qualités requises.");


        // Création d'une deuxième candidature par exemple

        $application2 = new Application();

        $application2->setAuthor('Pierre');

        $application2->setContent("Je suis très motivé.");


        // On lie les candidatures à l'annonce

        $application1->setAdvert($advert);

        $application2->setAdvert($advert);


        // On récupère l'EntityManager

        $em = $this->getDoctrine()->getManager();


        // Étape 1 : On « persiste » l'entité

        $em->persist($advert);


        // Étape 1 ter : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est

        // définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.

        $em->persist($application1);

        $em->persist($application2);


        // Étape 2 : On « flush » tout ce qui a été persisté avant

        $em->flush();

       // return $this->render('OCPlatformBundle:Advert:add.html.twig', array('advert' => $advert));
        return $this->render('OCPlatformBundle:Advert:add-annonce.html.twig', array('advert' => $advert,'application1'=>$application1,'application2'=>$application2));

    }


    public function editAction($id, Request $request)

    {

        // Ici, on récupérera l'annonce correspondante à $id


        // Même mécanisme que pour l'ajout

        if ($request->isMethod('POST')) {

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');


            return $this->redirectToRoute('oc_platform_view', array('id' => 5));

        }


        return $this->render('OCPlatformBundle:Advert:edit.html.twig');

    }



    public function editImageAction($advertId)

    {

        $em = $this->getDoctrine()->getManager();


        // On récupère l'annonce

        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($advertId);


        // On modifie l'URL de l'image par exemple

        $advert->getImage()->setUrl('https://images-na.ssl-images-amazon.com/images/M/MV5BMTIxOTY1NjUyN15BMl5BanBnXkFtZTcwMjMxMDk1MQ@@._V1_UX182_CR0,0,182,268_AL_.jpg');


        // On n'a pas besoin de persister l'annonce ni l'image.

        // Rappelez-vous, ces entités sont automatiquement persistées car

        // on les a récupérées depuis Doctrine lui-même



        // On déclenche la modification

        $em->flush();


        return $this->render('OCPlatformBundle:Advert:add.html.twig', array('advert' => $advert));

    }





    public function deleteAction($id)

    {

        // Ici, on récupérera l'annonce correspondant à $id


        // Ici, on gérera la suppression de l'annonce en question


        return $this->render('OCPlatformBundle:Advert:delete.html.twig');

    }


    public function viewApplicationAction(Request $request,$id)

    {

        $em = $this->getDoctrine()->getManager();


        // On récupère l'annonce $id

        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);


        if (null === $advert) {

            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");

        }


        // On récupère la liste des candidatures de cette annonce

        $listApplications = $em

            ->getRepository('OCPlatformBundle:Application')

            ->findBy(array('advert' => $advert))

        ;


        return $this->render('OCPlatformBundle:Advert:view-application.html.twig', array(

            'advert'           => $advert,

            'listApplications' => $listApplications

        ));

    }

    public function addToCategoryAction(Request $request,$id)

    {
        $em = $this->getDoctrine()->getManager();


        // On récupère l'annonce $id

        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);


        if (null === $advert) {

            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");

        }


        // La méthode findAll retourne toutes les catégories de la base de données

        $listCategories = $em->getRepository('OCPlatformBundle:Category')->findAll();


        // On boucle sur les catégories pour les lier à l'annonce

        foreach ($listCategories as $category) {

            $advert->addCategory($category);

        }


        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire

        // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine


        // Étape 2 : On déclenche l'enregistrement

        $em->flush();

        return $this->render('OCPlatformBundle:Advert:view-annonce.html.twig', array(
        'advert'           => $advert));

    }


    public function updateAdvertAction(Request $request,$id,$titre,$content)
    {


        return new Response("OK update");

    }

    public function addFormAction(Request $request)
    {

        $advert = new Advert();

        $form   = $this->get('form.factory')->create(AdvertType::class, $advert);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($advert);

            $em->flush();


            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');


            return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));

        }


        return $this->render('OCPlatformBundle:Advert:addForm.html.twig', array(

            'form' => $form->createView(),

        ));

    }


    public function formNodateAction(Request $request)
    {
        $advert = new Advert();

        $form   = $this->get('form.factory')->create(AdvertEditType::class, $advert);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($advert);

            $em->flush();


            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');


            return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));

        }


        return $this->render('OCPlatformBundle:Advert:addFormNodate.html.twig', array(

            'form' => $form->createView(),

        ));



    }


}