# RELEASE_CHECKLIST.md — Kokoro Brașov Academy

Ghid pas-cu-pas pentru deploy-ul temei `kokoro-theme` pe production `kokoro.ro`. Fiecare item e acționabil — comandă concretă + rationale + verificare + rollback.

**Constrângeri mediu**: PHP 7.4, WP 6.9.4, LiteSpeed, 22 plugin-uri active. Vezi `kokoro-theme/INSTALL.md` pentru context plugin-uri.

---

## SECTION 0 — Pre-deploy preparation (cu 1 săptămână înainte)

### 0.1 Backup proaspăt

**De ce**: Backuply nu mai rulase de 122 zile la auditul inițial. Deploy fără backup = no rollback path.

**Acțiune**:
1. WP Admin → Backuply → "Take Backup Now"
2. Așteaptă completare (~5-15 min)
3. Download .zip local + verifică conținutul (DB + uploads + themes)
4. Extra: separately export DB:
   ```bash
   wp db export kokoro-pre-deploy-$(date +%Y%m%d).sql
   ```

**Verificare**:
- [ ] Backup-ul există local (nu doar pe server)
- [ ] DB SQL e ≥1 MB (corpul real, nu fișier gol)
- [ ] `/wp-content/uploads/` în arhivă conține imagini

**Dacă nu merge**: Backuply timeout pe shared hosting → rulează DB export manual prin phpMyAdmin + descarcă uploads via FTP separat.

### 0.2 Staging environment

**De ce**: Deploy direct pe production e No-Go. Staging permite test + rollback fără downtime.

**Acțiune**:
1. Confirmă `staging.kokoro.ro` (sau echivalent) e accesibil
2. DB clonată din production (recent — nu mai veche de 1 săptămână)
3. `wp-config.php` cu DB separată + `define('WP_DEBUG', true);` + `define('WP_DEBUG_LOG', true);`
4. Acces FTP/SSH pentru upload temă + mu-plugin

**Verificare**:
- [ ] Login în WP admin staging
- [ ] Plugin-uri identice cu production (versiuni)
- [ ] Tema activă pe staging = Power Gym (înainte de switch)
- [ ] `wp-content/debug.log` writable

**Dacă nu merge**: hosting nu are staging dedicat → folosește un subdomain temporar (`test.kokoro.ro`) cu wp-config.php pointing la o DB clonată.

### 0.3 Profile production current performance (BASELINE)

**De ce**: Vrem comparabil înainte/după. Fără baseline nu putem confirma că B1/I2 fix-urile vor fi necesare în iter 2.

**Acțiune**:
1. Chrome DevTools → Lighthouse → mode Mobile
2. Run pe 6 pagini production:
   - `https://kokoro.ro/`
   - `https://kokoro.ro/contact/`
   - `https://kokoro.ro/tarife/`
   - `https://kokoro.ro/inscriere/`
   - `https://kokoro.ro/noutati/`
   - `https://kokoro.ro/ju-jitsu-copii-brasov/` (dacă există deja pe Power Gym)
3. Save fiecare ca PDF/JSON cu nume `lighthouse-baseline-{slug}-{date}.json`

**Verificare**:
- [ ] 6 rapoarte salvate local
- [ ] Notează LCP, CLS, INP, scor Performance pentru fiecare

**Dacă nu merge**: Lighthouse timeout → folosește https://pagespeed.web.dev/ ca alternativă (acceptă URL public).

### 0.4 Inventory plugins production

**De ce**: Trebuie să știm ce dezactivăm/configurăm și unde poate apărea conflict.

**Acțiune**:
```bash
wp plugin list --status=active --format=csv > plugins-snapshot-$(date +%Y%m%d).csv
```
Sau manual: WP admin → Plugins → screenshot lista activate.

**Plugin-uri cu setări custom** (necesită backup setări):
- LiteSpeed Cache → settings export
- SpeedyCache → settings export
- ACF → field groups (din cod via theme, dar verifică UI overrides)
- CPTUI → cptui_post_types option (export)
- SiteSEO → settings export
- Solid Security → settings export

**Verificare**:
- [ ] CSV/screenshot listă plugin-uri salvat
- [ ] Setări LiteSpeed + SpeedyCache exportate
- [ ] CPTUI types listă (pentru migrare în 1.5)

**Dacă nu merge**: WP-CLI inaccesibil → screenshot manual + documentează versiunile.

---

## SECTION 1 — Deploy temă pe staging

### 1.1 Build kokoro-theme.zip

**De ce**: WP admin acceptă upload .zip. Excludere `bin/` previne expunerea seed.php pe production.

