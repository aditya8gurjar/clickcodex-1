<?php
declare(strict_types=1);

$html = file_get_contents(__DIR__ . '/../storage/Frontend/index.html');

preg_match('/(\.hero-trust-row\s*\{[^}]+\})/s', $html, $m1);
echo "hero-trust-row:\n" . ($m1[0] ?? 'not found') . "\n\n";

preg_match('/(\.client-avatars\s*\{[^}]+\})/s', $html, $m2);
echo "client-avatars:\n" . ($m2[0] ?? 'not found') . "\n\n";

preg_match('/(\.client-avatars\s*img\s*\{[^}]+\})/s', $html, $m3);
echo "client-avatars img:\n" . ($m3[0] ?? 'not found') . "\n\n";

preg_match('/(<div class="hero-trust-row">.*?<\/div>\s*<\/div>)/s', $html, $m4);
echo "HTML structure:\n" . ($m4[0] ?? 'not found') . "\n\n";
