<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AdminUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Adminuser controller.
 *
 * @Route("admin")
 */
class AdminUserController extends Controller
{

    /**
     * @param Request $request
     * @Route("/", name="admin_index")
     * @return View
     */
    public function indexAction(Request $request)
    {
        return $this->render("/admin/index.html.twig");
    }

    /**
     * @Route("/login", name="admin_login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {

        $error = $this->get('security.authentication_utils')
            ->getLastAuthenticationError();

        return $this->render('admin/login.html.twig', [
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="admin_logout")
     */
    public function logoutAction(Request $request)
    {
    }

    /**
     * Creates a new adminUser entity.
     *
     * @Route("/new", name="admin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $adminUser = new Adminuser();
        $form = $this->createForm('AppBundle\Form\AdminUserType', $adminUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $adminUser->getPassword();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($adminUser,$plainPassword);
            $adminUser->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($adminUser);
            $em->flush($adminUser);

            return $this->redirectToRoute('admin_show', array('id' => $adminUser->getId()));
        }

        return $this->render('adminuser/new.html.twig', array(
            'adminUser' => $adminUser,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a adminUser entity.
     *
     * @param AdminUser $adminUser The adminUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AdminUser $adminUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_delete', array('id' => $adminUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
