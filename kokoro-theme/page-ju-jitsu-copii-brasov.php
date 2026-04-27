<?php
/**
 * Template Name: Pillar — Ju-Jitsu Copii Brașov
 *
 * Template hardcoded pentru pagina pilon SEO „ju-jitsu-copii-brasov".
 * Conținutul este sincronizat manual cu kokoro-theme/preview/ju-jitsu-copii-brasov.html.
 * Pentru update: edit aici sau pe preview, păstrați-le în sincron.
 *
 * Schema JSON-LD este randată inline (nu prin kokoro_render_jsonld_pillar
 * care țintește doar template-ul page-pillar.php generic).
 *
 * @package Kokoro
 */

get_header();
?>

<main id="content">

<!-- ============================================================
     SECTION 1: HERO
     ============================================================ -->
<section class="page-header">
  <div class="container">
    <div class="section-number">Pentru Copii (4-15 ani)</div>
    <h1>JU-JITSU<br>PENTRU <em>COPII</em><br>BRAȘOV</h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 700px; line-height: 1.7; font-size: 1.0625rem;">
      La Kokoro Brașov Academy, copilul dumneavoastră învață Ju-Jitsu autentic într-un mediu sigur și disciplinat. Cursuri pentru toate vârstele între 4 și 15 ani, cu antrenori cu palmares internațional și 17 ani de experiență.
    </p>

    <div style="display: flex; gap: var(--space-md); flex-wrap: wrap; margin-top: var(--space-2xl); align-items: center;">
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--primary btn--large">
        Antrenament Gratuit de Probă
      </a>
      <a href="tel:+40742037973" class="btn btn--outline btn--large">
        Sună Acum
      </a>
      <a href="tel:+40742037973" style="color: var(--color-accent); font-weight: 700; font-size: 1.125rem; margin-left: var(--space-md); white-space: nowrap; text-decoration: none;">
        📞 0742 037 973
      </a>
    </div>
  </div>
  <div class="page-header__number" aria-hidden="true">柔</div>
</section>

<!-- ============================================================
     SECTION 2: INTRO
     ============================================================ -->
<section class="section section--dark">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">01 — Despre cursuri</div>
      <h2>O ALEGERE COMPLETĂ<br>PENTRU <em>COPILUL DUMNEAVOASTRĂ</em></h2>
    </div>

    <div class="reveal" style="color: var(--color-gray); line-height: 1.9; font-size: 1.0625rem;">
      <p style="margin-bottom: var(--space-lg);">
        <strong>Ju-Jitsu pentru copii la Kokoro Brașov</strong> este una dintre cele mai vechi și complete arte marțiale, oferind copiilor mult mai mult decât tehnici de luptă. Este un sistem educațional complet care formează caracterul prin disciplină, respect, control de sine și încredere — calități care îl însoțesc pe copilul dumneavoastră pe tot parcursul vieții.
      </p>
      <p style="margin-bottom: var(--space-lg);">
        Fondată în 2008, academia noastră din Brașov este recunoscută pentru rezultatele de excepție obținute la competiții naționale și internaționale. Antrenorii noștri, în frunte cu vicecampionul european U21 <strong style="color: var(--color-white);">Adrian Boglut</strong>, transmit cu pasiune valorile autentice ale Ju-Jitsu-ului japonez tradițional.
      </p>
      <p>
        Programele pentru copii sunt special concepute pe grupe de vârstă (4-7, 8-12 și 13-15 ani), cu accent pe dezvoltare fizică armonioasă, antrenament progresiv și siguranță. Fiecare lecție este o oportunitate pentru copilul dumneavoastră să devină mai puternic, mai concentrat și mai stăpân pe sine — într-un mediu unde respectul reciproc și plăcerea de a învăța sunt fundamentale.
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     [D2.1] DONE: Beneficii, Ce învață, Grupe de vârstă
     [D2.2] Cum se desfășoară, Echipament, Prețuri, Diferențiator
     [D2.3] Testimoniale, FAQ, Locație, CTA final + Schema Course + FAQPage
     ============================================================ -->