**Acțiune**:
```bash
cd /workspaces/kokoro.ro
git checkout feat/audit-faze-1-5
git pull origin feat/audit-faze-1-5
zip -r kokoro-theme.zip kokoro-theme/ \
  -x "kokoro-theme/.git*" \
     "kokoro-theme/bin/seed.php" \
     "kokoro-theme/bin/perf-snapshot.php" \
     "kokoro-theme/bin/verify.php" \
     "kokoro-theme/bin/.htaccess" \
     "kokoro-theme/bin/README.md" \
     "**/.DS_Store" \
     "**/node_modules/*"
```

**Verificare**:
- [ ] `kokoro-theme.zip` creat (10-50 MB depending pe assets)
- [ ] `unzip -l kokoro-theme.zip | grep "bin/"` → empty (bin/ exclus)
- [ ] `unzip -l kokoro-theme.zip | grep "style.css"` → present

**Dacă nu merge**: bin/ inclus accidental → re-zip cu excludere explicită; SAU upload zip + șterge `bin/` din server post-upload.

### 1.2 Upload temă staging

**De ce**: Activarea via admin permite verificarea automatic-page-creation (kokoro_activate hook).

**Acțiune**:
1. Staging WP Admin → Appearance → Themes → Add New → Upload Theme
2. Selectează `kokoro-theme.zip` → Install Now
3. **Activează kokoro-theme**

**Verificare**:
- [ ] Tema apare în lista Themes
- [ ] După activare, paginile default sunt create automat (despre-noi, antrenori, etc.) — verifică Pages
- [ ] Vizualizează frontend `staging.kokoro.ro` — homepage se încarcă (poate cu ACF empty state)

**Dacă nu merge**: Activare aruncă fatal error → check `wp-content/debug.log`; dezactivează tema imediat (Power Gym revine activ); fix problema localmente; re-zip; retry.

### 1.3 Copy mu-plugin

**De ce**: Faza 0 a decis CPT-urile (campion/disciplina/antrenor) trăiesc în mu-plugin (decuplare de temă). Fără mu-plugin, șabloanele single-* nu vor răspunde.

**Acțiune**:
```bash
# Local, după staging credentials
ssh user@staging.kokoro.ro "mkdir -p /var/www/html/wp-content/mu-plugins/"
scp mu-plugins/kokoro-content-types.php user@staging.kokoro.ro:/var/www/html/wp-content/mu-plugins/
```
Sau via FTP: upload `mu-plugins/kokoro-content-types.php` în `wp-content/mu-plugins/`.

**Verificare**:
- [ ] WP Admin → Plugins → Must-Use → "Kokoro — Content Types" listat
- [ ] Sidebar admin: meniurile "Campioni", "Discipline", "Antrenori" apar

**Dacă nu merge**: file permissions 644, folder 755; verifică PHP error log dacă fatal.

### 1.4 Verifică admin notices

**De ce**: Tema emite notices proactive pentru a evita debugging tăcut.

**Acțiune**: WP admin → Dashboard.

**Așteptat**:
- ✅ ZERO red notice "Kokoro — mu-plugin lipsă: Tipurile de conținut..."
- ✅ ZERO red notice "Kokoro Brașov Academy — tema necesită ACF"
- ⚠️ Posibil galben "Kokoro — conflict CPT detectat" (vezi 1.5 dacă apare)

**Verificare**:
- [ ] Dashboard fără red notices
- [ ] Frontend: `staging.kokoro.ro/antrenori/` listează antrenorii (dacă seed rulat) sau pagina goală OK

**Dacă RED**:
- "mu-plugin lipsă" → re-upload (1.3) + verifică file permissions
- "ACF necesar" → instalează ACF gratuit din WP repo

**Dacă YELLOW** (CPT conflict): treci la 1.5.

### 1.5 Migrare CPTUI duplicates (DOAR DACĂ apare notice galben)

**De ce**: CPTUI poate fi configurat cu CPT-uri (`trainers`, `discipline`, `champions`) cu rol duplicat față de cele din mu-plugin (`antrenor`, `disciplina`, `campion`). Coexistență = conținut fragmentat în 2 locuri.

**Acțiune**:
1. WP Admin → CPT UI → Edit Post Types — listează ce există
2. Pentru fiecare CPT cu rol duplicat:
   - **Are conținut (>0 posts)**: 
     ```bash
     wp post list --post_type=trainers --format=csv > trainers-export.csv
     # editează CSV: schimbă post_type=trainers → post_type=antrenor
     wp import trainers-export.csv  # sau via WP All Import
     ```
   - **E gol (0 posts)**: șterge definiția CPTUI (Delete)
3. Re-verifică Dashboard — notice galben dispărut

**Verificare**:
- [ ] CPTUI nu mai listează `trainers`/`champions`/`discipline`
- [ ] Frontend `/antrenori/` afișează antrenori migrați

