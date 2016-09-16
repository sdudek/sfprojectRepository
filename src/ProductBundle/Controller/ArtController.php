<?php

namespace ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ProductBundle\Entity\Art;
use ProductBundle\Form\ArtType;

/**
 * Art controller.
 *
 */
class ArtController extends Controller
{
    /**
     * Lists all Art entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $arts = $em->getRepository('ProductBundle:Art')->findAll();

        return $this->render('art/index.html.twig', array(
            'arts' => $arts,
        ));
    }

    /**
     * Creates a new Art entity.
     *
     */
    public function newAction(Request $request)
    {
        $art = new Art();
        $form = $this->createForm(new ArtType(), $art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($art);
            $em->flush();

            return $this->redirectToRoute('art_show', array('id' => $art->getId()));
        }

        return $this->render('art/new.html.twig', array(
            'art' => $art,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Art entity.
     *
     */
    public function showAction(Art $art)
    {
        $deleteForm = $this->createDeleteForm($art);

        return $this->render('art/show.html.twig', array(
            'art' => $art,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Art entity.
     *
     */
    public function editAction(Request $request, Art $art)
    {
        $deleteForm = $this->createDeleteForm($art);
        $editForm = $this->createForm(new ArtType(), $art);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($art);
            $em->flush();

            return $this->redirectToRoute('art_edit', array('id' => $art->getId()));
        }

        return $this->render('art/edit.html.twig', array(
            'art' => $art,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Art entity.
     *
     */
    public function deleteAction(Request $request, Art $art)
    {
        $form = $this->createDeleteForm($art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($art);
            $em->flush();
        }

        return $this->redirectToRoute('art_index');
    }

    /**
     * Creates a form to delete a Art entity.
     *
     * @param Art $art The Art entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Art $art)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('art_delete', array('id' => $art->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