<!-- ============================================================
     SECTION 3: BENEFICII
     ============================================================ -->
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">02 — Beneficii</div>
      <h2>CE PRIMEȘTE COPILUL<br>DUMNEAVOASTRĂ <em>LA KOKORO</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); max-width: 700px; line-height: 1.7;">
        Ju-Jitsu nu este doar despre tehnici de luptă — este un sistem complet care formează caractere puternice și sănătoase. Iată cele șase beneficii esențiale pe care le veți observa în primele luni.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-xl);">
      <div class="reveal reveal-delay-1" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">🥋</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Disciplină autentică</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Copilul dumneavoastră învață să-și controleze comportamentul, să respecte reguli clare și să persevereze în fața obstacolelor — abilități transferabile direct la școală și acasă.
        </p>
      </div>

      <div class="reveal reveal-delay-2" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">🛡️</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Autoapărare practică</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Tehnici eficiente de Ju-Jitsu adaptate vârstei, focusate pe dezescaladarea conflictului și apărarea corporală controlată — fără agresivitate sau lovituri inutile.
        </p>
      </div>

      <div class="reveal reveal-delay-3" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">💪</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Dezvoltare fizică armonioasă</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Forță, mobilitate, coordonare, echilibru și viteză — toate dezvoltate progresiv într-un mediu sigur, cu instructori atenți la fiecare nivel de progres individual.
        </p>
      </div>

      <div class="reveal reveal-delay-4" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">🧠</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Concentrare și încredere</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Antrenamentul Ju-Jitsu cere atenție constantă. În câteva luni veți observa un copil mai concentrat la lecțiile școlare și mai sigur pe sine în situații sociale dificile.
        </p>
      </div>

      <div class="reveal reveal-delay-1" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">🤝</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Spirit de echipă</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Lecțiile se desfășoară în grupe mici unde copilul dumneavoastră leagă prietenii sănătoase, învață să colaboreze cu coechipierii și să respecte adversarul ca pe un partener de evoluție.
        </p>
      </div>

      <div class="reveal reveal-delay-2" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">🏆</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Cale spre performanță</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Pentru copiii care doresc, există drumul competiției: avem deja campioni mondiali și europeni care au început antrenamentele la Kokoro la vârsta de 6-7 ani.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 4: CE ÎNVAȚĂ COPILUL
     ============================================================ -->
<section class="section section--dark">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">03 — Curriculum</div>
      <h2>CE VA ÎNVĂȚA<br><em>COPILUL DUMNEAVOASTRĂ</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); line-height: 1.7;">
        Curriculum-ul nostru urmează tradiția japoneză autentică, adaptată însă pentru fiecare grupă de vârstă. Iată ce conține un an de antrenament la Kokoro Brașov.
      </p>
    </div>

    <ul class="reveal" style="list-style: none; padding: 0; margin: 0;">
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Tehnici de proiectare (nage waza)</strong> — bazele aruncărilor controlate, fundamentale în Ju-Jitsu autentic.</span>
      </li>
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Tehnici de control la sol (ne-waza)</strong> — imobilizări sigure și escape-uri, esențiale pentru autoapărare reală.</span>
      </li>
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Lovituri și blocaje adaptate (atemi waza)</strong> — adaptate strict pentru vârstă, cu accent pe control, nu pe agresivitate.</span>
      </li>
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Cădere sigură fără traumatisme (ukemi)</strong> — prima abilitate pe care o învață orice copil, ce protejează în viața de zi cu zi.</span>
      </li>
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Etichetă de dojo</strong> — salutul, respectul față de antrenor și coechipieri, ritualul japonez tradițional al antrenamentului.</span>
      </li>
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Vocabular japonez de bază</strong> — termenii esențiali ai disciplinei, transmiși din generație în generație.</span>
      </li>
    </ul>
  </div>
</section>

