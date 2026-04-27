<?php
/**
 * Template Name: Pillar — Autoapărare Femei Brașov
 *
 * Template hardcoded pentru pagina pilon SEO „autoaparare-femei-brasov".
 * Conținutul este sincronizat manual cu kokoro-theme/preview/autoaparare-femei-brasov.html.
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
    <div class="section-number">Pentru Femei (16+ ani)</div>
    <h1>AUTOAPĂRARE<br>PENTRU <em>FEMEI</em><br>BRAȘOV</h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 700px; line-height: 1.7; font-size: 1.0625rem;">
      Învățați un sistem de autoapărare care <strong style="color: var(--color-white);">funcționează indiferent de mărime sau forță</strong>. La Kokoro Brașov, vă oferim Ju-Jitsu autentic — tehnică reală, mediu sigur, instructori profesioniști. Pentru femeile care nu mai vor să trăiască cu frica zilnică.
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
  <div class="page-header__number" aria-hidden="true">護身</div>
</section>

<!-- ============================================================
     SECTION 2: INTRO
     ============================================================ -->
<section class="section section--dark">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">01 — De ce Ju-Jitsu pentru femei</div>
      <h2>O TEHNICĂ A <em>PÂRGHIILOR</em>,<br>NU A FORȚEI</h2>
    </div>

    <div class="reveal" style="color: var(--color-gray); line-height: 1.9; font-size: 1.0625rem;">
      <p style="margin-bottom: var(--space-lg);">
        Statistic, majoritatea femeilor sunt mai mici și mai puțin musculoase decât potențialii agresori. Această realitate face ineficiente sistemele de autoapărare bazate pe lovituri puternice — pentru că pur și simplu nu aveți forța necesară. <strong style="color: var(--color-white);">Ju-Jitsu autentic</strong>, în schimb, este construit tocmai pentru această situație: un sistem al pârghiilor și controlului echilibrului, în care un atacator de două ori mai mare poate fi imobilizat eficient.
      </p>
      <p style="margin-bottom: var(--space-lg);">
        Tehnicile pe care le veți învăța la Kokoro nu necesită formă fizică perfectă pentru a începe — ele se bazează pe principiul <em>seiryoku zen'yō</em> (utilizarea minimă a energiei pentru efect maxim). Veți învăța să folosiți greutatea agresorului împotriva sa, să eliberați eficient din apucări de încheietură, păr sau gât, și să imobilizați pe sol — toate abilități care funcționează în situații reale: stradă, parcaj, transport public sau, dureros mai des, în relații abuzive de acasă.
      </p>
      <p>
        Mediul nostru de antrenament este <strong style="color: var(--color-white);">profesional și respectuos</strong>. Vestiare separate, instructori cu experiență în lucrul cu cursantele femei, grupe în care nu vă veți simți expusă sau judecată. Avem cursante care antrenează aici de ani de zile, inclusiv la nivel competițional — iar prima dvs. lecție este întotdeauna gratuită.
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     [D4.2] DONE: Beneficii + Ce invata + Niveluri
     [D4.3] Testimoniale, FAQ, Locatie, CTA + Course/FAQPage schema
     ============================================================ -->

<!-- ============================================================
     SECTION 3: BENEFICII
     ============================================================ -->
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">02 — Beneficii</div>
      <h2>CE OBȚINEȚI<br>CU UN <em>CURS COMPLET</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); max-width: 700px; line-height: 1.7;">
        Autoapărarea reală nu se rezumă la câteva tehnici memorizate. Iată transformările pe care le veți observa în primele luni de antrenament la Kokoro Brașov.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-xl);">
      <div class="reveal reveal-delay-1" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">🛡️</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Tehnică reală, eficientă</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Imobilizări, escape-uri și controlul agresorului — tehnici care funcționează indiferent de diferența de mărime sau de antrenament fizic anterior.
        </p>
      </div>

      <div class="reveal reveal-delay-2" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">🧘</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Eliminarea fricii zilnice</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Mersul pe stradă seara, parcajele subterane, transportul public — toate devin mai puțin amenințătoare când știți că aveți resurse interioare și fizice de a vă apăra.
        </p>
      </div>

      <div class="reveal reveal-delay-3" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">💪</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Forță funcțională</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Antrenamentul Ju-Jitsu dezvoltă rezistență, coordonare și putere reală — diferită de antrenamentul de sală pentru estetică. Forța care vă servește în viața reală.
        </p>
      </div>

      <div class="reveal reveal-delay-4" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">⚡</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Reflex sub presiune</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          În autoapărare nu aveți timp să gândiți — corpul trebuie să reacționeze. Acest reflex se construiește doar prin repetiție constantă, săptămâni și luni de antrenament real.
        </p>
      </div>

      <div class="reveal reveal-delay-1" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">🤝</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Comunitate sigură</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Veți antrena alături de alte cursante și cursanți care înțeleg de ce sunteți acolo. Nu este o sală de fitness anonimă — este un grup care se sprijină reciproc.
        </p>
      </div>

      <div class="reveal reveal-delay-2" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);">🧠</div>
        <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm);">Postură și prezență</h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Femeile cu antrenament marțial emană o încredere subtilă pe care agresorii o citesc instantaneu. Postura, privirea, mersul — toate devin afirmații nerostite de „nu sunt o țintă ușoară".
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 4: CE ÎNVAȚĂ CURSANTA
     ============================================================ -->
<section class="section section--dark">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">03 — Curriculum</div>
      <h2>CE VEȚI <em>ÎNVĂȚA</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); line-height: 1.7;">
        Programul nostru combină prevenția (cea mai puternică formă de autoapărare) cu tehnică fizică reală. Iată curriculum-ul detaliat.
      </p>
    </div>

    <ul class="reveal" style="list-style: none; padding: 0; margin: 0;">
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Conștientizare situațională</strong> — cum să recunoașteți semnele timpurii ale unei situații periculoase și să o evitați înainte să escaladeze.</span>
      </li>
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Postură și voce de comandă</strong> — limbajul corporal care descurajează agresiunea, fraze ferme care opresc abordările nedorite.</span>
      </li>
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Escape-uri din apucări</strong> — eliberarea eficientă din apucări de încheietură, gât, păr, haine sau prinderi din spate (cele mai frecvente atacuri).</span>
      </li>
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Controlul atacatorului la sol</strong> — ce faceți dacă sunteți doborâtă: imobilizări, escape-uri din montaj, ridicare sigură.</span>
      </li>
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Cădere sigură (ukemi)</strong> — abilitate fundamentală care vă protejează de leziuni dacă sunteți împinsă, cădeți pe scări sau alunecați.</span>
      </li>
      <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
        <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
        <span><strong>Aspecte legale ale autoapărării</strong> — limitele legale ale apărării proporționale în România, când să sunați la 112, ce să declarați.</span>
      </li>
    </ul>

    <div class="reveal" style="margin-top: var(--space-xl); padding: var(--space-lg); background: var(--color-bg-card); border-left: 4px solid var(--color-accent); border-radius: 4px;">
      <p style="color: var(--color-white); line-height: 1.7;">
        <strong>Important:</strong> Antrenamentul nu se face niciodată cu forță reală asupra cursantelor. Tehnicile sunt practicate cu intensitate progresivă, mereu sub controlul instructorului — siguranța dumneavoastră este prioritară.
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 5: NIVELURI DE PREGĂTIRE
     ============================================================ -->
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">04 — Niveluri</div>
      <h2>3 NIVELURI<br>DE <em>PREGĂTIRE</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); max-width: 700px; line-height: 1.7;">
        Nu este nevoie de experiență anterioară sau de o formă fizică specifică. Veniți la prima lecție așa cum sunteți — restul construim împreună.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-xl);">
      <div class="card reveal reveal-delay-1" style="padding: var(--space-2xl);">
        <div class="card__tag">Începătoare</div>
        <p style="color: var(--color-accent); font-weight: 700; margin: var(--space-md) 0; font-size: 0.9375rem;">
          Fără experiență anterioară · 2 antrenamente/săptămână × 60 min
        </p>
        <h3 class="card__title" style="margin-bottom: var(--space-md);">PRIMUL <em>NIVEL</em></h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Pentru femeile care nu au făcut niciodată un sport de contact. Începem cu căderea sigură, escape-uri simple și conștientizare situațională. Nu se face nicio sparring (luptă liberă) în primele 4-6 săptămâni — totul în siguranță deplină.
        </p>
      </div>

      <div class="card reveal reveal-delay-2" style="padding: var(--space-2xl); border-color: var(--color-accent);">
        <div class="card__tag">Intermediare</div>
        <p style="color: var(--color-accent); font-weight: 700; margin: var(--space-md) 0; font-size: 0.9375rem;">
          6+ luni de antrenament · 3 antrenamente/săptămână × 75 min
        </p>
        <h3 class="card__title" style="margin-bottom: var(--space-md);">CONSOLIDARE <em>TEHNICĂ</em></h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Tehnicile devin automate, încep antrenamentele cu sparring controlat. Învățați variante avansate ale escape-urilor și controlul agresorului în diverse poziții. Aici se construiește reflexul real.
        </p>
      </div>

      <div class="card reveal reveal-delay-3" style="padding: var(--space-2xl);">
        <div class="card__tag">Avansate / Performanță</div>
        <p style="color: var(--color-accent); font-weight: 700; margin: var(--space-md) 0; font-size: 0.9375rem;">
          1+ an experiență · 3-4 antrenamente/săptămână × 90 min
        </p>
        <h3 class="card__title" style="margin-bottom: var(--space-md);">NIVEL <em>EXPERT</em></h3>
        <p style="color: var(--color-gray); line-height: 1.7;">
          Pentru femeile care doresc să intre în competiție sau să-și perfecționeze tehnica la nivel expert. Sparring intens, lucru cu agresori multipli, situații specifice (atac cu armă albă, în spațiu închis, etc.).
        </p>
      </div>
    </div>

    <div class="reveal" style="margin-top: var(--space-2xl); padding: var(--space-xl); background: var(--color-white); border-radius: 4px; border-left: 4px solid var(--color-accent); max-width: 800px; margin-left: auto; margin-right: auto;">
      <p style="color: var(--color-bg); line-height: 1.7;">
        <strong>Notă:</strong> Trecerea între niveluri se face individual, în funcție de progresul dumneavoastră — nu strict după timpul de antrenament. Antrenorul vă evaluează periodic și vă recomandă mutarea când sunteți pregătită.
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 6: TESTIMONIALE
     ============================================================ -->
<section class="section section--dark">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">05 — Părerile cursantelor</div>
      <h2>POVEȘTI DE LA<br>CURSANTELE <em>NOASTRE</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); max-width: 700px; line-height: 1.7;">
        Schimbarea pe care o veți simți în primele luni este vizibilă mai întâi în mersul zilnic — postura, încrederea, calmul în situații noi.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-xl);">
      <div class="testimonial reveal reveal-delay-1">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „[DE COMPLETAT — testimonial real cursantă 1: a venit fără experiență, a câștigat încredere de a merge seara prin oraș fără frică.]"
        </p>
        <div class="testimonial__author">[Nume Cursantă 1]</div>
        <div class="testimonial__source">[ocupație], [vârstă] ani</div>
      </div>

      <div class="testimonial reveal reveal-delay-2">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „[DE COMPLETAT — testimonial real cursantă 2: focus pe descoperirea forței interioare și transformare fizică.]"
        </p>
        <div class="testimonial__author">[Nume Cursantă 2]</div>
        <div class="testimonial__source">[ocupație], [vârstă] ani</div>
      </div>

      <div class="testimonial reveal reveal-delay-3">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „[DE COMPLETAT — testimonial real cursantă 3: situație concretă în care antrenamentul a făcut o diferență reală — evitat un incident sau câștigat încredere socială.]"
        </p>
        <div class="testimonial__author">[Nume Cursantă 3]</div>
        <div class="testimonial__source">[ocupație], [vârstă] ani</div>
      </div>
    </div>

    <div class="reveal" style="text-align: center; margin-top: var(--space-2xl);">
      <p style="color: var(--color-gray); font-size: 0.9375rem;">
        ⭐ <strong style="color: var(--color-accent);">4.8/5</strong> pe Google · <strong style="color: var(--color-white);">97 recenzii</strong> de la cursanți și părinți din Brașov
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 7: FAQ
     ============================================================ -->
<section class="section section--alt" id="faq">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">06 — Întrebări frecvente</div>
      <h2>ÎNTREBĂRI<br><em>FRECVENTE</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); line-height: 1.7;">
        Răspunsuri la cele mai des întâlnite întrebări ale femeilor care iau în considerare un curs de autoapărare. Pentru situații specifice, sunați la <a href="tel:+40742037973" style="color: var(--color-accent);">0742 037 973</a>.
      </p>
    </div>

    <div class="kokoro-faq" style="display: flex; flex-direction: column; gap: var(--space-md);">
      <details class="reveal reveal-delay-1" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Trebuie să am formă fizică bună pentru a începe?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          <strong>Nu.</strong> Veniți așa cum sunteți. Antrenamentul Ju-Jitsu construiește treptat condiția fizică — primele săptămâni se concentrează pe tehnică simplă și mobilitate, nu pe efort intens. După 2-3 luni veți simți o îmbunătățire vizibilă a forței și rezistenței.
        </div>
      </details>

      <details class="reveal reveal-delay-2" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Mă va deranja contactul fizic în antrenament?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Înțelegem complet aceasta îngrijorare — este firească. La Kokoro, atingerea în antrenament este <strong>strict tehnică, profesională, controlată</strong>. Începătoarele pot lucra exclusiv cu alte cursante sau cu instructorul timp de câteva luni, până când se simt confortabil. Niciun antrenor nu va depăși vreodată o limită pe care o exprimați.
        </div>
      </details>

      <details class="reveal reveal-delay-3" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Funcționează tehnicile dacă agresorul e cu mult mai mare?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Da — exact pentru asta a fost conceput Ju-Jitsu acum 400+ de ani: o femeie sau un samurai dezarmat să poată neutraliza un războinic înarmat și mult mai mare. Tehnicile se bazează pe <strong>pârghii anatomice</strong> și pe folosirea greutății adversarului împotriva lui. Cu cât atacatorul e mai mare, cu atât mai eficiente devin anumite imobilizări.
        </div>
      </details>

      <details class="reveal reveal-delay-4" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Cât durează până devin eficientă în autoapărare?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Câteva tehnici esențiale (escape din apucare de încheietură, postură de descurajare) le veți avea în <strong>4-6 săptămâni</strong>. Reflexul real, capacitatea de a reacționa fără să gândiți, se construiește în <strong>6-12 luni</strong> de antrenament constant. Dar transformarea de încredere și postură o veți simți după primele 2-3 luni.
        </div>
      </details>

      <details class="reveal reveal-delay-1" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Pot veni dacă am peste 40 de ani?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          <strong>Absolut.</strong> Avem cursante între 40 și 60 de ani. Ju-Jitsu este una dintre cele mai potrivite arte marțiale pentru vârsta adultă matură — nu cere flexibilitate extremă sau viteză tinerească, ci înțelegere a pârghiilor și răbdare. Antrenamentul vă va ajuta și cu mobilitatea articulară și densitatea osoasă.
        </div>
      </details>

      <details class="reveal reveal-delay-2" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Ce port la primul antrenament?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          Pentru lecția de probă: doar haine sport confortabile (legging-uri sau pantaloni de trening + tricou), sticlă de apă și unghii tăiate scurt. Picioarele goale pe tatami. După înscriere veți cumpăra kimono Ju-Jitsu (gi alb din bumbac) — vă recomandăm furnizori verificați.
        </div>
      </details>

      <details class="reveal reveal-delay-3" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Există grupe exclusiv feminine?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          În prezent grupele sunt mixte, dar predominant feminine. Atmosfera este profesională și respectuoasă — nu vă veți simți expusă sau judecată. Dacă există suficient interes, putem deschide o grupă exclusiv feminină — sunați-ne să discutăm.
        </div>
      </details>

      <details class="reveal reveal-delay-4" style="background: var(--color-white); border: 1px solid rgba(13, 33, 55, 0.1); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
        <summary style="cursor: pointer; font-weight: 700; color: var(--color-bg); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
          <span>Care e diferența față de cursurile de Krav Maga sau MMA pentru femei?</span>
          <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
        </summary>
        <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid rgba(13, 33, 55, 0.08);">
          <strong>Krav Maga</strong> este sistem militar israelian — focus pe lovituri puternice și neutralizare rapidă. Eficient, dar necesită forță și poate fi intimidant pentru femeile fără experiență anterioară. <strong>MMA</strong> este sport competițional, nu autoapărare reală. <strong>Ju-Jitsu autentic</strong>, în schimb, oferă o cale mai accesibilă: tehnicile bazate pe pârghii sunt prietenoase pentru femeile începătoare, învățate progresiv, fără sparring intens în primele luni. Filozofia non-agresivă și disciplina morală fac diferența.
        </div>
      </details>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 8: LOCAȚIE
     ============================================================ -->
<section class="section section--dark" id="locatie">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">07 — Locație</div>
      <h2>UNDE NE <em>GĂSIȚI</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md); line-height: 1.7;">
        Sala Kokoro este în <strong style="color: var(--color-white);">Str. Carpaților 60, Brașov</strong> — zonă centrală, cu acces facil cu transport public, parcare disponibilă în apropiere și vestiare separate pentru cursante.
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
     SECTION 9: CTA FINAL
     ============================================================ -->
<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);">VENIȚI LA<br>PRIMUL <em>ANTRENAMENT</em></h2>
      <p style="color: var(--color-bg); opacity: 0.85; margin: var(--space-lg) auto var(--space-2xl); max-width: 600px; line-height: 1.7;">
        Primul antrenament este <strong>gratuit, fără nicio obligație ulterioară</strong>. Vă vom contacta în maxim 24 de ore pentru a stabili împreună grupa potrivită nivelului dumneavoastră.
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
  "name": "Autoapărare pentru Femei (16+ ani) — Kokoro Brașov",
  "description": "Curs autoapărare pentru femei la Kokoro Brașov, bazat pe Ju-Jitsu autentic. Tehnicile bazate pe pârghii anatomice funcționează indiferent de mărimea agresorului. 3 niveluri (Începătoare, Intermediare, Avansate). Mediu profesional, vestiare separate.",
  "url": "https://kokoro.ro/autoaparare-femei-brasov.html",
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
    "audienceType": "Women aged 16+"
  },
  "teaches": [
    "Conștientizare situațională",
    "Postură și voce de comandă",
    "Escape-uri din apucări",
    "Controlul atacatorului la sol",
    "Cădere sigură (ukemi)",
    "Aspecte legale ale autoapărării"
  ],
  "hasCourseInstance": {
    "@type": "CourseInstance",
    "courseMode": "in-person",
    "courseSchedule": {
      "@type": "Schedule",
      "repeatFrequency": "P1W",
      "byDay": ["Tuesday", "Thursday"]
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
      "name": "Trebuie să am formă fizică bună pentru a începe autoapărare la Kokoro?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Nu. Veniți așa cum sunteți. Antrenamentul Ju-Jitsu construiește treptat condiția fizică — primele săptămâni se concentrează pe tehnică simplă și mobilitate, nu pe efort intens. După 2-3 luni veți simți o îmbunătățire vizibilă a forței și rezistenței."
      }
    },
    {
      "@type": "Question",
      "name": "Mă va deranja contactul fizic în antrenament?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "La Kokoro, atingerea în antrenament este strict tehnică, profesională, controlată. Începătoarele pot lucra exclusiv cu alte cursante sau cu instructorul timp de câteva luni, până când se simt confortabil. Niciun antrenor nu va depăși vreodată o limită pe care o exprimați."
      }
    },
    {
      "@type": "Question",
      "name": "Funcționează tehnicile de Ju-Jitsu dacă agresorul e cu mult mai mare?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Da — exact pentru asta a fost conceput Ju-Jitsu acum 400+ de ani: o femeie sau un samurai dezarmat să poată neutraliza un războinic înarmat și mult mai mare. Tehnicile se bazează pe pârghii anatomice și pe folosirea greutății adversarului împotriva lui. Cu cât atacatorul e mai mare, cu atât mai eficiente devin anumite imobilizări."
      }
    },
    {
      "@type": "Question",
      "name": "Cât durează până devin eficientă în autoapărare?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Câteva tehnici esențiale (escape din apucare de încheietură, postură de descurajare) le veți avea în 4-6 săptămâni. Reflexul real, capacitatea de a reacționa fără să gândiți, se construiește în 6-12 luni de antrenament constant. Dar transformarea de încredere și postură o veți simți după primele 2-3 luni."
      }
    },
    {
      "@type": "Question",
      "name": "Pot veni la cursul de autoapărare dacă am peste 40 de ani?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Absolut. Avem cursante între 40 și 60 de ani. Ju-Jitsu este una dintre cele mai potrivite arte marțiale pentru vârsta adultă matură — nu cere flexibilitate extremă sau viteză tinerească, ci înțelegere a pârghiilor și răbdare. Antrenamentul vă va ajuta și cu mobilitatea articulară și densitatea osoasă."
      }
    },
    {
      "@type": "Question",
      "name": "Ce port la primul antrenament?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Pentru lecția de probă: doar haine sport confortabile (legging-uri sau pantaloni de trening + tricou), sticlă de apă și unghii tăiate scurt. Picioarele goale pe tatami. După înscriere veți cumpăra kimono Ju-Jitsu (gi alb din bumbac)."
      }
    },
    {
      "@type": "Question",
      "name": "Există grupe exclusiv feminine?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "În prezent grupele sunt mixte, dar predominant feminine. Atmosfera este profesională și respectuoasă — nu vă veți simți expusă sau judecată. Dacă există suficient interes, putem deschide o grupă exclusiv feminină — sunați-ne să discutăm."
      }
    },
    {
      "@type": "Question",
      "name": "Care e diferența față de cursurile de Krav Maga sau MMA pentru femei?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Krav Maga este sistem militar israelian — focus pe lovituri puternice și neutralizare rapidă. Eficient, dar necesită forță și poate fi intimidant pentru femeile fără experiență anterioară. MMA este sport competițional, nu autoapărare reală. Ju-Jitsu autentic, în schimb, oferă o cale mai accesibilă: tehnicile bazate pe pârghii sunt prietenoase pentru femeile începătoare, învățate progresiv, fără sparring intens în primele luni."
      }
    }
  ]
}
</script>

<?php get_footer();
