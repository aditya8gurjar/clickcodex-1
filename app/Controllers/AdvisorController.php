<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\AdvisorModel;

class AdvisorController {
    public function index(): void {
        $model = new AdvisorModel();

        $settings = $model->getSettings();
        $seo = $model->getSeoMetadata();
        $page = $model->getPageData();
        $sections = $model->getPageSections();
        $questions = $model->getQuestionsWithOptions();
        $archetypes = $model->getArchetypes();
        $faqs = $model->getFaqs();

        $activeNav = 'service-finder';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/service-finder.css';
        $extraHead = '';
        $breadcrumbs = [
            [
                'name' => 'Solution Advisor',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/service-finder'
            ]
        ];

        include __DIR__ . '/../Views/service-finder.php';
    }
}
