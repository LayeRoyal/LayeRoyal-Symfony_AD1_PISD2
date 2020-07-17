<?php

namespace App\Controller;

use App\Entity\Batiment;
use App\Entity\Chambre;
use App\Entity\Etudiant;
use App\Repository\BatimentRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ChambreRepository;
use function Sodium\add;

class EtudiantController extends AbstractController
{

    /**
     * @Route("/", name="saveEtudiant")
     */
    public function index(EtudiantRepository $dataEtudiant)
    {
        if (isset($_POST['enregistrer'])) {
            $entityManager = $this->getDoctrine()->getManager();
            $etudiant = new Etudiant();
            //generer matricule
            $lname = substr($_POST['prenom'], -2);
            $fname = substr($_POST['nom'], 0, 2);
            $num = (int)$dataEtudiant->lastId()[0]['id'] + 1;
            $num = $s_number = str_pad($num, 4, "0", STR_PAD_LEFT);
            $matricule = '2020' . $lname . $fname . $num;
            $chambre = $this->getDoctrine()->getRepository(Chambre::class)->find($_POST['chambre']);
            $etudiant->setNom($_POST['nom']);
            $etudiant->setPrenom($_POST['prenom']);
            $etudiant->setEmail($_POST['email']);
            $etudiant->setTelephone($_POST['telephone']);
            $etudiant->setDateNaissance(new \DateTime($_POST['dateDeNaissanc']));
            $etudiant->setMatricule($matricule);
            $etudiant->setBourse($_POST['bourse']);
            if ($_POST['bourse'] == "Non" || $_POST['logement'] == "Non") {
                $etudiant->setAdresse($_POST['adresse']);
            } else {
                $etudiant->setNumChambre($chambre);
            }
            $entityManager->persist($etudiant);
            $entityManager->flush();
            $message = "succes";
            return $this->redirectToRoute('saveEtudiant', ['message' => $message]);
        }
        $chambres = $this->getDoctrine()->getRepository(Chambre::class)->findAll();

        return $this->render('/etudiant/saveEtudiant.html.twig', [
            'controller_name' => 'EtudiantController',
            'chambres' => $chambres
        ]);
    }
    /**
     * @Route("/etudiant/searchEtudiant", name="searchEtudiant")
     */
    public function searchEtudiant(Request $request, EtudiantRepository $dataEtudiant)
    {

        $etudiant = $dataEtudiant->findStudent($request->request->get('req'));
        $data = [];
        foreach ($etudiant as $key => $value) {
            if ($value['adresse'] == null) {
                $num = $value['num_chambre_id'];
            } else {
                $num = null;
            }
            $data[] = [
                'id' => $value['id'],
                'matricule' => $value['matricule'],
                'prenom' => $value['prenom'],
                'nom' => $value['nom'],
                'email' => $value['email'],
                'telephone' => $value['telephone'],
                'bourse' => $value['bourse'],
                'adresse' => $value['adresse'],
                'numChambre' => $num

            ];
        }
        return new JsonResponse($data);
    }
    /**
     * @Route("/etudiant/listEtudiant", name="listEtudiant")
     */
    public function listEtudiant(EtudiantRepository $etudiantRepository, EntityManagerInterface $manager)
    {

        //delete etudiant
        if (isset($_POST['delete'])) {
            $etudiant = new Etudiant();
            $etudiant = $etudiantRepository->find($_POST['delete']);
            $manager->remove($etudiant);
            $manager->flush();
            return $this->redirectToRoute('listEtudiant');
        }
        //update etudiant
        if (isset($_POST['submit'])) {
            if ($_POST['nom'] == '' || $_POST['prenom'] == '' || $_POST['telephone'] == '' || $_POST['email'] == '') {
                $this->data['message'] = '<h4 class="m-0 p-0 text-danger" >Veuiller remplir tous les champ!</h4>';
            } else {
                $etudiant = $etudiantRepository->find($_POST['submit']);
                $etudiant->setPrenom($_POST['prenom'])
                    ->setNom($_POST['nom'])
                    ->setEmail($_POST['email'])
                    ->setTelephone($_POST['telephone'])
                    ->setBourse($_POST['bourse']);
                if ($etudiant->getAdresse() == !null) {
                    $etudiant->setAdresse($_POST['adresse']);
                }

                $manager->persist($etudiant);
                $manager->flush();
                return $this->redirectToRoute('listEtudiant');
            }
        }

        return $this->render('/etudiant/listEtudiant.html.twig', [
            'controller_name' => 'EtudiantController'
        ]);
    }

