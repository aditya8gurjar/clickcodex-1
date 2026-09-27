<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\ContactModel;

class ContactController {
    /**
     * Render the Contact Us page
     */
    public function index(): void {
        $model = new ContactModel();

        $settings = $model->getSettings();
        $seo = $model->getSeoMetadata();
        $page = $model->getPageData();
        $sections = $model->getPageSections();
        $faqs = $model->getFaqs();
        $campuses = $model->getCampuses();

        $activeNav = 'contactus';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/contactus.css';
        $extraHead = '<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>';

        $breadcrumbs = [
            [
                'name' => 'Contact Us',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/contactus'
            ]
        ];

        include __DIR__ . '/../Views/contactus.php';
    }

    /**
     * Handle Form Submission (Discovery Form & Consultation Modal)
     */
    public function submit(): void {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
            exit;
        }

        // Support both application/json payload and traditional POST form data
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $data = [];

        if (stripos($contentType, 'application/json') !== false) {
            $rawInput = file_get_contents('php://input');
            $decoded = json_decode($rawInput, true);
            if (is_array($decoded)) {
                $data = $decoded;
            }
        } else {
            $data = $_POST;
        }

        $model = new ContactModel();
        $result = $model->saveInquiry($data);

        if (!$result['success']) {
            http_response_code(400);
        } else {
            http_response_code(200);
        }

        echo json_encode($result);
        exit;
    }
}