<!-- ============================================================
     SECTION 5: GRUPE DE VÂRSTĂ
     ============================================================ -->
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">04 — Grupe</div>
      <h2>PROGRAMUL <em>PE VÂRSTE</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); max-width: 700px; line-height: 1.7;">
        Fiecare copil este unic, iar noi structurăm antrenamentele după nivelul de dezvoltare al fiecărei vârste. Veți alege împreună cu noi grupa potrivită pentru copilul dumneavoastră.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-xl);">
      <div class="card reveal reveal-delay-1" style="padding: var(--space-2xl);">
        <div class="card__tag">Copii 4-7 ani</div>
        <p style="color: var(--color-accent); font-weight: 700; margin: var(--space-md) 0; font-size: 0.9375rem;">
          Inițiere prin joc · 2 antrenamente/săptămână × 45 min
        </p>
        <h3 class="card__title" style="margin-bottom: var(--space-md);">PRIMUL <em>CONTACT</em></h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Focus pe motricitate generală, învățarea căderilor sigure, respectarea regulilor de grup și plăcerea de a învăța prin mișcare. Antrenamentele sunt conduse cu joacă structurată — copilul se distrează în timp ce dezvoltă fundamentele Ju-Jitsu-ului.
        </p>
      </div>

      <div class="card reveal reveal-delay-2" style="padding: var(--space-2xl); border-color: var(--color-accent);">
        <div class="card__tag">Copii 8-12 ani</div>
        <p style="color: var(--color-accent); font-weight: 700; margin: var(--space-md) 0; font-size: 0.9375rem;">
          Tehnică de bază · 3 antrenamente/săptămână × 60 min
        </p>
        <h3 class="card__title" style="margin-bottom: var(--space-md);">FUNDAMENTELE <em>TEHNICII</em></h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Învățarea sistematică a tehnicilor Ju-Jitsu: proiectări, controale la sol, autoapărare introductivă. Copilul dumneavoastră poate participa opțional la primele competiții și începe să-și formeze o identitate sportivă reală.
        </p>
      </div>

      <div class="card reveal reveal-delay-3" style="padding: var(--space-2xl);">
        <div class="card__tag">Juniori 13-15 ani</div>
        <p style="color: var(--color-accent); font-weight: 700; margin: var(--space-md) 0; font-size: 0.9375rem;">
          Performanță · 3-4 antrenamente/săptămână × 75 min
        </p>
        <h3 class="card__title" style="margin-bottom: var(--space-md);">CALEA <em>COMPETIȚIEI</em></h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Pregătire sistematică pentru competiții naționale și internaționale, autoapărare avansată, perfecționare tehnică. Pentru juniorii cu potențial, oferim suport individual către lotul de performanță al academiei.
        </p>
      </div>
    </div>

    <div class="reveal" style="margin-top: var(--space-2xl); padding: var(--space-xl); background: var(--color-white); border-radius: 4px; border-left: 4px solid var(--color-accent); max-width: 800px; margin-left: auto; margin-right: auto;">
      <p style="color: var(--color-bg); line-height: 1.7;">
        <strong>Notă:</strong> Trecerea între grupe se face individual, în funcție de nivelul de pregătire al copilului — nu strict după vârstă. Antrenorul evaluează periodic fiecare copil și recomandă mutarea atunci când este cazul.
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 6: CUM SE DESFĂȘOARĂ UN ANTRENAMENT
     ============================================================ -->
<section class="section section--dark">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">05 — Antrenament</div>
      <h2>CUM SE DESFĂȘOARĂ<br>UN <em>ANTRENAMENT</em></h2>
    </div>

    <div class="reveal" style="color: var(--color-gray); line-height: 1.9; font-size: 1.0625rem;">
      <p style="margin-bottom: var(--space-lg);">
        Fiecare antrenament la Kokoro începe cu salutul tradițional japonez (<em>rei</em>), urmat de o încălzire de 10-15 minute care include exerciții cardio adaptate vârstei și pregătirea articulațiilor. Această parte este esențială pentru prevenirea accidentărilor și pentru a-i obișnui pe copii cu rigoarea unui antrenament marțial autentic.
      </p>
      <p style="margin-bottom: var(--space-lg);">
        Partea principală a lecției durează 30-40 de minute și se concentrează pe învățarea progresivă a tehnicilor: instructorul demonstrează tehnica, apoi copiii o exersează în perechi sub supraveghere atentă. Fiecare tehnică este descompusă în pași simpli, iar copiii avansează doar după ce sunt asimilați corect — siguranța este prioritară.
      </p>
      <p style="margin-bottom: var(--space-lg);">
        Ultimele 10-15 minute sunt dedicate aplicării libere — <em>randori</em> (luptă controlată) sau jocuri tematice care întăresc învățarea. Lecția se încheie cu salutul final și o reflecție scurtă despre ce s-a învățat în ziua respectivă.
      </p>
      <p>
        Antrenorii noștri respectă principiul fundamental al Ju-Jitsu-ului japonez: <strong style="color: var(--color-white);">progresul nu se grăbește</strong>. Fiecare copil avansează în ritmul propriu, cu obiective clare și feedback constant. Niciun antrenament nu se încheie cu rănire, frustrare sau confuzie — ci cu satisfacția unui pas făcut înainte.
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 7: ECHIPAMENT NECESAR
     ============================================================ -->
