<?php

namespace App\Controllers;

class Site extends BaseController
{

    /*---------------------------------------------------------------------------*/
    // News Data
    /*---------------------------------------------------------------------------*/
    public function getNews()
    {
        $req = $this->request->getVar();
        $siteModel = new \App\Models\SiteModel();

        $data_news = $siteModel->getNews()->paginate(10);

        $data['news'] = $data_news;
        $data['pager'] = $siteModel->pager->getDetails();
        $data['req'] = $req;

        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function getNewsById($ID)
    {
        $req = $this->request->getVar();
        $siteModel = new \App\Models\SiteModel();

        $data['news'] = $siteModel->getNewsById($ID)->first();


        return $this->response->setStatusCode(200)->setJSON($data);
    }

    /*---------------------------------------------------------------------------*/
    // Lowongan Kerja Data
    /*---------------------------------------------------------------------------*/
    public function getLowonganKerja()
    {
        $req = $this->request->getVar();
        $siteModel = new \App\Models\SiteModel();

        $data_news = $siteModel->getLowonganKerja()->paginate(10);

        $data['lowongan'] = $data_news;
        $data['pager'] = $siteModel->pager->getDetails();
        $data['req'] = $req;

        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function getLowonganKerjaById($ID)
    {
        $req = $this->request->getVar();
        $siteModel = new \App\Models\SiteModel();

        $data['lowongan'] = $siteModel->getLowonganKerjaById($ID)->first();


        return $this->response->setStatusCode(200)->setJSON($data);
    }

    /*---------------------------------------------------------------------------*/
    // Advertisement Data
    /*---------------------------------------------------------------------------*/
    public function getAdvertisement()
    {
        $req = $this->request->getVar();
        $siteModel = new \App\Models\SiteModel();

        $data_news = $siteModel->getAdvertisement()->paginate(10);

        $data['advertisement'] = $data_news;
        $data['pager'] = $siteModel->pager->getDetails();
        $data['req'] = $req;

        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function getAdvertisementById($ID)
    {
        $req = $this->request->getVar();
        $siteModel = new \App\Models\SiteModel();

        $data['advertisement'] = $siteModel->getAdvertisementById($ID)->first();


        return $this->response->setStatusCode(200)->setJSON($data);
    }

    /*---------------------------------------------------------------------------*/
    // Agenda Data
    /*---------------------------------------------------------------------------*/
    public function getAgenda()
    {
        $req = $this->request->getVar();
        $siteModel = new \App\Models\SiteModel();

        $data_news = $siteModel->getAgenda()->paginate(10);

        $data['agenda'] = $data_news;
        $data['pager'] = $siteModel->pager->getDetails();
        $data['req'] = $req;

        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function getAgendaById($ID)
    {
        $req = $this->request->getVar();
        $siteModel = new \App\Models\SiteModel();

        $data['agenda'] = $siteModel->getAgendaById($ID)->first();


        return $this->response->setStatusCode(200)->setJSON($data);
    }

    
    /*---------------------------------------------------------------------------*/
    // Pengurus Data
    /*---------------------------------------------------------------------------*/
    public function getPengurus()
    {
        $req = $this->request->getVar();
        $siteModel = new \App\Models\SiteModel();

        $data['pengurus'] = $siteModel->getPengurus()->first();


        return $this->response->setStatusCode(200)->setJSON($data);
    }
}
