<?php

namespace FormaLibre\InvoiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FormaLibre\InvoiceBundle\Entity\Invoice;

class InvoiceController extends Controller
{
    /** @DI\Inject("security.token_storage") */
    private $tokenStorage;

    /** @DI\Inject("security.authorization_checker") */
    private $authorization;

    /** @DI\Inject("formalibre.manager.product_manager") */
    private $productManager;

    /** @DI\Inject("formalibre.manager.invoice_manager") */
    private $invoiceManager;

    /**
     * @EXT\Route(
     *      "/admin/invoice/{invoice}/show",
     *      name="admin_invoice_show"
     * )
     * @EXT\Template
     */
    public function showAction(invoice $invoice)
    {
        if (
            $invoice->getChart()->getOwner() !== $this->tokenStorage->getToken()->getUser() &&
            !$this->authorization->isGranted('ROLE_ADMIN')
        ) {
            throw new AccessDeniedException;
        }

        return array('invoice' => $invoice);
    }

    /**
     * @EXT\Route(
     *      "/download/invoice/{invoice}",
     *      name="invoice_download"
     * )
     *
     * @return Response
     */
    public function downloadAction(Invoice $invoice)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($invoice->getChart()->getOwner() !== $user &&
            !$this->authorization->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException;
        }

        $file = $this->invoiceManager->getPdf($invoice);
        $response = new StreamedResponse();

        $response->setCallBack(
            function () use ($file) {
                readfile($file);
            }
        );

        $response->headers->set('Content-Transfer-Encoding', 'octet-stream');
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename=invoice-' . $invoice->getInvoiceNumber() . '.pdf');
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Connection', 'close');
        $response->send();

        return new Response();
    }

    /**
     * @EXT\Route(
     *      "/ask/invoice/{invoice}",
     *      name="invoice_ask"
     * )
     *
     * @return Response
     */
    public function askInvoiceAction(Invoice $invoice)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($invoice->getChart()->getOwner() !== $user &&
            !$this->authorization->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $this->invoiceManager->ask($invoice);
        $this->get('request')->getSession()
            ->getFlashBag()
            ->add('success', $this->get('translator')->trans('invoice_request_done', array(), 'invoice'));

        return new RedirectResponse($this->get('router')->generate('claro_desktop_open'));
    }

    /**
     * @EXT\Route(
     *      "/orders/list",
     *      name="formalibre_my_orders_desktop_tool_index"
     * )
     * @EXT\Template
     *
     * @return Response
     */
    public function listAction()
    {
        return array(
            'invoices' => $this->container->get('formalibre.manager.invoiceManager')
                ->getByUser($this->tokenStorage->getToken()->getUser())
        );
    }
}
