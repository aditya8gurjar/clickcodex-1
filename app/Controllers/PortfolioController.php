<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\PortfolioModel;

class PortfolioController {
    public function index(): void {
        $model = new PortfolioModel();

        $settings = $model->getSettings();
        $seo = $model->getSeoMetadata();
        $page = $model->getPageData();
        $sections = $model->getPageSections();
        $categories = $model->getCategories();
        $caseStudies = $model->getCaseStudies();
        $testimonials = $model->getTestimonials();

        $activeNav = 'portfolio';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/portfolio.css';
        $extraHead = '<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>';
        $breadcrumbs = [
            [
                'name' => 'Portfolio & Results',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/portfolio'
            ]
        ];

        include __DIR__ . '/../Views/portfolio.php';
    }
}