**Dacă nu merge**: păstrează CPTUI activ și redenumește slug-urile în temă (D7 din audit) — backwards-incompatible cu pillarele hardcodate, NU recomandat.

### 1.6 Permalinks flush

**De ce**: CPT-urile noi din mu-plugin au rewrite rules care trebuie înregistrate.

**Acțiune**:
- WP Admin → Settings → Permalinks → Save Changes (fără modificări)
- SAU: `wp rewrite flush`

**Verificare**:
- [ ] `staging.kokoro.ro/antrenor/sensei-lucian-boglut/` → 200 OK (nu 404)
- [ ] `staging.kokoro.ro/campion/adrian-boglut/` → 200 OK
- [ ] `staging.kokoro.ro/disciplina/ju-jitsu-fighting/` → 200 OK

**Dacă nu merge**: `flush_rewrite_rules(true)` (force) prin admin notice; dacă persistă, verifică `.htaccess` permissions.

---

## SECTION 2 — Configure plugins pentru tema nouă

### 2.1 SiteSEO module disable

**De ce**: Tema gestionează `<title>` via filtru `pre_get_document_title` (Faza 0). SiteSEO module "Title & Meta" emite paralel → duplicate `<title>` în `<head>`.

**Acțiune**:
1. WP Admin → SiteSEO → Settings → Modules
2. **Disable "Title & Meta"**
3. **Lasă active**: Sitemap, robots.txt, breadcrumbs (dacă folosești)
4. Save

**Verificare**:
- [ ] View Source `staging.kokoro.ro/contact/` → un singur `<title>` în `<head>`
- [ ] View Source homepage → `<title>Kokoro Brașov — Ju-Jitsu...</title>` (din ACF `set_seo_titlu_home`)

**Dacă nu merge**: păstrează "Title & Meta" activ și inversează — în [inc/seo-meta.php:181](kokoro-theme/inc/seo-meta.php) shimbă filtrul `pre_get_document_title` la priority 20 (după SiteSEO 10) ca să-l overrideze. SAU dezactivează tot SiteSEO și folosește doar tema.

### 2.2 LiteSpeed Cache configuration

**De ce**: Cookie-ul anti-phishing `kokoro_form_token` (Faza 1) și URL-uri cu `?kokoro_form=*` trebuie excluse din cache, altfel banner-ul de succes apare la utilizatori random.

**Acțiune**: WP Admin → LiteSpeed Cache → Cache → **Excludes** tab.

| Setting | Valoare |
|---------|---------|
| **Do Not Cache URIs** | `/multumesc-inscriere/` |
| | `*kokoro_form=*` (wildcard) |
| **Do Not Cache Cookies** | `kokoro_form_token` |
| **Do Not Cache User Agents** | (lasă default) |

Save & Purge All.

**Verificare**:
- [ ] Submit form `/contact/` → banner verde apare (cookie token validat)
- [ ] Open `/contact/?kokoro_form=ok` în incognito → banner NU apare (anti-phishing OK)
- [ ] Vizitează `/multumesc-inscriere/` direct (fără submit) → încarcă dar fără confirmation flow

**Dacă nu merge**: Browser DevTools → Network tab → response header `x-litespeed-cache: hit` pe URL-uri cu `?kokoro_form` = bypass nu funcționează → re-verifică Excludes config.

### 2.3 SpeedyCache configuration

**De ce**: Aceleași considerente ca LiteSpeed.

**Acțiune**: WP Admin → SpeedyCache → Settings → **Advanced** tab.

| Setting | Valoare |
|---------|---------|
| **Never Cache URLs** | `/multumesc-inscriere/` |
| | `kokoro_form` (query string match) |
| **Never Cache Cookies** | `kokoro_form_token` |

Save & Clear Cache.

**Verificare** (similar 2.2):
- [ ] Form submit + banner cookie funcțional
- [ ] Anti-phishing test în incognito OK

**Dacă nu merge**: dezactivează temporar SpeedyCache pentru a izola problemă; LiteSpeed singur e suficient.

### 2.4 ACF settings populate

**De ce**: Tema folosește multe setări via `kokoro_setting()`. Dacă sunt goale, fallback-urile PHP iau efect dar valorile reale ar trebui în ACF.

**Acțiune**: WP Admin → **Setări Kokoro** (options page).

| Field | Default ACF | Verifică/setează |
|-------|------------|-----------------|
| `set_telefon` | `0742 037 973` | Format afișaj UI; tema convertește la E.164 automat |
| `set_email` | `contact@kokoro.ro` | Pentru schema + admin notifications |
| `set_lat` | `45.6427` | Coordonate GPS sală METROM |
| `set_lng` | `25.5887` | Coordonate GPS sală METROM |
| `set_whatsapp_numar` | `40742037973` | **Doar cifre, fără +** |
| `set_an_fondare` | `2008` | Folosit de `kokoro_ani_experienta()` (Faza 8) |
| `set_google_rating` | `4.8` | Din Google Business profile actual |
| `set_google_count` | `97` | Numărul real de recenzii |

