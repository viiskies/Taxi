<?php

namespace App\Controller;

use App\Entity\Attachment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/sample/", name="sample")
     */
    public function sample()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/attachment/", name="attachment")
     */
    public function attachment(Request $request)
    {
        $attachment = new Attachment();
        $form = $this->createFormBuilder($attachment)
            ->add('file', FileType::class)
            ->add('submit', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Attachment $data */
            $data = $form->getData();

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $data->getFile();

            $filename = md5(uniqid()) . '.' . $file->guessClientExtension();
            $file->move(
                $this->getParameter('attachment_folder'),
                $filename
            );
            $data->setFile($filename);

            $this->em->persist($data);
            $this->em->flush();

            echo 'yay';
            exit;
        }

        return $this->render('home/attachment.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