    /**
     * @Route("/etudiant/dataEtudiant", name="dataEtudiant")
     */
    public function dataEtudiant(Request $request, EtudiantRepository $dataEtudiant)
    {

        $etudiant = $dataEtudiant->findBy(
            array(),
            array(
                'nom' => 'ASC'
            ),
            $request->request->get('limit'),
            $request->request->get('offset')
        );
        $data = [];
        foreach ($etudiant as $key => $value) {
            if ($value->getAdresse() == null) {
                $num = $value->getNumChambre()->getId();
            } else {
                $num = null;
            }
            $data[] = [
                'id' => $value->getId(),
                'matricule' => $value->getMatricule(),
                'prenom' => $value->getPrenom(),
                'nom' => $value->getNom(),
                'email' => $value->getEmail(),
                'telephone' => $value->getTelephone(),
                'bourse' => $value->getBourse(),
                'adresse' => $value->getAdresse(),
                'numChambre' => $num

            ];
        }
        return new JsonResponse($data);
    }
    /**
     * @Route("/etudiant/saveChambre", name="saveChambre")
     */

    public function saveChambre(Request $request, EntityManagerInterface $manager)
    {
        $chambre = new Chambre();
        $form = $this->createFormBuilder($chambre)
            ->add('batiment', EntityType::class, [
                'class' => Batiment::class,
                'choice_label' => 'id'
            ])
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'individuel' => 'individuel',
                    'à deux' => 'deux'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        $message = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($chambre);
            $manager->flush();
            $message = '<h4>Chambre générée avec succes</h4>';
        }

        return $this->render('/etudiant/saveChambre.html.twig', [
            'controller_name' => 'EtudiantController',
            'form' => $form->createView(),
            'message' => $message
        ]);
    }

    /**
     * @Route("/etudiant/listChambre", name="listChambre")
     */
    public function listChambre(EntityManagerInterface $manager, Request $request, PaginatorInterface $paginator, BatimentRepository $batimentRepository, ChambreRepository $chambreRepository, EtudiantRepository $etudiantRepository)
    {
        $chambre = $chambreRepository->findAll();
        $batiments = $batimentRepository->findAll();
        foreach ($chambre as $key => $value) {
            $data[] = [
                'id' => $value->getId(),
                'batiment' => $value->getBatiment()->getId(),
                'type' => $value->getType()

            ];
        }
        $chambres = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );
        //delete etudiant
        if (isset($_POST['delete'])) {
            $room = $chambreRepository->find($_POST['delete']);
            $froom = $etudiantRepository->freeRoom();
            //delete room non occupé
            foreach ($froom as $key => $value) {
                if ($value['num_chambre_id'] == $_POST['delete']) {
                    $message = "chambre occupée";
                    return $this->render('/etudiant/listChambre.html.twig', [
                        'controller_name' => 'ChambreController',
                        'batiments' => $batiments,
                        'chambres' => $chambres,
                        'message' => $message
                    ]);
                }
            }
            $manager->remove($room);
            $manager->flush();
            return $this->redirectToRoute('listChambre');
        }
        // update etudiant
        if (isset($_POST['submit'])) {
            $room = $chambreRepository->find($_POST['submit']);
            $bat = $batimentRepository->find($_POST['batiment']);
            $room->setType($_POST['type'])
                ->setBatiment($bat);
            $manager->persist($room);
            $manager->flush();
            return $this->redirectToRoute('listChambre');
        }
        return $this->render('/etudiant/listChambre.html.twig', [
            'controller_name' => 'ChambreController',
            'batiments' => $batiments,
            'chambres' => $chambres
        ]);
    }
}