<section class="section section--alt">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">06 — Echipament</div>
      <h2>CE TREBUIE<br>SĂ <em>PREGĂTIȚI</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); line-height: 1.7;">
        Pentru primul antrenament de probă nu aveți nevoie de echipament special — doar haine sport confortabile. Echipamentul complet îl cumpărați doar după înscriere, cu recomandările noastre.
      </p>
    </div>

    <div class="reveal" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: var(--space-md);">
      <div style="padding: var(--space-md) var(--space-lg); background: var(--color-white); border-radius: 4px; display: flex; align-items: center; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem;">✓</span>
        <span><strong>Kimono Ju-Jitsu (gi)</strong> alb din bumbac</span>
      </div>
      <div style="padding: var(--space-md) var(--space-lg); background: var(--color-white); border-radius: 4px; display: flex; align-items: center; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem;">✓</span>
        <span><strong>Centura</strong> corespunzătoare nivelului</span>
      </div>
      <div style="padding: var(--space-md) var(--space-lg); background: var(--color-white); border-radius: 4px; display: flex; align-items: center; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem;">✓</span>
        <span><strong>Sticlă de apă</strong> personală</span>
      </div>
      <div style="padding: var(--space-md) var(--space-lg); background: var(--color-white); border-radius: 4px; display: flex; align-items: center; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem;">✓</span>
        <span><strong>Picioare goale</strong> pe tatami (papuci doar în vestiar)</span>
      </div>
      <div style="padding: var(--space-md) var(--space-lg); background: var(--color-white); border-radius: 4px; display: flex; align-items: center; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem;">✓</span>
        <span><strong>Unghii tăiate scurt</strong> (regulă de siguranță)</span>
      </div>
      <div style="padding: var(--space-md) var(--space-lg); background: var(--color-white); border-radius: 4px; display: flex; align-items: center; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem;">✓</span>
        <span><strong>Prosop mic</strong> (opțional)</span>
      </div>
    </div>

    <div class="reveal" style="margin-top: var(--space-xl); text-align: center; color: var(--color-bg); font-size: 0.9375rem; line-height: 1.7;">
      <p><strong>Recomandare:</strong> primul kimono se cumpără după prima săptămână de antrenament, când copilul este sigur că vrea să continue. Vă recomandăm furnizori verificați — fără să fim afiliați la vreunul.</p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 8: PREȚURI
     ============================================================ -->
