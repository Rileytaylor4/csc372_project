const express = require("express");
const path = require("path");
const { engine } = require("express-handlebars");

const app = express();
const PORT = process.env.PORT || 3000;

/* Handlebars setup */
app.engine("handlebars", engine({ defaultLayout: "main" }));
app.set("view engine", "handlebars");
app.set("views", path.join(__dirname, "views"));

/* Static files */
app.use(express.static(path.join(__dirname, "public")));

/* Routes */

app.get("/", (req, res) => {
  res.render("home", {
    title: "Home"
  });
});

app.get("/services", (req, res) => {
  res.render("services", {
    title: "Services"
  });
});

app.get("/vin-checker", (req, res) => {
  res.render("vin-checker", {
    title: "VIN Checker"
  });
});

app.get("/schedule-appointment", (req, res) => {
  res.render("schedule-appointment", {
    title: "Schedule Appointment"
  });
});

/* 404 handler (MUST come after all routes) */
app.use((req, res) => {
  res.status(404).render("404", {
    title: "404 - Not Found"
  });
});

/* 500 handler */
app.use((err, req, res, next) => {
  console.error(err);
  res.status(500).render("500", {
    title: "500 - Server Error"
  });
});

/* Start server */
app.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});