**Verificare**:
- [ ] Frontend pillar pages: telefon afișat = `set_telefon`
- [ ] View Source homepage: `<meta name="geo.position" content="45.6427;25.5887">`
- [ ] Schema Organization include `aggregateRating` cu valori actualizate

**Dacă nu merge**: SCF/ACF options page nu apare în meniu → asigură-te că SCF este instalat (sau ACF în varianta cu options page) SAU verifică `acf_add_options_page` rulează pe `acf/init` (debug log).

### 2.5 ACF testimoniale consimtamant

**De ce**: GDPR + Faza 3 — doar testimonialele cu acord scris intră în schema.org Review.

**Acțiune**: WP Admin → **Pagini → Acasă** (sau wherever home_test e configurat) → Testimoniale repeater.

Pentru fiecare testimonial:
- [ ] Confirmă acord scris arhivat (mesaj WhatsApp / email / hârtie)
- [ ] Bifează ✅ `consimtamant_publicare`
- [ ] Anonimizează nume dacă e necesar (ex. "Maria P." în loc de nume complet)

**Verificare**:
- [ ] View Source homepage → `<script type="application/ld+json">` cu `"@type": "Review"` apare DOAR pentru cele bifate
- [ ] Cele nebifate nu emit Review schema (apar doar vizual pe pagină dacă există secțiune dedicată)

**Dacă nu merge**: niciun testimonial cu consimtamant=true → schema Reviews dispare complet (acceptabil — better safe than GDPR-violation).

---

## SECTION 3 — Validare staging

### 3.1 Test funcțional pagini-cheie

**Pagini test (minim)**: vezi spec utilizator + checklist concretă mai jos.

| Pagina | Layout | Imagini | CTAs | Click-to-call | WhatsApp |
|--------|--------|---------|------|---------------|----------|
| `/` (homepage) | [ ] | [ ] | [ ] | [ ] | [ ] |
| `/despre-noi/` | [ ] | [ ] | [ ] | [ ] | [ ] |
| `/tarife/` | [ ] | [ ] | [ ] | [ ] | [ ] |
| `/orar/` | [ ] | [ ] | [ ] | [ ] | [ ] |
| `/inscriere/` | [ ] | [ ] | [ ] | [ ] | [ ] |
| `/contact/` | [ ] | [ ] | [ ] | [ ] | [ ] |
| `/ju-jitsu-copii-brasov/` (pillar) | [ ] | [ ] | [ ] | [ ] | [ ] |
| `/antrenor/sensei-lucian-boglut/` | [ ] | [ ] | [ ] | [ ] | [ ] |
| `/campion/adrian-boglut/` | [ ] | [ ] | [ ] | [ ] | [ ] |
| `/noutati/` (archive) | [ ] | [ ] | [ ] | — | — |
| `/not-a-page/` (404) | [ ] | [ ] | [ ] | — | — |

**Notă mobile-first**: testează simultan pe DevTools mobile emulation 375px (iPhone) + real phone dacă posibil.

**Dacă nu merge**: pagină goală → ACF defaults nu se folosesc, populează vizual din admin; broken layout → check CSS file 404; click-to-call inactiv → verifică `tel:` URL e well-formed.

### 3.2 Test formulare

**Acțiune contact form** (`/contact/`):
1. Completează: Nume, Email, Telefon, Subiect, Mesaj
2. Submit
3. Verifică:
   - [ ] Banner verde "Mesajul a fost trimis cu succes!" apare
   - [ ] Email primit la admin (verifică inbox)
   - [ ] WP admin → Mesaje → noul `kokoro_msg` post listed
   - [ ] DevTools → Application → Cookies → `kokoro_form_token` setat (90s expiry)

**Acțiune înscriere form** (`/inscriere/`):
1. Completează: Nume copil, Vârsta, Telefon (doar required)
2. Submit
3. Verifică:
   - [ ] Redirect la `/multumesc-inscriere/` (NU back la formular cu banner)
   - [ ] View Source: `<meta name="robots" content="noindex...">` prezent
   - [ ] Admin email cu subject `[Înscriere] {Nume} · {Vârstă}`

**Acțiune rate limit test**:
1. Submit 4 form-uri rapide (≤1 min) din același browser
2. Al patrulea ar trebui să primească banner galben "Prea multe trimiteri..."
3. Așteaptă 1 min → poți submit din nou

**Acțiune anti-phishing test**:
1. Browser nou (incognito) → vizitează `https://staging.kokoro.ro/contact/?kokoro_form=ok`
2. Banner verde NU ar trebui să apară (token cookie lipsește)