<section class="section section--dark">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">07 — Investiție</div>
      <h2>TARIFE <em>TRANSPARENTE</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); line-height: 1.7;">
        Investiția în educația fizică și caracterul copilului dumneavoastră este una dintre cele mai bune decizii pe care le puteți lua. Tarifele noastre sunt diferențiate pe grupă de vârstă și frecvență.
      </p>
    </div>

    <div class="reveal" style="background: var(--color-bg-card); border: 1px solid var(--color-gray-dark); border-radius: 4px; padding: var(--space-2xl); color: var(--color-white); line-height: 1.9;">
      <p style="margin-bottom: var(--space-lg);">
        <strong style="color: var(--color-accent);">Copii 4-12 ani:</strong> [DE COMPLETAT] RON/lună (3 antrenamente/săptămână)
      </p>
      <p style="margin-bottom: var(--space-lg);">
        <strong style="color: var(--color-accent);">Juniori 13-15 ani:</strong> [DE COMPLETAT] RON/lună (4 antrenamente/săptămână)
      </p>
      <p style="margin-bottom: var(--space-lg); color: var(--color-gray);">
        Oferim reducere pentru frați (-20%) și pentru abonamentele anuale plătite în avans (-15%). Prima lecție este întotdeauna gratuită — nu există nicio obligație ulterioară.
      </p>
      <p style="margin-bottom: var(--space-xl); color: var(--color-gray);">
        Pentru detalii actualizate și oferte speciale (perioade de cumpărare echipament, reduceri sezoniere), consultați pagina <a href="<?php echo esc_url(home_url('/tarife/')); ?>" style="color: var(--color-accent);">Tarife</a> sau contactați-ne la <a href="tel:+40742037973" style="color: var(--color-accent);">0742 037 973</a>.
      </p>
      <div style="text-align: center;">
        <a href="<?php echo esc_url(home_url('/tarife/')); ?>" class="btn btn--outline-accent">Vezi Toate Tarifele</a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 9: CE NE DIFERENȚIAZĂ
     ============================================================ -->
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">08 — De ce noi</div>
      <h2>DE CE PĂRINȚII<br>ALEG <em>KOKORO BRAȘOV</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); max-width: 700px; line-height: 1.7;">
        Există mai multe școli de arte marțiale în Brașov. Iată ce ne diferențiază pe noi de restul.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-xl);">
      <div class="reveal reveal-delay-1" style="padding: var(--space-xl); border: 2px solid var(--color-accent); border-radius: 4px; background: var(--color-white);">
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.375rem; margin-bottom: var(--space-md); color: var(--color-bg);">
          17 ani de experiență locală
        </h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Din 2008 am format generații de copii brașoveni — cunoaștem ce funcționează în comunitatea noastră, ce așteaptă părinții și ce rezultate concrete putem livra într-un an de antrenament.
        </p>
      </div>

      <div class="reveal reveal-delay-2" style="padding: var(--space-xl); border: 2px solid var(--color-accent); border-radius: 4px; background: var(--color-white);">
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.375rem; margin-bottom: var(--space-md); color: var(--color-bg);">
          Antrenor cu palmares internațional
        </h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Adrian Boglut, vicecampion european U21 -62kg, conduce direct antrenamentele grupelor avansate. Copilul dumneavoastră învață de la cineva care a urcat pe podium la cel mai înalt nivel.
        </p>
      </div>

      <div class="reveal reveal-delay-3" style="padding: var(--space-xl); border: 2px solid var(--color-accent); border-radius: 4px; background: var(--color-white);">
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.375rem; margin-bottom: var(--space-md); color: var(--color-bg);">
          Grupe mici, atenție individuală
        </h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Limităm grupele la maxim 12-15 copii pentru a garanta corectarea individuală a tehnicii. Antrenorul cunoaște numele și ritmul fiecărui copil — nu este o lecție „de masă".
        </p>
      </div>

      <div class="reveal reveal-delay-4" style="padding: var(--space-xl); border: 2px solid var(--color-accent); border-radius: 4px; background: var(--color-white);">
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.375rem; margin-bottom: var(--space-md); color: var(--color-bg);">
          Spațiu propriu, dotat profesional
        </h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Sală cu tatami de competiție, vestiare separate băieți/fete, sistem de ventilație și iluminat profesional. Părinții pot urmări antrenamentul dintr-o zonă dedicată.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 10: TESTIMONIALE PĂRINȚI
     ============================================================ -->
<section class="section section--dark">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">09 — Părerile părinților</div>
      <h2>CE SPUN PĂRINȚII<br><em>DESPRE NOI</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); max-width: 700px; line-height: 1.7;">
        Suntem evaluați 4.8/5 stele pe Google din 97 de recenzii ale părinților din Brașov. Iată câteva mărturii reprezentative.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-xl);">
      <div class="testimonial reveal reveal-delay-1">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „[DE COMPLETAT — testimonial real părinte 1: 2-3 fraze despre cum a evoluat copilul în ultimele luni la Kokoro, accent pe disciplină și încredere.]"
        </p>
        <div class="testimonial__author">[Nume Părinte 1]</div>
        <div class="testimonial__source">mama lui [Nume copil], [vârstă] ani</div>
      </div>

      <div class="testimonial reveal reveal-delay-2">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „[DE COMPLETAT — testimonial real părinte 2: focus pe autoapărare, schimbare în comportamentul copilului la școală sau în grupul de prieteni.]"
        </p>
        <div class="testimonial__author">[Nume Părinte 2]</div>
        <div class="testimonial__source">tatăl lui [Nume copil], [vârstă] ani</div>
      </div>

      <div class="testimonial reveal reveal-delay-3">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „[DE COMPLETAT — testimonial real părinte 3: experiența cu antrenorii, calitatea grupei, recomandare pentru alți părinți.]"
        </p>
        <div class="testimonial__author">[Nume Părinte 3]</div>
        <div class="testimonial__source">mama lui [Nume copil], [vârstă] ani</div>
      </div>
    </div>

    <div class="reveal" style="text-align: center; margin-top: var(--space-2xl);">
      <p style="color: var(--color-gray); font-size: 0.9375rem;">
        ⭐ <strong style="color: var(--color-accent);">4.8/5</strong> pe Google · <strong style="color: var(--color-white);">97 recenzii</strong> de la părinți din Brașov
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 11: FAQ — ÎNTREBĂRI FRECVENTE
     ============================================================ -->
