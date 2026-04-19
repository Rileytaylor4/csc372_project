function SectionTitle({ title, subtitle }) {
  return (
    <section style={{ textAlign: "center", marginBottom: "30px" }}>
      <h2>{title}</h2>
      <p>{subtitle}</p>
    </section>
  );
}

export default SectionTitle;