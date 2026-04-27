# kokoro.ro

Site oficial **Kokoro Brașov Academy** — academie de Ju-Jitsu și autoapărare fondată în 2008.

## Structură

```
kokoro.ro/
├── kokoro-theme/         Temă WordPress completă (slug: kokoro-theme)
│   ├── *.php             Template-uri (15 fișiere): index, functions, header, footer,
│   │                     single-*, page-*, archive, category, search, 404
│   ├── style.css         Antet WordPress + import variabile
│   ├── inc/              CPT, ACF fields, SEO meta, form handler
│   ├── assets/           CSS (5), JS (1), SVG (3)
│   └── preview/          HTML static identic vizual cu tema (deploy pe gh-pages)
└── kokoro-theme.zip      Arhivă gata pentru WordPress upload
```

## Preview live (GitHub Pages)

Preview-ul static din `kokoro-theme/preview/` este publicat automat la fiecare push pe `main`:

→ <https://laur2198.github.io/kokoro.ro/>

## Pagini pilon SEO

Pagini de aterizare optimizate pentru cuvintele-cheie principale:

| Pagină | Cuvânt-cheie țintă |
|--------|--------------------|
| [`ju-jitsu-copii-brasov.html`](kokoro-theme/preview/ju-jitsu-copii-brasov.html) | Ju-Jitsu copii Brașov |
| [`autoaparare-copii-brasov.html`](kokoro-theme/preview/autoaparare-copii-brasov.html) | Autoapărare copii Brașov (anti-bullying) |
| [`autoaparare-femei-brasov.html`](kokoro-theme/preview/autoaparare-femei-brasov.html) | Autoapărare femei Brașov |
| [`arte-martiale-copii-brasov.html`](kokoro-theme/preview/arte-martiale-copii-brasov.html) | Ghid arte marțiale copii (editorial 6700 cuv) |
| [`personal-trainer-brasov.html`](kokoro-theme/preview/personal-trainer-brasov.html) | Personal trainer Brașov |
| [`faq.html`](kokoro-theme/preview/faq.html) | Întrebări frecvente (17 Q&A) |

Fiecare pagină pilon include schema JSON-LD specifică (`Course`, `Service`, `Article` sau `FAQPage`) plus `BreadcrumbList` și `SportsActivityLocation` universal.

## Instalare temă WordPress

Descarcă `kokoro-theme.zip` din rădăcina repo-ului și urcă-l prin **Appearance → Themes → Add New → Upload Theme → Install Now → Activate**.

## Deploy

GitHub Actions (`.github/workflows/deploy-preview.yml`) publică automat folderul `kokoro-theme/preview/` pe branch-ul `gh-pages` la fiecare push pe `main`.

## Contact

- Str. Carpaților 60, 500269 Brașov
- Telefon: [0742 037 973](tel:+40742037973)
- Email: [contact@kokoro.ro](mailto:contact@kokoro.ro)
