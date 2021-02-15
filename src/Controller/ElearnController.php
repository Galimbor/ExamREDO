<?php

namespace App\Controller;

use App\Entity\Enrolls;
use App\Repository\CategoriesRepository;
use App\Repository\CoursesRepository;
use App\Repository\EnrollsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Controller\Elearn_modelController;

class ElearnController extends AbstractController
{
    
	private $session;
	private $elearn_model;
	private $validator;
	
	public function __construct(SessionInterface $session, Elearn_modelController $elearn_model, ValidatorInterface $validator)
    {
		$this->session = $session;
		$this->elearn_model = $elearn_model;
        $this->validator = $validator;
    }
	
		
	/**
     * @Route("/elearn", name="elearn")
     */
    public function index(): Response
    {
        return $this->render('elearn/home.html.twig', [
            'controller_name' => 'ElearnController',
        ]);
    }

    /**
     * @Route("/elearn/courses", name="courses")
     * @param CoursesRepository $coursesRepository
     * @return Response
     */
    public function courses(CoursesRepository  $coursesRepository): Response
    {
        $courses = $coursesRepository->findAll();

        return $this->render('elearn/courses.html.twig', [
            'controller_name' => 'ElearnController', 'courses' => $courses
        ]);
    }

    /**
     * @Route("/elearn/enroll/{id?}", name="enroll")
     * @return Response
     */
    public function enroll(CoursesRepository  $coursesRepository, EnrollsRepository $enrollsRepository, $id): Response
    {
        if(! $this->getUser()  )
        {
            //The user isn't logged in
            $this->addFlash('error', 'You need to be signed in.');
            return $this->redirectToRoute('courses');
        }
        else if($enrollsRepository->findBy(array('user' => $this->getUser(), 'course' => $id))){
            $this->addFlash('error', 'You are already enrolled.');
            return $this->redirectToRoute('courses');
             }
        else{
            if(isset($id) && $coursesRepository->find($id))
            {
                $enroll =new Enrolls();

                $enroll->setUser($this->getUser());
                $enroll->setEnrollDate(new \DateTime('now'));
                $enroll->setCourse($coursesRepository->find($id));

                //Inserting new Order in the database.
                $em = $this->getDoctrine()->getManager();
                $em->persist($enroll);
                $em->flush();

                $this->addFlash('success', 'Enroll successfully completed. Thank you.');
                return $this->redirectToRoute('courses');

            }
            else{
                $this->addFlash('error', 'Something went wrong.Please try again.');
                return $this->redirectToRoute('courses');
            }
        }

    }

    /**
     * @Route("/elearn/mycourses", name="mycourses")
     * @param CoursesRepository $coursesRepository
     * @return Response
     */
    public function mycourses(EnrollsRepository $enrollsRepository): Response
    {
        $courses = $enrollsRepository->findBy(array('user' => $this->getUser()));

        return $this->render('elearn/mycourses.html.twig', [
            'controller_name' => 'ElearnController', 'enrolls' => $courses
        ]);
    }

}
