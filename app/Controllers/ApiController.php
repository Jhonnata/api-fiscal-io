<?php

namespace App\Controllers;

use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use Psr\Log\LoggerInterface;

class ApiController extends ResourceController
{

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * @OA\Info(
     *     title="TEST API FISCAL IO",
     *     version="0.0.1",
     *     description="Explore a API!  Nossa plataforma API oferece uma gama abrangente de endpoints para acessar e interagir com os dados essenciais. Descubra recursos robustos e serviços projetados para simplificar e enriquecer sua experiência na obtenção e gerenciamento de informações acadêmicas da mais alta qualidade.
    [http://swagger.io](http://swagger.io) or on
    [irc.freenode.net, #swagger](http://swagger.io/irc/).",
     *     @OA\Contact(name="Time",email="jhonnatasimoes@outlook.com"),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * ),
     * @OA\SecurityScheme(
     *     type="http",
     *     scheme="bearer",
     *     securityScheme="bearerAuth",
     * ),
     * @OA\Server(
     *     url="http://localhost:8080/",
     *     description="API Url Server"
     * )
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = \Config\Services::session();
    }

    /**
     * @throws Exception
     */
    protected function getRequestData()
    {
        $post = $this->request->getJSON(true);
        if (empty($post)) {
            $post = $this->request->getPost();
        }
        if (empty($post)) {
            $post = $this->request->getRawInput();
        }

        if (empty($post)) {
            throw  new Exception(lang('Messages.notDataReceived'));
        }
        return $post;
    }

    protected function log($exception): void
    {
        $error = [
            'user' => user()->sub,
            'name' => user()->name,
            'ip_address' => $this->request->getIPAddress()
        ];
        if (is_string($exception)) {
            $error['message'] = $exception;
            log_message('info', 'IP:{ip_address} | User:: [{user}] - {name} | Message:: {message} ', $error);
        } else if (is_object($exception)) {
            $error['exception'] = $exception;
            log_message('info', 'IP:{ip_address} | User:: [{user}] - {name} | [ERROR]:: {exception} ', $error);
        }
    }


    public function index()
    {
        return view('swagger');
    }

}