<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryController extends Controller {

    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function index(Request $request) {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        $paginator = $this->get('knp_paginator');

        $query = $repository->findAll();

        $categories = $paginator->paginate(
                $query, $request->query->getInt('page', 1), 5
        );

        return $this->render('admin/categories/index.html.twig', array(
                    'categories' => $categories,
        ));
    }

    /**
     * @Route("/admin/categories/new", name="admin_categories_new")
     * Method({"GET", "POST"})
     */
    public function newAction(Request $request, ValidatorInterface $validator) {
        $category = new Category();

        $form = $this->createFormBuilder($category)
                ->add('category_name', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Confirm',
                    'attr' => array(
                        'class' => 'btn btn-primary mt-3'
                    )
                ))
                ->getForm();

        $errors = null;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $errors = $validator->validate($category);

            if (count($errors) > 0) {
                return $this->render('admin/categories/new.html.twig', array(
                            'errors' => $errors,
                            'form' => $form->createView()
                ));
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('admin/categories/new.html.twig', array(
                    'errors' => $errors,
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/category/edit/{id}", name="admin_categories_edit")
     * Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id, ValidatorInterface $validator) {
        $category = new Category();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $form = $this->createFormBuilder($category)
                ->add('category_name', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Confirm',
                    'attr' => array(
                        'class' => 'btn btn-primary mt-3'
                    )
                ))
                ->getForm();

        $form->handleRequest($request);

        $errors = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $errors = $validator->validate($category);

            if (count($errors) > 0) {
                return $this->render('admin/categories/edit.html.twig', array(
                            'errors' => $errors,
                            'form' => $form->createView()
                ));
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('admin_categories');
        }
        return $this->render('admin/categories/edit.html.twig', array(
                    'category' => $category,
                    'errors' => $errors,
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/category/delete/{id}", name="admin_categories_delete")
     * @Method({"GET"})
     */
    public function deleteAction(Request $request, $id) {     // * @Method({"DELETE"})
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

//        $response = new Response();
//        $response->send();
        return $this->redirectToRoute('admin_categories');
    }

}
