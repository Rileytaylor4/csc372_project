/*
Name: Riley C. Taylor
Date: 2026-04-19
File: ServiceDetail.jsx
Description: Dynamic service detail page for individual service cards.
*/

import { useParams, Link } from "react-router-dom";
import services from "../data/services";

function ServiceDetail() {
  const { serviceName } = useParams();

  const service = services.find(
    (item) => item.name.toLowerCase().replace(/\s+/g, "-") === serviceName
  );

  if (!service) {
    return (
      <main>
        <h2>Service not found</h2>
        <Link to="/services">Back to Services</Link>
      </main>
    );
  }

  return (
    <main className="service-detail">
      <h1>{service.name}</h1>
      <img src={service.image} alt={service.name} />
      <p>{service.description}</p>
      <Link to="/services" className="back-link">
        Back to Services
      </Link>
    </main>
  );
}

export default ServiceDetail;