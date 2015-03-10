<?php

namespace Acme\LibraryBundle\Controller;

use Acme\LibraryBundle\Component\SimpleAuthorPaginator;
use Acme\LibraryBundle\Entity\Author;
use Acme\LibraryBundle\Form\AuthorType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorController extends FOSRestController implements ClassResourceInterface {

    public function cgetAction(Request $request)
    {
        /** @var \Acme\LibraryBundle\Entity\AuthorRepository $authorRepo */
        $authorRepo = $this->getDoctrine()->getRepository('LibraryBundle:Author');

        $pageSize = $request->query->get('page_size', SimpleAuthorPaginator::DEFAULT_PAGE_SIZE);

        $page = $request->query->get('page', 1);

        $paginator = new SimpleAuthorPaginator();

        $authors = $paginator->paginate(
            $authorRepo->getFindAllQuery(),
            (int) $page,
            $pageSize
        );

        $view = $this->view($authors, 200);

        return $this->handleView($view);
    }

    public function getAction($slug)
    {
        $author = $this->loadAuthor($slug);

        $view = $this->view($author, 200);

        return $this->handleView($view);
    }

    public function postAction(Request $request)
    {
        $form = $this->getForm(new Author(), $request, true);

        $view = $this->view($form);

        return $this->handleView($view);
    }

    public function putAction($slug, Request $request)
    {
        $author = $this->loadAuthor($slug);

        $form = $this->getForm($author, $request);

        $view = $this->view($form);

        return $this->handleView($view);
    }

    public function deleteAction($slug)
    {
        $author = $this->loadAuthor($slug);
        $em = $this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();

        return $this->handleView($this->view(null));
    }

    protected function getForm(Author $author, Request $request, $clearMissing = false)
    {
        $form = $this->createForm(new AuthorType(), $author);
        $form->submit($request, $clearMissing);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();
        }

        return $form;
    }

    /**
     * @param integer $id
     * @return object
     */
    protected function loadAuthor($id)
    {
        $author = $this->getDoctrine()->getRepository('LibraryBundle:Author')->find($id);

        if(!$author) {
            throw new NotFoundHttpException();
        }

        return $author;

    }


}