<section class="section section--alt" id="faq">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">10 — Întrebări frecvente</div>
      <h2>ÎNTREBĂRI<br><em>FRECVENTE</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); line-height: 1.7;">
        Răspunsuri la cele mai des întâlnite întrebări ale părinților care iau în considerare Ju-Jitsu pentru copii. Dacă aveți alte nelămuriri, sunați-ne la <a href="tel:+40742037973" style="color: var(--color-accent);">0742 037 973</a>.
      </p>
    </div>

    <div class="kokoro-faq" style="display: flex; flex-direction: column; gap: var(--space-md);">
      <details class="reveal reveal-delay-1" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>De la ce vârstă poate începe copilul Ju-Jitsu la Kokoro Brașov?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Acceptăm copii de la <strong>4 ani</strong>. Avem grupe special structurate pe vârste: 4-7 ani (inițiere prin joc), 8-12 ani (tehnică de bază și autoapărare introductivă), 13-15 ani (performanță și autoapărare avansată).
        </div>
      </details>

      <details class="reveal reveal-delay-2" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Ju-Jitsu este periculos pentru copii?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Nu. Tehnicile sunt adaptate strict pentru copii, iar accentul cade pe <strong>control, nu pe forță</strong>. Prima abilitate învățată este căderea sigură (ukemi). Antrenamentele se desfășoară pe tatami profesional cu supraveghere atentă din partea instructorului.
        </div>
      </details>

      <details class="reveal reveal-delay-3" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Câte antrenamente pe săptămână sunt recomandate?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Pentru rezultate vizibile, recomandăm <strong>2-3 antrenamente pe săptămână</strong>, fiecare de 45-75 minute (în funcție de grupa de vârstă). Frecvența mai mare ajută la consolidarea tehnicii și formarea obiceiului de antrenament.
        </div>
      </details>

      <details class="reveal reveal-delay-4" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Cât costă un abonament lunar?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Tarifele actuale sunt prezentate pe pagina <a href="<?php echo esc_url(home_url('/tarife/')); ?>" style="color: var(--color-accent);">Tarife</a>. Avem reduceri pentru frați (-20%) și pentru abonamentele anuale plătite în avans (-15%). Pentru ofertă personalizată, sunați la <a href="tel:+40742037973" style="color: var(--color-accent);">0742 037 973</a>.
        </div>
      </details>

      <details class="reveal reveal-delay-1" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Ce echipament este necesar la primul antrenament?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Pentru lecția de probă: doar haine sport confortabile, sticlă de apă și unghii tăiate scurt. Picioarele goale pe tatami (papucii rămân în vestiar). După înscriere, kimono-ul (gi alb din bumbac) și centura se cumpără în prima săptămână.
        </div>
      </details>

      <details class="reveal reveal-delay-2" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Care este diferența între Ju-Jitsu și Karate sau BJJ?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          <strong>Ju-Jitsu</strong> este arta marțială japoneză tradițională cu paletă completă: proiectări, control la sol și lovituri controlate. <strong>Karate</strong> se concentrează pe lovituri (pumni, picioare). <strong>BJJ (Brazilian Jiu-Jitsu)</strong> derivă din Ju-Jitsu dar lucrează aproape exclusiv la sol. Pentru copii, Ju-Jitsu autentic oferă cel mai echilibrat curriculum.
        </div>
      </details>

      <details class="reveal reveal-delay-3" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Există antrenament de probă gratuit?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Da, primul antrenament este <strong>gratuit și fără nicio obligație</strong>. Completați formularul de pe pagina <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" style="color: var(--color-accent);">Înscriere</a> sau sunați la <a href="tel:+40742037973" style="color: var(--color-accent);">0742 037 973</a> pentru a alege ziua și grupa potrivită.
        </div>
      </details>

      <details class="reveal reveal-delay-4" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Copilul meu este timid — îl ajută Ju-Jitsu?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Da, foarte mult. Ju-Jitsu construiește încrederea <strong>progresiv</strong>: copilul învață că este capabil să facă lucruri noi, primește feedback pozitiv constant și interacționează într-un mediu sigur cu alți copii. Timizii devin de obicei mai sociabili în primele 2-3 luni.
        </div>
      </details>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 12: LOCAȚIE
     ============================================================ -->