**Verificare integratoare**:
- [ ] Form contact funcțional + email trimis
- [ ] Form înscriere → /multumesc-inscriere/ + email
- [ ] Rate limit blochează la 4×/oră
- [ ] Anti-phishing: banner doar cu cookie token

**Dacă nu merge**:
- Email nu vine → check `wp_mail()` în debug log; SMTP plugin (Post SMTP) configurat?
- Rate limit nu blochează → verifică transient WP `wp transient list | grep kk_rl_`
- Banner apare în incognito → cache nu respectă cookie exclude (re-vizitează 2.2/2.3)

### 3.3 SEO + Schema validation

**Acțiune Rich Results Test**:
1. https://search.google.com/test/rich-results
2. Test fiecare URL:
   - `https://staging.kokoro.ro/` → Organization, Reviews (dacă consent)
   - `https://staging.kokoro.ro/antrenor/sensei-lucian-boglut/` → Person + hasOccupation
   - `https://staging.kokoro.ro/campion/adrian-boglut/` → Person + sameAs
   - `https://staging.kokoro.ro/disciplina/ju-jitsu-fighting/` → Course
   - `https://staging.kokoro.ro/tarife/` → Service + AggregateOffer
   - `https://staging.kokoro.ro/ju-jitsu-copii-brasov/` → Course + FAQPage
3. Save fiecare ca screenshot

**Acțiune Schema.org Validator**:
- https://validator.schema.org/ — rulează pe URL-urile de mai sus
- Cross-check eligibility cu Google Rich Results

**Verificare**:
- [ ] ZERO erori roșii pe Rich Results Test
- [ ] Warnings minore (`recommended properties missing`) acceptabile
- [ ] AggregateRating apare corect (depind de `set_google_rating`/`set_google_count`)

**Dacă nu merge**:
- Schema lipsește → verifică hook `kokoro_print_jsonld_schemas` rulează (DevTools → View Source → script[type=ld+json])
- Property invalid → check `inc/seo-schemas.php` pe funcția corespunzătoare

### 3.4 Accessibility validation

**WAVE browser extension**: install din https://wave.webaim.org/extension/

Test pe:
- [ ] homepage `/` — zero erori roșii
- [ ] `/ju-jitsu-copii-brasov/` — zero erori roșii
- [ ] `/contact/` — zero erori roșii
- [ ] `/inscriere/` — zero erori roșii (form labels association critic)

**Lighthouse Accessibility audit**:
- DevTools → Lighthouse → Mode Mobile → Categories Accessibility only
- Țintă: ≥90 fiecare, ideal ≥95
- Save raport per pagină

**Manual keyboard test**:
- Tab prin homepage de la sus la jos
- [ ] Toate elementele primesc focus VIZIBIL (outline `--color-primary-dark` 8.6:1)
- [ ] Skip link "Sări la conținut" apare la primul Tab
- [ ] Hamburger mobile (DevTools 375px): Click → focus pe primul item → Tab cycles în meniu → Esc închide

**Screen reader test (VoiceOver iOS)**:
- iPhone real → `staging.kokoro.ro/contact/`
- VoiceOver pornit (Settings → Accessibility → VoiceOver)
- Submit form → banner verde anunțat (role="status")

