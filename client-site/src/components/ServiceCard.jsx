/*
Name: Riley C. Taylor
Date: 2026-04-19
File: ServiceCard.jsx
Description: Reusable service card component using props.
*/

import { Link } from "react-router-dom";

function ServiceCard({ name, description, image }) {
  const path = name.toLowerCase().replace(/\s+/g, "-");

  return (
    <Link to={`/services/${path}`} className="card-link">
      <article>
        <img src={image} alt={name} />
        <h3>{name}</h3>
        <p>{description}</p>
      </article>
    </Link>
  );
}

export default ServiceCard;