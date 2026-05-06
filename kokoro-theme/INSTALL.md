# Ghid Instalare — Kokoro Brașov Academy

Ghid complet pas cu pas pentru lansarea site-ului pe un server WordPress.

## Cerințe

- WordPress 6.0+ instalat
- PHP 7.4+
- Plugin **Advanced Custom Fields (ACF)** — gratuit, disponibil pe wp.org
- Acces FTP/SSH la server (sau wp-cli)
- SSL/HTTPS activ (esențial pentru WhatsApp + securitate)

---

## PAS 1 — Upload temă

### Opțiunea A — Manual (FTP)
1. Comprimă folderul `kokoro-theme/` în `kokoro-theme.zip`
2. WP Admin → Aspect → Teme → Adaugă o temă nouă → Încarcă temă
3. Selectează `kokoro-theme.zip` → Instalează → Activează

### Opțiunea B — wp-cli
```bash
cd /var/www/html  # sau path-ul WordPress-ului
wp theme install /local/path/kokoro-theme.zip --activate
```

---

## PAS 2 — Activează ACF

1. WP Admin → Plugins → Adaugă nou
2. Caută **"Advanced Custom Fields"** (de la WP Engine)
3. Instalează → Activează

⚠ Tema nu va funcționa corect fără ACF.

---

## PAS 3 — Creează paginile

WP Admin → Pages → Add New (cu **Page Attributes → Template** asignat):

| Slug pagină | Titlu | Template asignat |
|---|---|---|
| (homepage) | Kokoro Brașov | Front Page |
| `despre-noi` | Despre Noi | page-despre-noi.php |
| `antrenori` | Antrenori | page-antrenori.php |
| `discipline` | Discipline | page-discipline.php |
| `orar` | Orar | Orar |
| `tarife` | Tarife | Tarife |
| `campioni` | Campioni | Campioni |
| `galerie` | Galerie | page-galerie.php |
| `contact` | Contact | Contact |
| `inscriere` | Înscriere | Înscriere |
| `faq` | FAQ | FAQ — Întrebări Frecvente |
| `formulare` | Formulare | Formulare |
| `regulament` | Regulament | Regulament Intern |
| `calendar-competitional` | Calendar Competițional | Calendar Competițional |
| `arte-martiale-copii-brasov` | Arte Marțiale Copii Brașov — Ghid | Pillar — Ghid Arte Marțiale Copii |
| `ju-jitsu-copii-brasov` | Ju-Jitsu Copii Brașov | Pillar — Ju-Jitsu Copii Brașov |
| `autoaparare-copii-brasov` | Autoapărare Copii Brașov | Pillar — Autoapărare Copii Brașov |
| `autoaparare-femei-brasov` | Autoapărare Femei Brașov | Pillar — Autoapărare Femei Brașov |
| `personal-trainer-brasov` | Personal Trainer Brașov | Pillar — Personal Trainer Brașov |

**Setează homepage:** Settings → Reading → A static page → Front page = "Kokoro Brașov"

**Setează permalink:** Settings → Permalinks → Post name → Save

---

## PAS 4 — Populează automat date (seed)

### Opțiunea A — wp-cli (recomandat)
```bash
cd /var/www/html
wp eval-file wp-content/themes/kokoro-theme/bin/seed.php
```

### Opțiunea B — Browser (one-time)
1. Loghează-te în WP admin ca administrator
2. Vizitează: `https://kokoro.ro/wp-content/themes/kokoro-theme/bin/seed.php`
3. Așteaptă mesajul "SEED COMPLET"

**Ce face seed-ul:**
- ✅ Creează 4 antrenori (Sensei Lucian + 3 Sempai) cu poze
- ✅ Creează 4 discipline (Competițional, Autoapărare, Personal Training, Preparator Fizic)
- ✅ Creează 23 campioni cu poze și palmares
- ✅ Populează tarife (300/350/100 lei)
- ✅ Populează orarul săptămânal (23 sesiuni + legendă)
- ✅ Populează FAQ (7 categorii, 17 Q&A)
- ✅ Populează formulare descărcabile + regulament intern
- ✅ Setează telefon/WhatsApp/email/adresă

### ⚠ PAS 5 — ȘTERGE seed.php după execuție

```bash
rm wp-content/themes/kokoro-theme/bin/seed.php
```

Sau via FTP — șterge fișierul. **Critic pentru securitate**.

---

## PAS 6 — Verificări post-launch

- [ ] Homepage afișează hero + statistici + carduri discipline
- [ ] `/orar/` afișează tabelul cu 23 sesiuni
- [ ] `/tarife/` afișează cele 3 pachete
- [ ] `/campioni/` afișează 23 sportivi (Adrian featured + 22 grid)
- [ ] `/antrenori/` afișează 4 antrenori
- [ ] `/contact/` afișează adresa METROM + WhatsApp + form
- [ ] `/faq/` afișează 7 categorii cu Q&A
- [ ] Footer afișează "Site dezvoltat de Green Pheonix Concept"
- [ ] Buton WhatsApp flotant în colțul din dreapta-jos pe toate paginile
- [ ] SSL activ (lacăt verde în URL bar)
- [ ] Test mobil — meniu hamburger funcționează

---

## PAS 7 — SEO & Analytics (opțional, după launch)

1. **Google Search Console** — adaugă proprietatea `https://kokoro.ro` și verifică prin DNS sau HTML tag
2. **Google Analytics** sau **GA4** — creează property, copiază GA-ID în WP admin → Setări Kokoro
3. **Sitemap** — generat automat de tema (sau instalează **Yoast SEO** plugin)
4. **Backup automat** — instalează **UpdraftPlus** și setează backup săptămânal

---

## Probleme frecvente

### „Pagina nu există după activare"
→ Settings → Permalinks → Save (refresh rewrites)

### „Imaginile antrenori/campioni nu se văd"
→ Verifică dacă folderele există:
- `/wp-content/themes/kokoro-theme/assets/images/antrenori/` (sensei-lucian.png, sempai-*.png)
- `/wp-content/themes/kokoro-theme/assets/images/campioni/` (1.png ... 23.png)

### „Buton WhatsApp nu apare"
→ Verifică în WP admin → Setări Kokoro → "Arată WhatsApp" = Da, și completează numărul.

### „Format ACF nu apare"
→ Hard-refresh (Ctrl+Shift+R) WP admin. Plugin-ul ACF trebuie să fie activ.

---

## Editare conținut după launch

Toate textele sunt editabile via ACF, fără să atingi codul. Vezi [bin/README.md](bin/README.md) pentru lista completă a câmpurilor editabile pe fiecare pagină.

---

## Suport tehnic

Site dezvoltat de **Green Pheonix Concept** — https://greenpheonixconcept.com
