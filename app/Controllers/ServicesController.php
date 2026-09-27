<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\ServicesModel;

class ServicesController {
    public function index(): void {
        $model = new ServicesModel();

        $settings = $model->getSettings();
        $seo = $model->getSeoMetadata();
        $page = $model->getPageData();
        $sections = $model->getPageSections();
        $services = $model->getAllServices();
        $cardDeck = $model->getCardDeck();
        $growthFunnel = $model->getGrowthFunnel();
        $deliveryDossier = $model->getDeliveryDossier();
        $activeNav = 'services';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/services.css';
        $extraHead = '<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>';
        $breadcrumbs = [
            [
                'name' => 'Our Services',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/services'
            ]
        ];

        include __DIR__ . '/../Views/services.php';
    }

    /**
     * Render the detailed dynamic service dossier
     */
    public function detail(string $slug = ''): void {
        $model = new ServicesModel();

        $service = $model->getServiceBySlug($slug);
        if (!$service) {
            header("Location: " . (defined('BASE_URL') ? BASE_URL : '') . "/services");
            exit;
        }

        $settings = $model->getSettings();
        $seo = $model->getServiceSeo($service);
        $faqs = $model->getServiceFaqs((int)$service['id']);
        $dossierSteps = $model->getDossierSteps();
        $relatedCases = $model->getRelatedCaseStudies((int)$service['category_id'], 2);
        $allServicesNav = $model->getAllServicesNav();

        $activeNav = 'services';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/service-detail.css';
        $extraHead = '';

        $breadcrumbs = [
            [
                'name' => 'Our Services',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/services'
            ],
            [
                'name' => $service['title'],
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/services/' . $service['slug']
            ]
        ];

        include __DIR__ . '/../Views/service-detail.php';
    }
}
