<?php
/*
* This file is part of the Claroline Connect package.
*
* (c) Claroline Consortium <consortium@claroline.net>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace FormaLibre\InvoiceBundle\Listener;

use JMS\DiExtraBundle\Annotation as DI;
use Claroline\CoreBundle\Event\DisplayToolEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Claroline\CoreBundle\Event\OpenAdministrationToolEvent;

/**
* @DI\Service()
*/
class Listener
{
    private $container;
    private $httpKernel;

    /**
    * @DI\InjectParams({
    *   "container" = @DI\Inject("service_container"),
    *    "httpKernel" = @DI\Inject("http_kernel")
    * })
    */
    public function __construct(
        ContainerInterface $container,
        HttpKernelInterface $httpKernel
    )
    {
        $this->container = $container;
        $this->httpKernel = $httpKernel;
    }

   /**
    * @DI\Observe("open_tool_desktop_formalibre_invoice")
    *
    * @param DisplayToolEvent $event
    */
    public function onDisplayInvoice(DisplayToolEvent $event)
    {
        $event->setContent($this->getDisplayInvoicePage());
    }

    private function getDisplayInvoicePage()
    {
        $params = array('_controller' => 'FormaLibreInvoiceBundle:SharedWorkspace:list');
        $subRequest = $this->container->get('request')->duplicate(array(), null, $params);
        $response = $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);

        return $response->getContent();
    }

    /**
     * @DI\Observe("administration_tool_formalibre_admin_invoice")
     *
     * @param DisplayToolEvent $event
     */
    public function onDisplayAdminInvoice(OpenAdministrationToolEvent $event)
    {
        $event->setResponse($this->openAdminPendingOperations());
    }

    private function openAdminPendingOperations()
    {
        $params = array('_controller' => 'FormaLibreInvoiceBundle:Administration:index');
        $params['page'] = 1;
        $params['search'] = '';
        $subRequest = $this->container->get('request')->duplicate(array(), null, $params);
        $response = $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);

        return $response;
    }
}