<section class="section section--dark" id="locatie">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">11 — Locație</div>
      <h2>UNDE NE <em>GĂSIȚI</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); line-height: 1.7;">
        Sala Kokoro este în <strong style="color: var(--color-white);">Str. Carpaților 60, Brașov</strong> — zonă centrală, cu parcare disponibilă în apropiere. Acces facil cu transport public.
      </p>
    </div>

    <div class="reveal" style="width: 100%; height: 400px; border-radius: 8px; overflow: hidden; border: 1px solid var(--color-gray-dark);">
      <iframe
        title="Hartă Kokoro Brașov Academy — Str. Carpaților 60"
        src="https://www.openstreetmap.org/export/embed.html?bbox=25.5787%2C45.6377%2C25.5987%2C45.6477&amp;layer=mapnik&amp;marker=45.6427%2C25.5887"
        style="width: 100%; height: 100%; border: 0;"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        allowfullscreen
      ></iframe>
    </div>

    <p class="reveal" style="text-align: center; margin-top: var(--space-md); color: var(--color-gray); font-size: 0.9375rem;">
      <strong style="color: var(--color-white);">Str. Carpaților 60, 500269 Brașov</strong> ·
      <a href="https://www.google.com/maps/search/?api=1&amp;query=45.6427%2C25.5887" target="_blank" rel="noopener" style="color: var(--color-accent);">Deschide pe Google Maps →</a>
    </p>
  </div>
</section>

<!-- ============================================================
     SECTION 13: CTA FINAL
     ============================================================ -->
<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);">PROGRAMAȚI<br>ANTRENAMENTUL <em>DE PROBĂ</em></h2>
      <p style="color: var(--color-bg); opacity: 0.85; margin: var(--space-lg) auto var(--space-2xl); max-width: 600px; line-height: 1.7;">
        Primul antrenament este <strong>gratuit, fără nicio obligație ulterioară</strong>. Vom contacta dumneavoastră în maxim 24 de ore pentru a confirma ziua și grupa potrivită pentru copilul dumneavoastră.
      </p>
      <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap; align-items: center;">
        <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
          Înscrie-te Acum
        </a>
        <a href="tel:+40742037973" class="btn btn--outline btn--large" style="border-color: var(--color-bg); color: var(--color-bg);">
          📞 0742 037 973
        </a>
      </div>
      <p style="color: var(--color-bg); opacity: 0.7; margin-top: var(--space-xl); font-size: 0.9375rem;">
        Sau scrieți-ne la <a href="mailto:contact@kokoro.ro" style="color: var(--color-bg); font-weight: 700;">contact&#64;kokoro.ro</a>
      </p>
    </div>
  </div>
</section>

