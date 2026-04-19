/*
Name: Riley C. Taylor
Date: 2026-04-19
File: Services.jsx
Description: Services page for the React version of the client site.
*/

import ServiceCard from "../components/ServiceCard";
import SectionTitle from "../components/SectionTitle";
import services from "../data/services";

function Services() {
  return (
    <main>
      <SectionTitle
        title="Our Services"
        subtitle="Mobile auto services designed for convenience and reliability."
      />

      <section className="services-grid">
        {services.map((service) => (
          <ServiceCard
            key={service.id}
            name={service.name}
            description={service.description}
            image={service.image}
          />
        ))}
      </section>
    </main>
  );
}

export default Services;