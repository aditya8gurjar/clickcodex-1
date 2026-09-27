<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\HomeModel;

class HomeController {
    public function index(): void {
        $model = new HomeModel();

        $settings = $model->getSettings();
        $seo = $model->getSeoMetadata();
        $sections = $model->getPageSections();
        $trustedBrands = $model->getTrustedBrands();
        $services = $model->getServices();
        $caseStudies = $model->getFeaturedCaseStudies();
        $companyValues = $model->getCompanyValues();
        $testimonials = $model->getTestimonials();
        $latestPosts = $model->getLatestBlogPosts(3);
        $blueprintSteps = $model->getBlueprintSteps();
        $activeNav = 'home';

        include __DIR__ . '/../Views/home.php';
    }
}