</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": "Ju-Jitsu pentru Copii (4-15 ani) — Kokoro Brașov",
  "description": "Curs structurat de Ju-Jitsu adaptat copiilor (4-15 ani), cu accent pe disciplină, autoapărare practică, dezvoltare fizică armonioasă și caractere puternice. Antrenamente pe grupe de vârstă: 4-7 ani (inițiere prin joc), 8-12 ani (tehnică de bază), 13-15 ani (performanță).",
  "url": "https://kokoro.ro/ju-jitsu-copii-brasov.html",
  "provider": {
    "@type": "Organization",
    "name": "Kokoro Brașov Academy",
    "@id": "https://kokoro.ro/#organization",
    "url": "https://kokoro.ro/"
  },
  "inLanguage": "ro",
  "courseMode": "in-person",
  "educationalLevel": "Beginner to Advanced",
  "audience": {
    "@type": "EducationalAudience",
    "audienceType": "Children aged 4-15"
  },
  "hasCourseInstance": {
    "@type": "CourseInstance",
    "courseMode": "in-person",
    "courseSchedule": {
      "@type": "Schedule",
      "repeatFrequency": "P1W",
      "byDay": ["Monday", "Wednesday", "Friday"]
    },
    "location": {
      "@type": "Place",
      "name": "Kokoro Brașov Academy",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Str. Carpaților 60",
        "addressLocality": "Brașov",
        "postalCode": "500269",
        "addressCountry": "RO"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 45.6427,
        "longitude": 25.5887
      }
    },
    "instructor": {
      "@type": "Person",
      "name": "Adrian Boglut",
      "jobTitle": "Antrenor principal",
      "award": "Vicecampion European U21 -62kg"
    }
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "De la ce vârstă poate începe copilul Ju-Jitsu la Kokoro Brașov?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Acceptăm copii de la 4 ani. Avem grupe special structurate pe vârste: 4-7 ani (inițiere prin joc), 8-12 ani (tehnică de bază și autoapărare introductivă), 13-15 ani (performanță și autoapărare avansată)."
      }
    },
    {
      "@type": "Question",
      "name": "Ju-Jitsu este periculos pentru copii?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Nu. Tehnicile sunt adaptate strict pentru copii, iar accentul cade pe control, nu pe forță. Prima abilitate învățată este căderea sigură (ukemi). Antrenamentele se desfășoară pe tatami profesional cu supraveghere atentă din partea instructorului."
      }
    },
    {
      "@type": "Question",
      "name": "Câte antrenamente pe săptămână sunt recomandate?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Pentru rezultate vizibile, recomandăm 2-3 antrenamente pe săptămână, fiecare de 45-75 minute (în funcție de grupa de vârstă). Frecvența mai mare ajută la consolidarea tehnicii și formarea obiceiului de antrenament."
      }
    },
    {
      "@type": "Question",
      "name": "Cât costă un abonament lunar la Kokoro Brașov?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Tarifele actuale sunt prezentate pe pagina Tarife. Avem reduceri pentru frați (-20%) și pentru abonamentele anuale plătite în avans (-15%). Pentru ofertă personalizată, sunați la 0742 037 973."
      }
    },
    {
      "@type": "Question",
      "name": "Ce echipament este necesar la primul antrenament?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Pentru lecția de probă: doar haine sport confortabile, sticlă de apă și unghii tăiate scurt. Picioarele goale pe tatami (papucii rămân în vestiar). După înscriere, kimono-ul (gi alb din bumbac) și centura se cumpără în prima săptămână."
      }
    },
    {
      "@type": "Question",
      "name": "Care este diferența între Ju-Jitsu și Karate sau BJJ?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Ju-Jitsu este arta marțială japoneză tradițională cu paletă completă: proiectări, control la sol și lovituri controlate. Karate se concentrează pe lovituri (pumni, picioare). BJJ (Brazilian Jiu-Jitsu) derivă din Ju-Jitsu dar lucrează aproape exclusiv la sol. Pentru copii, Ju-Jitsu autentic oferă cel mai echilibrat curriculum."
      }
    },
    {
      "@type": "Question",
      "name": "Există antrenament de probă gratuit?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Da, primul antrenament este gratuit și fără nicio obligație. Completați formularul de pe pagina Înscriere sau sunați la 0742 037 973 pentru a alege ziua și grupa potrivită."
      }
    },
    {
      "@type": "Question",
      "name": "Copilul meu este timid — îl ajută Ju-Jitsu?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Da, foarte mult. Ju-Jitsu construiește încrederea progresiv: copilul învață că este capabil să facă lucruri noi, primește feedback pozitiv constant și interacționează într-un mediu sigur cu alți copii. Timizii devin de obicei mai sociabili în primele 2-3 luni."
      }
    }
  ]
}
</script>

<?php get_footer();