**Dacă nu merge**:
- Lighthouse <90 → identifică contributorii principali (contrast / labels / aria)
- Skip link invizibil la focus → CSS regression check
- Banner nu anunță → verifică `role="status" aria-live="polite"` în [inc/forms.php:329](kokoro-theme/inc/forms.php#L329)

### 3.5 Performance baseline post-deploy

**Acțiune**: Repetă Lighthouse mobile pe aceleași 6 pagini ca în 0.3.

**Compară cu baseline-ul**:
| Metric | Baseline (Power Gym) | Post-deploy (Kokoro) | Delta |
|--------|---------------------|----------------------|-------|
| LCP | ___ | ___ | ___ |
| CLS | ___ | ___ | ___ |
| INP | ___ | ___ | ___ |
| Performance | ___ | ___ | ___ |

**Verificare**:
- [ ] LCP egal sau mai bun (B1, I2 încă pending — vezi Section 6)
- [ ] CLS stabil sau redus
- [ ] Performance score ≥ baseline

**Save raport ca**: `lighthouse-post-deploy-{slug}-{date}.json` — folosit pentru iter 2 B1/I2 decision.

**Dacă regresia**: identifică cauza prin DevTools Performance tab; rollback poate fi necesar (vezi Section 7).

### 3.6 CSP Report-Only monitoring

**De ce**: Faza 1 a setat CSP în Report-Only. După 24-48h pe staging cu trafic real, decide ce surse adaugi sau dacă promovezi la enforce.

**Acțiune**:
1. Lasă staging 24-48h cu trafic (sau test browsing intens)
2. Browser DevTools → Console → filtrează "Refused to..." messages
3. Identifică surse legitime ne-allowed (ex. CDN imagini, embed YouTube playlist)
4. Update [inc/security-headers.php](kokoro-theme/inc/security-headers.php) cu sursele confirmate
5. Decide promovare la enforce: schimbă `Content-Security-Policy-Report-Only:` → `Content-Security-Policy:`

**Verificare**:
- [ ] DevTools Console — zero "Refused to..." pe pagini-cheie după update
- [ ] Niciun script blocat care ar trebui să ruleze (analytics, embeds)

**Dacă nu merge**: rollback la Report-Only; identifică sursa lipsă; re-test. Nu promova la enforce dacă rămân violations.

### 3.7 Cross-browser test

Minim:
- [ ] Chrome desktop (Win/Mac/Linux)
- [ ] Chrome mobile (Android)
- [ ] Safari macOS
- [ ] Safari iOS (real device)
- [ ] Firefox desktop
- [ ] Edge desktop
- [ ] Samsung Internet (Android)

**Pe fiecare**: vizitează homepage + /contact/ + /tarife/ + 1 pillar.

**Verificare**: layout consistent, form-uri funcționale, font-uri Barlow se încarcă.

**Dacă nu merge**: Safari iOS particularități (safe-area-inset, position:sticky) — testat în Faza 4. Edge legacy nu mai e suportat de WP 6.9.

### 3.8 Test seed.php lock (DOAR DACĂ rulezi seed)

**De ce**: Faza 1 — seed.php trebuie să blocheze re-run accidental.

**Acțiune** (atenție: rulează DOAR dacă DB-ul de staging e gol sau accepți overwrite):
```bash
# Prima rulare
wp eval-file kokoro-theme/bin/seed.php
# Verifică: "SEED COMPLET" + lock activat

# A doua rulare
wp eval-file kokoro-theme/bin/seed.php
# Așteptat: DIE cu mesaj "Seed-ul a rulat deja la {timestamp}..."
```

**Verificare**:
- [ ] Prima rulare populează CPT-uri (4 antrenori, 4 discipline, 23 campioni)
- [ ] A doua rulare e blocată cu mesaj clar
- [ ] `wp option get kokoro_seed_completed` → returnează timestamp

**Dacă nu merge**: lock nu se aplică → verifică [bin/seed.php:43-53](kokoro-theme/bin/seed.php) (Faza 1 fix).

---

## SECTION 4 — Deploy production

> ⚠️ **PROCEED DOAR după Section 3 trecut complet (toate checkbox-urile bifate).**

### 4.1 Backup proaspăt production

Repetă 0.1 — backup imediat înainte de deploy. Production-only.

**Verificare**:
- [ ] Backup descărcat local TEM acum (nu cel vechi din 0.1)
- [ ] DB SQL valid

### 4.2 Maintenance mode

**De ce**: Părinții care vizitează site-ul în timpul deploy nu trebuie să vadă erori.

**Acțiune** (alegi UNA):

**Opțiunea A — Plugin** (recomandat, 1 click):
1. Install "WP Maintenance Mode & Coming Soon" (free)
2. Activează → setează mesaj custom
3. Mesaj: `"Site în actualizare scurtă. Revenim în 30 minute. Pentru urgențe: <a href='tel:+40742037973'>0742 037 973</a> sau <a href='https://wa.me/40742037973'>WhatsApp</a>."`

**Opțiunea B — .htaccess temporar**:
```apache
RewriteEngine On
RewriteCond %{REMOTE_ADDR} !^YOUR.IP.HERE$
RewriteRule ^(.*)$ /maintenance.html [R=503,L]
```
(`maintenance.html` static cu mesajul).

**Verificare**:
- [ ] Vizita anonimă pe `kokoro.ro/` → maintenance page
- [ ] Tu (logat sau IP whitelisted) vezi normal

### 4.3 Deploy temă

Repetă 1.1 → 1.6 dar pe production:
- [ ] Upload kokoro-theme.zip
- [ ] Activează tema
- [ ] Copy mu-plugin
- [ ] Verifică admin notices
- [ ] Migrare CPTUI dacă necesar (DOAR dacă apare notice galben)
- [ ] Permalinks flush

### 4.4 Configure plugins pe production

Repetă Section 2 pe production:
- [ ] SiteSEO Title & Meta dezactivat
- [ ] LiteSpeed cache excludes
- [ ] SpeedyCache cache excludes
- [ ] ACF settings populate (cu valori reale, nu defaults)
- [ ] Testimoniale consimtamant verificat

### 4.5 Smoke test rapid (10 min)

Cu maintenance mode ÎNCĂ activ (sau IP whitelisted):
- [ ] Homepage loads — layout corect
- [ ] `/contact/` — submit test form → email primit
- [ ] `/tarife/` → schema valid (Rich Results Test rapid)
- [ ] `/ju-jitsu-copii-brasov/` → schema valid + mențiunea anilor experiență dinamic (`kokoro_ani_experienta()`) afișează 18 (nu 17)
- [ ] Lighthouse mobile pe homepage → score acceptable (≥80)

**Dacă smoke test fail**: rollback imediat (vezi Section 7) — NU dezactiva maintenance mode.

### 4.6 Disable maintenance mode

- Plugin: dezactivează
- .htaccess: șterge regulile temporare

**Verificare**:
- [ ] `kokoro.ro/` accesibil public
- [ ] Browser DevTools Console — zero erori JS
- [ ] Network tab — toate request-urile 200/304

### 4.7 Cache flush

**De ce**: Post-deploy, cache vechi (Power Gym) trebuie purged.

**Acțiune**:
- [ ] LiteSpeed → Toolbox → Purge → Purge All
- [ ] SpeedyCache → Clear All Cache
- [ ] CloudFlare (dacă activ) → Purge Everything
- [ ] Browser cache: hard reload (Ctrl+Shift+R) verifică serverside

**Verificare**:
- [ ] DevTools Network → first request `cache-control: max-age=0`
- [ ] After 2nd visit: cache hit (LiteSpeed `x-litespeed-cache: hit`)

---

## SECTION 5 — Post-deploy monitoring (primele 48h)

### 5.1 Error monitoring

**Acțiune zilnică**:
```bash
tail -100 wp-content/debug.log | grep -E "Fatal|Warning|Notice"
ls -la wp-content/uploads/error_log* 2>/dev/null
```

**Verificare**:
- [ ] `debug.log` — zero Fatal errors
- [ ] LiteSpeed error log — zero 5xx
- [ ] Site Health (admin) — toate verzi

**Dacă apar erori**: identifică pattern; dacă blocant → rollback (Section 7).

### 5.2 Form submissions monitoring

**Acțiune**:
- [ ] Verifică inbox admin — lead-uri de înscriere/contact apar
- [ ] WP admin → Mesaje (kokoro_msg CPT) — lista mesajelor primite
- [ ] Notează rata de conversion (form views → submissions) — comparativ baseline

**Verificare rate limit nu rănește utilizatorii**:
- [ ] Niciun mesaj despre "rate_limit" în feedback users
- [ ] Dacă apar plângeri "nu pot trimite" → adjust treshold în [inc/forms.php:127](kokoro-theme/inc/forms.php) (3/min, 5/oră → mai generos)

### 5.3 Analytics

**Google Analytics**:
- [ ] Bounce rate — stabil sau îmbunătățit (target -5% post-deploy)
- [ ] Average session duration — stabil sau crescut
- [ ] Conversion goal "thank-you page view" — primele lead-uri tracked

**Search Console**:
- [ ] Crawl errors — niciuna nouă (404-uri pe slug-uri vechi semnalează rewrite issue)
- [ ] Resubmit sitemap dacă slug-uri CPT sau pagini noi
- [ ] Verifică schema markup în Performance → Search Appearance

### 5.4 User feedback

**Adi/Lucian (admin users)**:
- [ ] Folosesc admin? Notează feedback pe UX panel
- [ ] Pot edita testimoniale + bifa consent? (Faza 3 ACF nou)
- [ ] Setări Kokoro options page intuitivă?

**Părinți (frontend)**:
- [ ] Întrebări pe WhatsApp legate de site? (UX confuse)
- [ ] Form-ul nou (3 fields) e completat fără probleme?

---

## SECTION 6 — Iter 2 plan (după 1-2 săptămâni stabile)

> Doar după ce site-ul rulează stabil ≥1 săptămână fără rollback și fără bug-uri majore reportate.

### 6.1 Lighthouse-driven optimizations

Folosește datele din 3.5 + 5.3:
- [ ] **B1** — `srcset`/`sizes` (decide pe baza LCP — dacă LCP > 2.5s pe mobile, prioritar)
- [ ] **I2** — `<link rel="preload">` pentru hero LCP (după confirm hero e LCP element)
- [ ] **D1** — inline style → CSS classes (necesită screenshot regression test pe staging)

### 6.2 Marketing TODO

Decizii de luat cu Adi/Lucian:
- [ ] **B-1** Voice consistency — "tu" vs "dumneavoastră" pe pillar pages
- [ ] **B-6** Taglines integrare — "Azi mai buni ca ieri" / "Fii mai bun ca ieri" pe site?
- [ ] **B-7** Mascot Carpathian bear — când imagini finale
- [ ] **P4** Statistici reale — număr copii activi confirmat (nu "200+" inventat)
- [ ] **P3** Photo session pillars — programare cu Adi pentru autentic

### 6.3 Content debt

- [ ] **B-9** Glossary martial arts — pagini SEO long-tail
- [ ] **T4** Tarife comparison side-by-side
- [ ] **T5** Reduceri frați/anual vizibile
- [ ] **O1, O2, O3** Mobile orar UX — collapse pe zile, filtru vârstă, click row → preset grupa

### 6.4 Form refactor follow-up

- [ ] **F3** Per-field error messages (din audit Faza 4)
- [ ] Verifică conversion rate form nou (3 required) vs vechi (9):
  - Pre-deploy: ___ % submissions/views
  - Post-deploy: ___ % submissions/views
  - Delta țintit: +30-50% (mai puține fields = mai puține abandonments)

---

## SECTION 7 — Rollback plan

> Dacă smoke test (4.5) fail SAU Fatal error în primele 24h → execută rollback.

### 7.1 Theme rollback rapid

**Acțiune**:
- WP Admin → Appearance → Themes → Activate "Power Gym"
- SAU CLI: `wp theme activate power-gym`

**Verificare**:
- [ ] Frontend `kokoro.ro/` se încarcă cu tema veche
- [ ] Form-urile vechi (din Power Gym) funcționează
- [ ] Conținutul e intact (CPT-urile rămân în DB chiar dacă mu-plugin activ)

### 7.2 Mu-plugin rollback (DOAR DACĂ Power Gym nu suportă CPT-urile noi)

**Acțiune**:
```bash
ssh user@kokoro.ro "rm /var/www/html/wp-content/mu-plugins/kokoro-content-types.php"
```

**Efect**: CPT-urile (campion/disciplina/antrenor) dispar din meniu admin. **Conținutul rămâne în DB** pentru recovery — doar nu mai e accesibil până când mu-plugin redeployed.

**Verificare**:
- [ ] Admin sidebar nu mai listează CPT-urile
- [ ] DB query: `wp post list --post_type=campion` returnează posts (conținut intact)

### 7.3 DB rollback (în caz de migrare CPTUI nereușită în 1.5)

**Acțiune drastică**:
```bash
wp db import kokoro-pre-deploy-{date}.sql
```

**Atenție**: pierzi orice schimbare făcută între backup și rollback (mesaje noi în kokoro_msg, ACF edits, posts noi, etc.).

**Recomandare**: înainte de Section 4, fă DB backup separat:
```bash
wp db export kokoro-pre-prod-deploy-$(date +%Y%m%d-%H%M).sql
```

**Verificare după restore**:
- [ ] Post count revenit la nivel pre-deploy
- [ ] Plugin settings (LiteSpeed, ACF) revenite

### 7.4 Plugin rollback

**Setări LiteSpeed/SpeedyCache**:
- Restaurează din screenshot/export făcut în 0.4
- Sau dezactivare temporară plugin până când reconfigurezi

**ACF**:
- Field-urile noi (din Faza 3 — given_name, family_name, honorific_prefix, antrenor_skills, etc.) rămân declarate în cod
- Dacă tema e dezactivată → field groups nu se mai înregistrează → metadata din wp_postmeta rămâne intact (orfan dar recuperabil)

**Verificare post-rollback complet**:
- [ ] Site e accesibil public
- [ ] Form-urile funcționează (chiar dacă în formatul vechi)
- [ ] DB integrity check: `wp db check`
- [ ] Notify Adi/Lucian: "rollback executat, problemă X identificată, deploy nou planificat pentru Y"

---

## Notițe finale

### Ordine recomandată de execuție
1. **Săptămâna -1**: Section 0 (preparation)
2. **Ziua -3**: Section 1, 2, 3 pe staging (cu test la fiecare pas)
3. **Ziua deploy** (orele off-peak: marți-joi 22:00-23:00):
   - 22:00 → 4.1 backup
   - 22:05 → 4.2 maintenance ON
   - 22:10 → 4.3-4.5 deploy + smoke test
   - 22:30 → 4.6 maintenance OFF
   - 22:35 → 4.7 cache flush
4. **Ziua +1, +2**: Section 5 (monitoring)
5. **Săptămâna +2**: Section 6 (iter 2 dacă stabil)

### Contact escalation

În caz de probleme blocante:
- **Tehnic**: developer responsabil (tu) → rollback Section 7
- **Business**: Adi/Lucian (telefon `set_telefon`)
- **Hosting**: provider (LiteSpeed support, dacă issue server-side)

### Documentație suplimentară
- [`kokoro-theme/INSTALL.md`](kokoro-theme/INSTALL.md) — setup detaliat
- Memory `.claude/projects/.../memory/` — context audit pe faze
- PR #9 GitHub — review code changes Faza 1-9
