<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commerce;
use AppBundle\Form\SearchCommerceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Commerce controller.
 *
 * @Route("commerce")
 */
class CommerceController extends Controller
{
    /**
     * Lists all commerce entities.
     *
     * @Route("/", name="commerce_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $nom = $request->get("nom");
        $adresse = $request->get("adresse");

        $em = $this->getDoctrine()->getManager();

        $commerces = $em->getRepository('AppBundle:Commerce')->findAll();

        $commercesFiltred = $em->getRepository('AppBundle:Commerce')->findCommerce($nom,$adresse);

        return $this->render('commerce/index.html.twig', array(
            'commerces' => $commerces,
            'commercesFiltred' => $commercesFiltred
        ));
    }

    /**
     * Creates a new commerce entity.
     *
     * @Route("/new", name="commerce_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commerce = new Commerce();
        $form = $this->createForm('AppBundle\Form\CommerceType', $commerce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $commerce->getImage();
            $fileName = $this->get('app.pagePerso_uploader')->upload($file);
            $commerce->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($commerce);
            $em->flush($commerce);

            return $this->redirectToRoute('commerce_show', array('id' => $commerce->getId()));
        }

        return $this->render('commerce/new.html.twig', array(
            'commerce' => $commerce,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commerce entity.
     *
     * @Route("/{id}", name="commerce_show")
     * @Method("GET")
     */
    public function showAction(Commerce $commerce)
    {
        $deleteForm = $this->createDeleteForm($commerce);

        return $this->render('commerce/show.html.twig', array(
            'commerce' => $commerce,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commerce entity.
     *
     * @Route("/{id}/edit", name="commerce_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commerce $commerce)
    {
        $deleteForm = $this->createDeleteForm($commerce);
        $editForm = $this->createForm('AppBundle\Form\CommerceType', $commerce);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commerce_edit', array('id' => $commerce->getId()));
        }

        return $this->render('commerce/edit.html.twig', array(
            'commerce' => $commerce,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commerce entity.
     *
     * @Route("/{id}", name="commerce_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Commerce $commerce)
    {
        $form = $this->createDeleteForm($commerce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commerce);
            $em->flush($commerce);
        }

        return $this->redirectToRoute('commerce_index');
    }

    /**
     * Creates a form to delete a commerce entity.
     *
     * @param Commerce $commerce The commerce entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commerce $commerce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commerce_delete', array('id' => $commerce->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
