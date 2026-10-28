<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="Wacky Lab - Laboratorium web eksperimental, interaktif, dan konyol buatan Rizky Dika.">
    <meta name="theme-color" content="#f5f3ff">

    <title>{{ $title ?? 'Wacky Lab - Eksperimen Web Konyol' }}</title>

    <!-- Preconnect / fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Top Rainbow Scroll Progress Bar -->
    <div id="bar"></div>

    <!-- Global Toast Notification Box -->
    <div id="msg" role="status" aria-live="polite"></div>

    <!-- Floating Parallax Background Emojis -->
    <span class="fl" data-s="0.25" style="top: 380px; left: 5%;">🪐</span>
    <span class="fl" data-s="0.4" style="top: 860px; left: 86%;">🍕</span>
    <span class="fl" data-s="0.18" style="top: 1450px; left: 6%;">🔥</span>
    <span class="fl" data-s="0.35" style="top: 2050px; left: 88%;">👾</span>
    <span class="fl" data-s="0.22" style="top: 2650px; left: 5%;">🐸</span>
    <span class="fl" data-s="0.3" style="top: 3100px; left: 84%;">💎</span>

    <!-- Sticky Navigation Bar -->
    <x-navbar />

    <!-- Main Content Container -->
    <main id="m">
        {{ $slot }}

        <!-- Footer -->
        <x-footer />
    </main>

    <!-- Cat Mascot & Feeding Interaction -->
    <x-mascot />
</body>

</html>
