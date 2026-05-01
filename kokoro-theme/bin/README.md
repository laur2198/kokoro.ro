# Kokoro — Seed Scripts & Editing Guide

## seed.php

Populează automat în WordPress prin ACF:

**CPTs:**
- 4 antrenori (cu poze)
- 4 discipline
- 23 campioni (cu poze + palmares)

**ACF page-specific:**
- Tarife (3 pachete + notă)
- Orar (legendă + 23 sesiuni)
- Formulare (4 formulare descărcabile + dosar)
- Regulament (13 articole)
- FAQ (7 categorii, 17 Q&A)
- Contact (5 subiecte form)

**Setări globale:** telefon, WhatsApp, email, adresă, descriere footer

### Cum se rulează

**Opțiunea A — wp-cli (recomandat):**
```bash
wp eval-file wp-content/themes/kokoro-theme/bin/seed.php
```

**Opțiunea B — browser (one-time, doar admin):**
1. Loghează-te în WordPress admin
2. Vizitează: `https://kokoro.ro/wp-content/themes/kokoro-theme/bin/seed.php`
3. **Șterge `bin/seed.php`** după execuție.

### Cerințe

- ACF activ
- Paginile create în WP admin cu template-urile corecte:
  - `/` → Front Page
  - `/despre-noi/` → page-despre-noi.php
  - `/antrenori/` → page-antrenori.php
  - `/discipline/` → page-discipline.php
  - `/orar/` → Orar
  - `/tarife/` → Tarife
  - `/campioni/` → Campioni
  - `/galerie/` → page-galerie.php
  - `/contact/` → Contact
  - `/inscriere/` → Înscriere
  - `/faq/` → FAQ
  - `/formulare/` → Formulare
  - `/regulament/` → Regulament Intern
  - `/calendar-competitional/` → Calendar Competițional

---

## EDITARE CONȚINUT din WP Admin

### Toate paginile sunt editabile prin ACF

| Pagină | Câmpuri ACF |
|---|---|
| **Front Page** | hero, marquee, discipline, valori (filozofie), campioni, testimoniale, orar preview, CTA |
| **Despre Noi** | hero, poveste, timeline, valori, mission, fondator |
| **Antrenori (CPT)** | nume, rol, bio, specializare, centură, ani experiență, contact |
| **Discipline (CPT)** | nume, teaser, descriere, beneficii, target audience |
| **Campioni (CPT)** | nume, bio, centură, palmares (repeater), featured |
| **Orar** | legendă (repeater), program săptămânal (repeater) |
| **Tarife** | pachete (repeater cu beneficii), notă, CTA |
| **Galerie** | titlu, intro |
| **Contact** | titlu, landmark, drum, program, subiecte form |
| **Înscriere** | hero, formular, opțiuni grupă, pași |
| **FAQ** | hero, intro, **categorii cu Q&A** (repeater nested) |
| **Formulare** | hero, **listă formulare** (repeater), pași, dosar, CTA |
| **Regulament** | hero, intro, **articole** (repeater), notă, semnatar |
| **Calendar Competițional** | hero, **competiții** (repeater cu data/locație/tip), CTA |
| **Pillar pages** (5) | override hero, intro, CTA — sau switch template la "Pagină Pilon (SEO)" pentru control complet |
| **Setări (Options)** | telefon, WhatsApp, email, adresă, social media, footer |

### Pagini Pilon — DOUĂ moduri de editare

**Modul A — Override rapid** (default după instalare):
- Pagina folosește template hardcoded (page-arte-martiale-copii-brasov.php etc.)
- Conținut SEO dens optimizat
- Editezi doar hero/intro/CTA via ACF

**Modul B — Control complet**:
- Schimbă din admin: **Page Attributes → Template = "Pagină Pilon (SEO)"** (page-pillar.php)
- Editezi via ACF toate secțiunile: Hero, Intro, Beneficii, Ce învață, Grupe, Cum se desfășoară, Echipament, Preț, Diferențiator, Testimoniale, Instructori, Locație, FAQ, CTA
- Trebuie să completezi toate câmpurile, pentru că hardcoded-ul nu mai e folosit

### Re-rulare seed

Scriptul e idempotent — caută postul după `post_title`. Poți rula de mai multe ori fără duplicări.
