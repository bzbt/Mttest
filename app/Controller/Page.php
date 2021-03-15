<?php


namespace App\Controller;


use App\AbstractController;
use App\Service\PhoneCallReportService;
use Symfony\Component\Routing\Annotation\Route;


class Page extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->view('page/index', ['token' => $this->csrfToken()]);
    }

    /**
     * @Route("/report", name="report")
     */
    public function report()
    {
        $request = $this->request();
        try {
            $this->validateCsrfToken($request->request->get('token'));
            $file = $request->files->get('calls');

            $report = (new PhoneCallReportService())->createFromUploadedCsv($file);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $this->view('page/report', ['report' => $report]);
    }
}
