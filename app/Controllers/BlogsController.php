<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\BlogsModel;

class BlogsController {
    public function index(): void {
        $model = new BlogsModel();

        $settings = $model->getSettings();
        $seo = $model->getSeoMetadata();
        $page = $model->getPageData();
        $sections = $model->getPageSections();
        $categories = $model->getCategories();
        $featuredPost = $model->getFeaturedPost();
        $posts = $model->getAllPosts();

        $activeNav = 'blogs';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/blogs.css';
        $extraHead = '';
        $breadcrumbs = [
            [
                'name' => 'Tech Blogs & Insights',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/blogs'
            ]
        ];

        include __DIR__ . '/../Views/blogs.php';
    }

    public function detail(string $slug = ''): void {
        $model = new BlogsModel();

        if (empty($slug)) {
            $slug = 'sub-10ms-global-apis-edge-rust';
        }

        $post = $model->getPostBySlug($slug);
        if (!$post) {
            $post = $model->getFeaturedPost();
        }

        $settings = $model->getSettings();
        $seo = !empty($post['id']) ? $model->getPostSeo((int)$post['id']) : $model->getSeoMetadata();
        $recentPosts = $model->getRecentPosts(3, !empty($post['id']) ? (int)$post['id'] : 0);

        $activeNav = 'blogs';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/blog-detail.css';
        $extraHead = '';
        $breadcrumbs = [
            [
                'name' => 'Tech Blogs',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/blogs'
            ],
            [
                'name' => $post['title'] ?? 'Article Detail',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/blogs/' . ($post['slug'] ?? '')
            ]
        ];

        if (file_exists(__DIR__ . '/../Views/blog-detail.php')) {
            include __DIR__ . '/../Views/blog-detail.php';
        } else {
            include __DIR__ . '/../Views/blogs.php';
        }
    }
}
