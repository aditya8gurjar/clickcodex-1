<?php
declare(strict_types=1);

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['HTTP_HOST'] = 'localhost';

ob_start();
require __DIR__ . '/../index.php';
$output = ob_get_clean();

echo "========================================================\n";
echo "HOMEPAGE DYNAMIC RENDERING VERIFICATION\n";
echo "========================================================\n";
echo "Output Size: " . strlen($output) . " bytes\n";
echo "1. HTML Document Open: " . (strpos($output, '<!DOCTYPE html>') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "2. Meta Title: " . (strpos($output, 'ClickCodex | Ideas to Solutions') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "3. Meta Description: " . (strpos($output, 'premier full-cycle digital agency') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "4. JSON-LD Schema: " . (strpos($output, 'schema.org') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "5. Exact CSS Linked: " . (strpos($output, 'public/assets/css/style.css') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "6. Navigation Bar: " . (strpos($output, 'id="siteNav"') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "7. Hero 3D Wave Canvas: " . (strpos($output, 'id="hero-wave-canvas"') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "8. Hero Dynamic Word Flip: " . (strpos($output, 'id="animatedHeroWord"') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "9. Trusted Brands Marquee: " . (strpos($output, 'TECHSPRINT') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "10. About Capabilities Tabs: " . (strpos($output, 'aboutTextContainer') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "11. 6 Core Services: " . (strpos($output, 'Website Creation & Web Apps') !== false && strpos($output, 'Custom Software & Dedicated Pods') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "12. 5-Step Process Blueprint: " . (strpos($output, 'process-cards-stack') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "13. Featured Case Studies: " . (strpos($output, 'portfolio-canvas-wrap') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "14. 3D Testimonial Carousel: " . (strpos($output, 'carousel-3d-stage') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "15. Tech Insights / Blogs: " . (strpos($output, 'home-blog-grid') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "16. CTA Banner: " . (strpos($output, 'cta-banner-card') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "17. Wave Footer Grid: " . (strpos($output, 'id="siteFooter"') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "18. Consultation Modal: " . (strpos($output, 'id="consultationModal"') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "19. Back to Top Button: " . (strpos($output, 'id="backToTopBtn"') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "20. Cursor Spotlight Orb: " . (strpos($output, 'id="cursorSpotlight"') !== false ? "✓ PASS" : "✗ FAIL") . "\n";
echo "========================================================\n";
echo "ALL TESTS EVALUATED.\n";
