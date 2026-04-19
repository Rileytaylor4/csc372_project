/*
Name: Riley C. Taylor
Date: 2026-04-19
File: Contact.jsx
Description: Contact page with a controlled React form and basic validation.
*/

import { useState } from "react";
import SectionTitle from "../components/SectionTitle";

function Contact() {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    message: "",
  });

  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  function handleChange(event) {
    const { name, value } = event.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  }

  function handleSubmit(event) {
    event.preventDefault();

    if (!formData.name || !formData.email || !formData.message) {
      setError("Please fill in all fields.");
      setSuccess("");
      return;
    }

    if (!formData.email.includes("@")) {
      setError("Please enter a valid email address.");
      setSuccess("");
      return;
    }

    setError("");
    setSuccess("Your message has been submitted.");
  }

  return (
    <main>
      <SectionTitle
        title="Contact Us"
        subtitle="Send us a message to ask about services or availability."
      />

      <form onSubmit={handleSubmit}>
        <input
          type="text"
          name="name"
          placeholder="Your name"
          value={formData.name}
          onChange={handleChange}
        />

        <input
          type="email"
          name="email"
          placeholder="Your email"
          value={formData.email}
          onChange={handleChange}
        />

        <textarea
          name="message"
          placeholder="Your message"
          value={formData.message}
          onChange={handleChange}
        />

        <button type="submit">Submit</button>

        {error && <p>{error}</p>}
        {success && <p>{success}</p>}
      </form>
    </main>
  );
}

export default Contact;