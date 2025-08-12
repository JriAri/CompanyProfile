<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * Helpers to be loaded automatically.
     *
     * @var array
     */
    protected $helpers = ['url', 'form', 'html'];

    /**
     * Session service instance.
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        date_default_timezone_set('Asia/Jakarta');
        $this->session = \Config\Services::session();
    }

    /**
     * Format standard JSON response.
     */
    protected function respondWithJSON($data, $statusCode = 200, $message = 'success')
    {
        return $this->response
                    ->setStatusCode($statusCode)
                    ->setJSON([
                        'status' => $statusCode < 400 ? 'success' : 'error',
                        'message' => $message,
                        'data' => $data
                    ]);
    }

    /**
     * Validate AJAX-only access.
     */
    protected function validateAjaxRequest()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page not found');
        }
        return true;
    }

    /**
     * Handle file upload process.
     */
    protected function uploadFile($fieldName, $uploadPath = 'uploads/', $allowedTypes = 'jpg|jpeg|png|gif')
    {
        $file = $this->request->getFile($fieldName);
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();

            if ($file->move(ROOTPATH . 'public/assets/images/' . $uploadPath, $fileName)) {
                return $fileName;
            }
        }

        return false;
    }
}