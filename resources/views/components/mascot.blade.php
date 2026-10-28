<!-- Interactive Pet Mascot & Draggable Treat -->
<div id="mascot" title="Klik aku untuk mendengarkan suaraku!">
    <div id="say">nyam!</div>
    <svg viewBox="0 0 120 110" aria-hidden="true" style="cursor: pointer; pointer-events: auto;">
        <!-- Ears -->
        <path d="M20 30 L28 4 L48 22Z M100 30 L92 4 L72 22Z" fill="#ff9f43" stroke="#1a1033" stroke-width="4" stroke-linejoin="round" />
        <!-- Head -->
        <ellipse cx="60" cy="62" rx="48" ry="40" fill="#ff9f43" stroke="#1a1033" stroke-width="4" />
        <!-- Cheeks blush -->
        <circle cx="28" cy="70" r="8" fill="#ff6b81" opacity="0.4" />
        <circle cx="92" cy="70" r="8" fill="#ff6b81" opacity="0.4" />
        <!-- Eye Whites -->
        <circle cx="42" cy="56" r="12" fill="#ffffff" stroke="#1a1033" stroke-width="3" />
        <circle cx="78" cy="56" r="12" fill="#ffffff" stroke="#1a1033" stroke-width="3" />
        <!-- Pupils -->
        <circle id="pl" cx="42" cy="56" r="5.5" fill="#1a1033" />
        <circle id="pr" cx="78" cy="56" r="5.5" fill="#1a1033" />
        <!-- Sleeping eyelids -->
        <path id="lids" d="M30 56h24M66 56h24" stroke="#1a1033" stroke-width="4" stroke-linecap="round" opacity="0" />
        <!-- Mouth -->
        <ellipse id="mouth" cx="60" cy="78" rx="8" ry="4" fill="#1a1033" />
        <!-- Nose -->
        <polygon points="56,68 64,68 60,72" fill="#ff5252" />
        <!-- Sleeping Zzz -->
        <text id="zzz" x="92" y="22" font-size="18">zZ</text>
    </svg>
</div>

<!-- Draggable Food to feed the cat -->
<div id="food" title="Seret pizza ini ke mulut kucing untuk memberinya makan!" role="button" tabindex="0">
    🍕
</div>

