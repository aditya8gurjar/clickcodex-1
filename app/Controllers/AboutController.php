<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\AboutModel;

class AboutController {
    public function index(): void {
        $model = new AboutModel();

        $settings = $model->getSettings();
        $seo = $model->getSeoMetadata();
        $page = $model->getPageData();
        $sections = $model->getPageSections();
        $milestones = $model->getMilestones();
        $companyValues = $model->getCompanyValues();
        $teamMembers = $model->getTeamMembers();
        $focusAreas = $model->getFocusAreas();
        $activeNav = 'aboutus';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/about.css';
        $extraHead = '<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>';
        $breadcrumbs = [
            [
                'name' => 'About ClickCodex',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/aboutus'
            ]
        ];

        include __DIR__ . '/../Views/aboutus.php';
    }
}
