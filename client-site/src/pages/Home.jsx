/*
Name: Riley C. Taylor
Date: 2026-04-19
File: Home.jsx
Description: Home page for the React version of the client site.
*/

import SectionTitle from "../components/SectionTitle";

function Home() {
  return (
    <main>
      <SectionTitle
        title="Forge & Fender Mobile Auto Works"
        subtitle="Reliable mobile mechanic service brought directly to you."
      />

      <img
        src={`${import.meta.env.BASE_URL}logo transparent bg.png`}
        alt="Forge & Fender Logo"
        className="home-logo"
      />

      <section className="home-intro">
        <p>
          Forge & Fender Mobile Auto Works delivers dependable at-home mechanic
          services designed for convenience, trust, and quality workmanship.
        </p>
        <p>
          From routine maintenance to specialized repairs, we bring the shop to
          you so your vehicle gets the attention it needs without disrupting
          your day.
        </p>
      </section>

      <section className="services-grid">
        <article>
          <h3>Oil Change</h3>
          <p>Fast, reliable oil changes to keep your engine running smoothly.</p>
        </article>

        <article>
          <h3>Brake Service</h3>
          <p>Complete brake inspections and replacements for your safety.</p>
        </article>

        <article>
          <h3>Tune-Ups</h3>
          <p>Keep your vehicle performing at its best with routine tune-ups.</p>
        </article>

        <article>
          <h3>Detailing</h3>
          <p>Professional interior and exterior cleaning services.</p>
        </article>
      </section>
    </main>
  );
}

export default Home;